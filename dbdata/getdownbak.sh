#!/bin/bash
rdir=tempbak
IP=134.175.127.247
bakdir=/home/baksqls
localdir=D:/workspace/DataCenter/server/dbdata

sftp root@$IP <<EOF
cd ${bakdir}
lcd ${localdir}
get -r downbak.sh
exit
close
bye
EOF