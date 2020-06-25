#!/bin/bash

# Get the list of processes and sort them by most mem usage
ps_output="$(ps aux)"
mem_top_processes="$(printf "%s\\n" "${ps_output}" | awk '{print $2, $4"%", $11}' | sort -k2rn | head -5 | awk '{print "ID: "$1, $3, "\t"$2}')"

echo -e "========= Top RAM Processes =========
$mem_top_processes"
