-- MySQL dump 10.14  Distrib 5.5.60-MariaDB, for Linux (x86_64)
--
-- Host: 10.66.203.188    Database: dbdiabloconf
-- ------------------------------------------------------
-- Server version	5.6.28-cdb2016-log

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
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `value` varchar(512) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1153 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

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
-- Dumping data for table `tbplt`
--

LOCK TABLES `tbplt` WRITE;
/*!40000 ALTER TABLE `tbplt` DISABLE KEYS */;
INSERT INTO `tbplt` VALUES (1,'muzhi','diablo');
/*!40000 ALTER TABLE `tbplt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbtemplatebyfiveminutes`
--

DROP TABLE IF EXISTS `tbtemplatebyfiveminutes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbtemplatebyfiveminutes` (
  `tplFiveMinutes` varchar(10) DEFAULT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1575 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbtemplatebyfiveminutes`
--

LOCK TABLES `tbtemplatebyfiveminutes` WRITE;
/*!40000 ALTER TABLE `tbtemplatebyfiveminutes` DISABLE KEYS */;
INSERT INTO `tbtemplatebyfiveminutes` VALUES ('00:00',1287),('00:05',1288),('00:10',1289),('00:15',1290),('00:20',1291),('00:25',1292),('00:30',1293),('00:35',1294),('00:40',1295),('00:45',1296),('00:50',1297),('00:55',1298),('01:00',1299),('01:05',1300),('01:10',1301),('01:15',1302),('01:20',1303),('01:25',1304),('01:30',1305),('01:35',1306),('01:40',1307),('01:45',1308),('01:50',1309),('01:55',1310),('02:00',1311),('02:05',1312),('02:10',1313),('02:15',1314),('02:20',1315),('02:25',1316),('02:30',1317),('02:35',1318),('02:40',1319),('02:45',1320),('02:50',1321),('02:55',1322),('03:00',1323),('03:05',1324),('03:10',1325),('03:15',1326),('03:20',1327),('03:25',1328),('03:30',1329),('03:35',1330),('03:40',1331),('03:45',1332),('03:50',1333),('03:55',1334),('04:00',1335),('04:05',1336),('04:10',1337),('04:15',1338),('04:20',1339),('04:25',1340),('04:30',1341),('04:35',1342),('04:40',1343),('04:45',1344),('04:50',1345),('04:55',1346),('05:00',1347),('05:05',1348),('05:10',1349),('05:15',1350),('05:20',1351),('05:25',1352),('05:30',1353),('05:35',1354),('05:40',1355),('05:45',1356),('05:50',1357),('05:55',1358),('06:00',1359),('06:05',1360),('06:10',1361),('06:15',1362),('06:20',1363),('06:25',1364),('06:30',1365),('06:35',1366),('06:40',1367),('06:45',1368),('06:50',1369),('06:55',1370),('07:00',1371),('07:05',1372),('07:10',1373),('07:15',1374),('07:20',1375),('07:25',1376),('07:30',1377),('07:35',1378),('07:40',1379),('07:45',1380),('07:50',1381),('07:55',1382),('08:00',1383),('08:05',1384),('08:10',1385),('08:15',1386),('08:20',1387),('08:25',1388),('08:30',1389),('08:35',1390),('08:40',1391),('08:45',1392),('08:50',1393),('08:55',1394),('09:00',1395),('09:05',1396),('09:10',1397),('09:15',1398),('09:20',1399),('09:25',1400),('09:30',1401),('09:35',1402),('09:40',1403),('09:45',1404),('09:50',1405),('09:55',1406),('10:00',1407),('10:05',1408),('10:10',1409),('10:15',1410),('10:20',1411),('10:25',1412),('10:30',1413),('10:35',1414),('10:40',1415),('10:45',1416),('10:50',1417),('10:55',1418),('11:00',1419),('11:05',1420),('11:10',1421),('11:15',1422),('11:20',1423),('11:25',1424),('11:30',1425),('11:35',1426),('11:40',1427),('11:45',1428),('11:50',1429),('11:55',1430),('12:00',1431),('12:05',1432),('12:10',1433),('12:15',1434),('12:20',1435),('12:25',1436),('12:30',1437),('12:35',1438),('12:40',1439),('12:45',1440),('12:50',1441),('12:55',1442),('13:00',1443),('13:05',1444),('13:10',1445),('13:15',1446),('13:20',1447),('13:25',1448),('13:30',1449),('13:35',1450),('13:40',1451),('13:45',1452),('13:50',1453),('13:55',1454),('14:00',1455),('14:05',1456),('14:10',1457),('14:15',1458),('14:20',1459),('14:25',1460),('14:30',1461),('14:35',1462),('14:40',1463),('14:45',1464),('14:50',1465),('14:55',1466),('15:00',1467),('15:05',1468),('15:10',1469),('15:15',1470),('15:20',1471),('15:25',1472),('15:30',1473),('15:35',1474),('15:40',1475),('15:45',1476),('15:50',1477),('15:55',1478),('16:00',1479),('16:05',1480),('16:10',1481),('16:15',1482),('16:20',1483),('16:25',1484),('16:30',1485),('16:35',1486),('16:40',1487),('16:45',1488),('16:50',1489),('16:55',1490),('17:00',1491),('17:05',1492),('17:10',1493),('17:15',1494),('17:20',1495),('17:25',1496),('17:30',1497),('17:35',1498),('17:40',1499),('17:45',1500),('17:50',1501),('17:55',1502),('18:00',1503),('18:05',1504),('18:10',1505),('18:15',1506),('18:20',1507),('18:25',1508),('18:30',1509),('18:35',1510),('18:40',1511),('18:45',1512),('18:50',1513),('18:55',1514),('19:00',1515),('19:05',1516),('19:10',1517),('19:15',1518),('19:20',1519),('19:25',1520),('19:30',1521),('19:35',1522),('19:40',1523),('19:45',1524),('19:50',1525),('19:55',1526),('20:00',1527),('20:05',1528),('20:10',1529),('20:15',1530),('20:20',1531),('20:25',1532),('20:30',1533),('20:35',1534),('20:40',1535),('20:45',1536),('20:50',1537),('20:55',1538),('21:00',1539),('21:05',1540),('21:10',1541),('21:15',1542),('21:20',1543),('21:25',1544),('21:30',1545),('21:35',1546),('21:40',1547),('21:45',1548),('21:50',1549),('21:55',1550),('22:00',1551),('22:05',1552),('22:10',1553),('22:15',1554),('22:20',1555),('22:25',1556),('22:30',1557),('22:35',1558),('22:40',1559),('22:45',1560),('22:50',1561),('22:55',1562),('23:00',1563),('23:05',1564),('23:10',1565),('23:15',1566),('23:20',1567),('23:25',1568),('23:30',1569),('23:35',1570),('23:40',1571),('23:45',1572),('23:50',1573),('23:55',1574);
/*!40000 ALTER TABLE `tbtemplatebyfiveminutes` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Dumping data for table `tbworldbegindate`
--

LOCK TABLES `tbworldbegindate` WRITE;
/*!40000 ALTER TABLE `tbworldbegindate` DISABLE KEYS */;
INSERT INTO `tbworldbegindate` VALUES (1,'muzhi',1,'2019-01-22',0);
/*!40000 ALTER TABLE `tbworldbegindate` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-22 18:43:14
