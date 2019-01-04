#!/bin/bash
ip=134.175.21.98
path=/project/server/php_web/
ssh -tt root@$ip <<EOF
cd $path
mkdir datacenter
mkdir newframe
mkdir dbdata
exit;
EOF
sftp root@$ip <<EOF
cd ${path}
lcd D:/workspace/DataCenter/server
put -r ./datacenter
put -r ./newframe
put -r ./dbdata
exit
close
bye
EOF

