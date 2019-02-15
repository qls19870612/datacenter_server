CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_random_online`()
BEGIN

declare i int default 0;
declare j int default 0;
declare onlinecount int default 0;
declare dayoffset int default 0;
declare ii varchar(4);
declare jj varchar(4);
declare t varchar(10);

declare r int;
-- delete from log;
while dayoffset < 10 do
	set i=0;
	set onlinecount =  rand() * 10000;
	while i<24 do
		set j = 0;
       
        
		while j < 60 do
        
			set r = rand() * 50 - 25;
            
			set onlinecount = onlinecount + r;
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
			-- dbdiablomuzhiresult.tbrealonlinecount
			INSERT INTO `dbdiablomuzhiresult`.`online_count`
			(`player_count`,
            `account_count`,
			`dtStatDate`,
			`worldid`)
			VALUES
			(onlinecount,
            onlinecount-rand()* 10,
			concat(FROM_UNIXTIME((unix_timestamp(now())-dayoffset*3600*24), '%Y-%m-%d'),' ',t,':00'),
			1);

			set j = j + 5;   
		end while;
		
	set i = i + 1;
	end while;
    set dayoffset = dayoffset + 1;
end while;

-- SELECT * FROM `dbdiabloconf`.`log`;

END