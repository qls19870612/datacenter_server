-- MySQL dump 10.13  Distrib 5.7.19, for linux-glibc2.12 (x86_64)
--
-- Host: localhost    Database: datacenter
-- ------------------------------------------------------
-- Server version	5.7.19

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
) ENGINE=InnoDB AUTO_INCREMENT=266 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=758 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-14 11:03:34
