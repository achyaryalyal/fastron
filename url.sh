#!/bin/bash

url=https://www.google.com

menit=1m

while true
do
    detik=$[(RANDOM%30)+1]s
    echo "================================"
    echo "start... waiting for" $menit $detik
    echo "================================"
    xdg-open $url
    sleep $menit $detik
    pkill chrome

    breath=$[(RANDOM%30)+1]s
    echo "================================"
    echo "rest for a while in" $breath
    echo "================================"
    sleep $breath

    echo "================================"
    echo "finished... all done!"
    echo -e "================================\n\n"
done
