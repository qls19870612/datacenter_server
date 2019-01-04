rm -rf $1
mkdir $1

time=`date "+%Y%m%d%H%M%S "`
time=$1/nodata_${time}
pswd=123456
plat=muzhi
game=diablo

echo ${time}
mkdir ${time}
cd ${time}
mysqldump=/usr/local/server/mysql/bin/mysqldump
$mysqldump -uroot -p${pswd} -a datacenter > datacenter.sql
$mysqldump -uroot -p${pswd} -a db${diablo}conf > db${diablo}conf.sql
$mysqldump -uroot -p${pswd} -d db${diablo}${plat}log > db${diablo}${plat}log.sql
$mysqldump -uroot -p${pswd} -d db${diablo}${plat}result > db${diablo}${plat}result.sql
