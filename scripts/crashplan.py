#!/usr/bin/python

import os
import plistlib
from datetime import datetime
from pytz import utc, timezone
import time
import subprocess

def get_app_log():

    # Check if the log exists
    if os.path.isfile('/Library/Logs/CrashPlan/app.log'):
        log_file = "/Library/Logs/CrashPlan/app.log"
    elif os.path.isfile('/Library/Logs/CrashPlan/app.log.0'):
        log_file = "/Library/Logs/CrashPlan/app.log.0"
    else:
        return {}

    result = {}

    # Process app log
    for line in open(log_file).readlines():
        if "DateTime     = " in line:
            result["app_log_time"] = app_log_to_timestamp(line.split(" = ")[1].strip())
        elif "Locale       = " in line:
            result["app_log_locale"] = line.split(" = ")[1].strip()
        elif "CPVERSION    = " in line:
            result["cp_version"] = line.split(" = ")[1].strip()
        elif "OrgType      = " in line:
            result["org_type"] = line.split(" = ")[1].capitalize().strip()
        elif "ServiceModel.authorized         = " in line:
            result["license_authorized"] = to_bool(line.split(" = ")[1].strip())
        elif "AuthorizedService.authRules          = " in line:
            result["auth_rules"] = line.split(" = ")[1].replace("AuthorizeRules [", "").replace("]", "").strip()
        elif "ServiceModel.license            = " in line:
            result["license_model"] = line.split(" = ")[1].strip()
        elif "LicensedFeatures                = " in line:
            result["license_features"] = line.split(" = ")[1].replace("[", "").replace("]", "").strip()
        
        elif ", lastConnected=" in line:
            result["last_connected"] = str(int(line.split("lastConnected=")[1].strip()))
        elif "backupEnabled                  = " in line:
            result["backup_enabled"] = to_bool(line.split(" = ")[1].strip())
        elif "backupPaths                    = " in line:
            result["backup_paths"] = line.split(" = ")[1].replace("[", "").replace("]", "").replace("V3[cs]+", "").replace("V3cs+", "").replace(";w, ", ", ").replace(";w", "").strip()
        elif "backupPaths.lastModified       = " in line:
            result["backup_paths_last_modified"] = app_log_to_timestamp(line.split(" = ")[1].strip())
        elif "scanning                       = " in line:
            result["backup_scanning"] = to_bool(line.split(" = ")[1].strip())
        elif "checkingForDeletes             = " in line:
            result["backup_check_for_deletes"] = to_bool(line.split(" = ")[1].strip())
        elif "totalFiles                     = " in line:
            result["backup_total_files"] = str(int(line.split(" = ")[1].strip()))
        elif "totalSize                      = " in line:
            result["backup_total_size"] = line.split(" = ")[1].strip()
        elif "watcherNoActivityInterval      = " in line:
            result["backup_frequency"] = line.split(" = ")[1].split("(")[0].strip()
        elif "backupOpenFiles                = " in line:
            result["backup_open_files"] = to_bool(line.split(" = ")[1].strip())
        elif "scanInterval                   = " in line:
            result["backup_scan_interval"] = line.split(" = ")[1].strip()
        elif "scanTime                       = " in line:
            result["backup_scan_time"] = line.split(" = ")[1].strip()
        elif "compression                    = " in line:
            result["backup_compression"] = to_bool(line.split(" = ")[1].strip())
        elif "encryptionEnabled              = " in line:
            result["backup_encryption"] = to_bool(line.split(" = ")[1].strip())
        elif "dataDeDuplication              = " in line:
            result["backup_data_deduplication"] = line.split(" = ")[1].capitalize().strip()
        elif "keepDeleted                    = " in line:
            result["backup_keep_deleted"] = to_bool(line.split(" = ")[1].strip())
        elif "keepDeletedMinutes             = " in line:
            result["backup_keep_deleted_minutes"] = line.split(" = ")[1].strip()
        elif "versionLastWeekInterval        = " in line:
            result["backup_version_last_week"] = line.split(" = ")[1].strip()
        elif "versionLastNinetyDaysInterval  = " in line:
            result["backup_version_ninety_days"] = line.split(" = ")[1].strip()
        elif "versionLastYearInterval        = " in line:
            result["backup_version_year"] = line.split(" = ")[1].strip()
        elif "versionPrevYearsInterval       = " in line:
            result["backup_version_previous_year"] = line.split(" = ")[1].strip()

    # Get app log file size
    result["app_log_size"] = str(os.path.getsize(log_file))

    return result

