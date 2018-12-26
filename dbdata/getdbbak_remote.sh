#!/bin/bash
rdir=tempbak
IP=134.175.127.247
bakdir=/home/baksqls
localdir=D:/workspace/DataCenter/server/dbdata
ssh root@$IP "cd ${bakdir}; sudo sh downbak.sh ${rdir};"
sftp root@$IP <<EOF
cd ${bakdir}
lcd ${localdir}
get -r ${rdir}/*
exit
close
bye
EOF