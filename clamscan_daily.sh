#!/bin/bash
LOGFILE="/var/log/clamav/clamav-$(date +'%Y-%m-%d').log";
EMAIL_MSG="Please see the log file attached.";
EMAIL_FROM="no-reply@opensimka.com";
EMAIL_TO="aymarxp@gmail.com";
DIRTOSCAN="/usr/share/fastron/master";

# Update ClamAV database
echo "Looking for ClamAV database updates...";
freshclam --quiet;

DIRSIZE=$(du -sh "$DIRTOSCAN" 2>/dev/null | cut -f1);

echo "Starting a daily scan of "$DIRTOSCAN" directory.
Amount of data to be scanned is "$DIRSIZE".";

clamscan -ri "$DIRTOSCAN" >> "$LOGFILE";

# get the value of "Infected lines"
MALWARE=$(tail "$LOGFILE"|grep Infected|cut -d" " -f3);

# if the value is not equal to zero, send an email with the log file attached
if [ "$MALWARE" -ne "0" ];then
#echo "From: $EMAIL_FROM
#To: $EMAIL_TO
#Subject: Malware Found Alert
#$EMAIL_MSG"| sendmail -t;
echo "$EMAIL_MSG"| mail -a "$LOGFILE" -s "Malware Found" -r "$EMAIL_FROM" "$EMAIL_TO";
fi 

done

exit 0
