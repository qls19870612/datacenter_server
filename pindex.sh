#!/bin/bash
sftp root@192.168.1.99 <<EOF
cd /usr/local/server/php_remote_web/datacenter/Public/
lcd D:/workspace/DataCenter/server/datacenter/Public/
put -r ./index.php
exit
close
bye
EOF
ssh root@192.168.1.99
service httpd restart
exit
