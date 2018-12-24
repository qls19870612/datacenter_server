CREATE DATABASE  IF NOT EXISTS `dbdiablomuzhiresult` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `dbdiablomuzhiresult`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: dbdiablomuzhiresult
-- ------------------------------------------------------
-- Server version	5.5.60-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `account_info`
--

DROP TABLE IF EXISTS `account_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `account_info` (
  `uin` varchar(255) DEFAULT NULL,
  `worldid` int(11) unsigned DEFAULT NULL,
  `registertime` varchar(255) DEFAULT NULL,
  `lastlogintime` varchar(255) DEFAULT NULL,
  `firstpaytime` varchar(255) DEFAULT NULL,
  `lastpaytime` varchar(255) DEFAULT NULL,
  `daypayamount` bigint(20) unsigned DEFAULT NULL,
  `daypaytimes` int(11) unsigned DEFAULT NULL,
  `totalpayamount` bigint(20) unsigned DEFAULT NULL,
  `totalpaytimes` int(11) unsigned DEFAULT NULL,
  `firstshoptime` varchar(255) DEFAULT NULL,
  `lastshoptime` varchar(255) DEFAULT NULL,
  `dayshopamount` bigint(20) unsigned DEFAULT NULL,
  `dayshoptimes` int(11) unsigned DEFAULT NULL,
  `totalshopamount` bigint(20) unsigned DEFAULT NULL,
  `totalshoptimes` int(11) unsigned DEFAULT NULL,
  `dtstatdate` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `account_info`
--

LOCK TABLES `account_info` WRITE;
/*!40000 ALTER TABLE `account_info` DISABLE KEYS */;
/*!40000 ALTER TABLE `account_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `create_count`
--

DROP TABLE IF EXISTS `create_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `create_count` (
  `playerCount` int(11) DEFAULT '0',
  `dtStatDate` datetime DEFAULT NULL,
  `iWorldId` int(11) DEFAULT NULL,
  `accountCount` int(11) DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `create_count`
--

LOCK TABLES `create_count` WRITE;
/*!40000 ALTER TABLE `create_count` DISABLE KEYS */;
INSERT INTO `create_count` VALUES (5,'2018-12-24 10:20:00',1,5,1),(6,'2018-12-24 11:20:00',1,6,2),(6,'2018-12-24 11:50:00',1,6,3);
/*!40000 ALTER TABLE `create_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_basic`
--

DROP TABLE IF EXISTS `daily_basic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_basic` (
  `dtStatDate` date NOT NULL DEFAULT '1970-01-01',
  `WorldId` int(11) unsigned NOT NULL DEFAULT '0',
  `RegisterAccount` int(10) unsigned NOT NULL DEFAULT '0',
  `LoginAccount` int(10) unsigned NOT NULL DEFAULT '0',
  `PayAccount` int(10) unsigned NOT NULL DEFAULT '0',
  `PayAmount` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ShopAccount` int(10) unsigned NOT NULL DEFAULT '0',
  `ShopAmount` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`dtStatDate`,`WorldId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='每日基本情况(区服)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_basic`
--

