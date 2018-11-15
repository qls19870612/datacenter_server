/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50615
Source Host           : 127.0.0.1:3306
Source Database       : dbbhsconf

Target Server Type    : MYSQL
Target Server Version : 50615
File Encoding         : 65001

Date: 2017-12-26 15:34:06
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for tbplt
-- ----------------------------
DROP TABLE IF EXISTS `tbplt`;
CREATE TABLE `tbplt` (
  `iPid` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '平台id',
  `vPname` varchar(100) DEFAULT NULL COMMENT '平台名称',
  `vGame` varchar(50) DEFAULT NULL COMMENT '游戏名称',
  PRIMARY KEY (`iPid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='风云平台对照表';

-- ----------------------------
-- Records of tbplt
-- ----------------------------
INSERT INTO `tbplt` VALUES ('1', 'yy', 'bhs');

-- ----------------------------
-- Table structure for tbworldbegindate
-- ----------------------------
DROP TABLE IF EXISTS `tbworldbegindate`;
CREATE TABLE `tbworldbegindate` (
  `iPid` int(10) NOT NULL COMMENT '平台id号',
  `vPlt` varchar(255) NOT NULL COMMENT '平台名称',
  `iWorldId` int(10) NOT NULL COMMENT '区服id',
  `dtBeginDate` date DEFAULT NULL COMMENT '开服时间',
  `iModify` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '是否已手动改开服时间(改过填1)',
  PRIMARY KEY (`vPlt`,`iWorldId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='平台区服开服时间';

-- ----------------------------
-- Records of tbworldbegindate
-- ----------------------------
INSERT INTO `tbworldbegindate` VALUES ('1', 'yy', '1', '2016-12-06', '0');
INSERT INTO `tbworldbegindate` VALUES ('1', 'yy', '2', '2017-02-22', '0');
INSERT INTO `tbworldbegindate` VALUES ('1', 'yy', '3', '2017-04-05', '0');
