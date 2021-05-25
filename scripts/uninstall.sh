#!/bin/bash

# Remove crashplan.py script
rm -f "${MUNKIPATH}preflight.d/crashplan.py"

# Remove crashplan.plist file
rm -f "${MUNKIPATH}preflight.d/cache/crashplan.plist"
