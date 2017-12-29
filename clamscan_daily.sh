#!/bin/bash
LOGFILE="/var/log/clamav/clamav-$(date +'%Y-%m-%d').log";
EMAIL_MSG="Please see the log file attached.";
EMAIL_FROM="no-reply@opensimka.com";
EMAIL_TO="aymarxp@gmail.com";
DIRTOSCAN="/usr/share/fastron/master";

for S in ${DIRTOSCAN}; do
 DIRSIZE=$(du -sh "$S" 2>/dev/null | cut -f1);

 echo "Starting a daily scan of "$S" directory.
 Amount of data to be scanned is "$DIRSIZE".";

 clamscan -ri "$S" >> "$LOGFILE";

 # get the value of "Infected lines"
 MALWARE=$(tail "$LOGFILE"|grep Infected|cut -d" " -f3);

 # if the value is not equal to zero, send an email with the log file attached
 if [ "$MALWARE" -ne "0" ];then
 # using heirloom-mailx below
 
 echo "From: $EMAIL_FROM
To: $EMAIL_TO
Subject: Malware Found Alert
$EMAIL_MSG"| sendmail -t;
 fi 
done

exit 0
