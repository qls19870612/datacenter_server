rm -rf $1
mkdir $1

time=`date "+%Y%m%d%H%M%S "`
time=$1/nodata_${time}
pswd=123456
echo ${time}
mkdir ${time}
cd ${time}
mysqldump=/usr/local/server/mysql/bin/mysqldump
$mysqldump -uroot -p${pswd} -a datacenter > datacenter.sql
$mysqldump -uroot -p${pswd} -a dbdiabloconf > dbdiabloconf.sql
$mysqldump -uroot -p${pswd} -d dbdiablomuzhilog > dbdiablomuzhilog.sql
$mysqldump -uroot -p${pswd} -d dbdiablomuzhiresult > dbdiablomuzhiresult.sql
