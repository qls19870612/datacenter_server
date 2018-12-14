-- MySQL dump 10.13  Distrib 5.7.19, for linux-glibc2.12 (x86_64)
--
-- Host: localhost    Database: dbdiabloconf
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
-- Table structure for table `tbplt`
--

DROP TABLE IF EXISTS `tbplt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbplt` (
  `iPid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '平台id',
  `vPname` varchar(100) DEFAULT NULL COMMENT '平台名称',
  `vGame` varchar(50) DEFAULT NULL COMMENT '游戏名称',
  PRIMARY KEY (`iPid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='风云平台对照表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tbworldbegindate`
--

DROP TABLE IF EXISTS `tbworldbegindate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbworldbegindate` (
  `iPid` int(10) NOT NULL COMMENT '平台id号',
  `vPlt` varchar(255) NOT NULL COMMENT '平台名称',
  `iWorldId` int(10) NOT NULL COMMENT '区服id',
  `dtBeginDate` date DEFAULT NULL COMMENT '开服时间',
  `iModify` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否已手动改开服时间(改过填1)',
  PRIMARY KEY (`vPlt`,`iWorldId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='平台区服开服时间';
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
