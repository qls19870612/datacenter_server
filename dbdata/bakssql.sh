time=`date "+%Y%m%d%H%M%S "`
pswd=xxxx
echo ${time}
mkdir ${time}
cd ${time}
mysqldump -uroot -p${pswd} datacenter > datacenter.sql
mysqldump -uroot -p${pswd} dbdiabloconf > dbdiabloconf.sql
mysqldump -uroot -p${pswd} dbdiabloyylog > dbdiabloyylog.sql
mysqldump -uroot -p${pswd} dbdiabloyyresult > dbdiabloyyresult.sql
