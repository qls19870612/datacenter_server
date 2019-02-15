CREATE DEFINER=`root`@`localhost` PROCEDURE `insert_time`()
BEGIN

declare i int;
declare j int;

declare ii varchar(4);
declare jj varchar(4);
declare t varchar(10);
set i=0;
set j=0;
delete from log;
while i<24 do
	set j = 0;
    while j < 60 do
		set ii = i;
        if i < 10 then
        set ii= concat('0', i);
        end if;
        set jj = j;
        if j < 10 then
        set jj=concat('0', j);
        end if;
        
		set t= concat(ii ,':',jj);
		insert into `dbdiabloconf`.`log` (`value`) values(concat('the value is->', t));
		insert into tbtemplatebyfiveminutes (`tplFiveMinutes`) value (t);
		set j = j + 5;   
    end while;
    
set i = i + 1;
end while;

SELECT * FROM `dbdiabloconf`.`log`;

END