#!/bin/bash
rdir=tempbak
IP=134.175.21.98
bakdir=/data/logbak
localdir=D:/workspace/DataCenter/server/dbdata
#不带数据
# ssh root@$IP "cd ${bakdir}; sudo sh downbak.sh ${rdir} 0;"

#带数据
ssh root@$IP "cd ${bakdir}; sudo sh downbak.sh ${rdir} 1;"
sftp root@$IP <<EOF
cd ${bakdir}
lcd ${localdir}
get -r ${rdir}/*
exit
close
bye
EOF