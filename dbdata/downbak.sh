rm -rf $1
mkdir $1
 


time=`date "+%Y%m%d%H%M%S "`
if [ "$2" -eq 1 ]; then
time=$1/data_${time}
else
time=$1/nodata_${time}
fi
pswd=ljam5p3i9qy
plat=muzhi
game=diablo
host=10.66.203.188

echo ${time}
mkdir ${time}
cd ${time}
mysqldump=mysqldump
if [ "$2" -eq 1 ]; then
$mysqldump -h${host} -uroot -p${pswd} datacenter > datacenter.sql
$mysqldump -h${host} -uroot -p${pswd} db${game}conf > db${game}conf.sql
$mysqldump -h${host} -uroot -p${pswd} db${game}${plat}log > db${game}${plat}log.sql
$mysqldump -h${host} -uroot -p${pswd} db${game}${plat}result > db${game}${plat}result.sql
else
$mysqldump -h${host} -uroot -p${pswd} -a datacenter > datacenter.sql
$mysqldump -h${host} -uroot -p${pswd} -a db${game}conf > db${game}conf.sql
$mysqldump -h${host} -uroot -p${pswd} -d db${game}${plat}log > db${game}${plat}log.sql
$mysqldump -h${host} -uroot -p${pswd} -d db${game}${plat}result > db${game}${plat}result.sql

fi
