#!/bin/bash
rp=/home/baksql/
p=`pwd`
p=$(echo d:/${p:3})
echo $p
sftp root@192.168.1.99 <<EOF
cd ${rp}
lcd ${p}
put -r -P ./*.sh
exit
close
bye
EOF
