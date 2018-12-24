-- MySQL dump 10.13  Distrib 5.7.19, for linux-glibc2.12 (x86_64)
--
-- Host: localhost    Database: dbdiablomuzhiresult
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
-- Table structure for table `createrole`
--

DROP TABLE IF EXISTS `createrole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `createrole` (
  `iEventId` varchar(255) NOT NULL,
  `iWorldId` int(11) unsigned DEFAULT NULL,
  `iUin` varchar(255) DEFAULT NULL,
  `dtEventTime` varchar(255) DEFAULT NULL,
  `vClientIp` varchar(255) DEFAULT NULL,
  `iRoleId` bigint(20) unsigned DEFAULT NULL,
  `vRoleName` varchar(255) DEFAULT NULL,
  `iJobId` int(10) unsigned DEFAULT NULL,
  `dt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`iEventId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
-- Table structure for table `recharge`
--

DROP TABLE IF EXISTS `recharge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recharge` (
  `iEventId` varchar(255) DEFAULT NULL,
  `dtEventTime` varchar(255) DEFAULT NULL,
  `iWorldId` int(11) unsigned DEFAULT NULL,
  `iUin` varchar(255) DEFAULT NULL,
  `iRoleId` bigint(20) unsigned DEFAULT NULL,
  `vRoleName` varchar(255) DEFAULT NULL,
  `iRoleLevel` int(10) unsigned DEFAULT NULL,
  `vSN` varchar(255) NOT NULL COMMENT '流水号',
  `iPayDelta` bigint(20) unsigned DEFAULT NULL COMMENT '充值金额',
  `iNewCash` bigint(20) unsigned DEFAULT NULL,
  `dt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`vSN`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rolelogin`
--

DROP TABLE IF EXISTS `rolelogin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rolelogin` (
  `iEventId` varchar(255) DEFAULT NULL,
  `iWorldId` int(11) unsigned DEFAULT NULL,
  `iUin` varchar(255) DEFAULT NULL,
  `dtEventTime` varchar(255) DEFAULT NULL,
  `vClientIp` varchar(255) DEFAULT NULL,
  `iRoleId` bigint(20) unsigned DEFAULT NULL,
  `vRoleName` varchar(255) DEFAULT NULL,
  `iJobId` int(10) unsigned DEFAULT NULL,
  `iRoleLevel` int(11) unsigned DEFAULT NULL,
  `iRoleExp` bigint(20) unsigned DEFAULT NULL,
  `dt` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shop`
--

DROP TABLE IF EXISTS `shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop` (
  `iEventId` varchar(255) NOT NULL,
  `iWorldId` int(11) NOT NULL,
  `dtEventTime` varchar(255) NOT NULL,
  `vClientIp` varchar(255) DEFAULT NULL,
  `iUin` varchar(255) DEFAULT NULL,
  `iRoleId` bigint(20) unsigned DEFAULT NULL,
  `vRoleName` varchar(255) DEFAULT NULL,
  `iJobId` int(10) unsigned DEFAULT NULL,
  `iCost` bigint(20) unsigned DEFAULT NULL,
  `iShopType` int(10) unsigned DEFAULT NULL,
  `iGoodsType` int(11) DEFAULT NULL,
  `iGoodsId` int(10) unsigned DEFAULT NULL,
  `iGoodsNum` int(10) unsigned DEFAULT NULL,
  `dt` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`iEventId`,`iWorldId`,`dtEventTime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-12-14 11:03:34
