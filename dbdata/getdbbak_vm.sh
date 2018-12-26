#!/bin/bash
rdir=tempbak
IP=192.168.1.99
bakdir=/home/baksql
localdir=D:/workspace/DataCenter/server/dbdata
ssh root@$IP "cd ${bakdir}; sh downbak.sh ${rdir};"
sftp root@$IP <<EOF
cd ${bakdir}
lcd ${localdir}
get -r ${rdir}/*
exit
close
bye
EOF