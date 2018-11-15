/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50615
Source Host           : 127.0.0.1:3306
Source Database       : datacenter

Target Server Type    : MYSQL
Target Server Version : 50615
File Encoding         : 65001

Date: 2017-12-26 15:33:02
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
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

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', 'ae63aca7da0132b2da2ca3a1fc6f4437', 'administrator', '0', '', '0', '1', '', '');

-- ----------------------------
-- Table structure for admin_group
-- ----------------------------
DROP TABLE IF EXISTS `admin_group`;
CREATE TABLE `admin_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL DEFAULT '',
  `power` text NOT NULL,
  `admin_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ord` int(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_group
-- ----------------------------

-- ----------------------------
-- Table structure for autologinlog
-- ----------------------------
DROP TABLE IF EXISTS `autologinlog`;
CREATE TABLE `autologinlog` (
  `iUid` int(10) DEFAULT NULL COMMENT '用户ID',
  `vIp` varchar(15) DEFAULT NULL COMMENT '登录IP',
  `dtDatetime` datetime DEFAULT NULL COMMENT '登录时间',
  `vAgent` varchar(500) DEFAULT NULL COMMENT '登录浏览器信息'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of autologinlog
-- ----------------------------

-- ----------------------------
-- Table structure for autologinpassip
-- ----------------------------
DROP TABLE IF EXISTS `autologinpassip`;
CREATE TABLE `autologinpassip` (
  `vPlt` varchar(50) DEFAULT '' COMMENT '平台名称',
  `vIp` varchar(16) DEFAULT '' COMMENT '验证通过的IP'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='自动登录验证ip';

-- ----------------------------
-- Records of autologinpassip
-- ----------------------------

-- ----------------------------
-- Table structure for autologinuser
-- ----------------------------
DROP TABLE IF EXISTS `autologinuser`;
CREATE TABLE `autologinuser` (
  `vPlt` varchar(20) NOT NULL DEFAULT '' COMMENT '平台名称',
  `iUserId` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',
  PRIMARY KEY (`vPlt`,`iUserId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of autologinuser
-- ----------------------------

