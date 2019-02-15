CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_random_amount`()
BEGIN

declare i int default 0;
declare j int default 0;
declare recharge int default 0;
declare dayoffset int default 10;
declare ii varchar(4);
declare jj varchar(4);
declare t varchar(10);

declare r int;
-- delete from log;
set recharge = 0;
while dayoffset > 0 do
	set i=0;

	while i<24 do
		set j = 0;
       
        
		while j < 60 do
        
			set r = rand() * 10000;
			set recharge = recharge + r;
			set ii = i;
			if i < 10 then
			set ii= concat('0', i);
			end if;
			set jj = j;
			if j < 10 then
			set jj=concat('0', j);
			end if;
			
			set t= concat(ii ,':',jj);
			-- insert into `dbdiabloconf`.`log` (`value`) values(concat('the value is->', t));
			-- dbdiablomuzhiresult.tbrealrecharge
			INSERT INTO `dbdiablomuzhiresult`.`tbrealrecharge`
			(`iHourRecharge`,
			`dtStatDate`,
			`iWorldId`)
			VALUES
			(recharge,
			concat(FROM_UNIXTIME((unix_timestamp(now())-(dayoffset - 1)*3600*24), '%Y-%m-%d'),' ',t,':00'),
			1);

			set j = j + 5;   
		end while;
		
	set i = i + 1;
	end while;
    set dayoffset = dayoffset - 1;
end while;

-- SELECT * FROM `dbdiabloconf`.`log`;

END