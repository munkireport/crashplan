Code42 CrashPlan Module
==============

Gets data about Code42's CrashPlan (Pro/Home/Enterprise) on the clients. 

Table Schema
------
* destination - VARCHAR(255) - Destination of backups
* last_success - bigint - Timestamp of last backup success
* duration - int - Backup length in seconds
* last_failure - bigint - Timestamp of last failure
* reason - VARCHAR(255) - Reason of last failure
* app_log_time - bigint - Timestamp of app log write time
* app_log_locale - VARCHAR(255) - Set locale and time zone
* cp_version - VARCHAR(255) - Version of CrashPlan installed
* org_type - VARCHAR(255) - Type of organization
* license_authorized - boolean - If license authorizes use
* auth_rules - text - Rules used for authentication
* license_model - text - License model used
* license_features - text - Features allowed in the license
* last_connected - bigint - Timestamp of when CrashPlan last connected to backup
* backup_enabled - boolean - Are backups enabled
* backup_paths - text - Paths to backup
* backup_paths_last_modified - bigint - Timestamp of when backup paths were last modified
* backup_scanning - boolean - Is backups scanning
* backup_check_for_deletes - boolean - Check for deleted files
* backup_total_files - bigint - Count of backed up files
* backup_total_size - VARCHAR(255) - Total size of backup
* backup_frequency - VARCHAR(255) - How often backup runs
* backup_open_files - boolean - Backup open files
* backup_scan_interval - VARCHAR(255) - How often backup scans
* backup_scan_time - VARCHAR(255) - How long previous scan was
* backup_compression -boolean - Is compression turned on
* backup_encryption - boolean - Is encryption enabled
* backup_data_deduplication - VARCHAR(255) - Type of data deduplication
* backup_keep_deleted - boolean - Keep files that were deleted
* backup_keep_deleted_minutes - VARCHAR(255) - How long files will be kept after deleted
* backup_version_last_week - VARCHAR(255) - How long files will be kept within the past week
* backup_version_ninety_days - VARCHAR(255) - How long files will be kept within the past 90 days
* backup_version_year - VARCHAR(255) - How long files will be kept within the past year
* backup_version_previous_year - VARCHAR(255) - How long files will be kept after one year
* app_log_size - bigint - Size of app log in bytes
* backup_start_time - bigint - Timestamp of when last backup started
* backup_start_files - VARCHAR(255) - Files to backup
* backup_time - VARCHAR(255) - How long it took to run last backup
* backup_end_files - VARCHAR(255) - Count of files that were backed up
* backup_sent - VARCHAR(255) - Size of last backup data sent
* backup_sent_speed - VARCHAR(255) - Speed of last backup
* cp_guid_change_time - bigint - Timestamp of when GUID last changed
* cp_guid_old - VARCHAR(255) - Old GUID
* cp_guid_new - VARCHAR(255) - New GUID
* history_log_size - bigint - Size of history log in bytes
* auth_date - bigint - Timestamp of authorization in identity
* org_name - VARCHAR(255) - Name of organization
* guid - VARCHAR(255) - Current GUID
* cp_username - VARCHAR(255) - CrashPlan username