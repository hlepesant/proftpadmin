#!/bin/bash

cd /opt/WebSites/proftpadmin/

cp var/queue/ftp_user_to_remove.txt ftp_user_to_remove.txt
cp /dev/null var/queue/ftp_user_to_remove.txt

for dir in `cat ftp_user_to_remove.txt`
do
	sudo rm -rf ${dir}
done
rm ftp_user_to_remove.txt

exit 0