LOCK TABLES `daily_basic` WRITE;
/*!40000 ALTER TABLE `daily_basic` DISABLE KEYS */;
/*!40000 ALTER TABLE `daily_basic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_ltv`
--

DROP TABLE IF EXISTS `daily_ltv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_ltv` (
  `dtStatDate` date NOT NULL DEFAULT '1970-01-01',
  `WorldId` int(10) unsigned NOT NULL DEFAULT '0',
  `RegisterDate` date NOT NULL DEFAULT '1970-01-01',
  `RegisterNum` int(10) unsigned NOT NULL DEFAULT '0',
  `TotalPayAmount` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`RegisterDate`,`dtStatDate`,`WorldId`),
  KEY `StatDate` (`dtStatDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='每日LTV';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_ltv`
--

LOCK TABLES `daily_ltv` WRITE;
/*!40000 ALTER TABLE `daily_ltv` DISABLE KEYS */;
/*!40000 ALTER TABLE `daily_ltv` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_retention`
--

DROP TABLE IF EXISTS `daily_retention`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `daily_retention` (
  `dtStatDate` date NOT NULL DEFAULT '1970-01-01',
  `WorldId` int(10) unsigned NOT NULL DEFAULT '0',
  `RegisterDate` date NOT NULL DEFAULT '1970-01-01',
  `RetentionNum` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`dtStatDate`,`WorldId`,`RegisterDate`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='每日留存';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_retention`
--

LOCK TABLES `daily_retention` WRITE;
/*!40000 ALTER TABLE `daily_retention` DISABLE KEYS */;
/*!40000 ALTER TABLE `daily_retention` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `monthly_basic`
--

DROP TABLE IF EXISTS `monthly_basic`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `monthly_basic` (
  `dtStatDate` date NOT NULL DEFAULT '1970-01-01',
  `WorldId` int(11) unsigned NOT NULL DEFAULT '0',
  `RegisterAccount` int(10) unsigned NOT NULL DEFAULT '0',
  `LoginAccount` int(10) unsigned NOT NULL DEFAULT '0',
  `PayAccount` int(10) unsigned NOT NULL DEFAULT '0',
  `PayAmount` bigint(20) unsigned NOT NULL DEFAULT '0',
  `NewPayAccount` int(10) unsigned NOT NULL DEFAULT '0',
  `NewPayAmount` bigint(20) unsigned NOT NULL DEFAULT '0',
  `ShopAccount` int(10) unsigned NOT NULL DEFAULT '0',
  `ShopAmount` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`dtStatDate`,`WorldId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='每月基本情况(区服)';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `monthly_basic`
--

LOCK TABLES `monthly_basic` WRITE;
/*!40000 ALTER TABLE `monthly_basic` DISABLE KEYS */;
/*!40000 ALTER TABLE `monthly_basic` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `online_count`
--

DROP TABLE IF EXISTS `online_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `online_count` (
  `iWorldId` int(10) DEFAULT NULL COMMENT '服ID\n',
  `player_count` int(10) DEFAULT NULL COMMENT '在线角色数\n',
  `account_count` int(10) DEFAULT NULL COMMENT '在线账号数',
  `dtStatDate` datetime DEFAULT NULL COMMENT '记录日期',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `online_count`
--

LOCK TABLES `online_count` WRITE;
/*!40000 ALTER TABLE `online_count` DISABLE KEYS */;
INSERT INTO `online_count` VALUES (1,1,1,'2018-12-24 11:20:00',1),(1,2,2,'2018-12-24 11:50:00',2);
/*!40000 ALTER TABLE `online_count` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shop_summary`
--

DROP TABLE IF EXISTS `shop_summary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop_summary` (
  `dtStatDate` date NOT NULL DEFAULT '1970-01-01' COMMENT '日期',
  `WorldId` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '区服',
  `ShopType` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商店类型',
  `GoodsType` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '商品类型',
  `GoodsId` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '物品ID',
  `GoodsNum` int(11) unsigned DEFAULT NULL COMMENT '物品数量',
  `Amount` int(11) unsigned DEFAULT NULL COMMENT '总消费钱币数',
  `RoleCount` int(11) unsigned DEFAULT NULL COMMENT '消费角色数',
  `BuyTimes` int(11) unsigned DEFAULT NULL COMMENT '消费次数',
  PRIMARY KEY (`dtStatDate`,`WorldId`,`ShopType`,`GoodsType`,`GoodsId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='消费统计';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shop_summary`
--

LOCK TABLES `shop_summary` WRITE;
/*!40000 ALTER TABLE `shop_summary` DISABLE KEYS */;
/*!40000 ALTER TABLE `shop_summary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbgoodsflowconsumestat`
--

DROP TABLE IF EXISTS `tbgoodsflowconsumestat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbgoodsflowconsumestat` (
  `iWorldId` varchar(60) DEFAULT NULL,
  `vOperate` varchar(60) DEFAULT NULL,
  `iGoodsId` int(11) DEFAULT NULL,
  `dtStatDate` datetime DEFAULT NULL,
  `iCount` int(11) DEFAULT NULL,
  `iUserNum` int(11) DEFAULT NULL,
  `iNum` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbgoodsflowconsumestat`
--

LOCK TABLES `tbgoodsflowconsumestat` WRITE;
/*!40000 ALTER TABLE `tbgoodsflowconsumestat` DISABLE KEYS */;
INSERT INTO `tbgoodsflowconsumestat` VALUES ('1','CREATE_GUILD',260002,'2018-12-05 00:00:00',1,1,1);
/*!40000 ALTER TABLE `tbgoodsflowconsumestat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbgoodsflowproducestat`
--

DROP TABLE IF EXISTS `tbgoodsflowproducestat`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbgoodsflowproducestat` (
  `iWorldId` varchar(60) DEFAULT NULL,
  `vOperate` varchar(60) DEFAULT NULL,
  `iGoodsId` int(11) DEFAULT NULL,
  `iCount` int(11) DEFAULT NULL,
  `iUserNum` int(11) DEFAULT NULL,
  `iNum` int(11) DEFAULT NULL,
  `dtStatDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbgoodsflowproducestat`
--

LOCK TABLES `tbgoodsflowproducestat` WRITE;
/*!40000 ALTER TABLE `tbgoodsflowproducestat` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbgoodsflowproducestat` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbrealrecharge`
--

DROP TABLE IF EXISTS `tbrealrecharge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbrealrecharge` (
  `totalRecharge` int(11) NOT NULL,
  `iWorldId` int(11) NOT NULL,
  `dtStatDate` datetime NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbrealrecharge`
--

LOCK TABLES `tbrealrecharge` WRITE;
/*!40000 ALTER TABLE `tbrealrecharge` DISABLE KEYS */;
INSERT INTO `tbrealrecharge` VALUES (0,1,'2018-12-24 11:20:00',1),(0,1,'2018-12-24 11:50:00',2);
/*!40000 ALTER TABLE `tbrealrecharge` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'dbdiablomuzhiresult'
--

--
-- Dumping routines for database 'dbdiablomuzhiresult'
--
/*!50003 DROP PROCEDURE IF EXISTS `insert_random_amount` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
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

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!50003 DROP PROCEDURE IF EXISTS `insert_random_online` */;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'STRICT_TRANS_TABLES,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
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

END ;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-24 18:32:40
