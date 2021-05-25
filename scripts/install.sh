#!/bin/bash

# crashplan controller
CTL="${BASEURL}index.php?/module/crashplan/"

# Get the scripts in the proper directories
"${CURL[@]}" "${CTL}get_script/crashplan.py" -o "${MUNKIPATH}preflight.d/crashplan.py"

# Check exit status of curl
if [ $? = 0 ]; then
	# Make executable
	chmod a+x "${MUNKIPATH}preflight.d/crashplan.py"

	# Set preference to include this file in the preflight check
	setreportpref "crashplan" "${CACHEPATH}crashplan.plist"

else
	echo "Failed to download all required components!"
	rm -f "${MUNKIPATH}preflight.d/crashplan.py"

	# Signal that we had an error
	ERR=1
fi