-- ----------------------------
-- Table structure for game
-- ----------------------------
DROP TABLE IF EXISTS `game`;
CREATE TABLE `game` (
  `gameid` int(11) NOT NULL AUTO_INCREMENT,
  `gamename` varchar(100) NOT NULL DEFAULT '',
  `gamecode` varchar(100) NOT NULL DEFAULT '',
  `pltlist` text,
  `LOGO` varchar(250) DEFAULT NULL,
  `gametype` int(11) NOT NULL DEFAULT '99',
  PRIMARY KEY (`gameid`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of game
-- ----------------------------
INSERT INTO `game` VALUES ('8', '崩坏3', 'bhs', 'yy', '/view/images/gamelogo/bhs.jpg', '1');
INSERT INTO `game` VALUES ('9', '天龙八部', 'tlbb', 'yy', null, '1');

-- ----------------------------
-- Table structure for game_report
-- ----------------------------
DROP TABLE IF EXISTS `game_report`;
CREATE TABLE `game_report` (
  `gamecode` varchar(50) NOT NULL COMMENT '游戏代号',
  `rp_cid` varchar(50) NOT NULL COMMENT '报表代号',
  UNIQUE KEY `gr` (`gamecode`,`rp_cid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of game_report
-- ----------------------------
INSERT INTO `game_report` VALUES ('bhs', 'daily_ltv');
INSERT INTO `game_report` VALUES ('bhs', 'daily_retention');
INSERT INTO `game_report` VALUES ('bhs', 'daily_status');
INSERT INTO `game_report` VALUES ('bhs', 'monthly_status');
INSERT INTO `game_report` VALUES ('bhs', 'realtime_recharge_curves');

-- ----------------------------
-- Table structure for game_server
-- ----------------------------
DROP TABLE IF EXISTS `game_server`;
CREATE TABLE `game_server` (
  `gamecode` varchar(50) NOT NULL DEFAULT '' COMMENT '游戏代号',
  `worldid` int(11) NOT NULL DEFAULT '0' COMMENT '服务器的世界ID',
  `servername` varchar(100) NOT NULL DEFAULT '' COMMENT '服务器名称',
  `platform` varchar(50) NOT NULL DEFAULT '' COMMENT '平台名称',
  UNIQUE KEY `gws` (`gamecode`,`worldid`,`platform`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of game_server
-- ----------------------------
INSERT INTO `game_server` VALUES ('bhs', '1', 's1', 'yy');
INSERT INTO `game_server` VALUES ('bhs', '2', 's2', 'yy');
INSERT INTO `game_server` VALUES ('bhs', '3', 's3', 'yy');

-- ----------------------------
-- Table structure for menu_group
-- ----------------------------
DROP TABLE IF EXISTS `menu_group`;
CREATE TABLE `menu_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupname` varchar(200) NOT NULL DEFAULT '' COMMENT '分组名称',
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '父类ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu_group
-- ----------------------------
INSERT INTO `menu_group` VALUES ('11', '基本运营信息', '0');
INSERT INTO `menu_group` VALUES ('12', '在线分析', '0');
INSERT INTO `menu_group` VALUES ('13', '用户分析', '0');
INSERT INTO `menu_group` VALUES ('14', '付费用户分析', '0');
INSERT INTO `menu_group` VALUES ('15', '收入分析', '0');
INSERT INTO `menu_group` VALUES ('16', '准实时类数据', '0');
INSERT INTO `menu_group` VALUES ('17', '游戏行为与特性分析', '0');
INSERT INTO `menu_group` VALUES ('21', '测试分类', '17');
INSERT INTO `menu_group` VALUES ('22', '装备系统', '17');
INSERT INTO `menu_group` VALUES ('23', '活跃行为相关统计', '14');
INSERT INTO `menu_group` VALUES ('24', '充值消费行为统计', '14');

-- ----------------------------
-- Table structure for report_layout
-- ----------------------------
DROP TABLE IF EXISTS `report_layout`;
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

-- ----------------------------
-- Records of report_layout
-- ----------------------------
INSERT INTO `report_layout` VALUES ('256', 'realtime_recharge_curves', null, '实时充值对比曲线', '99', '16', 'sp/general/realtime_recharge_curves.php', '7', '0', '1');
INSERT INTO `report_layout` VALUES ('262', 'daily_status', '4|50|datepicker|日期选择|fc59-ed8bf0c5|static%4|50|serverlist|服务器选择|4367-46786a4f|static%2|400|highchart|登录概况|b10b-458f62ea|ajax%2|400|highchart|充值概况|c575-e25b9bc1|ajax%2|400|highchart|消费概况|2133-8b9e01fb|ajax%2|400|highchart|注册概况|ea0c-c61f3f7c|ajax%4|600|mmgrid|每日总况|677e-1ed2fe91|ajax', '每日总况', '99', '11', '', '7', '0', '0');
INSERT INTO `report_layout` VALUES ('263', 'daily_retention', '4|50|datepicker|注册日期|db56-c088e3d6|static%4|50|serverlist|服务器选择|5a55-9160cff1|static%4|400|mmgridspec|多日留存|3055-8925f0ea|ajax%2|400|highchart|留存率曲线图(起始日)|931c-bed9dc26|ajax%2|400|mmgrid|留存率(起始日)|0e18-9ffc4f70|ajax', '每日留存', '99', '11', '', '7', '0', '0');
INSERT INTO `report_layout` VALUES ('264', 'daily_ltv', '4|50|datepicker|用户注册日期|c7c1-7f7b802c|static%4|50|serverlist|服务器选择|03dd-18c66dd1|static%4|50|parameter|LTV跨度|063d-c6a5d3e9|static%4|400|mmgridspec|LTV(单服)|3584-08a42c47|ajax%4|400|mmgridspec|LTV(汇总)|e905-6fb15f33|ajax%4|400|mmgridspec|LTV 15/30/60/90/120|456a-bce02f24|ajax', 'LTV(生命周期总价值)', '99', '11', '', '7', '0', '0');
INSERT INTO `report_layout` VALUES ('265', 'monthly_status', '4|50|datepicker|日期选择|193e-aa2b4450|static%4|50|serverlist|服务器选择|b5e9-3d42eb11|static%4|400|highchart|充值概况|cdbd-f94ed79c|ajax%4|400|highchart|登录概况|7e3d-5a0a7441|ajax%4|400|highchart|消费概况|314b-89396013|ajax%4|400|highchart|注册概况|3d7e-42e7fe8e|ajax%4|400|mmgrid|每月总况|7b5b-2e642db7|ajax', '每月总况', '99', '11', '', '93', '0', '0');

-- ----------------------------
-- Table structure for sql_tpl
-- ----------------------------
DROP TABLE IF EXISTS `sql_tpl`;
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
) ENGINE=InnoDB AUTO_INCREMENT=757 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sql_tpl
-- ----------------------------
INSERT INTO `sql_tpl` VALUES ('1', 't2', 'select t1.date, roles, users, changeTotal, consumers, amount from (select date_format(dtEventtime,\'%Y-%m-%d\') as date,count(*) as users, \'{plt}\' as plt from {plt}_accountlogin where iworldid in ({sid}) and dtEventtime between \'{ft}\' and \'{et}\' group by date_format(dtEventtime,\'%Y-%m-%d\')) as t1 inner join (select date_format(dtEventtime,\'%Y-%m-%d\') as date,count(*) as roles, \'{plt}\' as plt from {plt}_createrole where iworldid in ({sid}) and dtEventtime between \'{ft}\' and \'{et}\' group by date_format(dtEventtime,\'%Y-%m-%d\')) as t2 on t1.date = t2.date inner join (select date_format(dtEventtime,\'%Y-%m-%d\') as date, Sum(iMoneyPay) as changeTotal, count(DISTINCT iUin) as consumers, cast(sum(iMoneyPay)/10 as decimal(10,2)) as amount from {plt}_recharge where iworldid in ({sid}) and dtEventtime between \'{ft}\' and \'{et}\' group by date_format(dtEventtime,\'%Y-%m-%d\')) as t3 on t1.date = t3.date', '', 'bbb', '', 'b8f0-542173e5', 'select date,sum(cc) ,plt from [SQL] group by date');
INSERT INTO `sql_tpl` VALUES ('11', '试试', 'select date_format(dtEventtime,\'%Y-%m-%d\') as date,\'{plt}\' as plt,count(*) as cc from {plt}_createrole where iworldid in ({sid}) and dteventtime between \'{ft}\' and \'{et}\' group by date_format(dtEventtime,\'%Y-%m-%d\')', '', 'aaa', '', '87a5-20c3b25a', 'select date,sum(cc) ,plt from ([SQL]) as a group by date');
INSERT INTO `sql_tpl` VALUES ('61', '', 'select dtStatDate as statdate, iWorldId as worldid, iDayNewPayNum as daynewpaynum, iWeekNewPayNum as weeknewpaynum, iDWeekNewPayNum as dweeknewpaynum, iMonthNewPayNum as mouthnewpaynum from db{game}{plt}result.tbnewpayer where iworldid in ({sid})', '', 'test0', '{#@title#@:{#@text#@:#@Browser market shares at a specific website, 2010#@},#@tooltip#@:{#@pointFormat#@:#@{series.name}:{point.percentage:.1f}%#@},#@plotOptions#@:{#@pie#@:{#@allowPointSelect#@:1,#@cursor#@:#@pointer#@,#@dataLabels#@:{#@enabled#@:1,#@format#@:#@{point.name}:{point.percentage:.1f}%#@}}},#@series#@:[{#@type#@:#@pie#@,#@name#@:#@seriesName#@,#@data#@:[],#@key#@:#@optionName|optionData#@}]}', '0000-00000000', '');
INSERT INTO `sql_tpl` VALUES ('502', '', null, null, 'tset10022', null, 'c53f-1c7520c1', null);
INSERT INTO `sql_tpl` VALUES ('503', '', null, null, 'tset10022', null, '7b54-77144f5e', null);
INSERT INTO `sql_tpl` VALUES ('710', '', null, null, 'zhanjia_level_dis_by_day_new', null, '809d-ad8c8105', null);
INSERT INTO `sql_tpl` VALUES ('711', '', null, null, 'zhanjia_level_dis_by_day_new', null, 'a3ab-f7e9b8bb', null);
INSERT INTO `sql_tpl` VALUES ('712', '', null, null, 'tianzui_level_dis_by_day_new', null, '2073-c84576f6', null);
INSERT INTO `sql_tpl` VALUES ('713', '', null, null, 'tianzui_level_dis_by_day_new', null, '2449-29ffeffd', null);
INSERT INTO `sql_tpl` VALUES ('714', '', null, null, 'tianzui_level_dis_by_day_new', null, '9e6c-211a881e', null);
INSERT INTO `sql_tpl` VALUES ('716', 'custom', 'select aHourRecharge, bHourRecharge, cHourRecharge, dd.dtstattime from (select tplFiveMinutes as dtstattime from db{game}conf.tbtemplatebyfiveminutes) as dd left join (select sum(iHourRecharge) as aHourRecharge, aHour from (select max(iHourRecharge) as iHourRecharge, DATE_FORMAT(dtStatTime,\'%H:%i\') as aHour, iWorldId from db{game}{plt}result.tbrealrecharge WHERE iWorldId in ({sid}) and DATE_FORMAT(dtStatTime,\'%Y-%m-%d\') =\'{time_a}\'  GROUP BY iWorldId, DATE_FORMAT(dtStatTime,\'%H:%i\')) as a GROUP BY aHour) as aa on dd.dtstattime = aa.aHour left join (select sum(iHourRecharge) as bHourRecharge, aHour from (select max(iHourRecharge) as iHourRecharge, DATE_FORMAT(dtStatTime,\'%H:%i\') as aHour, iWorldId from db{game}{plt}result.tbrealrecharge WHERE iWorldId in ({sid}) and DATE_FORMAT(dtStatTime,\'%Y-%m-%d\') =\'{time_b}\'  GROUP BY iWorldId, DATE_FORMAT(dtStatTime,\'%H:%i\')) as b GROUP BY aHour) as bb on dd.dtstattime = bb.aHour left join (select sum(iHourRecharge) as cHourRecharge, aHour from (select max(iHourRecharge) as iHourRecharge, DATE_FORMAT(dtStatTime,\'%H:%i\') as aHour, iWorldId from db{game}{plt}result.tbrealrecharge WHERE iWorldId in ({sid}) and DATE_FORMAT(dtStatTime,\'%Y-%m-%d\') =\'{time_c}\'  GROUP BY iWorldId, DATE_FORMAT(dtStatTime,\'%H:%i\')) as c GROUP BY aHour) as cc on dd.dtstattime = cc.aHour', null, 'realtime_recharge_curves', null, 'e055-3c1503b0', 'select round(sum(aHourRecharge)/100,2) as aHourRecharge, round(sum(bHourRecharge)/100,2) as bHourRecharge, round(sum(cHourRecharge)/100,2) as cHourRecharge, CONCAT(DATE_FORMAT(now(),\'%Y-%m-%d \'), dtstattime, \':00\') as dtstattime from ([SQL]) as tmp group by dtstattime');
INSERT INTO `sql_tpl` VALUES ('739', '', 'select dtStatDate,sum(LoginAccount) iAccountCount\r\nfrom db{game}{plt}result.daily_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate', null, 'daily_status', '{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@登录概况#@},#@subtitle#@:{#@text#@:#@登录概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@登录人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}', 'b10b-458f62ea', 'select substr(dtStatDate,6,10) dtStatDate,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate');
INSERT INTO `sql_tpl` VALUES ('740', '', 'select dtStatDate, sum(PayAmount) iAmount,sum(PayAccount) iAccountCount\r\nfrom db{game}{plt}result.daily_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate', null, 'daily_status', '{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@充值概况#@},#@subtitle#@:{#@text#@:#@充值概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}元#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}},{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false},#@opposite#@:true}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@充值金额#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@元#@},#@key#@:#@iAmount#@,#@data#@:[]},{#@name#@:#@充值人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:1,#@type#@:#@line#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}', 'c575-e25b9bc1', 'select substr(dtStatDate,6,10) dtStatDate,round(sum(iAmount),2) iAmount,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate');
INSERT INTO `sql_tpl` VALUES ('741', '', 'select dtStatDate, sum(ShopAmount) iAmount, sum(ShopAccount) iAccountCount\r\nfrom db{game}{plt}result.daily_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate', null, 'daily_status', '{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@消费概况#@},#@subtitle#@:{#@text#@:#@消费概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}元#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}},{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false},#@opposite#@:true}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@消费金额#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@元#@},#@key#@:#@iAmount#@,#@data#@:[]},{#@name#@:#@消费人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:1,#@type#@:#@line#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}', '2133-8b9e01fb', 'select substr(dtStatDate,6,10) dtStatDate,round(sum(iAmount),2) iAmount,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate');
INSERT INTO `sql_tpl` VALUES ('742', '', 'select dtStatDate, sum(RegisterAccount) iAccountCount\r\nfrom db{game}{plt}result.daily_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate', null, 'daily_status', '{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@注册概况#@},#@subtitle#@:{#@text#@:#@注册概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}元#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@注册人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}', 'ea0c-c61f3f7c', 'select substr(dtStatDate,6,10) dtStatDate, sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate');
INSERT INTO `sql_tpl` VALUES ('743', '', 'select dl.dtStatDate,dl.loginCount,ifnull(wb.iOpenNum,0) iOpenNum,rechargeAmount rechargeAmount,rechargeAccountCount,createAccountCount,iShopAccount,iShopAmount iShopAmount\r\nfrom (\r\n	SELECT dtStatDate,sum(LoginAccount) loginCount,sum(PayAmount) rechargeAmount,sum(PayAccount) rechargeAccountCount,sum(RegisterAccount) createAccountCount,sum(ShopAccount) iShopAccount,sum(ShopAmount) iShopAmount\r\n	FROM db{game}{plt}result.daily_basic\r\n	WHERE dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\n	group by dtStatDate\r\n) dl left join (\r\n	SELECT dtBeginDate,count(iWorldId) iOpenNum\r\n	FROM db{game}conf.tbworldbegindate\r\n	WHERE vPlt = \'{plt}\'\r\n	AND dtBeginDate >= \'{ft}\'\r\n	AND dtBeginDate <= \'{et}\'\r\n	GROUP BY dtBeginDate\r\n) wb on dl.dtStatDate=wb.dtBeginDate', null, 'daily_status', '{#@column#@:[{#@title#@:#@日期#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@dtStatDate#@,#@type#@:#@0#@},{#@title#@:#@开服数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iOpenNum#@,#@type#@:#@number#@},{#@title#@:#@注册人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@createAccountCount#@,#@type#@:#@number#@},{#@title#@:#@登录人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@loginCount#@,#@type#@:#@number#@},{#@title#@:#@充值金额#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeAmount#@,#@type#@:#@number#@},{#@title#@:#@充值人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeAccountCount#@,#@type#@:#@number#@},{#@title#@:#@消费金额#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iShopAmount#@,#@type#@:#@number#@},{#@title#@:#@消费人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iShopAccount#@,#@type#@:#@number#@},{#@title#@:#@ARPU#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@arpu#@,#@type#@:#@number#@},{#@title#@:#@ARPPU#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@arppu#@,#@type#@:#@number#@},{#@title#@:#@充值渗透率(%)#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeRate#@,#@type#@:#@number#@},{#@title#@:#@老用户数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@oldAccount#@,#@type#@:#@number#@},{#@title#@:#@老用户比(%)#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@oldAccountRate#@,#@type#@:#@number#@}],#@paging#@:32}', '677e-1ed2fe91', 'select *,round(rechargeAmount/loginCount,2) arpu,round(rechargeAmount/rechargeAccountCount,2) arppu,round(rechargeAccountCount/loginCount*100,2) rechargeRate,loginCount-createAccountCount oldAccount,round((loginCount-createAccountCount)/loginCount*100,2) oldAccountRate,iShopAccount,iShopAmount\r\nfrom (\r\nselect dtStatDate,sum(loginCount) loginCount,sum(iOpenNum) iOpenNum,round(sum(rechargeAmount),2) rechargeAmount,sum(rechargeAccountCount) rechargeAccountCount ,\r\n      sum(createAccountCount) createAccountCount,sum(iShopAccount) iShopAccount,round(sum(iShopAmount),2) iShopAmount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate\r\norder by dtStatDate desc\r\n) o\r\n\r\nunion all\r\n\r\nselect *,round(rechargeAmount/loginCount,2) arpu,round(rechargeAmount/rechargeAccountCount,2) arppu,round(rechargeAccountCount/loginCount*100,2) rechargeRate,loginCount-createAccountCount oldAccount,round((loginCount-createAccountCount)/loginCount*100,2) oldAccountRate,iShopAccount,iShopAmount\r\nfrom (\r\nselect \'汇总\' dtStatDate,sum(loginCount) loginCount,sum(iOpenNum) iOpenNum,round(sum(rechargeAmount),2) rechargeAmount,sum(rechargeAccountCount) rechargeAccountCount ,\r\n      sum(createAccountCount) createAccountCount,sum(iShopAccount) iShopAccount,round(sum(iShopAmount),2) iShopAmount\r\nfrom ([SQL]) t\r\n) a');
INSERT INTO `sql_tpl` VALUES ('744', '', 'select  RegisterDate,dtStatDate,sum(RetentionNum) iRetentionNum\r\nfrom db{game}{plt}result.daily_retention\r\nwhere RegisterDate between \'{ft}\' and \'{et}\' and dtStatDate between RegisterDate and adddate(RegisterDate,interval 30 day) and worldid in ({sid}) \r\ngroup by RegisterDate,dtStatDate', null, 'daily_retention', '{#@column#@:[{#@title#@:#@注册日期#@,#@name#@:#@RegisterDate#@},{#@title#@:#@days#@,#@name#@:#@rate#@}]}', '3055-8925f0ea', 'select dtStatDate,a.RegisterDate,iRetentionNum,round(iRetentionNum/iRegNum*100,2) rate,concat(\'第\',datediff(dtStatDate,a.RegisterDate)+1,\'天\') days\r\nfrom (\r\n  select RegisterDate,dtStatDate,sum(iRetentionNum) iRetentionNum\r\n  from ([SQL]) t\r\n  where dtStatDate!=RegisterDate\r\n  group by RegisterDate,dtStatDate\r\n) d left join (\r\n  select RegisterDate,sum(iRetentionNum) iRegNum\r\n  from ([SQL]) tt\r\n  where dtStatDate=RegisterDate\r\n  group by RegisterDate\r\n) a on d.RegisterDate=a.RegisterDate\r\norder by RegisterDate asc, datediff(dtStatDate,a.RegisterDate) asc');
INSERT INTO `sql_tpl` VALUES ('745', '', 'select dtStatDate,sum(RetentionNum) iRetentionNum,\'{ft}\' regDate\r\nfrom db{game}{plt}result.daily_retention\r\nwhere RegisterDate=\'{ft}\' and dtStatDate between \'{ft}\' and adddate(\'{ft}\',interval 30 day) and worldid in ({sid}) \r\ngroup by dtStatDate', null, 'daily_retention', '{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@留存率曲线图#@},#@subtitle#@:{#@text#@:#@起始日#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@days#@,#@series#@:[{#@name#@:#@留存率#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@line#@,#@tooltip#@:{#@valueSuffix#@:#@%#@},#@key#@:#@rate#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}', '931c-bed9dc26', 'select dtStatDate,iRetentionNum,round(iRetentionNum/iRegNum*100,2) rate,datediff(dtStatDate,regDate)+1 days\r\nfrom (\r\nselect dtStatDate,sum(iRetentionNum) iRetentionNum,regDate\r\nfrom ([SQL]) t\r\nwhere dtStatDate!=regDate\r\ngroup by dtStatDate\r\n) d left join (\r\nselect sum(iRetentionNum) iRegNum\r\nfrom ([SQL]) tt\r\nwhere dtStatDate=regDate\r\n) a on 1=1');
INSERT INTO `sql_tpl` VALUES ('746', '', 'select dtStatDate,sum(RetentionNum) iRetentionNum,\'{ft}\' regDate\r\nfrom db{game}{plt}result.daily_retention\r\nwhere RegisterDate=\'{ft}\' and dtStatDate between \'{ft}\' and adddate(\'{ft}\',interval 60 day) and worldid in ({sid}) \r\ngroup by dtStatDate', null, 'daily_retention', '{#@column#@:[{#@title#@:#@留存日期#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@dtStatDate#@,#@type#@:#@0#@},{#@title#@:#@留存天数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@days#@,#@type#@:#@number#@},{#@title#@:#@留存人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iRetentionNum#@,#@type#@:#@number#@},{#@title#@:#@留存率(%)#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rate#@,#@type#@:#@number#@}]}', '0e18-9ffc4f70', 'select dtStatDate,iRetentionNum,round(iRetentionNum/iRegNum*100,2) rate,concat(\'第\',datediff(dtStatDate,regDate)+1,\'天\') days\r\nfrom (\r\nselect dtStatDate,sum(iRetentionNum) iRetentionNum,regDate\r\nfrom ([SQL]) t\r\nwhere dtStatDate!=regDate\r\ngroup by dtStatDate\r\n) d left join (\r\nselect sum(iRetentionNum) iRegNum\r\nfrom ([SQL]) tt\r\nwhere dtStatDate=regDate\r\n) a on 1=1');
INSERT INTO `sql_tpl` VALUES ('747', '', '', null, 'daily_ltv', '{#@parameter#@:[{#@title#@:#@跨度(7/15/30)#@,#@name#@:#@inter_days#@,#@type#@:#@text#@,#@value#@:#@7#@}]}', '063d-c6a5d3e9', '');
INSERT INTO `sql_tpl` VALUES ('748', '', 'select concat(RegisterDate,\' @\',\'{plt}\',\' #\',WorldId) dateAndSid,round(TotalPayAmount/RegisterNum,2) iLTV,concat(\'LTV\',datediff(dtStatDate,RegisterDate)+1) vdays,datediff(dtStatDate,RegisterDate)+1 idays\r\nfrom db{game}{plt}result.daily_ltv\r\nwhere RegisterDate between \'{ft}\' and \'{et}\' \r\nand  dtStatDate between RegisterDate and adddate(RegisterDate ,interval {inter_days}-1 day) \r\nand  worldid in ({sid})', null, 'daily_ltv', '{#@column#@:[{#@title#@:#@注册日期 @平台 #区服#@,#@name#@:#@dateAndSid#@},{#@title#@:#@vdays#@,#@name#@:#@iLTV#@}]}', '3584-08a42c47', 'select *\r\nfrom ([SQL]) t\r\norder by dateAndSid,idays');
INSERT INTO `sql_tpl` VALUES ('749', '', 'select RegisterDate,TotalPayAmount TotalPayAmount,RegisterNum,datediff(dtStatDate,RegisterDate)+1 idays\r\nfrom db{game}{plt}result.daily_ltv\r\nwhere RegisterDate between \'{ft}\' and \'{et}\' \r\nand  dtStatDate between RegisterDate and adddate(RegisterDate ,interval {inter_days}-1 day) \r\nand  worldid in ({sid})', null, 'daily_ltv', '{#@column#@:[{#@title#@:#@注册日期#@,#@name#@:#@RegisterDate#@},{#@title#@:#@vdays#@,#@name#@:#@iLtv#@}]}', 'e905-6fb15f33', 'select RegisterDate,ifnull(round(sum(TotalPayAmount)/sum(RegisterNum),2),0) iLtv,concat(\'LTV\',idays) vdays\r\nfrom ([SQL]) t\r\ngroup by RegisterDate,idays\r\norder by RegisterDate,idays');
INSERT INTO `sql_tpl` VALUES ('750', '', 'select concat(RegisterDate,\' @\',\'{plt}\',\' #\',WorldId) dateAndSid,round(TotalPayAmount/RegisterNum,2) iLTV,concat(\'LTV\',datediff(dtStatDate,RegisterDate)+1) vdays,datediff(dtStatDate,RegisterDate)+1 idays\r\nfrom db{game}{plt}result.daily_ltv\r\nwhere RegisterDate between \'{ft}\' and \'{et}\' \r\nand  dtStatDate in (adddate(RegisterDate ,interval 15-1 day),adddate(RegisterDate ,interval 30-1 day),adddate(RegisterDate ,interval 60-1 day),adddate(RegisterDate ,interval 90-1 day),adddate(RegisterDate ,interval 120-1 day))\r\nand WorldId in ({sid})', null, 'daily_ltv', '{#@column#@:[{#@title#@:#@注册日期 @平台 #区服#@,#@name#@:#@dateAndSid#@},{#@title#@:#@vdays#@,#@name#@:#@iLTV#@}]}', '456a-bce02f24', 'select *\r\nfrom ([SQL]) t\r\norder by dateAndSid,idays');
INSERT INTO `sql_tpl` VALUES ('751', '', 'select date_format(dtStatDate, \'%Y-%m\') dtStatDate,sum(PayAmount) iAmount,sum(PayAccount) iAccountCount\r\nfrom db{game}{plt}result.monthly_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate', null, 'monthly_status', '{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@充值概况#@},#@subtitle#@:{#@text#@:#@充值概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}元#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}},{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false},#@opposite#@:true}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@充值金额#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@元#@},#@key#@:#@iAmount#@,#@data#@:[]},{#@name#@:#@充值人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:1,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}', 'cdbd-f94ed79c', 'select dtStatDate,round(sum(iAmount),2) iAmount,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate');
INSERT INTO `sql_tpl` VALUES ('752', '', 'select date_format(dtStatDate, \'%Y-%m\') dtStatDate,sum(LoginAccount) iAccountCount\r\nfrom db{game}{plt}result.monthly_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate', null, 'monthly_status', '{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@登录概况#@},#@subtitle#@:{#@text#@:#@登录概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}},{#@labels#@:{#@format#@:#@{value}次#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false},#@opposite#@:true}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@登录人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}', '7e3d-5a0a7441', 'select dtStatDate,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate');
INSERT INTO `sql_tpl` VALUES ('753', '', 'select date_format(dtStatDate, \'%Y-%m\') dtStatDate,sum(PayAmount) iAmount,sum(ShopAccount) iAccountCount\r\nfrom db{game}{plt}result.monthly_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate', null, 'monthly_status', '{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@消费概况#@},#@subtitle#@:{#@text#@:#@消费概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}元#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}},{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false},#@opposite#@:true}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@消费金额#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@元#@},#@key#@:#@iAmount#@,#@data#@:[]},{#@name#@:#@消费人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:1,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}', '314b-89396013', 'select dtStatDate,round(sum(iAmount),2) iAmount,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate');
INSERT INTO `sql_tpl` VALUES ('754', '', 'select date_format(dtStatDate, \'%Y-%m\') dtStatDate,sum(RegisterAccount) iAccountCount\r\nfrom db{game}{plt}result.monthly_basic\r\nwhere dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\ngroup by dtStatDate', null, 'monthly_status', '{#@chart#@:{#@zoomType#@:#@xy#@},#@title#@:{#@text#@:#@注册概况#@},#@subtitle#@:{#@text#@:#@注册概况#@},#@yAxis#@:[{#@labels#@:{#@format#@:#@{value}元#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false}},{#@labels#@:{#@format#@:#@{value}人#@},#@title#@:{#@text#@:#@#@},#@stackLabels#@:{#@enabled#@:false},#@opposite#@:true}],#@xAxis#@:[{#@categories#@:[]}],#@xkey#@:#@dtStatDate#@,#@series#@:[{#@name#@:#@注册人数#@,#@dataLabels#@:{#@enabled#@:true},#@yAxis#@:0,#@type#@:#@column#@,#@tooltip#@:{#@valueSuffix#@:#@人#@},#@key#@:#@iAccountCount#@,#@data#@:[]}],#@plotOptions#@:{#@series#@:{#@dataLabels#@:{#@color#@:#@gray#@}}}}', '3d7e-42e7fe8e', 'select dtStatDate,sum(iAccountCount) iAccountCount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate');
INSERT INTO `sql_tpl` VALUES ('755', '', 'select dl.dtStatDate,dl.loginCount,ifnull(wb.iOpenNum,0) iOpenNum,rechargeAmount rechargeAmount,rechargeAccountCount,createAccountCount,iNewPayAmount iNewPayAmount,iNewPayAccount,iShopAccount,iShopAmount iShopAmount\r\nfrom (\r\n	SELECT date_format(dtStatDate, \'%Y-%m\') dtStatDate,sum(LoginAccount) loginCount,sum(PayAmount) rechargeAmount,sum(PayAccount) rechargeAccountCount,sum(NewPayAmount) iNewPayAmount,sum(NewPayAccount) iNewPayAccount,\r\n               sum(RegisterAccount) createAccountCount,sum(ShopAccount) iShopAccount,sum(ShopAmount) iShopAmount\r\n	FROM db{game}{plt}result.monthly_basic\r\n	WHERE dtStatDate between \'{ft}\' and \'{et}\' and WorldId in ({sid}) \r\n	group by dtStatDate\r\n) dl left join (\r\n	SELECT date_format(dtBeginDate, \'%Y-%m\') dtBeginDate,count(iWorldId) iOpenNum\r\n	FROM db{game}conf.tbworldbegindate\r\n	WHERE vPlt = \'{plt}\'\r\n	AND dtBeginDate >= \'{ft}\'\r\n	AND dtBeginDate <= \'{et}\'\r\n	GROUP BY date_format(dtBeginDate, \'%Y-%m\')\r\n) wb on dl.dtStatDate=wb.dtBeginDate', null, 'monthly_status', '{#@column#@:[{#@title#@:#@日期#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@dtStatDate#@,#@type#@:#@0#@},{#@title#@:#@开服数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iOpenNum#@,#@type#@:#@number#@},{#@title#@:#@注册人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@createAccountCount#@,#@type#@:#@number#@},{#@title#@:#@登录人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@loginCount#@,#@type#@:#@number#@},{#@title#@:#@充值金额#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeAmount#@,#@type#@:#@number#@},{#@title#@:#@充值人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeAccountCount#@,#@type#@:#@number#@},{#@title#@:#@消费金额#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iShopAmount#@,#@type#@:#@number#@},{#@title#@:#@消费人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iShopAccount#@,#@type#@:#@number#@},{#@title#@:#@ARPU#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@arpu#@,#@type#@:#@number#@},{#@title#@:#@ARPPU#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@arppu#@,#@type#@:#@number#@},{#@title#@:#@充值渗透率(%)#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@rechargeRate#@,#@type#@:#@number#@},{#@title#@:#@老用户数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@oldAccount#@,#@type#@:#@number#@},{#@title#@:#@老用户比(%)#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@oldAccountRate#@,#@type#@:#@number#@},{#@title#@:#@新注册充值人数#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iNewPayAccount#@,#@type#@:#@number#@},{#@title#@:#@新注册充值金额#@,#@sortable#@:#@1#@,#@align#@:#@center#@,#@name#@:#@iNewPayAmount#@,#@type#@:#@number#@}]}', '7b5b-2e642db7', 'select *,round(rechargeAmount/loginCount,2) arpu,round(rechargeAmount/rechargeAccountCount,2) arppu,rechargeAccountCount/loginCount*100 rechargeRate,loginCount-createAccountCount oldAccount,(loginCount-createAccountCount)/loginCount*100 oldAccountRate,iShopAccount,iShopAmount,iNewPayAmount,iNewPayAccount\r\nfrom (\r\nselect dtStatDate,sum(loginCount) loginCount,sum(iOpenNum) iOpenNum,round(sum(rechargeAmount),2) rechargeAmount,sum(rechargeAccountCount) rechargeAccountCount ,\r\n      sum(createAccountCount) createAccountCount,sum(iShopAccount) iShopAccount,round(sum(iShopAmount),2) iShopAmount,round(sum(iNewPayAmount),2) iNewPayAmount,sum(iNewPayAccount) iNewPayAccount\r\nfrom ([SQL]) t\r\ngroup by dtStatDate\r\norder by dtStatDate desc\r\n) o');
INSERT INTO `sql_tpl` VALUES ('756', '', '', null, 'monthly_status', '{#@dptimepick#@:1,#@dpmethod#@:0}', '193e-aa2b4450', '');