def get_history_log():

    # Check if the log exists
    if os.path.isfile('/Library/Logs/CrashPlan/history.log'):
        log_file = "/Library/Logs/CrashPlan/history.log"
    elif os.path.isfile('/Library/Logs/CrashPlan/history.log.0'):
        log_file = "/Library/Logs/CrashPlan/history.log.0"
    else:
        return {}

    start_backup = 0
    complete_backup = 0
    guid_changed = 0
    stopped_backup = 0
    result = {}

    # Process history log
    for line in reversed(open(log_file).readlines()):
        if " Starting backup to " in line and start_backup is 0:
            result["backup_start_time"] = history_log_to_timestamp(line.split(" [")[0].replace("I ", "").strip())
            result["destination"] = line.split(" Starting backup to ")[1].split(": ")[0].strip()
            result["backup_start_files"] = line.split(" Starting backup to ")[1].split(": ")[1].replace(" to back up", "").strip()
            start_backup = 1

        elif " Completed backup to " in line and complete_backup is 0:
            result["last_success"] = history_log_to_timestamp(line.split(" [")[0].replace("I ", "").strip())
            result["duration"] = duration_to_timestamp(line.split(" Completed backup to ")[1].split(" in ")[1].split("s: ")[0].strip())
            result["backup_end_files"] = line.split("s: ")[1].split(" backed up, ")[0].strip()
            result["backup_sent"] = line.split(" backed up, ")[1].split(" ")[0].strip()
            if " sent @ " in line:
                result["backup_sent_speed"] = line.split(" sent @ ")[1].strip()
            complete_backup = 1

        elif "Computer identifier (GUID) changed from " in line and guid_changed is 0:
            result["cp_guid_change_time"] = history_log_to_timestamp(line.split(" Computer identifier (GUID) changed from ")[0].replace("I ", "").strip())
            result["cp_guid_old"] = line.split(" changed from ")[1].split(" to ")[0].strip()
            result["cp_guid_new"] = line.split(" changed from ")[1].split(" to ")[1].replace(".", "").strip()
            guid_changed = 1

        elif " - Reason for stopping backup: " in line and stopped_backup is 0:
            result["last_failure"] = history_log_to_timestamp(line.split(" - Reason for stopping backup: ")[0].replace("I ", "").strip())
            result["reason"] = line.split(" - Reason for stopping backup: ")[1].strip()
            stopped_backup = 1
        
        # Exit loop if three values have been obtained
        if start_backup is 1 and complete_backup is 1 and guid_changed is 1 and stopped_backup is 1:
            break

    # Get app log file size
    result["history_log_size"] = str(os.path.getsize(log_file))

    return result

def get_identity():

    # Check if identity exists
    if os.path.isfile('/Library/Application Support/CrashPlan/.identity'):
        result = {}

        # Process app log
        for line in open("/Library/Application Support/CrashPlan/.identity").readlines():
            if "authDate=" in line:
                result["auth_date"] = str(int(line.replace("authDate=", "").strip()))
            elif "orgName=" in line:
                result["org_name"] = line.replace("orgName=", "").strip()
            elif "guid=" in line:
                result["guid"] = line.replace("guid=", "").strip()
            elif "username=" in line:
                result["cp_username"] = line.replace("username=", "").strip()

        return result
    else:
        return {}

def app_log_to_timestamp(time_string):
    return str(int(time.mktime(datetime.strptime(time_string.strip(), "%a %b %d %H:%M:%S %Z %Y").timetuple())) * 1000)

def history_log_to_timestamp(time_string):
    return str(int(time.mktime(datetime.strptime(time_string.strip(), "%m/%d/%y %I:%M%p").timetuple())) * 1000)

def duration_to_timestamp(time_string):

    hours = time_string.split(":")[0].replace("h", "").strip()
    minutes = time_string.split(":")[1].replace("m", "").strip()
    seconds = time_string.split(":")[2].replace("s", "").strip()

    return str(int((((hours*60)+minutes)*60)+seconds))

def to_bool(s):
    if s == True or "true" in s or "enabled" in s or "ON" in s:
        return 1
    else:
        return 0

def merge_two_dicts(x, y):
    z = x.copy()
    z.update(y)
    return z

def main():
    """Main"""

    # Get information about Code42 CrashPlan from logs  
    result = merge_two_dicts(get_app_log(), get_history_log())
    result = merge_two_dicts(result, get_identity())

    # Write results to cache
    cachedir = '%s/cache' % os.path.dirname(os.path.realpath(__file__))
    output_plist = os.path.join(cachedir, 'crashplan.plist')
    plistlib.writePlist(result, output_plist)
#    print plistlib.writePlistToString(result)

if __name__ == "__main__":
    main()
