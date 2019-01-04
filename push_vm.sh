#!/bin/bash
ip=192.168.1.101
path=/project/server/
ssh -tt root@$ip <<EOF
cd $path
mkdir php_web
cd php_web
mkdir datacenter
mkdir newframe
mkdir dbdata
exit;
EOF
sftp root@$ip <<EOF
cd ${path}/php_web
lcd D:/workspace/DataCenter/server
put -r ./datacenter
put -r ./newframe
put -r ./dbdata
exit
close
bye
EOF