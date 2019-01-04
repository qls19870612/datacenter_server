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
INSERT INTO `log` VALUES ('the value is->00:00',865),('the value is->00:05',866),('the value is->00:10',867),('the value is->00:15',868),('the value is->00:20',869),('the value is->00:25',870),('the value is->00:30',871),('the value is->00:35',872),('the value is->00:40',873),('the value is->00:45',874),('the value is->00:50',875),('the value is->00:55',876),('the value is->01:00',877),('the value is->01:05',878),('the value is->01:10',879),('the value is->01:15',880),('the value is->01:20',881),('the value is->01:25',882),('the value is->01:30',883),('the value is->01:35',884),('the value is->01:40',885),('the value is->01:45',886),('the value is->01:50',887),('the value is->01:55',888),('the value is->02:00',889),('the value is->02:05',890),('the value is->02:10',891),('the value is->02:15',892),('the value is->02:20',893),('the value is->02:25',894),('the value is->02:30',895),('the value is->02:35',896),('the value is->02:40',897),('the value is->02:45',898),('the value is->02:50',899),('the value is->02:55',900),('the value is->03:00',901),('the value is->03:05',902),('the value is->03:10',903),('the value is->03:15',904),('the value is->03:20',905),('the value is->03:25',906),('the value is->03:30',907),('the value is->03:35',908),('the value is->03:40',909),('the value is->03:45',910),('the value is->03:50',911),('the value is->03:55',912),('the value is->04:00',913),('the value is->04:05',914),('the value is->04:10',915),('the value is->04:15',916),('the value is->04:20',917),('the value is->04:25',918),('the value is->04:30',919),('the value is->04:35',920),('the value is->04:40',921),('the value is->04:45',922),('the value is->04:50',923),('the value is->04:55',924),('the value is->05:00',925),('the value is->05:05',926),('the value is->05:10',927),('the value is->05:15',928),('the value is->05:20',929),('the value is->05:25',930),('the value is->05:30',931),('the value is->05:35',932),('the value is->05:40',933),('the value is->05:45',934),('the value is->05:50',935),('the value is->05:55',936),('the value is->06:00',937),('the value is->06:05',938),('the value is->06:10',939),('the value is->06:15',940),('the value is->06:20',941),('the value is->06:25',942),('the value is->06:30',943),('the value is->06:35',944),('the value is->06:40',945),('the value is->06:45',946),('the value is->06:50',947),('the value is->06:55',948),('the value is->07:00',949),('the value is->07:05',950),('the value is->07:10',951),('the value is->07:15',952),('the value is->07:20',953),('the value is->07:25',954),('the value is->07:30',955),('the value is->07:35',956),('the value is->07:40',957),('the value is->07:45',958),('the value is->07:50',959),('the value is->07:55',960),('the value is->08:00',961),('the value is->08:05',962),('the value is->08:10',963),('the value is->08:15',964),('the value is->08:20',965),('the value is->08:25',966),('the value is->08:30',967),('the value is->08:35',968),('the value is->08:40',969),('the value is->08:45',970),('the value is->08:50',971),('the value is->08:55',972),('the value is->09:00',973),('the value is->09:05',974),('the value is->09:10',975),('the value is->09:15',976),('the value is->09:20',977),('the value is->09:25',978),('the value is->09:30',979),('the value is->09:35',980),('the value is->09:40',981),('the value is->09:45',982),('the value is->09:50',983),('the value is->09:55',984),('the value is->10:00',985),('the value is->10:05',986),('the value is->10:10',987),('the value is->10:15',988),('the value is->10:20',989),('the value is->10:25',990),('the value is->10:30',991),('the value is->10:35',992),('the value is->10:40',993),('the value is->10:45',994),('the value is->10:50',995),('the value is->10:55',996),('the value is->11:00',997),('the value is->11:05',998),('the value is->11:10',999),('the value is->11:15',1000),('the value is->11:20',1001),('the value is->11:25',1002),('the value is->11:30',1003),('the value is->11:35',1004),('the value is->11:40',1005),('the value is->11:45',1006),('the value is->11:50',1007),('the value is->11:55',1008),('the value is->12:00',1009),('the value is->12:05',1010),('the value is->12:10',1011),('the value is->12:15',1012),('the value is->12:20',1013),('the value is->12:25',1014),('the value is->12:30',1015),('the value is->12:35',1016),('the value is->12:40',1017),('the value is->12:45',1018),('the value is->12:50',1019),('the value is->12:55',1020),('the value is->13:00',1021),('the value is->13:05',1022),('the value is->13:10',1023),('the value is->13:15',1024),('the value is->13:20',1025),('the value is->13:25',1026),('the value is->13:30',1027),('the value is->13:35',1028),('the value is->13:40',1029),('the value is->13:45',1030),('the value is->13:50',1031),('the value is->13:55',1032),('the value is->14:00',1033),('the value is->14:05',1034),('the value is->14:10',1035),('the value is->14:15',1036),('the value is->14:20',1037),('the value is->14:25',1038),('the value is->14:30',1039),('the value is->14:35',1040),('the value is->14:40',1041),('the value is->14:45',1042),('the value is->14:50',1043),('the value is->14:55',1044),('the value is->15:00',1045),('the value is->15:05',1046),('the value is->15:10',1047),('the value is->15:15',1048),('the value is->15:20',1049),('the value is->15:25',1050),('the value is->15:30',1051),('the value is->15:35',1052),('the value is->15:40',1053),('the value is->15:45',1054),('the value is->15:50',1055),('the value is->15:55',1056),('the value is->16:00',1057),('the value is->16:05',1058),('the value is->16:10',1059),('the value is->16:15',1060),('the value is->16:20',1061),('the value is->16:25',1062),('the value is->16:30',1063),('the value is->16:35',1064),('the value is->16:40',1065),('the value is->16:45',1066),('the value is->16:50',1067),('the value is->16:55',1068),('the value is->17:00',1069),('the value is->17:05',1070),('the value is->17:10',1071),('the value is->17:15',1072),('the value is->17:20',1073),('the value is->17:25',1074),('the value is->17:30',1075),('the value is->17:35',1076),('the value is->17:40',1077),('the value is->17:45',1078),('the value is->17:50',1079),('the value is->17:55',1080),('the value is->18:00',1081),('the value is->18:05',1082),('the value is->18:10',1083),('the value is->18:15',1084),('the value is->18:20',1085),('the value is->18:25',1086),('the value is->18:30',1087),('the value is->18:35',1088),('the value is->18:40',1089),('the value is->18:45',1090),('the value is->18:50',1091),('the value is->18:55',1092),('the value is->19:00',1093),('the value is->19:05',1094),('the value is->19:10',1095),('the value is->19:15',1096),('the value is->19:20',1097),('the value is->19:25',1098),('the value is->19:30',1099),('the value is->19:35',1100),('the value is->19:40',1101),('the value is->19:45',1102),('the value is->19:50',1103),('the value is->19:55',1104),('the value is->20:00',1105),('the value is->20:05',1106),('the value is->20:10',1107),('the value is->20:15',1108),('the value is->20:20',1109),('the value is->20:25',1110),('the value is->20:30',1111),('the value is->20:35',1112),('the value is->20:40',1113),('the value is->20:45',1114),('the value is->20:50',1115),('the value is->20:55',1116),('the value is->21:00',1117),('the value is->21:05',1118),('the value is->21:10',1119),('the value is->21:15',1120),('the value is->21:20',1121),('the value is->21:25',1122),('the value is->21:30',1123),('the value is->21:35',1124),('the value is->21:40',1125),('the value is->21:45',1126),('the value is->21:50',1127),('the value is->21:55',1128),('the value is->22:00',1129),('the value is->22:05',1130),('the value is->22:10',1131),('the value is->22:15',1132),('the value is->22:20',1133),('the value is->22:25',1134),('the value is->22:30',1135),('the value is->22:35',1136),('the value is->22:40',1137),('the value is->22:45',1138),('the value is->22:50',1139),('the value is->22:55',1140),('the value is->23:00',1141),('the value is->23:05',1142),('the value is->23:10',1143),('the value is->23:15',1144),('the value is->23:20',1145),('the value is->23:25',1146),('the value is->23:30',1147),('the value is->23:35',1148),('the value is->23:40',1149),('the value is->23:45',1150),('the value is->23:50',1151),('the value is->23:55',1152);
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
INSERT INTO `tbtemplatebyfiveminutes` VALUES ('00:00',122),('00:05',123),('00:10',124),('00:15',125),('00:20',126),('00:25',127),('00:30',128),('00:35',129),('00:40',130),('00:45',131),('00:50',132),('00:55',133),('00:00',134),('00:05',135),('00:10',136),('00:15',137),('00:20',138),('00:25',139),('00:30',140),('00:35',141),('00:40',142),('00:45',143),('00:50',144),('00:55',145),('01:00',146),('01:05',147),('01:10',148),('01:15',149),('01:20',150),('01:25',151),('01:30',152),('01:35',153),('01:40',154),('01:45',155),('01:50',156),('01:55',157),('02:00',158),('02:05',159),('02:10',160),('02:15',161),('02:20',162),('02:25',163),('02:30',164),('02:35',165),('02:40',166),('02:45',167),('02:50',168),('02:55',169),('03:00',170),('03:05',171),('03:10',172),('03:15',173),('03:20',174),('03:25',175),('03:30',176),('03:35',177),('03:40',178),('03:45',179),('03:50',180),('03:55',181),('04:00',182),('04:05',183),('04:10',184),('04:15',185),('04:20',186),('04:25',187),('04:30',188),('04:35',189),('04:40',190),('04:45',191),('04:50',192),('04:55',193),('05:00',194),('05:05',195),('05:10',196),('05:15',197),('05:20',198),('05:25',199),('05:30',200),('05:35',201),('05:40',202),('05:45',203),('05:50',204),('05:55',205),('06:00',206),('06:05',207),('06:10',208),('06:15',209),('06:20',210),('06:25',211),('06:30',212),('06:35',213),('06:40',214),('06:45',215),('06:50',216),('06:55',217),('07:00',218),('07:05',219),('07:10',220),('07:15',221),('07:20',222),('07:25',223),('07:30',224),('07:35',225),('07:40',226),('07:45',227),('07:50',228),('07:55',229),('08:00',230),('08:05',231),('08:10',232),('08:15',233),('08:20',234),('08:25',235),('08:30',236),('08:35',237),('08:40',238),('08:45',239),('08:50',240),('08:55',241),('09:00',242),('09:05',243),('09:10',244),('09:15',245),('09:20',246),('09:25',247),('09:30',248),('09:35',249),('09:40',250),('09:45',251),('09:50',252),('09:55',253),('10:00',254),('10:05',255),('10:10',256),('10:15',257),('10:20',258),('10:25',259),('10:30',260),('10:35',261),('10:40',262),('10:45',263),('10:50',264),('10:55',265),('11:00',266),('11:05',267),('11:10',268),('11:15',269),('11:20',270),('11:25',271),('11:30',272),('11:35',273),('11:40',274),('11:45',275),('11:50',276),('11:55',277),('12:00',278),('12:05',279),('12:10',280),('12:15',281),('12:20',282),('12:25',283),('12:30',284),('12:35',285),('12:40',286),('12:45',287),('12:50',288),('12:55',289),('13:00',290),('13:05',291),('13:10',292),('13:15',293),('13:20',294),('13:25',295),('13:30',296),('13:35',297),('13:40',298),('13:45',299),('13:50',300),('13:55',301),('14:00',302),('14:05',303),('14:10',304),('14:15',305),('14:20',306),('14:25',307),('14:30',308),('14:35',309),('14:40',310),('14:45',311),('14:50',312),('14:55',313),('15:00',314),('15:05',315),('15:10',316),('15:15',317),('15:20',318),('15:25',319),('15:30',320),('15:35',321),('15:40',322),('15:45',323),('15:50',324),('15:55',325),('16:00',326),('16:05',327),('16:10',328),('16:15',329),('16:20',330),('16:25',331),('16:30',332),('16:35',333),('16:40',334),('16:45',335),('16:50',336),('16:55',337),('17:00',338),('17:05',339),('17:10',340),('17:15',341),('17:20',342),('17:25',343),('17:30',344),('17:35',345),('17:40',346),('17:45',347),('17:50',348),('17:55',349),('18:00',350),('18:05',351),('18:10',352),('18:15',353),('18:20',354),('18:25',355),('18:30',356),('18:35',357),('18:40',358),('18:45',359),('18:50',360),('18:55',361),('19:00',362),('19:05',363),('19:10',364),('19:15',365),('19:20',366),('19:25',367),('19:30',368),('19:35',369),('19:40',370),('19:45',371),('19:50',372),('19:55',373),('20:00',374),('20:05',375),('20:10',376),('20:15',377),('20:20',378),('20:25',379),('20:30',380),('20:35',381),('20:40',382),('20:45',383),('20:50',384),('20:55',385),('21:00',386),('21:05',387),('21:10',388),('21:15',389),('21:20',390),('21:25',391),('21:30',392),('21:35',393),('21:40',394),('21:45',395),('21:50',396),('21:55',397),('22:00',398),('22:05',399),('22:10',400),('22:15',401),('22:20',402),('22:25',403),('22:30',404),('22:35',405),('22:40',406),('22:45',407),('22:50',408),('22:55',409),('23:00',410),('23:05',411),('23:10',412),('23:15',413),('23:20',414),('23:25',415),('23:30',416),('23:35',417),('23:40',418),('23:45',419),('23:50',420),('23:55',421),('00:00',422),('00:00',423),('00:05',424),('00:10',425),('00:15',426),('00:20',427),('00:25',428),('00:30',429),('00:35',430),('00:40',431),('00:45',432),('00:50',433),('00:55',434),('01:00',435),('01:05',436),('01:10',437),('01:15',438),('01:20',439),('01:25',440),('01:30',441),('01:35',442),('01:40',443),('01:45',444),('01:50',445),('01:55',446),('02:00',447),('02:05',448),('02:10',449),('02:15',450),('02:20',451),('02:25',452),('02:30',453),('02:35',454),('02:40',455),('02:45',456),('02:50',457),('02:55',458),('03:00',459),('03:05',460),('03:10',461),('03:15',462),('03:20',463),('03:25',464),('03:30',465),('03:35',466),('03:40',467),('03:45',468),('03:50',469),('03:55',470),('04:00',471),('04:05',472),('04:10',473),('04:15',474),('04:20',475),('04:25',476),('04:30',477),('04:35',478),('04:40',479),('04:45',480),('04:50',481),('04:55',482),('05:00',483),('05:05',484),('05:10',485),('05:15',486),('05:20',487),('05:25',488),('05:30',489),('05:35',490),('05:40',491),('05:45',492),('05:50',493),('05:55',494),('06:00',495),('06:05',496),('06:10',497),('06:15',498),('06:20',499),('06:25',500),('06:30',501),('06:35',502),('06:40',503),('06:45',504),('06:50',505),('06:55',506),('07:00',507),('07:05',508),('07:10',509),('07:15',510),('07:20',511),('07:25',512),('07:30',513),('07:35',514),('07:40',515),('07:45',516),('07:50',517),('07:55',518),('08:00',519),('08:05',520),('08:10',521),('08:15',522),('08:20',523),('08:25',524),('08:30',525),('08:35',526),('08:40',527),('08:45',528),('08:50',529),('08:55',530),('09:00',531),('09:05',532),('09:10',533),('09:15',534),('09:20',535),('09:25',536),('09:30',537),('09:35',538),('09:40',539),('09:45',540),('09:50',541),('09:55',542),('10:00',543),('10:05',544),('10:10',545),('10:15',546),('10:20',547),('10:25',548),('10:30',549),('10:35',550),('10:40',551),('10:45',552),('10:50',553),('10:55',554),('11:00',555),('11:05',556),('11:10',557),('11:15',558),('11:20',559),('11:25',560),('11:30',561),('11:35',562),('11:40',563),('11:45',564),('11:50',565),('11:55',566),('12:00',567),('12:05',568),('12:10',569),('12:15',570),('12:20',571),('12:25',572),('12:30',573),('12:35',574),('12:40',575),('12:45',576),('12:50',577),('12:55',578),('13:00',579),('13:05',580),('13:10',581),('13:15',582),('13:20',583),('13:25',584),('13:30',585),('13:35',586),('13:40',587),('13:45',588),('13:50',589),('13:55',590),('14:00',591),('14:05',592),('14:10',593),('14:15',594),('14:20',595),('14:25',596),('14:30',597),('14:35',598),('14:40',599),('14:45',600),('14:50',601),('14:55',602),('15:00',603),('15:05',604),('15:10',605),('15:15',606),('15:20',607),('15:25',608),('15:30',609),('15:35',610),('15:40',611),('15:45',612),('15:50',613),('15:55',614),('16:00',615),('16:05',616),('16:10',617),('16:15',618),('16:20',619),('16:25',620),('16:30',621),('16:35',622),('16:40',623),('16:45',624),('16:50',625),('16:55',626),('17:00',627),('17:05',628),('17:10',629),('17:15',630),('17:20',631),('17:25',632),('17:30',633),('17:35',634),('17:40',635),('17:45',636),('17:50',637),('17:55',638),('18:00',639),('18:05',640),('18:10',641),('18:15',642),('18:20',643),('18:25',644),('18:30',645),('18:35',646),('18:40',647),('18:45',648),('18:50',649),('18:55',650),('19:00',651),('19:05',652),('19:10',653),('19:15',654),('19:20',655),('19:25',656),('19:30',657),('19:35',658),('19:40',659),('19:45',660),('19:50',661),('19:55',662),('20:00',663),('20:05',664),('20:10',665),('20:15',666),('20:20',667),('20:25',668),('20:30',669),('20:35',670),('20:40',671),('20:45',672),('20:50',673),('20:55',674),('21:00',675),('21:05',676),('21:10',677),('21:15',678),('21:20',679),('21:25',680),('21:30',681),('21:35',682),('21:40',683),('21:45',684),('21:50',685),('21:55',686),('22:00',687),('22:05',688),('22:10',689),('22:15',690),('22:20',691),('22:25',692),('22:30',693),('22:35',694),('22:40',695),('22:45',696),('22:50',697),('22:55',698),('23:00',699),('23:05',700),('23:10',701),('23:15',702),('23:20',703),('23:25',704),('23:30',705),('23:35',706),('23:40',707),('23:45',708),('23:50',709),('23:55',710),('00:00',711),('00:05',712),('00:10',713),('00:15',714),('00:20',715),('00:25',716),('00:30',717),('00:35',718),('00:40',719),('00:45',720),('00:50',721),('00:55',722),('01:00',723),('01:05',724),('01:10',725),('01:15',726),('01:20',727),('01:25',728),('01:30',729),('01:35',730),('01:40',731),('01:45',732),('01:50',733),('01:55',734),('02:00',735),('02:05',736),('02:10',737),('02:15',738),('02:20',739),('02:25',740),('02:30',741),('02:35',742),('02:40',743),('02:45',744),('02:50',745),('02:55',746),('03:00',747),('03:05',748),('03:10',749),('03:15',750),('03:20',751),('03:25',752),('03:30',753),('03:35',754),('03:40',755),('03:45',756),('03:50',757),('03:55',758),('04:00',759),('04:05',760),('04:10',761),('04:15',762),('04:20',763),('04:25',764),('04:30',765),('04:35',766),('04:40',767),('04:45',768),('04:50',769),('04:55',770),('05:00',771),('05:05',772),('05:10',773),('05:15',774),('05:20',775),('05:25',776),('05:30',777),('05:35',778),('05:40',779),('05:45',780),('05:50',781),('05:55',782),('06:00',783),('06:05',784),('06:10',785),('06:15',786),('06:20',787),('06:25',788),('06:30',789),('06:35',790),('06:40',791),('06:45',792),('06:50',793),('06:55',794),('07:00',795),('07:05',796),('07:10',797),('07:15',798),('07:20',799),('07:25',800),('07:30',801),('07:35',802),('07:40',803),('07:45',804),('07:50',805),('07:55',806),('08:00',807),('08:05',808),('08:10',809),('08:15',810),('08:20',811),('08:25',812),('08:30',813),('08:35',814),('08:40',815),('08:45',816),('08:50',817),('08:55',818),('09:00',819),('09:05',820),('09:10',821),('09:15',822),('09:20',823),('09:25',824),('09:30',825),('09:35',826),('09:40',827),('09:45',828),('09:50',829),('09:55',830),('10:00',831),('10:05',832),('10:10',833),('10:15',834),('10:20',835),('10:25',836),('10:30',837),('10:35',838),('10:40',839),('10:45',840),('10:50',841),('10:55',842),('11:00',843),('11:05',844),('11:10',845),('11:15',846),('11:20',847),('11:25',848),('11:30',849),('11:35',850),('11:40',851),('11:45',852),('11:50',853),('11:55',854),('12:00',855),('12:05',856),('12:10',857),('12:15',858),('12:20',859),('12:25',860),('12:30',861),('12:35',862),('12:40',863),('12:45',864),('12:50',865),('12:55',866),('13:00',867),('13:05',868),('13:10',869),('13:15',870),('13:20',871),('13:25',872),('13:30',873),('13:35',874),('13:40',875),('13:45',876),('13:50',877),('13:55',878),('14:00',879),('14:05',880),('14:10',881),('14:15',882),('14:20',883),('14:25',884),('14:30',885),('14:35',886),('14:40',887),('14:45',888),('14:50',889),('14:55',890),('15:00',891),('15:05',892),('15:10',893),('15:15',894),('15:20',895),('15:25',896),('15:30',897),('15:35',898),('15:40',899),('15:45',900),('15:50',901),('15:55',902),('16:00',903),('16:05',904),('16:10',905),('16:15',906),('16:20',907),('16:25',908),('16:30',909),('16:35',910),('16:40',911),('16:45',912),('16:50',913),('16:55',914),('17:00',915),('17:05',916),('17:10',917),('17:15',918),('17:20',919),('17:25',920),('17:30',921),('17:35',922),('17:40',923),('17:45',924),('17:50',925),('17:55',926),('18:00',927),('18:05',928),('18:10',929),('18:15',930),('18:20',931),('18:25',932),('18:30',933),('18:35',934),('18:40',935),('18:45',936),('18:50',937),('18:55',938),('19:00',939),('19:05',940),('19:10',941),('19:15',942),('19:20',943),('19:25',944),('19:30',945),('19:35',946),('19:40',947),('19:45',948),('19:50',949),('19:55',950),('20:00',951),('20:05',952),('20:10',953),('20:15',954),('20:20',955),('20:25',956),('20:30',957),('20:35',958),('20:40',959),('20:45',960),('20:50',961),('20:55',962),('21:00',963),('21:05',964),('21:10',965),('21:15',966),('21:20',967),('21:25',968),('21:30',969),('21:35',970),('21:40',971),('21:45',972),('21:50',973),('21:55',974),('22:00',975),('22:05',976),('22:10',977),('22:15',978),('22:20',979),('22:25',980),('22:30',981),('22:35',982),('22:40',983),('22:45',984),('22:50',985),('22:55',986),('23:00',987),('23:05',988),('23:10',989),('23:15',990),('23:20',991),('23:25',992),('23:30',993),('23:35',994),('23:40',995),('23:45',996),('23:50',997),('23:55',998),('00:00',999),('00:05',1000),('00:10',1001),('00:15',1002),('00:20',1003),('00:25',1004),('00:30',1005),('00:35',1006),('00:40',1007),('00:45',1008),('00:50',1009),('00:55',1010),('01:00',1011),('01:05',1012),('01:10',1013),('01:15',1014),('01:20',1015),('01:25',1016),('01:30',1017),('01:35',1018),('01:40',1019),('01:45',1020),('01:50',1021),('01:55',1022),('02:00',1023),('02:05',1024),('02:10',1025),('02:15',1026),('02:20',1027),('02:25',1028),('02:30',1029),('02:35',1030),('02:40',1031),('02:45',1032),('02:50',1033),('02:55',1034),('03:00',1035),('03:05',1036),('03:10',1037),('03:15',1038),('03:20',1039),('03:25',1040),('03:30',1041),('03:35',1042),('03:40',1043),('03:45',1044),('03:50',1045),('03:55',1046),('04:00',1047),('04:05',1048),('04:10',1049),('04:15',1050),('04:20',1051),('04:25',1052),('04:30',1053),('04:35',1054),('04:40',1055),('04:45',1056),('04:50',1057),('04:55',1058),('05:00',1059),('05:05',1060),('05:10',1061),('05:15',1062),('05:20',1063),('05:25',1064),('05:30',1065),('05:35',1066),('05:40',1067),('05:45',1068),('05:50',1069),('05:55',1070),('06:00',1071),('06:05',1072),('06:10',1073),('06:15',1074),('06:20',1075),('06:25',1076),('06:30',1077),('06:35',1078),('06:40',1079),('06:45',1080),('06:50',1081),('06:55',1082),('07:00',1083),('07:05',1084),('07:10',1085),('07:15',1086),('07:20',1087),('07:25',1088),('07:30',1089),('07:35',1090),('07:40',1091),('07:45',1092),('07:50',1093),('07:55',1094),('08:00',1095),('08:05',1096),('08:10',1097),('08:15',1098),('08:20',1099),('08:25',1100),('08:30',1101),('08:35',1102),('08:40',1103),('08:45',1104),('08:50',1105),('08:55',1106),('09:00',1107),('09:05',1108),('09:10',1109),('09:15',1110),('09:20',1111),('09:25',1112),('09:30',1113),('09:35',1114),('09:40',1115),('09:45',1116),('09:50',1117),('09:55',1118),('10:00',1119),('10:05',1120),('10:10',1121),('10:15',1122),('10:20',1123),('10:25',1124),('10:30',1125),('10:35',1126),('10:40',1127),('10:45',1128),('10:50',1129),('10:55',1130),('11:00',1131),('11:05',1132),('11:10',1133),('11:15',1134),('11:20',1135),('11:25',1136),('11:30',1137),('11:35',1138),('11:40',1139),('11:45',1140),('11:50',1141),('11:55',1142),('12:00',1143),('12:05',1144),('12:10',1145),('12:15',1146),('12:20',1147),('12:25',1148),('12:30',1149),('12:35',1150),('12:40',1151),('12:45',1152),('12:50',1153),('12:55',1154),('13:00',1155),('13:05',1156),('13:10',1157),('13:15',1158),('13:20',1159),('13:25',1160),('13:30',1161),('13:35',1162),('13:40',1163),('13:45',1164),('13:50',1165),('13:55',1166),('14:00',1167),('14:05',1168),('14:10',1169),('14:15',1170),('14:20',1171),('14:25',1172),('14:30',1173),('14:35',1174),('14:40',1175),('14:45',1176),('14:50',1177),('14:55',1178),('15:00',1179),('15:05',1180),('15:10',1181),('15:15',1182),('15:20',1183),('15:25',1184),('15:30',1185),('15:35',1186),('15:40',1187),('15:45',1188),('15:50',1189),('15:55',1190),('16:00',1191),('16:05',1192),('16:10',1193),('16:15',1194),('16:20',1195),('16:25',1196),('16:30',1197),('16:35',1198),('16:40',1199),('16:45',1200),('16:50',1201),('16:55',1202),('17:00',1203),('17:05',1204),('17:10',1205),('17:15',1206),('17:20',1207),('17:25',1208),('17:30',1209),('17:35',1210),('17:40',1211),('17:45',1212),('17:50',1213),('17:55',1214),('18:00',1215),('18:05',1216),('18:10',1217),('18:15',1218),('18:20',1219),('18:25',1220),('18:30',1221),('18:35',1222),('18:40',1223),('18:45',1224),('18:50',1225),('18:55',1226),('19:00',1227),('19:05',1228),('19:10',1229),('19:15',1230),('19:20',1231),('19:25',1232),('19:30',1233),('19:35',1234),('19:40',1235),('19:45',1236),('19:50',1237),('19:55',1238),('20:00',1239),('20:05',1240),('20:10',1241),('20:15',1242),('20:20',1243),('20:25',1244),('20:30',1245),('20:35',1246),('20:40',1247),('20:45',1248),('20:50',1249),('20:55',1250),('21:00',1251),('21:05',1252),('21:10',1253),('21:15',1254),('21:20',1255),('21:25',1256),('21:30',1257),('21:35',1258),('21:40',1259),('21:45',1260),('21:50',1261),('21:55',1262),('22:00',1263),('22:05',1264),('22:10',1265),('22:15',1266),('22:20',1267),('22:25',1268),('22:30',1269),('22:35',1270),('22:40',1271),('22:45',1272),('22:50',1273),('22:55',1274),('23:00',1275),('23:05',1276),('23:10',1277),('23:15',1278),('23:20',1279),('23:25',1280),('23:30',1281),('23:35',1282),('23:40',1283),('23:45',1284),('23:50',1285),('23:55',1286),('00:00',1287),('00:05',1288),('00:10',1289),('00:15',1290),('00:20',1291),('00:25',1292),('00:30',1293),('00:35',1294),('00:40',1295),('00:45',1296),('00:50',1297),('00:55',1298),('01:00',1299),('01:05',1300),('01:10',1301),('01:15',1302),('01:20',1303),('01:25',1304),('01:30',1305),('01:35',1306),('01:40',1307),('01:45',1308),('01:50',1309),('01:55',1310),('02:00',1311),('02:05',1312),('02:10',1313),('02:15',1314),('02:20',1315),('02:25',1316),('02:30',1317),('02:35',1318),('02:40',1319),('02:45',1320),('02:50',1321),('02:55',1322),('03:00',1323),('03:05',1324),('03:10',1325),('03:15',1326),('03:20',1327),('03:25',1328),('03:30',1329),('03:35',1330),('03:40',1331),('03:45',1332),('03:50',1333),('03:55',1334),('04:00',1335),('04:05',1336),('04:10',1337),('04:15',1338),('04:20',1339),('04:25',1340),('04:30',1341),('04:35',1342),('04:40',1343),('04:45',1344),('04:50',1345),('04:55',1346),('05:00',1347),('05:05',1348),('05:10',1349),('05:15',1350),('05:20',1351),('05:25',1352),('05:30',1353),('05:35',1354),('05:40',1355),('05:45',1356),('05:50',1357),('05:55',1358),('06:00',1359),('06:05',1360),('06:10',1361),('06:15',1362),('06:20',1363),('06:25',1364),('06:30',1365),('06:35',1366),('06:40',1367),('06:45',1368),('06:50',1369),('06:55',1370),('07:00',1371),('07:05',1372),('07:10',1373),('07:15',1374),('07:20',1375),('07:25',1376),('07:30',1377),('07:35',1378),('07:40',1379),('07:45',1380),('07:50',1381),('07:55',1382),('08:00',1383),('08:05',1384),('08:10',1385),('08:15',1386),('08:20',1387),('08:25',1388),('08:30',1389),('08:35',1390),('08:40',1391),('08:45',1392),('08:50',1393),('08:55',1394),('09:00',1395),('09:05',1396),('09:10',1397),('09:15',1398),('09:20',1399),('09:25',1400),('09:30',1401),('09:35',1402),('09:40',1403),('09:45',1404),('09:50',1405),('09:55',1406),('10:00',1407),('10:05',1408),('10:10',1409),('10:15',1410),('10:20',1411),('10:25',1412),('10:30',1413),('10:35',1414),('10:40',1415),('10:45',1416),('10:50',1417),('10:55',1418),('11:00',1419),('11:05',1420),('11:10',1421),('11:15',1422),('11:20',1423),('11:25',1424),('11:30',1425),('11:35',1426),('11:40',1427),('11:45',1428),('11:50',1429),('11:55',1430),('12:00',1431),('12:05',1432),('12:10',1433),('12:15',1434),('12:20',1435),('12:25',1436),('12:30',1437),('12:35',1438),('12:40',1439),('12:45',1440),('12:50',1441),('12:55',1442),('13:00',1443),('13:05',1444),('13:10',1445),('13:15',1446),('13:20',1447),('13:25',1448),('13:30',1449),('13:35',1450),('13:40',1451),('13:45',1452),('13:50',1453),('13:55',1454),('14:00',1455),('14:05',1456),('14:10',1457),('14:15',1458),('14:20',1459),('14:25',1460),('14:30',1461),('14:35',1462),('14:40',1463),('14:45',1464),('14:50',1465),('14:55',1466),('15:00',1467),('15:05',1468),('15:10',1469),('15:15',1470),('15:20',1471),('15:25',1472),('15:30',1473),('15:35',1474),('15:40',1475),('15:45',1476),('15:50',1477),('15:55',1478),('16:00',1479),('16:05',1480),('16:10',1481),('16:15',1482),('16:20',1483),('16:25',1484),('16:30',1485),('16:35',1486),('16:40',1487),('16:45',1488),('16:50',1489),('16:55',1490),('17:00',1491),('17:05',1492),('17:10',1493),('17:15',1494),('17:20',1495),('17:25',1496),('17:30',1497),('17:35',1498),('17:40',1499),('17:45',1500),('17:50',1501),('17:55',1502),('18:00',1503),('18:05',1504),('18:10',1505),('18:15',1506),('18:20',1507),('18:25',1508),('18:30',1509),('18:35',1510),('18:40',1511),('18:45',1512),('18:50',1513),('18:55',1514),('19:00',1515),('19:05',1516),('19:10',1517),('19:15',1518),('19:20',1519),('19:25',1520),('19:30',1521),('19:35',1522),('19:40',1523),('19:45',1524),('19:50',1525),('19:55',1526),('20:00',1527),('20:05',1528),('20:10',1529),('20:15',1530),('20:20',1531),('20:25',1532),('20:30',1533),('20:35',1534),('20:40',1535),('20:45',1536),('20:50',1537),('20:55',1538),('21:00',1539),('21:05',1540),('21:10',1541),('21:15',1542),('21:20',1543),('21:25',1544),('21:30',1545),('21:35',1546),('21:40',1547),('21:45',1548),('21:50',1549),('21:55',1550),('22:00',1551),('22:05',1552),('22:10',1553),('22:15',1554),('22:20',1555),('22:25',1556),('22:30',1557),('22:35',1558),('22:40',1559),('22:45',1560),('22:50',1561),('22:55',1562),('23:00',1563),('23:05',1564),('23:10',1565),('23:15',1566),('23:20',1567),('23:25',1568),('23:30',1569),('23:35',1570),('23:40',1571),('23:45',1572),('23:50',1573),('23:55',1574);
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
INSERT INTO `tbworldbegindate` VALUES (1,'muzhi',1,'2016-12-06',0),(1,'muzhi',2,'2017-02-22',0),(1,'muzhi',3,'2017-04-05',0);
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

-- Dump completed on 2019-01-02  9:57:06