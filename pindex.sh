#!/bin/bash
#put -r ./report/sp/general/js/realtime_recharge_curves.js
#ip=134.175.127.247
ip=134.175.21.98
sftp root@$ip <<EOF
cd /data/project/server/php_web/datacenter/Public/
lcd D:/workspace/DataCenter/server/datacenter/Public/
put -r ./report/resource/js/parser.js
exit
close
bye
EOF

ssh -tt root@$ip<<EOF
service httpd restart
exit
EOF
