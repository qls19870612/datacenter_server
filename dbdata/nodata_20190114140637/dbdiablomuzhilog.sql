-- MySQL dump 10.13  Distrib 5.7.19, for linux-glibc2.12 (x86_64)
--
-- Host: localhost    Database: dbdiablomuzhilog
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
-- Table structure for table `createrole`
--

DROP TABLE IF EXISTS `createrole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `createrole` (
  `iEventId` varchar(60) DEFAULT NULL COMMENT '游戏事件ID',
  `iWorldId` int(11) DEFAULT NULL COMMENT '游戏大区ID',
  `iUin` varchar(60) DEFAULT NULL COMMENT '用户ID',
  `dtEventTime` datetime DEFAULT NULL COMMENT '记录时间, 格式 YYYY-MM-DD HH:MM:SS',
  `iRoleId` bigint(20) DEFAULT NULL COMMENT '角色ID',
  `vClientIp` varchar(16) DEFAULT NULL COMMENT '客户端所在ip',
  `vRoleName` varchar(20) DEFAULT NULL COMMENT '角色名',
  `iJobId` tinyint(11) DEFAULT NULL COMMENT '角色职业',
  `iLoginWay` int(11) DEFAULT NULL COMMENT '登录渠道',
  `dt` varchar(20) DEFAULT NULL COMMENT '记录时间日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `goodsflow`
--

DROP TABLE IF EXISTS `goodsflow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `goodsflow` (
  `iEventId` varchar(60) DEFAULT NULL COMMENT '操作ID',
  `iWorldId` int(11) DEFAULT NULL COMMENT '游戏大区ID',
  `iUin` varchar(60) DEFAULT NULL COMMENT '用户ID',
  `dtEventTime` datetime DEFAULT NULL COMMENT '记录时间, 格式 YYYY-MM-DD HH:MM:SS',
  `iRoleId` bigint(20) DEFAULT NULL COMMENT '角色ID',
  `vRoleName` varchar(60) DEFAULT NULL COMMENT '角色名',
  `vOperate` varchar(60) DEFAULT NULL COMMENT '操作类型',
  `iGoodsId` int(11) DEFAULT NULL COMMENT '物品id',
  `vGoodsName` varchar(60) DEFAULT NULL COMMENT '物品名字',
  `iCount` int(11) DEFAULT NULL COMMENT '个数',
  `iTotalCount` int(11) DEFAULT NULL COMMENT '动作后的道具总个数',
  `iIdentifier` int(11) DEFAULT NULL COMMENT '标识 1是得到，2是失去',
  `dt` varchar(20) DEFAULT NULL COMMENT '记录时间日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `moneyflow`
--

DROP TABLE IF EXISTS `moneyflow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moneyflow` (
  `iEventId` varchar(60) DEFAULT NULL COMMENT '游戏事件ID',
  `iWorldId` int(11) DEFAULT NULL COMMENT '游戏大区ID',
  `iUin` varchar(60) DEFAULT NULL COMMENT '用户ID',
  `dtEventTime` datetime DEFAULT NULL COMMENT '记录时间, 格式 YYYY-MM-DD HH:MM:SS',
  `iRoleId` bigint(20) DEFAULT NULL COMMENT '角色ID',
  `vRoleName` varchar(20) DEFAULT NULL COMMENT '角色名',
  `iJobId` tinyint(11) DEFAULT NULL COMMENT '角色职业',
  `iRoleLevel` int(11) DEFAULT NULL COMMENT '角色等级',
  `iMoneyBeforer` bigint(20) DEFAULT NULL COMMENT '动作前的金钱数',
  `iMoneyAfter` bigint(20) DEFAULT NULL COMMENT '动作后的金钱数',
  `iMoney` bigint(20) DEFAULT NULL COMMENT '动作涉及的金钱数',
  `iMoneyType` int(11) DEFAULT NULL COMMENT '金钱的类型',
  `iAction` int(11) DEFAULT NULL COMMENT '动作,发生原因',
  `dt` varchar(20) DEFAULT NULL COMMENT '记录时间日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `recharge`
--

DROP TABLE IF EXISTS `recharge`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `recharge` (
  `iEventId` varchar(60) DEFAULT NULL COMMENT '操作ID',
  `dtEventTime` datetime DEFAULT NULL COMMENT '记录时间, 格式 YYYY-MM-DD HH:MM:SS',
  `iWorldId` int(11) DEFAULT NULL COMMENT '游戏大区ID',
  `iUin` varchar(60) DEFAULT NULL COMMENT '用户ID',
  `iRoleId` bigint(20) DEFAULT NULL COMMENT '角色ID',
  `vRoleName` varchar(20) DEFAULT NULL COMMENT '角色名',
  `iRoleLevel` int(11) DEFAULT NULL COMMENT '角色等级',
  `vSN` varchar(64) DEFAULT NULL COMMENT '流水号',
  `ts` int(11) DEFAULT NULL COMMENT '充值时间',
  `iPayDelta` int(11) DEFAULT NULL COMMENT '充值金额',
  `iNewCash` bigint(20) DEFAULT NULL COMMENT '元宝余量',
  `vSubType` varchar(64) DEFAULT NULL COMMENT '子类型',
  `iLoginWay` int(11) DEFAULT NULL COMMENT '登录渠道',
  `dt` varchar(20) DEFAULT NULL COMMENT '记录时间日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rolelevelup`
--

DROP TABLE IF EXISTS `rolelevelup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rolelevelup` (
  `iEventId` varchar(60) DEFAULT NULL COMMENT '游戏事件ID',
  `iWorldId` int(11) DEFAULT NULL COMMENT '游戏大区ID',
  `iUin` varchar(60) DEFAULT NULL COMMENT '用户ID',
  `dtEventTime` datetime DEFAULT NULL COMMENT '记录时间, 格式 YYYY-MM-DD HH:MM:SS',
  `iRoleId` bigint(20) DEFAULT NULL COMMENT '角色ID',
  `vClientIp` varchar(16) DEFAULT NULL COMMENT '客户端所在ip',
  `vRoleName` varchar(20) DEFAULT NULL COMMENT '角色名',
  `iJobId` tinyint(11) DEFAULT NULL COMMENT '角色职业',
  `iRoleLevel` int(11) DEFAULT NULL COMMENT '角色等级',
  `iRoleExp` bigint(20) DEFAULT NULL COMMENT '角色经验值',
  `iMoney` bigint(20) DEFAULT NULL COMMENT '角色金币数',
  `iLijin` bigint(20) DEFAULT NULL COMMENT '角色绑钻数量',
  `iGamePoints` bigint(20) DEFAULT NULL COMMENT '角色钻石数量',
  `dtCreateTime` datetime DEFAULT NULL COMMENT '角色创建的时间',
  `iOnlineTotalTime` int(11) DEFAULT NULL COMMENT '角色总在线时长',
  `iReason` int(11) DEFAULT NULL COMMENT '升级原因',
  `iLoginWay` int(11) DEFAULT NULL COMMENT '登录渠道',
  `dt` varchar(20) DEFAULT NULL COMMENT '记录时间日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rolelogin`
--

DROP TABLE IF EXISTS `rolelogin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rolelogin` (
  `iEventId` varchar(60) DEFAULT NULL COMMENT '游戏事件ID',
  `iWorldId` int(11) DEFAULT NULL COMMENT '游戏大区ID',
  `iUin` varchar(60) DEFAULT NULL COMMENT '用户ID',
  `dtEventTime` datetime DEFAULT NULL COMMENT '记录时间, 格式 YYYY-MM-DD HH:MM:SS',
  `iRoleId` bigint(20) DEFAULT NULL COMMENT '角色ID',
  `vClientIp` varchar(16) DEFAULT NULL COMMENT '客户端所在ip',
  `vRoleName` varchar(20) DEFAULT NULL COMMENT '角色名',
  `iJobId` tinyint(11) DEFAULT NULL COMMENT '角色职业',
  `iRoleLevel` int(11) DEFAULT NULL COMMENT '角色等级',
  `iRoleExp` bigint(20) DEFAULT NULL COMMENT '角色经验值',
  `iMoney` bigint(20) DEFAULT NULL COMMENT '角色金币数',
  `iLijin` bigint(20) DEFAULT NULL COMMENT '角色绑钻数量',
  `iGamePoints` bigint(20) DEFAULT NULL COMMENT '角色钻石数量',
  `dtCreateTime` datetime DEFAULT NULL COMMENT '角色创建的时间',
  `iOnlineTotalTime` int(11) DEFAULT NULL COMMENT '角色总在线时长',
  `iLoginWay` int(11) DEFAULT NULL COMMENT '登录渠道',
  `dt` varchar(20) DEFAULT NULL COMMENT '记录时间日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `rolelogout`
--

DROP TABLE IF EXISTS `rolelogout`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rolelogout` (
  `iEventId` varchar(60) DEFAULT NULL COMMENT '游戏事件ID',
  `iWorldId` int(11) DEFAULT NULL COMMENT '游戏大区ID',
  `iUin` varchar(60) DEFAULT NULL COMMENT '用户ID',
  `dtEventTime` datetime DEFAULT NULL COMMENT '记录时间, 格式 YYYY-MM-DD HH:MM:SS',
  `dtLoginTime` datetime DEFAULT NULL COMMENT '登录时间, 格式 YYYY-MM-DD HH:MM:SS',
  `iRoleId` bigint(20) DEFAULT NULL COMMENT '角色ID',
  `vClientIp` varchar(16) DEFAULT NULL COMMENT '客户端所在ip',
  `dtCreateTime` datetime DEFAULT NULL COMMENT '角色创建的时间',
  `iOnlineTime` int(11) DEFAULT NULL COMMENT '本次登录在线时间',
  `iOnlineTotalTime` int(11) DEFAULT NULL COMMENT '角色总在线时长',
  `vRoleName` varchar(20) DEFAULT NULL COMMENT '角色名',
  `iJobId` tinyint(11) DEFAULT NULL COMMENT '角色职业',
  `iRoleLevel` int(11) DEFAULT NULL COMMENT '角色等级',
  `iRoleExp` bigint(20) DEFAULT NULL COMMENT '角色经验值',
  `iMoney` bigint(20) DEFAULT NULL COMMENT '角色金币数',
  `iLijin` bigint(20) DEFAULT NULL COMMENT '角色绑钻数量',
  `iGamePoints` bigint(20) DEFAULT NULL COMMENT '角色钻石数量',
  `iLoginWay` int(11) DEFAULT NULL COMMENT '登录渠道',
  `dt` varchar(20) DEFAULT NULL COMMENT '记录时间日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `shop`
--

DROP TABLE IF EXISTS `shop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shop` (
  `iEventId` varchar(60) DEFAULT NULL COMMENT '游戏事件ID',
  `iWorldId` int(11) DEFAULT NULL COMMENT '游戏大区ID',
  `iUin` varchar(60) DEFAULT NULL COMMENT '用户ID',
  `dtEventTime` datetime DEFAULT NULL COMMENT '记录时间, 格式 YYYY-MM-DD HH:MM:SS',
  `iRoleId` bigint(20) DEFAULT NULL COMMENT '角色ID',
  `vClientIp` varchar(16) DEFAULT NULL COMMENT '客户端所在ip',
  `vRoleName` varchar(20) DEFAULT NULL COMMENT '角色名',
  `iJobId` tinyint(11) DEFAULT NULL COMMENT '角色职业',
  `iCost` bigint(20) DEFAULT NULL COMMENT '支付消耗',
  `iShopType` tinyint(11) DEFAULT NULL COMMENT '商店类型，消费类型 1为各种商店购买，2为其他消费如元宝一键扫荡等',
  `iGoodsType` int(11) DEFAULT NULL COMMENT '商品类型',
  `iGoodsId` int(11) DEFAULT NULL COMMENT '物品ID',
  `iGoodsNum` int(11) DEFAULT NULL COMMENT '物品数量',
  `vGuid` varchar(60) DEFAULT NULL COMMENT '全局唯一标识(暂时没用,空着)',
  `iLoginWay` int(11) DEFAULT NULL COMMENT '登录渠道',
  `iNewCash` bigint(20) DEFAULT NULL COMMENT '钻石余量',
  `dt` varchar(20) DEFAULT NULL COMMENT '记录时间日期'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-14 14:06:39
