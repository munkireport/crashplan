#!/usr/local/munkireport/munkireport-python3

"""
extracts information about the external displays from system profiler
"""

import sys
import csv
import os
import re
from datetime import datetime

def cp_date_to_unixtimestamp(cp_date):
    """ Convert Crashplan date to unix timestamp """
    dt = datetime.strptime(cp_date, "%m/%d/%y %I:%M%p")
    #ep = dt.fromtimestamp(0)
    #diff = dt - ep
    #return int(diff.total_seconds())
    return int(datetime.strftime(dt, "%s"))

crashplan_log="/Library/Logs/CrashPlan/history.log"
crashplan_log_0="/Library/Logs/CrashPlan/history.log.0"
cacheFile = 'crashplan.txt'

# convoluted code because Code42 can't decide what log name formatting to use
if os.path.exists(crashplan_log):
    if os.path.exists(crashplan_log_0):
        if os.path.getctime(crashplan_log) > os.path.getctime(crashplan_log_0):
            pass
        else:
            crashplan_log = crashplan_log_0
    else:
        pass
else:
    if os.path.exists(crashplan_log_0):
        crashplan_log = crashplan_log_0

# crashplan logformat
regex = re.compile(r'. (\d+\/\d+\/\d+ \d+:\d+[AP]M)\s+(\[[^\]]+\])\s+(.*)')

start = 0
destinations = {}
if os.path.exists(crashplan_log):
    with open(crashplan_log, mode='r', buffering=-1) as cplog:
        for line in cplog:
            m = regex.match(line)
            if m:
                timestamp = cp_date_to_unixtimestamp(m.group(1))
                destination = m.group(2)
                message = m.group(3)
                # Check if destination is enclosed with []
                if not re.match(r'^\[.+\]$', destination):
                    continue
                if not destinations.get(destination):
                    destinations[destination] = {'destination': destination, 'start': 0, 'last_success': 0, 'duration': 0, 'last_failure': 0, 'reason': ''}
                if re.match(r'^Starting backup', message):
                    destinations[destination]['start'] = timestamp
                elif re.match(r'^Completed backup', message):
                    if destinations[destination]['start']:
                        duration = timestamp - destinations[destination]['start']
                        destinations[destination]['duration'] = duration
                    else:
                        destinations[destination]['duration'] = 0
                    destinations[destination]['last_success'] = timestamp
                elif re.match(r'^Stopped backup', message):
                    reason = re.match(r'.*Reason for stopping backup: (.*)', next(cplog))
                    if reason:
                        if reason.group(1) == "Nothing to do":
                            destinations[destination]['last_success'] = timestamp
                        elif reason.group(1):
                            destinations[destination]['last_failure'] = timestamp
                            destinations[destination]['reason'] = reason.group(1)
                    else:
                        destinations[destination]['last_failure'] = timestamp
                        destinations[destination]['reason'] = 'unknown'
else:
    print("CrashPlan log not found at: %s or %s" % (crashplan_log, crashplan_log_0))

# Write to file
cachedir = '%s/cache' % os.path.dirname(os.path.realpath(__file__))
listWriter = csv.DictWriter(
   open(os.path.join(cachedir, cacheFile), 'w'),
   fieldnames=['destination', 'start', 'last_success', 'duration', 'last_failure', 'reason'],
   delimiter=',',
   quotechar='"',
   quoting=csv.QUOTE_MINIMAL
)

listWriter.writeheader()
for name, values in destinations.items():
    listWriter.writerow(values)
