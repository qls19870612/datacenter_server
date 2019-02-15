#!/bin/bash
rp=/data/logbak
p=`pwd`
p=$(echo d:/${p:3})
echo $p
sftp root@134.175.21.98 <<EOF
cd ${rp}
lcd ${p}
put -r -P ./*.sh
exit
close
bye
EOF
