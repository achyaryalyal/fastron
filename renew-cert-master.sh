#!/bin/bash

WEB_SERVICE='Fastron'
LE_PATH='/opt/letsencrypt'
EXP_LIMIT=60;
DOMAIN='smarttukang.com'
WEBROOT_PATH="-w /usr/share/fastron/master -d $DOMAIN -d www.$DOMAIN -w /usr/share/fastron/phpmyadmin -d data.$DOMAIN -w /usr/share/fastron/development -d dev.$DOMAIN"
CERT_FILE="/etc/letsencrypt/live/$DOMAIN/fullchain.pem"

if [ ! -f $CERT_FILE ]; then
	echo "[ERROR] certificate file not found for domain $DOMAIN."
fi

DATE_NOW=$(date -d "now" +%s)
EXP_DATE=$(date -d "`openssl x509 -in $CERT_FILE -text -noout | grep "Not After" | cut -c 25-`" +%s)
EXP_DAYS=$(echo \( $EXP_DATE - $DATE_NOW \) / 86400 |bc)

echo "Checking expiration date for $DOMAIN..."

if [ "$EXP_DAYS" -gt "$EXP_LIMIT" ] ; then
	echo "The certificate is up to date, no need for renewal ($EXP_LIMIT days left)."
	exit 0;
else
	echo "The certificate for $DOMAIN is about to expire soon. Starting webroot renewal script..."
	$LE_PATH/letsencrypt-auto -t --renew-by-default --agree-tos certonly --webroot $WEBROOT_PATH
	echo "Reloading $WEB_SERVICE"
	/usr/sbin/service $WEB_SERVICE reload
	echo "Renewal process finished for domain $DOMAIN"
	exit 0;
fi
