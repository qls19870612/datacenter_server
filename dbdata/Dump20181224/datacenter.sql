CREATE DATABASE  IF NOT EXISTS `datacenter` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `datacenter`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: datacenter
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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '',
  `password` varchar(64) NOT NULL DEFAULT '',
  `realname` varchar(64) NOT NULL DEFAULT '',
  `stop` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `group_ids` text,
  `pid` int(10) DEFAULT '0',
  `level` tinyint(3) unsigned DEFAULT '0',
  `AllowGame` varchar(200) NOT NULL DEFAULT '',
  `AllowPlatform` varchar(2048) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admin','14e1b600b1fd579f47433b88e8d85291','administrator',0,'1',0,1,'diablo,tlbb','yy');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `admin_group`
--

DROP TABLE IF EXISTS `admin_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `power` text NOT NULL,
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ord` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_group`
--

LOCK TABLES `admin_group` WRITE;
/*!40000 ALTER TABLE `admin_group` DISABLE KEYS */;
INSERT INTO `admin_group` VALUES (1,'a','1',1,1);
/*!40000 ALTER TABLE `admin_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autologinlog`
--

DROP TABLE IF EXISTS `autologinlog`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autologinlog` (
  `iUid` int(10) DEFAULT NULL COMMENT '用户ID',
  `vIp` varchar(15) DEFAULT NULL COMMENT '登录IP',
  `dtDatetime` datetime DEFAULT NULL COMMENT '登录时间',
  `vAgent` varchar(500) DEFAULT NULL COMMENT '登录浏览器信息'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autologinlog`
--

LOCK TABLES `autologinlog` WRITE;
/*!40000 ALTER TABLE `autologinlog` DISABLE KEYS */;
/*!40000 ALTER TABLE `autologinlog` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autologinpassip`
--

DROP TABLE IF EXISTS `autologinpassip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autologinpassip` (
  `vPlt` varchar(50) DEFAULT '' COMMENT '平台名称',
  `vIp` varchar(16) DEFAULT '' COMMENT '验证通过的IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自动登录验证ip';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autologinpassip`
--

LOCK TABLES `autologinpassip` WRITE;
/*!40000 ALTER TABLE `autologinpassip` DISABLE KEYS */;
/*!40000 ALTER TABLE `autologinpassip` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `autologinuser`
--

DROP TABLE IF EXISTS `autologinuser`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `autologinuser` (
  `vPlt` varchar(20) NOT NULL DEFAULT '' COMMENT '平台名称',
  `iUserId` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  PRIMARY KEY (`vPlt`,`iUserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autologinuser`
--

LOCK TABLES `autologinuser` WRITE;
/*!40000 ALTER TABLE `autologinuser` DISABLE KEYS */;
/*!40000 ALTER TABLE `autologinuser` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game` (
  `gameid` int(11) NOT NULL AUTO_INCREMENT,
  `gamename` varchar(100) NOT NULL DEFAULT '',
  `gamecode` varchar(100) NOT NULL DEFAULT '',
  `pltlist` text,
  `LOGO` varchar(250) DEFAULT NULL,
  `gametype` int(11) NOT NULL DEFAULT '99',
  PRIMARY KEY (`gameid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game`
--

LOCK TABLES `game` WRITE;
/*!40000 ALTER TABLE `game` DISABLE KEYS */;
INSERT INTO `game` VALUES (8,'暗黑','diablo','muzhi','/view/images/gamelogo/diablo.jpg',1),(9,'天龙八部','tlbb','muzhi',NULL,1);
/*!40000 ALTER TABLE `game` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_report`
--

DROP TABLE IF EXISTS `game_report`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_report` (
  `gamecode` varchar(50) NOT NULL COMMENT '游戏代号',
  `rp_cid` varchar(50) NOT NULL COMMENT '报表代号',
  UNIQUE KEY `gr` (`gamecode`,`rp_cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_report`
--

LOCK TABLES `game_report` WRITE;
/*!40000 ALTER TABLE `game_report` DISABLE KEYS */;
INSERT INTO `game_report` VALUES ('diablo','daily_ltv'),('diablo','daily_retention'),('diablo','daily_status'),('diablo','monthly_status'),('diablo','online_by_day_dynamic_g'),('diablo','realtime_recharge_curves');
/*!40000 ALTER TABLE `game_report` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_server`
--

DROP TABLE IF EXISTS `game_server`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_server` (
  `gamecode` varchar(50) NOT NULL DEFAULT '' COMMENT '游戏代号',
  `worldid` int(11) NOT NULL DEFAULT '0' COMMENT '服务器的世界ID',
  `servername` varchar(100) NOT NULL DEFAULT '' COMMENT '服务器名称',
  `platform` varchar(50) NOT NULL DEFAULT '' COMMENT '平台名称',
  UNIQUE KEY `gws` (`gamecode`,`worldid`,`platform`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_server`
--

LOCK TABLES `game_server` WRITE;
/*!40000 ALTER TABLE `game_server` DISABLE KEYS */;
INSERT INTO `game_server` VALUES ('diablo',1,'s1','muzhi'),('diablo',2,'s2','muzhi'),('diablo',3,'s3','muzhi');
/*!40000 ALTER TABLE `game_server` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_group`
--

DROP TABLE IF EXISTS `menu_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(200) NOT NULL DEFAULT '' COMMENT '分组名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父类ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_group`
--

LOCK TABLES `menu_group` WRITE;
/*!40000 ALTER TABLE `menu_group` DISABLE KEYS */;
INSERT INTO `menu_group` VALUES (11,'基本运营信息',0),(12,'在线分析',0),(13,'用户分析',0),(14,'付费用户分析',0),(15,'收入分析',0),(16,'准实时类数据',0),(17,'游戏行为与特性分析',0),(21,'测试分类',17),(22,'装备系统',17),(23,'活跃行为相关统计',14),(24,'充值消费行为统计',14);
/*!40000 ALTER TABLE `menu_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `report_layout`
--

DROP TABLE IF EXISTS `report_layout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `report_layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rp_cid` varchar(50) NOT NULL,
  `rp_config` text,
  `rp_title` varchar(50) DEFAULT NULL,
  `rp_index` int(11) DEFAULT '99',
  `rp_mark` int(11) DEFAULT '11',
  `rp_url` text,
  `rp_interval` int(5) unsigned DEFAULT '7',
  `rp_start` int(5) unsigned DEFAULT '0',
  `rp_list` int(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `rp` (`rp_cid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=272 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `report_layout`
--

LOCK TABLES `report_layout` WRITE;
/*!40000 ALTER TABLE `report_layout` DISABLE KEYS */;
INSERT INTO `report_layout` VALUES (256,'realtime_recharge_curves',NULL,'实时充值对比曲线',99,16,'sp/general/realtime_recharge_curves.php',7,0,1),(262,'daily_status','4|50|datepicker|日期选择|fc59-ed8bf0c5|static%4|50|serverlist|服务器选择|4367-46786a4f|static%2|400|highchart|登录概况|b10b-458f62ea|ajax%2|400|highchart|充值概况|c575-e25b9bc1|ajax%2|400|highchart|消费概况|2133-8b9e01fb|ajax%2|400|highchart|注册概况|ea0c-c61f3f7c|ajax%4|600|mmgrid|每日总况|677e-1ed2fe91|ajax','每日总况',99,11,'',7,0,0),(263,'daily_retention','4|50|datepicker|注册日期|db56-c088e3d6|static%4|50|serverlist|服务器选择|5a55-9160cff1|static%4|400|mmgridspec|多日留存|3055-8925f0ea|ajax%2|400|highchart|留存率曲线图(起始日)|931c-bed9dc26|ajax%2|400|mmgrid|留存率(起始日)|0e18-9ffc4f70|ajax','每日留存',99,11,'',7,0,0),(264,'daily_ltv','4|50|datepicker|用户注册日期|c7c1-7f7b802c|static%4|50|serverlist|服务器选择|03dd-18c66dd1|static%4|50|parameter|LTV跨度|063d-c6a5d3e9|static%4|400|mmgridspec|LTV(单服)|3584-08a42c47|ajax%4|400|mmgridspec|LTV(汇总)|e905-6fb15f33|ajax%4|400|mmgridspec|LTV 15/30/60/90/120|456a-bce02f24|ajax','LTV(生命周期总价值)',99,11,'',7,0,0),(265,'monthly_status','4|50|datepicker|日期选择|193e-aa2b4450|static%4|50|serverlist|服务器选择|b5e9-3d42eb11|static%4|400|highchart|充值概况|cdbd-f94ed79c|ajax%4|400|highchart|登录概况|7e3d-5a0a7441|ajax%4|400|highchart|消费概况|314b-89396013|ajax%4|400|highchart|注册概况|3d7e-42e7fe8e|ajax%4|400|mmgrid|每月总况|7b5b-2e642db7|ajax','每月总况',99,11,'',93,0,0),(269,'online_by_day_dynamic_g',NULL,'实时在线人数',99,16,'sp/general/online_by_day_dynamic.php',7,0,0);
/*!40000 ALTER TABLE `report_layout` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sql_tpl`
--

DROP TABLE IF EXISTS `sql_tpl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sql_tpl` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sql_name` varchar(200) NOT NULL DEFAULT '' COMMENT '语句名称',
  `sql_content` text,
  `sql_memo` text COMMENT '语句备注',
  `sql_key` varchar(50) NOT NULL DEFAULT '',
  `mod_config` text,
  `suid` varchar(50) DEFAULT NULL,
  `pre_sql` text COMMENT '汇总指令',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`,`sql_key`,`suid`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=761 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sql_tpl`
--

LOCK TABLES `sql_tpl` WRITE;
/*!40000 ALTER TABLE `sql_tpl` DISABLE KEYS */;
INSERT INTO `sql_tpl` VALUES (1,'t2','select t1.date, roles, users, changeTotal, consumers, amount from (select date_format(dtEventtime,\'%Y-%m-%d\') as date,count(*) as users, \'{plt}\' as plt from {plt}_accountlogin where iworldid in ({sid}) and dtEventtime between \'{ft}\' and \'{et}\' group by date_format(dtEventtime,\'%Y-%m-%d\')) as t1 inner join (select date_format(dtEventtime,\'%Y-%m-%d\') as date,count(*) as roles, \'{plt}\' as plt from {plt}_createrole where iworldid in ({sid}) and dtEventtime between \'{ft}\' and \'{et}\' group by date_format(dtEventtime,\'%Y-%m-%d\')) as t2 on t1.date = t2.date inner join (select date_format(dtEventtime,\'%Y-%m-%d\') as date, Sum(iMoneyPay) as changeTotal, count(DISTINCT iUin) as consumers, cast(sum(iMoneyPay)/10 as decimal(10,2)) as amount from {plt}_recharge where iworldid in ({sid}) and dtEventtime between \'{ft}\' and \'{et}\' group by date_format(dtEventtime,\'%Y-%m-%d\')) as t3 on t1.date = t3.date','','bbb','','b8f0-542173e5','select date,sum(cc) ,plt from [SQL] group by date'),(11,'试试','select date_format(dtEventtime,\'%Y-%m-%d\') as date,\'{plt}\' as plt,count(*) as cc from {plt}_createrole where iworldid in ({sid}) and dteventtime between \'{ft}\' and \'{et}\' group by date_format(dtEventtime,\'%Y-%m-%d\')','','aaa','','87a5-20c3b25a','select date,sum(cc) ,plt from ([SQL]) as a group by date'),(61,'','select dtStatDate as statdate, iWorldId as worldid, iDayNewPayNum as daynewpaynum, iWeekNewPayNum as weeknewpaynum, iDWeekNewPayNum as dweeknewpaynum, iMonthNewPayNum as mouthnewpaynum from db{game}{plt}result.tbnewpayer where iworldid in ({sid})','','test0','{#@title#@:{#@text#@:#@Browser market shares at a specific website, 2010#@},#@tooltip#@:{#@pointFormat#@:#@{series.name}:{point.percentage:.1f}%#@},#@plotOptions#@:{#@pie#@:{#@allowPointSelect#@:1,#@cursor#@:#@pointer#@,#@dataLabels#@:{#@enabled#@:1,#@format#@:#@{point.name}:{point.percentage:.1f}%#@}}},#@series#@:[{#@type#@:#@pie#@,#@name#@:#@seriesName#@,#@data#@:[],#@key#@:#@optionName|optionData#@}]}','0000-00000000',''),(502,'',NULL,NULL,'tset10022',NULL,'c53f-1c7520c1',NULL),(503,'',NULL,NULL,'tset10022',NULL,'7b54-77144f5e',NULL),(710,'',NULL,NULL,'zhanjia_level_dis_by_day_new',NULL,'809d-ad8c8105',NULL),(711,'',NULL,NULL,'zhanjia_level_dis_by_day_new',NULL,'a3ab-f7e9b8bb',NULL),(712,'',NULL,NULL,'tianzui_level_dis_by_day_new',NULL,'2073-c84576f6',NULL),(713,'',NULL,NULL,'tianzui_level_dis_by_day_new',NULL,'2449-29ffeffd',NULL),(714,'',NULL,NULL,'tianzui_level_dis_by_day_new',NULL,'9e6c-211a881e',NULL),(716,'custom','select aHourRecharge, bHourRecharge, cHourRecharge, dd.dtstattime from (select tplFiveMinutes as dtstattime from db{game}conf.tbtemplatebyfiveminutes) as dd left join (select sum(iHourRecharge) as aHourRecharge, aHour from (select max(iHourRecharge) as iHourRecharge, DATE_FORMAT(dtStatTime,\'%H:%i\') as aHour, iWorldId from db{game}{plt}result.tbrealrecharge WHERE iWorldId in ({sid}) and DATE_FORMAT(dtStatTime,\'%Y-%m-%d\') =\'{time_a}\'  GROUP BY iWorldId, DATE_FORMAT(dtStatTime,\'%H:%i\')) as a GROUP BY aHour) as aa on dd.dtstattime = aa.aHour left join (select sum(iHourRecharge) as bHourRecharge, aHour from (select max(iHourRecharge) as iHourRecharge, DATE_FORMAT(dtStatTime,\'%H:%i\') as aHour, iWorldId from db{game}{plt}result.tbrealrecharge WHERE iWorldId in ({sid}) and DATE_FORMAT(dtStatTime,\'%Y-%m-%d\') =\'{time_b}\'  GROUP BY iWorldId, DATE_FORMAT(dtStatTime,\'%H:%i\')) as b GROUP BY aHour) as bb on dd.dtstattime = bb.aHour left join (select sum(iHourRecharge) as cHourRecharge, aHour from (select max(iHourRecharge) as iHourRecharge, DATE_FORMAT(dtStatTime,\'%H:%i\') as aHour, iWorldId from db{game}{plt}result.tbrealrecharge WHERE iWorldId in ({sid}) and DATE_FORMAT(dtStatTime,\'%Y-%m-%d\') =\'{time_c}\'  GROUP BY iWorldId, DATE_FORMAT(dtStatTime,\'%H:%i\')) as c GROUP BY aHour) as cc on dd.dtstattime = cc.aHour',NULL,'realtime_recharge_curves',NULL,'e055-3c1503b0','select round(sum(aHourRecharge)/100,2) as aHourRecharge, round(sum(bHourRecharge)/100,2) as bHourRecharge, round(sum(cHourRecharge)/100,2) as cHourRecharge, CONCAT(DATE_FORMAT(now(),\'%Y-%m-%d \'), dtstattime, \':00\') as dtstattime from ([SQL]) as tmp group by dtstattime'),(739,'','select dtStatDate,sum(LoginAccount) iAccountCount\r\nfrom db{game}{plt}result.daily_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate',NULL,'daily_status','{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@登录概况#@},#@subtitle#@:{#@text#@:#@登录概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@登录人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}','b10b-458f62ea','select substr(dtStatDate,6,10) dtStatDate,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate'),(740,'','select dtStatDate, sum(PayAmount) iAmount,sum(PayAccount) iAccountCount\r\nfrom db{game}{plt}result.daily_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate',NULL,'daily_status','{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@充值概况#@},#@subtitle#@:{#@text#@:#@充值概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}元#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}},{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false},#@opposite#@:true}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@充值金额#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@元#@},#@key#@:#@iAmount#@,#@data#@:[]},{#@name#@:#@充值人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:1,#@type#@:#@line#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}','c575-e25b9bc1','select substr(dtStatDate,6,10) dtStatDate,round(sum(iAmount),2) iAmount,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate'),(741,'','select dtStatDate, sum(ShopAmount) iAmount, sum(ShopAccount) iAccountCount\r\nfrom db{game}{plt}result.daily_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate',NULL,'daily_status','{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@消费概况#@},#@subtitle#@:{#@text#@:#@消费概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}元#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}},{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false},#@opposite#@:true}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@消费金额#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@元#@},#@key#@:#@iAmount#@,#@data#@:[]},{#@name#@:#@消费人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:1,#@type#@:#@line#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}','2133-8b9e01fb','select substr(dtStatDate,6,10) dtStatDate,round(sum(iAmount),2) iAmount,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate'),(742,'','select dtStatDate, sum(RegisterAccount) iAccountCount\r\nfrom db{game}{plt}result.daily_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate',NULL,'daily_status','{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@注册概况#@},#@subtitle#@:{#@text#@:#@注册概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@注册人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}','ea0c-c61f3f7c','select substr(dtStatDate,6,10) dtStatDate, sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate'),(743,'','select dl.dtStatDate,dl.loginCount,ifnull(wb.iOpenNum,0) iOpenNum,rechargeAmount rechargeAmount,rechargeAccountCount,createAccountCount,iShopAccount,iShopAmount iShopAmount\r\nfrom (\r\n	SELECT dtStatDate,sum(LoginAccount) loginCount,sum(PayAmount) rechargeAmount,sum(PayAccount) rechargeAccountCount,sum(RegisterAccount) createAccountCount,sum(ShopAccount) iShopAccount,sum(ShopAmount) iShopAmount\r\n	FROM db{game}{plt}result.daily_basic\r\n	WHERE dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\n	group by dtStatDate\r\n) dl left join (\r\n	SELECT dtBeginDate,count(iWorldId) iOpenNum\r\n	FROM db{game}conf.tbworldbegindate\r\n	WHERE vPlt = \'{plt}\'\r\n	AND dtBeginDate >= \'{ft}\'\r\n	AND dtBeginDate <= \'{et}\'\r\n	GROUP BY dtBeginDate\r\n) wb on dl.dtStatDate=wb.dtBeginDate',NULL,'daily_status','{#@column#@:[{#@title#@:#@日期#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@dtStatDate#@,#@type#@:#@0#@},{#@title#@:#@开服数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iOpenNum#@,#@type#@:#@number#@},{#@title#@:#@注册人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@createAccountCount#@,#@type#@:#@number#@},{#@title#@:#@登录人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@loginCount#@,#@type#@:#@number#@},{#@title#@:#@充值金额#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeAmount#@,#@type#@:#@number#@},{#@title#@:#@充值人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeAccountCount#@,#@type#@:#@number#@},{#@title#@:#@消费金额#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iShopAmount#@,#@type#@:#@number#@},{#@title#@:#@消费人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iShopAccount#@,#@type#@:#@number#@},{#@title#@:#@ARPU#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@arpu#@,#@type#@:#@number#@},{#@title#@:#@ARPPU#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@arppu#@,#@type#@:#@number#@},{#@title#@:#@充值渗透率(%)#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeRate#@,#@type#@:#@number#@},{#@title#@:#@老用户数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@oldAccount#@,#@type#@:#@number#@},{#@title#@:#@老用户比(%)#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@oldAccountRate#@,#@type#@:#@number#@}],#@paging#@:32}','677e-1ed2fe91','select *,round(rechargeAmount/loginCount,2) arpu,round(rechargeAmount/rechargeAccountCount,2) arppu,round(rechargeAccountCount/loginCount*100,2) rechargeRate,loginCount-createAccountCount oldAccount,round((loginCount-createAccountCount)/loginCount*100,2) oldAccountRate,iShopAccount,iShopAmount\r\nfrom (\r\nselect dtStatDate,sum(loginCount) loginCount,sum(iOpenNum) iOpenNum,round(sum(rechargeAmount),2) rechargeAmount,sum(rechargeAccountCount) rechargeAccountCount ,\r\n      sum(createAccountCount) createAccountCount,sum(iShopAccount) iShopAccount,round(sum(iShopAmount),2) iShopAmount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate\r\norder by dtStatDate desc\r\n) o\r\n\r\nunion all\r\n\r\nselect *,round(rechargeAmount/loginCount,2) arpu,round(rechargeAmount/rechargeAccountCount,2) arppu,round(rechargeAccountCount/loginCount*100,2) rechargeRate,loginCount-createAccountCount oldAccount,round((loginCount-createAccountCount)/loginCount*100,2) oldAccountRate,iShopAccount,iShopAmount\r\nfrom (\r\nselect \'汇总\' dtStatDate,sum(loginCount) loginCount,sum(iOpenNum) iOpenNum,round(sum(rechargeAmount),2) rechargeAmount,sum(rechargeAccountCount) rechargeAccountCount ,\r\n      sum(createAccountCount) createAccountCount,sum(iShopAccount) iShopAccount,round(sum(iShopAmount),2) iShopAmount\r\nfrom ([SQL]) t\r\n) a'),(744,'','select  RegisterDate,dtStatDate,sum(RetentionNum) iRetentionNum\r\nfrom db{game}{plt}result.daily_retention\r\nwhere RegisterDate between \'{ft}\' and \'{et}\' and dtStatDate between RegisterDate and adddate(RegisterDate,interval 30 day) and worldid in ({sid}) \r\ngroup by RegisterDate,dtStatDate',NULL,'daily_retention','{#@column#@:[{#@title#@:#@注册日期#@,#@name#@:#@RegisterDate#@},{#@title#@:#@days#@,#@name#@:#@rate#@}]}','3055-8925f0ea','select dtStatDate,a.RegisterDate,iRetentionNum,round(iRetentionNum/iRegNum*100,2) rate,concat(\'第\',datediff(dtStatDate,a.RegisterDate)+1,\'天\') days\r\nfrom (\r\n  select RegisterDate,dtStatDate,sum(iRetentionNum) iRetentionNum\r\n  from ([SQL]) t\r\n  where dtStatDate!=RegisterDate\r\n  group by RegisterDate,dtStatDate\r\n) d left join (\r\n  select RegisterDate,sum(iRetentionNum) iRegNum\r\n  from ([SQL]) tt\r\n  where dtStatDate=RegisterDate\r\n  group by RegisterDate\r\n) a on d.RegisterDate=a.RegisterDate\r\norder by RegisterDate asc, datediff(dtStatDate,a.RegisterDate) asc'),(745,'','select dtStatDate,sum(RetentionNum) iRetentionNum,\'{ft}\' regDate\r\nfrom db{game}{plt}result.daily_retention\r\nwhere RegisterDate=\'{ft}\' and dtStatDate between \'{ft}\' and adddate(\'{ft}\',interval 30 day) and worldid in ({sid}) \r\ngroup by dtStatDate',NULL,'daily_retention','{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@留存率曲线图#@},#@subtitle#@:{#@text#@:#@起始日#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@days#@,#@series#@:[{#@name#@:#@留存率#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@line#@,#@tooltip#@:{#@valueSuffix#@:#@%#@},#@key#@:#@rate#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}','931c-bed9dc26','select dtStatDate,iRetentionNum,round(iRetentionNum/iRegNum*100,2) rate,datediff(dtStatDate,regDate)+1 days\r\nfrom (\r\nselect dtStatDate,sum(iRetentionNum) iRetentionNum,regDate\r\nfrom ([SQL]) t\r\nwhere dtStatDate!=regDate\r\ngroup by dtStatDate\r\n) d left join (\r\nselect sum(iRetentionNum) iRegNum\r\nfrom ([SQL]) tt\r\nwhere dtStatDate=regDate\r\n) a on 1=1'),(746,'','select dtStatDate,sum(RetentionNum) iRetentionNum,\'{ft}\' regDate\r\nfrom db{game}{plt}result.daily_retention\r\nwhere RegisterDate=\'{ft}\' and dtStatDate between \'{ft}\' and adddate(\'{ft}\',interval 60 day) and worldid in ({sid}) \r\ngroup by dtStatDate',NULL,'daily_retention','{#@column#@:[{#@title#@:#@留存日期#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@dtStatDate#@,#@type#@:#@0#@},{#@title#@:#@留存天数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@days#@,#@type#@:#@number#@},{#@title#@:#@留存人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iRetentionNum#@,#@type#@:#@number#@},{#@title#@:#@留存率(%)#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rate#@,#@type#@:#@number#@}]}','0e18-9ffc4f70','select dtStatDate,iRetentionNum,round(iRetentionNum/iRegNum*100,2) rate,concat(\'第\',datediff(dtStatDate,regDate)+1,\'天\') days\r\nfrom (\r\nselect dtStatDate,sum(iRetentionNum) iRetentionNum,regDate\r\nfrom ([SQL]) t\r\nwhere dtStatDate!=regDate\r\ngroup by dtStatDate\r\n) d left join (\r\nselect sum(iRetentionNum) iRegNum\r\nfrom ([SQL]) tt\r\nwhere dtStatDate=regDate\r\n) a on 1=1'),(747,'','',NULL,'daily_ltv','{#@parameter#@:[{#@title#@:#@跨度(7/15/30)#@,#@name#@:#@inter_days#@,#@type#@:#@text#@,#@value#@:#@7#@}]}','063d-c6a5d3e9',''),(748,'','select concat(RegisterDate,\' @\',\'{plt}\',\' #\',WorldId) dateAndSid,round(TotalPayAmount/RegisterNum,2) iLTV,concat(\'LTV\',datediff(dtStatDate,RegisterDate)+1) vdays,datediff(dtStatDate,RegisterDate)+1 idays\r\nfrom db{game}{plt}result.daily_ltv\r\nwhere RegisterDate between \'{ft}\' and \'{et}\' \r\nand  dtStatDate between RegisterDate and adddate(RegisterDate ,interval {inter_days}-1 day) \r\nand  worldid in ({sid})',NULL,'daily_ltv','{#@column#@:[{#@title#@:#@注册日期 @平台 #区服#@,#@name#@:#@dateAndSid#@},{#@title#@:#@vdays#@,#@name#@:#@iLTV#@}]}','3584-08a42c47','select *\r\nfrom ([SQL]) t\r\norder by dateAndSid,idays'),(749,'','select RegisterDate,TotalPayAmount TotalPayAmount,RegisterNum,datediff(dtStatDate,RegisterDate)+1 idays\r\nfrom db{game}{plt}result.daily_ltv\r\nwhere RegisterDate between \'{ft}\' and \'{et}\' \r\nand  dtStatDate between RegisterDate and adddate(RegisterDate ,interval {inter_days}-1 day) \r\nand  worldid in ({sid})',NULL,'daily_ltv','{#@column#@:[{#@title#@:#@注册日期#@,#@name#@:#@RegisterDate#@},{#@title#@:#@vdays#@,#@name#@:#@iLtv#@}]}','e905-6fb15f33','select RegisterDate,ifnull(round(sum(TotalPayAmount)/sum(RegisterNum),2),0) iLtv,concat(\'LTV\',idays) vdays\r\nfrom ([SQL]) t\r\ngroup by RegisterDate,idays\r\norder by RegisterDate,idays'),(750,'','select concat(RegisterDate,\' @\',\'{plt}\',\' #\',WorldId) dateAndSid,round(TotalPayAmount/RegisterNum,2) iLTV,concat(\'LTV\',datediff(dtStatDate,RegisterDate)+1) vdays,datediff(dtStatDate,RegisterDate)+1 idays\r\nfrom db{game}{plt}result.daily_ltv\r\nwhere RegisterDate between \'{ft}\' and \'{et}\' \r\nand  dtStatDate in (adddate(RegisterDate ,interval 15-1 day),adddate(RegisterDate ,interval 30-1 day),adddate(RegisterDate ,interval 60-1 day),adddate(RegisterDate ,interval 90-1 day),adddate(RegisterDate ,interval 120-1 day))\r\nand WorldId in ({sid})',NULL,'daily_ltv','{#@column#@:[{#@title#@:#@注册日期 @平台 #区服#@,#@name#@:#@dateAndSid#@},{#@title#@:#@vdays#@,#@name#@:#@iLTV#@}]}','456a-bce02f24','select *\r\nfrom ([SQL]) t\r\norder by dateAndSid,idays'),(751,'','select date_format(dtStatDate, \'%Y-%m\') dtStatDate,sum(PayAmount) iAmount,sum(PayAccount) iAccountCount\r\nfrom db{game}{plt}result.monthly_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate',NULL,'monthly_status','{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@充值概况#@},#@subtitle#@:{#@text#@:#@充值概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}元#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}},{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false},#@opposite#@:true}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@充值金额#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@元#@},#@key#@:#@iAmount#@,#@data#@:[]},{#@name#@:#@充值人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:1,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}','cdbd-f94ed79c','select dtStatDate,round(sum(iAmount),2) iAmount,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate'),(752,'','select date_format(dtStatDate, \'%Y-%m\') dtStatDate,sum(LoginAccount) iAccountCount\r\nfrom db{game}{plt}result.monthly_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate',NULL,'monthly_status','{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@注册概况#@},#@subtitle#@:{#@text#@:#@注册概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@注册人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}','7e3d-5a0a7441','select dtStatDate,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate'),(753,'','select date_format(dtStatDate, \'%Y-%m\') dtStatDate,sum(ShopAmount) iAmount,sum(ShopAccount) iAccountCount from db{game}{plt}result.monthly_basic where dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) group by dtStatDate',NULL,'monthly_status','{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@消费概况#@},#@subtitle#@:{#@text#@:#@消费概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}元#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}},{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false},#@opposite#@:true}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@消费金额#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@元#@},#@key#@:#@iAmount#@,#@data#@:[]},{#@name#@:#@消费人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:1,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}','314b-89396013','select dtStatDate,round(sum(iAmount),2) iAmount,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate'),(754,'','select date_format(dtStatDate, \'%Y-%m\') dtStatDate,sum(RegisterAccount) iAccountCount\r\nfrom db{game}{plt}result.monthly_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate',NULL,'monthly_status','{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@注册概况#@},#@subtitle#@:{#@text#@:#@注册概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}},{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false},#@opposite#@:true}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@注册人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}','3d7e-42e7fe8e','select dtStatDate,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate'),(755,'','select dl.dtStatDate,dl.loginCount,ifnull(wb.iOpenNum,0) iOpenNum,rechargeAmount rechargeAmount,rechargeAccountCount,createAccountCount,iNewPayAmount iNewPayAmount,iNewPayAccount,iShopAccount,iShopAmount iShopAmount\r\nfrom (\r\n	SELECT date_format(dtStatDate, \'%Y-%m\') dtStatDate,sum(LoginAccount) loginCount,sum(PayAmount) rechargeAmount,sum(PayAccount) rechargeAccountCount,sum(NewPayAmount) iNewPayAmount,sum(NewPayAccount) iNewPayAccount,\r\n               sum(RegisterAccount) createAccountCount,sum(ShopAccount) iShopAccount,sum(ShopAmount) iShopAmount\r\n	FROM db{game}{plt}result.monthly_basic\r\n	WHERE dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\n	group by dtStatDate\r\n) dl left join (\r\n	SELECT date_format(dtBeginDate, \'%Y-%m\') dtBeginDate,count(iWorldId) iOpenNum\r\n	FROM db{game}conf.tbworldbegindate\r\n	WHERE vPlt = \'{plt}\'\r\n	AND dtBeginDate >= \'{ft}\'\r\n	AND dtBeginDate <= \'{et}\'\r\n	GROUP BY date_format(dtBeginDate, \'%Y-%m\')\r\n) wb on dl.dtStatDate=wb.dtBeginDate',NULL,'monthly_status','{#@column#@:[{#@title#@:#@日期#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@dtStatDate#@,#@type#@:#@0#@},{#@title#@:#@开服数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iOpenNum#@,#@type#@:#@number#@},{#@title#@:#@注册人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@createAccountCount#@,#@type#@:#@number#@},{#@title#@:#@登录人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@loginCount#@,#@type#@:#@number#@},{#@title#@:#@充值金额#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeAmount#@,#@type#@:#@number#@},{#@title#@:#@充值人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeAccountCount#@,#@type#@:#@number#@},{#@title#@:#@消费金额#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iShopAmount#@,#@type#@:#@number#@},{#@title#@:#@消费人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iShopAccount#@,#@type#@:#@number#@},{#@title#@:#@ARPU#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@arpu#@,#@type#@:#@number#@},{#@title#@:#@ARPPU#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@arppu#@,#@type#@:#@number#@},{#@title#@:#@充值渗透率(%)#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeRate#@,#@type#@:#@number#@},{#@title#@:#@老用户数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@oldAccount#@,#@type#@:#@number#@},{#@title#@:#@老用户比(%)#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@oldAccountRate#@,#@type#@:#@number#@},{#@title#@:#@新注册充值人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iNewPayAccount#@,#@type#@:#@number#@},{#@title#@:#@新注册充值金额#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iNewPayAmount#@,#@type#@:#@number#@}]}','7b5b-2e642db7','select *,round(rechargeAmount/loginCount,2) arpu,round(rechargeAmount/rechargeAccountCount,2) arppu,rechargeAccountCount/loginCount*100 rechargeRate,loginCount-createAccountCount oldAccount,(loginCount-createAccountCount)/loginCount*100 oldAccountRate,iShopAccount,iShopAmount,iNewPayAmount,iNewPayAccount\r\nfrom (\r\nselect dtStatDate,sum(loginCount) loginCount,sum(iOpenNum) iOpenNum,round(sum(rechargeAmount),2) rechargeAmount,sum(rechargeAccountCount) rechargeAccountCount ,\r\n      sum(createAccountCount) createAccountCount,sum(iShopAccount) iShopAccount,round(sum(iShopAmount),2) iShopAmount,round(sum(iNewPayAmount),2) iNewPayAmount,sum(iNewPayAccount) iNewPayAccount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate\r\norder by dtStatDate desc\r\n) o'),(756,'','',NULL,'monthly_status','{#@dptimepick#@:1,#@dpmethod#@:0}','193e-aa2b4450',''),(757,'',NULL,NULL,'daily_ltv',NULL,'c7c1-7f7b802c',NULL),(758,'custom','select player_count as playercount, account_count as accountcount, dtStatDate as stattime from online_count where iWorldId IN ({sid}) and dtStatDate between \'{ft}\' and \'{et}\'',NULL,'online_by_day_dynamic_g',NULL,'1c85-f14233da',''),(759,'custom','SELECT max(totalRecharge) FROM dbdiablomuzhiresult.tbrealrecharge where iWorldId IN ({sid}) and dtStatDate <= \'{ft}\'',NULL,'online_by_day_dynamic_g',NULL,'cdcb-e08d105b','select round((totalRecharge - (ifnull(([SQL]),0)))/100,2) as addrecharge,dtStatDate as stattime from tbrealrecharge where iWorldId IN ({sid}) and dtStatDate  between \'{ft}\' and \'{et}\' group by dtStatDate'),(760,'custom','select a.dtStatDate as stattime,a.playercount, b.accountcount from (\r\n(SELECT \r\n    (playerCount - ifnull((SELECT \r\n            MAX(playerCount) as playerCount\r\n        FROM\r\n            dbdiablomuzhiresult.create_count\r\n        WHERE\r\n            dtStatDate <= \'{ft}\' and iWorldId IN ({sid})),0)\r\n) AS playercount,\r\n    dtStatDate\r\nFROM\r\n    create_count\r\nWHERE\r\n    iWorldId IN ({sid})\r\n        AND dtStatDate BETWEEN \'{ft}\' AND \'{et}\'  group by dtStatDate) as a left join\r\n        (\r\n        SELECT \r\n    (accountCount - ifnull((SELECT \r\n            MAX(accountCount) as playerCount\r\n        FROM\r\n            dbdiablomuzhiresult.create_count\r\n        WHERE\r\n            dtStatDate <= \'{ft}\' and iWorldId IN ({sid})),0)\r\n) AS accountcount\r\n,\r\n    dtStatDate\r\nFROM\r\n    create_count\r\nWHERE\r\n    iWorldId IN ({sid})\r\n        AND dtStatDate BETWEEN \'{ft}\' AND \'{et}\'  group by dtStatDate) as b on a.dtStatDate=b.dtStatDate)',NULL,'online_by_day_dynamic_g',NULL,'fd7a-7e291ac7','');
/*!40000 ALTER TABLE `sql_tpl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'datacenter'
--

--
-- Dumping routines for database 'datacenter'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-24 12:05:00
