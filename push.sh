#!/bin/bash
sftp root@192.168.1.99 <<EOF
cd /usr/local/server/php_remote_web/
lcd D:/workspace/DataCenter/server
put -r ./datacenter
put -r ./newframe
put -r ./dbdata
exit
close
bye
EOF
