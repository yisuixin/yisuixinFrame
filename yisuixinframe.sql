/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50726
Source Host           : localhost:3306
Source Database       : yisuixinframe

Target Server Type    : MYSQL
Target Server Version : 50726
File Encoding         : 65001

Date: 2020-11-30 12:57:30
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin
-- ----------------------------
DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `roleId` int(11) unsigned NOT NULL COMMENT '//用户所属角色组',
  `avatar` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `api_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `auth_key` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `password_hash` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password_reset_token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `mark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) NOT NULL DEFAULT '10' COMMENT '9禁用,10启用，0已删除',
  `last_ip` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `roleId` (`roleId`) USING BTREE,
  CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`roleId`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of admin
-- ----------------------------
INSERT INTO `admin` VALUES ('1', 'admin', '他们都叫我小明', '1', 'http://yisuixinframe.com/uploads/2020-11-22/20201122173411387.png', '8O-C_HgYLt34tW0G-FYt0XNkDVYsFyI0_1606700075', 'DogXMXfvKsRaZwJ4VQLjyrHVDWQFEnqA', '$2y$13$1xEsALQ8BXbPm27ea9NdKOTpd.iQD4I7GUFCQiU77yWzmKW3bpqVS', null, '1036753791@qq.com', '天下第一帅？', '10', '127.0.0.1', '1598173301', '1606700075');
INSERT INTO `admin` VALUES ('3', 'newManager', '测试新增管理员', '4', 'http://vuepermission.com/uploads/2020-10-19/20201019160628359.png', 'a1l13bCqF4O2dPqed-AM6Lh_evxJIbOP_1606700297', 'g8Hww8DWQ4viqj9-ODrsnWiCyTW2re2B', '$2y$13$S7shP4X258SFIhBrgP.X2.ID2nZFlLymnEIZ18Tt/YeMgTw.e38Fm', null, '', '', '10', '127.0.0.1', '1600760210', '1606700297');
INSERT INTO `admin` VALUES ('5', 'test', '测试用户', '4', 'http://vuepermission.com/uploads/2020-10-19/20201019160628359.png', 'HLYx_CBnVRYd9birMZzhe73xGjfRcDgP_1603094680', 'NKQ8C3_Stc30xV3htr1glf_sDJQHbpjC', '$2y$13$MSIyMBe10Onnv47pQNaKPupaESbp3xMZxTSNTvrvwYnM034AqKgGi', null, 'test@qq.com', '', '0', '127.0.0.1', '1603094666', '1606639659');
INSERT INTO `admin` VALUES ('6', 'QQQQQQQ', '222222', '4', null, null, 'r767RY72MXMsYF3O3HzvfKtWn9aHiPyz', '$2y$13$q1r6b4jL5JWGvpfDoLSRt.wjk1H5c9zj151Q0d82mzaIEU1rSUiIm', null, '222222@QQ.COM', '', '0', null, '1606034934', '1606034955');
INSERT INTO `admin` VALUES ('7', 'roleAdmin', 'adminT', '5', null, 'z41np5306HIv_m4CFioYpEQaqHdPmT1M_1606551533', 'TKNJN2vb39jg21rqM9-jmbWK5Y3QTdwU', '$2y$13$/7uWcJcRULl20B1IyM.0jO2cF.56MHFOI8wGHyJB7tbRlybFMr/H.', null, 'roleAdmin@qq.com', '', '0', '127.0.0.1', '1606551482', '1606625961');
INSERT INTO `admin` VALUES ('8', 'roleer', 'roleer', '5', null, 'wFaclmqAL8Npa-b6OfTRlUm53nyfydPl_1606711349', '1C7tKqXXo0YK9AdLlphWB81XxsXwafPH', '$2y$13$2SyVS4q01qttFyA/u94.1e.DVi00q8YGaQJWI4AhcdjADpZ4/jlqK', null, '', '', '10', '127.0.0.1', '1606639606', '1606711349');

-- ----------------------------
-- Table structure for admincountdata
-- ----------------------------
DROP TABLE IF EXISTS `admincountdata`;
CREATE TABLE `admincountdata` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manger` int(11) NOT NULL DEFAULT '0',
  `category` int(11) NOT NULL DEFAULT '0',
  `content` int(11) NOT NULL DEFAULT '0',
  `theme` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admincountdata
-- ----------------------------
INSERT INTO `admincountdata` VALUES ('1', '1', '2', '3', '4');

-- ----------------------------
-- Table structure for frontendcountperson
-- ----------------------------
DROP TABLE IF EXISTS `frontendcountperson`;
CREATE TABLE `frontendcountperson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `number` int(11) NOT NULL,
  `visit_time` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of frontendcountperson
-- ----------------------------

-- ----------------------------
-- Table structure for log
-- ----------------------------
DROP TABLE IF EXISTS `log`;
CREATE TABLE `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uId` int(11) DEFAULT NULL,
  `type` tinyint(2) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `url` varchar(255) DEFAULT NULL,
  `desc` longtext,
  `ip` varchar(255) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=631 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of log
-- ----------------------------
INSERT INTO `log` VALUES ('532', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603174133', '1603174133');
INSERT INTO `log` VALUES ('533', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603178122', '1603178122');
INSERT INTO `log` VALUES ('534', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603248108', '1603248108');
INSERT INTO `log` VALUES ('535', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603249643', '1603249643');
INSERT INTO `log` VALUES ('536', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603329354', '1603329354');
INSERT INTO `log` VALUES ('537', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603334614', '1603334614');
INSERT INTO `log` VALUES ('538', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603345693', '1603345693');
INSERT INTO `log` VALUES ('539', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603416074', '1603416074');
INSERT INTO `log` VALUES ('540', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603421030', '1603421030');
INSERT INTO `log` VALUES ('541', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603503842', '1603503842');
INSERT INTO `log` VALUES ('542', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603507487', '1603507487');
INSERT INTO `log` VALUES ('543', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603676082', '1603676082');
INSERT INTO `log` VALUES ('544', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603694963', '1603694963');
INSERT INTO `log` VALUES ('545', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603762646', '1603762646');
INSERT INTO `log` VALUES ('546', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603781287', '1603781287');
INSERT INTO `log` VALUES ('547', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603847840', '1603847840');
INSERT INTO `log` VALUES ('548', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603849190', '1603849190');
INSERT INTO `log` VALUES ('549', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603861975', '1603861975');
INSERT INTO `log` VALUES ('550', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1603938028', '1603938028');
INSERT INTO `log` VALUES ('551', null, '1', '登录失败,账号或者密码错误', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:37:\"登录失败,账号或者密码错误\";}', '127.0.0.1', '1604021603', '1604021603');
INSERT INTO `log` VALUES ('552', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1604021612', '1604021612');
INSERT INTO `log` VALUES ('553', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1604024771', '1604024771');
INSERT INTO `log` VALUES ('554', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1604048806', '1604048806');
INSERT INTO `log` VALUES ('555', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1604049148', '1604049148');
INSERT INTO `log` VALUES ('556', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1604108140', '1604108140');
INSERT INTO `log` VALUES ('557', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1604111543', '1604111543');
INSERT INTO `log` VALUES ('558', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1604112454', '1604112454');
INSERT INTO `log` VALUES ('559', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1604113107', '1604113107');
INSERT INTO `log` VALUES ('560', null, '1', '登录成功', 'http://ysuixincms.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1604282049', '1604282049');
INSERT INTO `log` VALUES ('561', null, '1', '登录成功', 'http://yisuixinframe.com/api/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1604301581', '1604301581');
INSERT INTO `log` VALUES ('562', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1605407654', '1605407654');
INSERT INTO `log` VALUES ('563', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1605853851', '1605853851');
INSERT INTO `log` VALUES ('564', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1605926567', '1605926567');
INSERT INTO `log` VALUES ('565', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606009972', '1606009972');
INSERT INTO `log` VALUES ('566', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606030646', '1606030646');
INSERT INTO `log` VALUES ('567', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606031996', '1606031996');
INSERT INTO `log` VALUES ('568', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606037613', '1606037613');
INSERT INTO `log` VALUES ('569', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606096752', '1606096752');
INSERT INTO `log` VALUES ('570', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606356420', '1606356420');
INSERT INTO `log` VALUES ('571', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606442090', '1606442090');
INSERT INTO `log` VALUES ('572', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606466252', '1606466252');
INSERT INTO `log` VALUES ('573', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606466410', '1606466410');
INSERT INTO `log` VALUES ('574', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606466536', '1606466536');
INSERT INTO `log` VALUES ('575', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606468513', '1606468513');
INSERT INTO `log` VALUES ('576', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606468646', '1606468646');
INSERT INTO `log` VALUES ('577', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606529416', '1606529416');
INSERT INTO `log` VALUES ('578', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606529978', '1606529978');
INSERT INTO `log` VALUES ('579', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606540064', '1606540064');
INSERT INTO `log` VALUES ('580', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606541603', '1606541603');
INSERT INTO `log` VALUES ('581', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606548334', '1606548334');
INSERT INTO `log` VALUES ('582', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606548402', '1606548402');
INSERT INTO `log` VALUES ('583', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606548470', '1606548470');
INSERT INTO `log` VALUES ('584', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606548524', '1606548524');
INSERT INTO `log` VALUES ('585', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606548670', '1606548670');
INSERT INTO `log` VALUES ('586', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606548761', '1606548761');
INSERT INTO `log` VALUES ('587', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606549081', '1606549081');
INSERT INTO `log` VALUES ('588', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606549128', '1606549128');
INSERT INTO `log` VALUES ('589', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606549137', '1606549137');
INSERT INTO `log` VALUES ('590', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606549710', '1606549710');
INSERT INTO `log` VALUES ('591', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606550009', '1606550009');
INSERT INTO `log` VALUES ('592', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606550085', '1606550085');
INSERT INTO `log` VALUES ('593', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606550168', '1606550168');
INSERT INTO `log` VALUES ('594', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606550199', '1606550199');
INSERT INTO `log` VALUES ('595', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606550220', '1606550220');
INSERT INTO `log` VALUES ('596', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606550276', '1606550276');
INSERT INTO `log` VALUES ('597', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606550734', '1606550734');
INSERT INTO `log` VALUES ('598', null, '1', '登录失败,账号或者密码错误', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"adminT\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:37:\"登录失败,账号或者密码错误\";}', '127.0.0.1', '1606551498', '1606551498');
INSERT INTO `log` VALUES ('599', null, '1', '登录失败,账号或者密码错误', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"adminT\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:37:\"登录失败,账号或者密码错误\";}', '127.0.0.1', '1606551516', '1606551516');
INSERT INTO `log` VALUES ('600', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:9:\"roleAdmin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606551533', '1606551533');
INSERT INTO `log` VALUES ('601', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606552741', '1606552741');
INSERT INTO `log` VALUES ('602', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606552865', '1606552865');
INSERT INTO `log` VALUES ('603', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606552993', '1606552993');
INSERT INTO `log` VALUES ('604', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606553479', '1606553479');
INSERT INTO `log` VALUES ('605', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606553511', '1606553511');
INSERT INTO `log` VALUES ('606', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606554608', '1606554608');
INSERT INTO `log` VALUES ('607', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606556959', '1606556959');
INSERT INTO `log` VALUES ('608', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606557100', '1606557100');
INSERT INTO `log` VALUES ('609', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606614476', '1606614476');
INSERT INTO `log` VALUES ('610', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606614519', '1606614519');
INSERT INTO `log` VALUES ('611', null, '1', '登录失败.账号所属角色被禁用', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606637612', '1606637612');
INSERT INTO `log` VALUES ('612', null, '1', '登录失败.账号所属角色被禁用', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606637637', '1606637637');
INSERT INTO `log` VALUES ('613', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606637669', '1606637669');
INSERT INTO `log` VALUES ('614', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606637842', '1606637842');
INSERT INTO `log` VALUES ('615', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606638209', '1606638209');
INSERT INTO `log` VALUES ('616', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606638957', '1606638957');
INSERT INTO `log` VALUES ('617', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606639697', '1606639697');
INSERT INTO `log` VALUES ('618', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"roleer\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606639812', '1606639812');
INSERT INTO `log` VALUES ('619', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"roleer\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606641907', '1606641907');
INSERT INTO `log` VALUES ('620', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"roleer\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606642190', '1606642190');
INSERT INTO `log` VALUES ('621', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:5:\"admin\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606700076', '1606700076');
INSERT INTO `log` VALUES ('622', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"roleer\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606700215', '1606700215');
INSERT INTO `log` VALUES ('623', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606700256', '1606700256');
INSERT INTO `log` VALUES ('624', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:10:\"newManager\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606700297', '1606700297');
INSERT INTO `log` VALUES ('625', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"roleer\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606700644', '1606700644');
INSERT INTO `log` VALUES ('626', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"roleer\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606703415', '1606703415');
INSERT INTO `log` VALUES ('627', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"roleer\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606703503', '1606703503');
INSERT INTO `log` VALUES ('628', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"roleer\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606710984', '1606710984');
INSERT INTO `log` VALUES ('629', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"roleer\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606711098', '1606711098');
INSERT INTO `log` VALUES ('630', null, '1', '登录成功', 'http://yisuixinframe.com/common/user/login', 'a:3:{s:8:\"username\";s:6:\"roleer\";s:8:\"password\";s:12:\"密码保密\";s:7:\"content\";s:12:\"登录成功\";}', '127.0.0.1', '1606711349', '1606711349');

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) NOT NULL DEFAULT '0' COMMENT '0为第一级菜单',
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` tinyint(3) DEFAULT '1' COMMENT '1权限认证+菜单2只作为菜单；权限不会显示在页面',
  `icon` varchar(50) DEFAULT NULL,
  `href` varchar(255) DEFAULT NULL,
  `template` varchar(255) DEFAULT NULL COMMENT '页面模板地址',
  `level` tinyint(2) DEFAULT '1' COMMENT '1一级菜单，2二级菜单，3三级菜单',
  `sort` tinyint(4) DEFAULT '1',
  `status` tinyint(3) DEFAULT '1' COMMENT '1显示2隐藏',
  `create_template` tinyint(3) DEFAULT '2' COMMENT '//是否生成前端vue模板，1是2否',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=214 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('137', '0', '内容管理', 'contentManager', '2', 'ios-analytics', 'contentManager', 'contentManager', '1', '1', '1', '2', '1600161029', '1606639081');
INSERT INTO `menu` VALUES ('138', '137', '内容管理', 'contentManager', '2', 'md-list-box', 'contentManager', 'contentManager/contentManager', '2', '1', '1', '2', '1600161070', '1604047752');
INSERT INTO `menu` VALUES ('139', '138', '管理内容', 'contentManager', '1', 'md-list-box', 'contentManager', 'contentManager/contentManager/contentManager', '3', '1', '1', '2', '1600161094', '1604047752');
INSERT INTO `menu` VALUES ('140', '137', '内容相关管理', 'contentRelevant', '2', 'md-link', 'contentRelevant', 'contentManager/contentRelevant', '2', '1', '1', '2', '1600161297', '1604047752');
INSERT INTO `menu` VALUES ('141', '138', '附件管理', 'attachmentManager', '1', 'md-list-box', 'attachmentManager', 'contentManager/contentManager/attachmentManager', '3', '1', '1', '2', '1600161346', '1604047752');
INSERT INTO `menu` VALUES ('142', '140', '栏目列表', 'categoryList', '1', 'md-list-box', 'categoryList', 'contentManager/contentRelevant/categoryList', '3', '1', '1', '2', '1600161448', '1604047752');
INSERT INTO `menu` VALUES ('143', '140', '模型管理', 'modelManager', '1', 'md-list-box', 'modelManager', 'contentManager/contentRelevant/modelManager', '3', '1', '1', '2', '1600161464', '1604047752');
INSERT INTO `menu` VALUES ('144', '0', '系统设置', 'systemSeeting', '2', 'ios-settings', 'systemSeeting', 'systemSeeting', '1', '2', '1', '2', '1600161556', '1605942347');
INSERT INTO `menu` VALUES ('145', '144', '系统设置', 'systemSeeting', '2', 'md-cog', 'systemSeeting', 'systemSeeting/systemSeeting', '2', '1', '1', '2', '1600161653', '1604047752');
INSERT INTO `menu` VALUES ('146', '145', '站点配置', 'webConfig', '1', 'md-cog', 'webConfig', 'systemSeeting/systemSeeting/webConfig', '3', '1', '1', '2', '1600161677', '1604048828');
INSERT INTO `menu` VALUES ('147', '145', '后台菜单配置', 'adminMenuConfig', '1', 'ios-link-outline', 'adminMenuConfig', 'systemSeeting/systemSeeting/adminMenuConfig', '3', '2', '1', '2', '1600161698', '1604048829');
INSERT INTO `menu` VALUES ('148', '144', '管理员设置', 'adminSetting', '2', 'md-contact', 'adminSetting', 'systemSeeting/adminSetting', '2', '1', '1', '2', '1600161757', '1604047752');
INSERT INTO `menu` VALUES ('149', '148', '角色管理', 'roleManager', '1', 'ios-contacts', 'roleManager', 'systemSeeting/adminSetting/roleManager', '3', '1', '1', '2', '1600161777', '1604047752');
INSERT INTO `menu` VALUES ('150', '148', '管理员管理', 'adminManager', '1', 'logo-android', 'adminManager', 'systemSeeting/adminSetting/adminManager', '3', '2', '1', '2', '1600161795', '1604047752');
INSERT INTO `menu` VALUES ('151', '144', '日志管理', 'adminLoginLogs', '2', 'logo-dropbox', 'adminLoginLogs', 'systemSeeting/adminLoginLogs', '2', '1', '1', '2', '1600161831', '1604047752');
INSERT INTO `menu` VALUES ('152', '151', '后台登录日志', 'adminLoginLogs', '1', 'logo-dropbox', 'adminLoginLogs', 'systemSeeting/adminLoginLogs/adminLoginLogs', '3', '3', '1', '2', '1600161851', '1604047752');
INSERT INTO `menu` VALUES ('153', '151', '后台操作日志', 'adminOperationLogs', '1', 'logo-dropbox', 'adminOperationLogs', 'systemSeeting/adminLoginLogs/adminOperationLogs', '3', '3', '1', '2', '1600161872', '1604047752');
INSERT INTO `menu` VALUES ('154', '0', '界面', 'themeManager', '2', 'ios-color-palette', 'themeManager', 'themeManager', '1', '4', '1', '2', '1600161899', '1605942790');
INSERT INTO `menu` VALUES ('155', '154', '模板管理', 'themeManger', '2', 'md-compass', 'themeManger', 'themeManager/themeManger', '2', '4', '1', '2', '1600161919', '1604047752');
INSERT INTO `menu` VALUES ('156', '155', '主题设置', 'themeManager', '1', 'md-compass', 'themeManager', 'themeManager/themeManger/themeManager', '3', '2', '1', '2', '1600161936', '1604047752');
INSERT INTO `menu` VALUES ('176', '137', '通知管理', 'notice', '2', 'ios-notifications', 'notice', 'contentManager/notice', '2', '1', '1', '2', '1603781227', '1604047752');
INSERT INTO `menu` VALUES ('177', '176', '通知管理', 'notice', '1', 'ios-notifications-outline', 'notice', 'contentManager/notice/notice', '3', '4', '1', '1', '1603781263', '1604047752');
INSERT INTO `menu` VALUES ('212', '0', '测试菜单', 'test', '2', 'ios-add-circle', 'test', 'test', '1', '1', '1', '2', '1606468385', '1606468385');
INSERT INTO `menu` VALUES ('213', '212', '测试二级菜单', 'test2-1', '2', 'ios-add-circle', 'test2-1', 'test/test2-1', '2', '2', '1', '2', '1606468401', '1606540005');

-- ----------------------------
-- Table structure for modules
-- ----------------------------
DROP TABLE IF EXISTS `modules`;
CREATE TABLE `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1系统模块，2第三方模块',
  `version` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `desc` varchar(300) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '1启用，2禁用',
  `created_at` int(10) DEFAULT NULL,
  `updated_at` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of modules
-- ----------------------------
INSERT INTO `modules` VALUES ('1', '公共模块', 'test', '2', '0.0.1', 'xiaoming', '测试第三方插件', '1', '1605928110', '1605928110');

-- ----------------------------
-- Table structure for notice
-- ----------------------------
DROP TABLE IF EXISTS `notice`;
CREATE TABLE `notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `author` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `desc` varchar(200) NOT NULL,
  `content` longtext NOT NULL,
  `type` int(10) NOT NULL DEFAULT '1' COMMENT '1全部用户，2指定角色，3指定用户',
  `topping` tinyint(2) NOT NULL DEFAULT '2' COMMENT '1置顶，2不置顶',
  `created_at` int(10) DEFAULT NULL,
  `updated_at` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `author` (`author`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=51 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of notice
-- ----------------------------
INSERT INTO `notice` VALUES ('46', '1', '高考议论文要怎么写的让老师眼前一亮？', '中国共产党第十九', '<p>中国共产党第十九届中央委员会第五次全体会议公报发布。全会称，“十三五”时期，全面深化改革取得重大突破，全面依法治国取得重大进展，全面从严治党取得重大成果，国家治理体系和治理能力现代化加快推进，中国共产党领导和我国社会主义制度优势进一步彰显；经济实力、科技实力、综合国力跃上新的大台阶，经济运行总体平稳，经济结构持续优化，预计二〇二〇年国内生产总值突破一百万亿元。中国共产党第十九届中央委员会第五次全体会议公报发布。全会称，“十三五”时期，全面深化改革取得重大突破，全面依法治国取得重大进展，全面从严治党取得重大成果，国家治理体系和治理能力现代化加快推进，中国共产党领导和我国社会主义制度优势进一步彰显；经济实力、科技实力、综合国力跃上新的大台阶，经济运行总体平稳，经济结构持续优化，预计二〇二〇年国内生产总值突破一百万亿元。中国共产党第十九届中央委员会第五次全体会议公报发布。全会称，“十三五”时期，全面深化改革取得重大突破，全面依法治国取得重大进展，全面从严治党取得重大成果，国家治理体系和治理能力现代化加快推进，中国共产党领导和我国社会主义制度优势进一步彰显；经济实力、科技实力、综合国力跃上新的大台阶，经济运行总体平稳，经济结构持续优化，预计二〇二〇年国内生产总值突破一百万亿元。中国共产党第十九届中央委员会第五次全体会议公报发布。全会称，“十三五”时期，全面深化改革取得重大突破，全面依法治国取得重大进展，全面从严治党取得重大成果，国家治理体系和治理能力现代化加快推进，中国共产党领导和我国社会主义制度优势进一步彰显；经济实力、科技实力、综合国力跃上新的大台阶，经济运行总体平稳，经济结构持续优化，预计二〇二〇年国内生产总值突破一百万亿元。中国共产党第十九届中央委员会第五次全体会议公报发布。全会称，“十三五”时期，全面深化改革取得重大突破，全面依法治国取得重大进展，全面从严治党取得重大成果，国家治理体系和治理能力现代化加快推进，中国共产党领导和我国社会主义制度优势进一步彰显；经济实力、科技实力、综合国力跃上新的大台阶，经济运行总体平稳，经济结构持续优化，预计二〇二〇年国内生产总值突破一百万亿元。中国共产党第十九届中央委员会第五次全体会议公报发布。全会称，“十三五”时期，全面深化改革取得重大突破，全面依法治国取得重大进展，全面从严治党取得重大成果，国家治理体系和治理能力现代化加快推进，中国共产党领导和我国社会主义制度优势进一步彰显；经济实力、科技实力、综合国力跃上新的大台阶，经济运行总体平稳，经济结构持续优化，预计二〇二〇年国内生产总值突破一百万亿元。<br></p>', '2', '1', '1604023524', '1604108308');
INSERT INTO `notice` VALUES ('49', '1', '五家快递公司出现“无人派送”：低价战反噬快递业', '“无人派送”：低价战反噬快递业本刊记者/赵一苇发于2020.11.2总第970期《中国新闻周刊》10月18日，针对正在发酵的通达系快递公司全国多个城市网点停工罢工传闻，圆通、中通、申通、百世等公司相继回应称，罢工传闻...', '<p>“无人派送”：低价战反噬快递业</p><p>本刊记者/赵一苇</p><p>发于2020.11.2总第970期《中国新闻周刊》</p><p>10月18日，针对正在发酵的通达系快递公司全国多个城市网点停工罢工传闻，圆通、中通、申通、百世等公司相继回应称，罢工传闻为不实消息，目前快递网络运营正常。但多方否认后，关于快递网点欠薪罢工的讨论依然热烈。微博数据显示，最近一个月有关快递罢工的讨论已超过1万次，涉及通达系公司的全国多个网点。</p><p>多位通达系基层网点员工向《中国新闻周刊》提供的异常网点统计名单显示，圆通、申通、中通、百世汇通、韵达五家快递公司在最近一个月内异常网点仍在增多，这些网点涉及湖南、四川、江苏、上海等多个省市，运营情况多标注为“网点异常”“快件积压严重”“无人派送”等。有员工透露，异常网点大多因拖欠工资导致快递员罢工，网点停摆，影响包裹投递，许多网点的欠薪问题至今未解决。</p><p>这只是通达系快递所面临问题的冰山一角。自2019年5月打响行业价格战后，通达系基层网点和基层快递员的收入已经被挤压至生存红线，派送网络不稳定性正在加剧。“以价换量的价格战如果不是基于生态平衡下的博弈，换来的可能是竞争泥石流。”中国物流与采购联合会研究室副主任、电商物流专家杨达卿告诉《中国新闻周刊》，“当价格竞争策略变成所有企业拼市场的常规武器，它带来的是破坏性竞争，而不是建设性竞争，最终末端网点将因恶性竞争而无利可图。这是生态破坏带来的结果”。</p><p>快递员讨薪难</p><p>报警之后，苏州市姑苏区韵达快递九鼎友新服务部来了新的负责人，并实行工资日结的特殊管理办法。表面上看，服务部已恢复了正常运作，备战“双十一”，但事实上，该服务部自8月起已陆续拖欠员工十余万元工资，服务部原负责人杳无音讯，总部又不承担网点的债务，报警无果的员工不知去哪里追讨被拖欠的工资。眼看“双十一”旺季来临，只能继续在网点干一天赚一天的钱。</p><p>“我们联系不上服务部老板，只能联系总部，但总部回复永远是‘会协调’，欠的钱至今也不知道找谁要。”被拖欠了两个月工资的快递员王立华告诉《中国新闻周刊》，“现在‘双十一’来了，总部的解决方案是先派人来接管，把网点运作起来，继续干的员工实行工资日结。但之前老板拖欠的工资一直没有结果”。</p><p>从今年3月开始，通达系快递公司多地加盟网点异常情况增多，原因主要有两方面：一是上级网点降低或拖欠派件费，下级网点发起停业以示抗议；二是网点经营不善，资金紧张，网点降低或拖欠快递员工资，导致员工集中罢工或离职，网点难以正常运营。</p><p>无论哪种原因造成的停业，最终承担后果的都是位于最末端的基层网点和快递员。在通达系加盟制快递网络中，总部掌握定价权和管理权，一级代理网点掌握辖内网点的分包权和罚款权，以每单1～1.2元的价格向下分发派件。二级及以下加盟商依靠收发快递的基础业务，派件每单赚取0.1～0.3元的利润，最末端的派送员赚取每单0.7～0.9元的派送费。</p><p>业内日益惨烈的价格战进一步挤压了二级加盟商和快递员的生存空间。2019年5月，以顺丰率先降价掀起的第一轮行业价格战拉开序幕，通达系纷纷下调快递单票价。而今年2月以来，由于全国公路免收、叠加油价下跌，快递公司成本进一步下降，为了争夺市场，业内又掀起了一轮更为激烈的价格战。</p><p>然而，快递业的低价竞争并不是多方共同买单。收获市场份额增长的资方获取了急剧增长的利润，却将损失层层转嫁到了基层代理商和快递员身上。调查显示，加盟式快递企业中，40％加盟商是亏损，50％加盟商盈亏持平，只有10％赚钱。这相当于90％的快递加盟商是不赚钱的。</p><p>“通达系快递的二级加盟商赚得最少也最难，尤其是去年以来的几次压价之后，全国二级商几乎都在亏损线徘徊。”圆通快递二级加盟商于磊告诉《中国新闻周刊》，二级加盟商不仅需要向一级交承包费和押金，还要承担一级分发下来的各种考核任务，收发件任务不达标会被罚款。同时，二级加盟商还需要自己承担门店租金、员工成本，“除非是学校或人口密集的社区，大多数二级加盟商很难赚钱”。</p><p>承担考核与成本压力、仅赚取微薄差价的二级代理商几乎没有抗风险能力，一旦上级网点经营不善或拖欠款项，二级代理网点就会立即陷入困境。近日，湖南长沙韵达快递观沙岭服务站就因为经营不善，与二级代理点无法结清账目，导致二级商停业，拖欠投递员工资，不少快递员从4月份至今只拿到5000元工资。</p><p>另一方面，直接受雇于基层网点的快递员没有劳动合同和社保，一旦发生纠纷，快递员几乎连维权证据都拿不出来。在快递行业从业近8年的王立华告诉《中国新闻周刊》，通达系快递员几乎都不签劳动合同，没有社保，薪资待遇完全由受雇网点老板口头承诺。发生纠纷后，即使快递员把网点加盟商告到劳动局，也很难有明确的下文。</p><p>“就算闹到罢工，钱也不一定能要回来。只能等换个老板或网点，继续干下去。”王立华说，“此前为了讨薪，快递员们在网点门口拉横幅、闹罢工，不仅没用还影响治安。我们只能等新老板来接管了接着干，以前的欠款不知道是不是就不了了之了”。</p><p>总部和加盟商互相推责</p><p>10月12日，韵达快递针对长沙观沙岭服务站拖欠工资的问题回应称，该网点的问题属于一级加盟商和二级加盟商之间的矛盾，是经营问题，并表示被拖欠工资的快递员薪资应由所在加盟商负责，公司正在督促协调。</p><p>“这种情况经常出现，一旦发生纠纷，总部就会把责任全部推给代理和加盟商，而不提自己在管理上的问题。”韵达快递湖南某二级加盟商马建军告诉《中国新闻周刊》，“总部对一级代理监管不到位，如果一级代理出问题，这个一级站点下辖的所有二级加盟商都会受影响”。</p><p>以通达系为代表的加盟制快递公司有相似的架构和运行机制。由总部负责建立转运中心进行大站中转和分拣，制定代理和加盟运行规则，提供品牌、快递单和结算系统。末端的派送通常由一级加盟商和他们发展的二级加盟商完成。因此，末端配送的时效和服务质量往往与该地区的加盟商经营情况直接相关。</p><p>“加盟制的最大弊端在于加盟商素质参差不齐，只要有钱就能干。”马建军直言，“有的一级代理商运作不规范，可能用罚款或拖欠的手段压榨二级。二级加盟商态度恶劣或服务不好，也可能损害整个片区的口碑和大客户生意”。</p><p>中国快递物流行业高级专家、中国快递协会原副秘书长邵钟林认为，加盟体系导致此类事情发生不可避免，主要原因是总部和加盟商的利益不一致。中通、韵达、圆通等都采取类似的加盟体系。</p><p>自2019年5月开始燃烧的价格战火仍在行业内蔓延，进一步加深了加盟制快递公司总部、代理、加盟商的三方矛盾。</p><p>根据申万宏源的统计数据，今年8月份快递行业平均单票收入为10.05元，再创历史新低，跌幅持续扩大。同时，各快递公司的财报数据显示，今年9月份，韵达快递的单票收入为2.15元、圆通和申通均为2.18元，分别同比减少31％，23％，20％。</p><p>各快递公司财报披露的单票收入构成显示，假如消费者付出10元快递费，其中3元归网点收件方，城市内分拨费0.6元，分拨中心0.3元，快递公司总部收取1元的面单费、2元的中转费、1.5元的派件费，最后到代理加盟商和快递员手上的派送费仅1.6元。</p><p>多位通达系快递员告诉《中国新闻周刊》，今年以来，一级代理给二级加盟商的派件费从1.5元普降至1.2元，二级加盟商给雇佣快递员的派费从1元多普降至0.7元。总部降价后，给一级代理、二级加盟商、快递员的压力是逐层递增的。</p><p>“快递派费一降再降，去年降到9毛，今年降到了7毛，浙江广东地区甚至降到了5毛。”在王立华身边，已经有很多同行转行去送派费更高的外卖了，“底层快递员每天送几百个快递，累死累活，收入却一天不如一天”。</p><p>由于源头的收件价降低后，面单收入、中转费、运输费用基本固定，最终会使派件费也相应减少。一般情况下，快递加盟网点的收入包含收件和派件两个方面，而不断压低的单票价格正在同时挤压加盟商两方面的生存空间。</p><p>一位韵达快递员向《中国新闻周刊》透露，部分一级代理和二级加盟商依靠向下罚款来增加利润，罚款条目达几十条，每次罚款100元起。“不及时到岗要罚款、不及时开会要罚款、包裹破损要罚款、客户投诉要罚款等等，几个罚款下来，一个礼拜就白干了，这也是很多快递员离职的原因”。</p><p>“从品牌和上市公司的责任来看，快递企业总部应该对有波动的网点无条件兜底。不论总部和网点之间怎么谈判，基层快递员都不应该受到损失。”快递物流专家赵小敏向《中国新闻周刊》表示，“快递企业需要考虑总部和加盟商双方的原因。总部网络管控能力不足，地方经营情况一旦出现问题，孤立的小网点很容易倒闭。最重要的是，收件、派件、等核心环节都由加盟商完成，加盟商在外就代表总公司。总部直接甩锅加盟商是非常不负责任的做法。”</p><p>价格战或将失灵</p><p>10月18日，中国2020年的第600亿件快件诞生。国家邮政局监测数据显示，2020年9月快递业务量完成80.9亿件，增速创三年来新高。但快递数量的增长并不意味着同等规模的收入增长，快速的市场扩张导致内部价格竞争不断加剧。国家统计局数据显示，中国每年的快递量和快递业务收入虽然都在攀升，但每单快递的快递单价还不到十年前的一半。</p><p>以价换市是快递业内最简单直接的竞争策略。在电商增速放缓的大背景下，快递企业之间的竞争趋于同质化，从而依靠不断压低价格来争夺市场。</p><p>上市快递企业发布的2020上半年财报显示，六家物流企业快递业务的单票价格均下滑超过20％，其中顺丰单票价格下滑22.18％，中通下滑21.86％，韵达下滑28.48％，圆通下滑25.23％，申通下滑21.34％。在最激烈的3月到6月，有快递公司甚至在义乌打出了“8毛发全国”的市场最低价，以迅速抢夺市场份额。</p><p>压价竞争的直接后果，是公司净利润不断下滑。市场占有率排名第二的韵达快递财报数据显示，2019年上半年共完成快递业务量43.34亿票，净利润12.96亿元。而在今年上半年共完成快递业务量达56.29亿票，净利润仅为6.81亿元。短短一年，韵达的快递业务量增加了10多亿票，但是单票的利润却从0.30元下跌到0.12元。</p><p>业内已逼近利润红线，但继续打价格战仍然是通达系公司的策略共识。9月，中通快递在港二次上市，在招股书中明确表示，为了保持具有竞争力的定价并提高利润率，必须不断控制成本。“我们过往的派送服务市场价格有所下降，未来可能会继续面临定价下降的压力。”</p><p>“眼下快递业的价格战已经到了敌我不分的程度。杀敌一千自损九百。”赵小敏表示，过去十几年间，快递企业的迅速崛起是建立在廉价劳动力、大众强烈的购买力和经济快速发展上的，第一轮依靠体力劳动和原始资本的初级竞争早已结束。如今已经进入第二轮竞争，冷链、供应链、乡村振兴、国际化等需要高额投资和链条建设。“遗憾的是，如今依靠价格战来争夺市场依然是最简单的方法，企业并不主动寻求更高级别的竞争”。</p><p>在通达系之外，新入局者给价格战又添了一把火。今年才在国内起网的极兔速递、京东众邮、顺丰丰网三家新兴公司以低价入局，尤其极兔速递依靠超低单价、蹭网等手段，短短半年就拥有了传统快递公司十年的业务量。“双十一”在即，这三家快递更一再突破底价进行竞争，行业价格战的漩涡被再度扩大。</p><p>10月19日，韵达在官网全面公开全国禁止代理极兔业务通知书。此前，申通与圆通速递也在总部方面明确表示禁止代理极兔。这意味着，通达系公司有意全面围剿极兔速递。</p><p>“价格战是企业惯用的竞争策略，它不会停止。”杨达卿认为，价格战要回归合理区间，有两个决定性因素，第一个因素在于新零售市场格局能否实现相对稳定。电商快递市场稳定的决定性因素在需求方，快递是仰仗电商巨头决定进退的。一旦头部电商形成鼎立局面，就会与快递企业在服务上深度捆绑，支持价值竞争，而不是价格竞争。第二个因素在于快递头部企业是否建立大幅度领先优势，如果中国快递头部企业仍在市场占有率等方面保持均势竞争，价格战就不会回归理性区间。</p><p>快递物流专家赵小敏预计，未来8～10个月，行业价格战将迎来临界点。“现在正是矛盾集中爆发的时段。”赵小敏表示，当无论价格多低，业务量增速都低于三成时，价格战策略就面临失灵了。与此同时，价格战带来的网点连续波动、人员流失、现金流紧张也会让企业不堪重负，拉低企业乃至整个行业的服务质量。“在价格战结束之前，类似快递网点罢工、跑路等情况还将继续发生”。</p><p>（因受访者要求，文中于磊、王立华为化名）</p>', '3', '1', '1604028935', '1606037548');
INSERT INTO `notice` VALUES ('50', '1', '1', '2', '<p>3</p>', '1', '2', '1606032990', '1606032990');

-- ----------------------------
-- Table structure for notice_user
-- ----------------------------
DROP TABLE IF EXISTS `notice_user`;
CREATE TABLE `notice_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `notice_id` int(11) NOT NULL,
  `status` tinyint(2) DEFAULT '1' COMMENT '1未读，2已读',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `notice_id` (`notice_id`) USING BTREE,
  CONSTRAINT `notice_user_ibfk_1` FOREIGN KEY (`notice_id`) REFERENCES `notice` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of notice_user
-- ----------------------------
INSERT INTO `notice_user` VALUES ('25', '3', '46', '2', '1604023524', '1606467653');
INSERT INTO `notice_user` VALUES ('26', '5', '46', '1', '1604023524', '1604023524');
INSERT INTO `notice_user` VALUES ('51', '5', '49', '1', '1604028935', '1604028935');
INSERT INTO `notice_user` VALUES ('52', '3', '49', '2', '1604028935', '1606467651');
INSERT INTO `notice_user` VALUES ('53', '1', '49', '2', '1604028935', '1604029067');
INSERT INTO `notice_user` VALUES ('54', '1', '50', '2', '1606032998', '1606032998');
INSERT INTO `notice_user` VALUES ('55', '1', '50', '2', '1606467648', '1606467648');
INSERT INTO `notice_user` VALUES ('56', '1', '50', '2', '1606711729', '1606711729');

-- ----------------------------
-- Table structure for page_permission
-- ----------------------------
DROP TABLE IF EXISTS `page_permission`;
CREATE TABLE `page_permission` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `menuId` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `identification` varchar(200) DEFAULT NULL COMMENT '//标识，用来控制前端按钮',
  `created_at` int(11) DEFAULT NULL,
  `updated_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menuId`) USING BTREE,
  CONSTRAINT `page_permission_ibfk_1` FOREIGN KEY (`menuId`) REFERENCES `menu` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_permission
-- ----------------------------
INSERT INTO `page_permission` VALUES ('238', '177', '发布通知', 'add_notice', '1606556864', '1606556864');
INSERT INTO `page_permission` VALUES ('239', '177', '置顶通知', 'top_notice', '1606556864', '1606556864');
INSERT INTO `page_permission` VALUES ('240', '177', '删除通知', 'del_notice', '1606556864', '1606556864');
INSERT INTO `page_permission` VALUES ('241', '177', '查看通知', 'view_notice', '1606556864', '1606556864');
INSERT INTO `page_permission` VALUES ('248', '147', '查看菜单', 'view_menu', '1606556921', '1606556921');
INSERT INTO `page_permission` VALUES ('249', '147', '查看权限组', 'view_permission', '1606556921', '1606556921');
INSERT INTO `page_permission` VALUES ('250', '147', '删除菜单', 'del_menu', '1606556921', '1606556921');
INSERT INTO `page_permission` VALUES ('251', '147', '菜单排序', 'sort_menu', '1606556921', '1606556921');
INSERT INTO `page_permission` VALUES ('252', '147', '添加菜单', 'add_menu', '1606556921', '1606556921');
INSERT INTO `page_permission` VALUES ('253', '147', '编辑菜单', 'edit_menu', '1606556921', '1606556921');
INSERT INTO `page_permission` VALUES ('258', '149', '新增角色', 'add_role', '1606639222', '1606639222');
INSERT INTO `page_permission` VALUES ('259', '149', '查看角色', 'view_role', '1606639222', '1606639222');
INSERT INTO `page_permission` VALUES ('260', '149', '删除角色', 'del_role', '1606639222', '1606639222');
INSERT INTO `page_permission` VALUES ('261', '149', '设置整站权限', 'add_role_permis', '1606639222', '1606639222');
INSERT INTO `page_permission` VALUES ('277', '150', '添加管理员', 'add_manager', '1606703476', '1606703476');
INSERT INTO `page_permission` VALUES ('278', '150', '查看管理员', 'view_manager', '1606703476', '1606703476');
INSERT INTO `page_permission` VALUES ('279', '150', '编辑管理员', 'edit_manager', '1606703476', '1606703476');
INSERT INTO `page_permission` VALUES ('280', '150', '设置管理员角色', 'change_manager_role', '1606703476', '1606703476');
INSERT INTO `page_permission` VALUES ('281', '152', '查看日志', 'view_login_log', '1606711633', '1606711633');

-- ----------------------------
-- Table structure for page_permission_item
-- ----------------------------
DROP TABLE IF EXISTS `page_permission_item`;
CREATE TABLE `page_permission_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_permission_id` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menuId` (`page_permission_id`),
  CONSTRAINT `menuId` FOREIGN KEY (`page_permission_id`) REFERENCES `page_permission` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=412 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of page_permission_item
-- ----------------------------
INSERT INTO `page_permission_item` VALUES ('358', '238', 'system/role/get-role-list');
INSERT INTO `page_permission_item` VALUES ('359', '238', 'system/manager/get-manager-list');
INSERT INTO `page_permission_item` VALUES ('360', '238', 'content/notice/add-notice');
INSERT INTO `page_permission_item` VALUES ('361', '239', 'content/add/topping-notice');
INSERT INTO `page_permission_item` VALUES ('362', '239', 'content/add/topping-notice');
INSERT INTO `page_permission_item` VALUES ('363', '239', 'content/add/topping-notice');
INSERT INTO `page_permission_item` VALUES ('364', '240', 'content/add/del-notice');
INSERT INTO `page_permission_item` VALUES ('365', '240', 'content/add/del-notice');
INSERT INTO `page_permission_item` VALUES ('366', '240', 'content/add/del-notice');
INSERT INTO `page_permission_item` VALUES ('367', '241', 'content/notice/get-admin-notice-list');
INSERT INTO `page_permission_item` VALUES ('375', '248', 'system/menu/list');
INSERT INTO `page_permission_item` VALUES ('376', '249', 'system/menu/get-page-permission-list');
INSERT INTO `page_permission_item` VALUES ('377', '250', 'system/menu/delete-menu');
INSERT INTO `page_permission_item` VALUES ('378', '251', 'system/menu/sort-menu');
INSERT INTO `page_permission_item` VALUES ('379', '252', 'system/menu/add-or-edit');
INSERT INTO `page_permission_item` VALUES ('380', '253', 'system/menu/add-or-edit');
INSERT INTO `page_permission_item` VALUES ('381', '253', 'system/menu/get-only-menu');
INSERT INTO `page_permission_item` VALUES ('387', '258', 'system/role/add-role');
INSERT INTO `page_permission_item` VALUES ('388', '259', 'system/role/get-role-info');
INSERT INTO `page_permission_item` VALUES ('389', '259', 'system/role/get-role-list');
INSERT INTO `page_permission_item` VALUES ('390', '260', 'system/role/delete-role');
INSERT INTO `page_permission_item` VALUES ('391', '261', 'system/role/add-role-permission');
INSERT INTO `page_permission_item` VALUES ('407', '277', 'system/manager/add-manager');
INSERT INTO `page_permission_item` VALUES ('408', '278', 'system/manager/get-manager-list');
INSERT INTO `page_permission_item` VALUES ('409', '279', 'system/manager/edit-manager');
INSERT INTO `page_permission_item` VALUES ('410', '280', 'system/manager/change-manager-role');
INSERT INTO `page_permission_item` VALUES ('411', '281', 'system/login-log/list');

-- ----------------------------
-- Table structure for quick_operation
-- ----------------------------
DROP TABLE IF EXISTS `quick_operation`;
CREATE TABLE `quick_operation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `updated_at` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=76 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of quick_operation
-- ----------------------------
INSERT INTO `quick_operation` VALUES ('66', '1', '146', '1603788400', '1603788400');
INSERT INTO `quick_operation` VALUES ('52', '3', '149', '1603695163', '1603695163');
INSERT INTO `quick_operation` VALUES ('53', '3', '147', '1603695163', '1603695163');
INSERT INTO `quick_operation` VALUES ('54', '3', '146', '1603695163', '1603695163');
INSERT INTO `quick_operation` VALUES ('67', '1', '147', '1603788400', '1603788400');
INSERT INTO `quick_operation` VALUES ('68', '1', '149', '1603788400', '1603788400');
INSERT INTO `quick_operation` VALUES ('69', '1', '150', '1603788400', '1603788400');
INSERT INTO `quick_operation` VALUES ('70', '1', '152', '1603788400', '1603788400');
INSERT INTO `quick_operation` VALUES ('71', '1', '153', '1603788400', '1603788400');
INSERT INTO `quick_operation` VALUES ('72', '1', '142', '1603788400', '1603788400');
INSERT INTO `quick_operation` VALUES ('73', '1', '143', '1603788400', '1603788400');
INSERT INTO `quick_operation` VALUES ('74', '1', '139', '1603788400', '1603788400');
INSERT INTO `quick_operation` VALUES ('75', '8', '177', '1606641813', '1606641813');

-- ----------------------------
-- Table structure for role
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `type` tinyint(2) DEFAULT '2' COMMENT '1超级管理员2其它管理角色',
  `mark` varchar(255) DEFAULT NULL,
  `status` tinyint(2) NOT NULL DEFAULT '1' COMMENT '1启用2禁用',
  `created_at` int(10) DEFAULT NULL,
  `updated_at` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', '超级管理员', '1', '超级管理员描述', '1', '1600754204', '1600828113');
INSERT INTO `role` VALUES ('4', '菜单管理员', '2', '菜单管理员', '1', '1600754204', '1606639649');
INSERT INTO `role` VALUES ('5', '管理员管理', '2', '管理员管理', '1', '1606551367', '1606642158');

-- ----------------------------
-- Table structure for role_menu_item
-- ----------------------------
DROP TABLE IF EXISTS `role_menu_item`;
CREATE TABLE `role_menu_item` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NOT NULL,
  `menu_id` int(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `menu_id` (`menu_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=327 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role_menu_item
-- ----------------------------
INSERT INTO `role_menu_item` VALUES ('306', '4', '150');
INSERT INTO `role_menu_item` VALUES ('305', '4', '148');
INSERT INTO `role_menu_item` VALUES ('326', '5', '150');
INSERT INTO `role_menu_item` VALUES ('304', '4', '147');
INSERT INTO `role_menu_item` VALUES ('303', '4', '145');
INSERT INTO `role_menu_item` VALUES ('302', '4', '144');
INSERT INTO `role_menu_item` VALUES ('325', '5', '149');
INSERT INTO `role_menu_item` VALUES ('324', '5', '148');
INSERT INTO `role_menu_item` VALUES ('323', '5', '144');

-- ----------------------------
-- Table structure for role_permission_item
-- ----------------------------
DROP TABLE IF EXISTS `role_permission_item`;
CREATE TABLE `role_permission_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `page_permission_id` (`page_permission_id`),
  CONSTRAINT `page_permission_id` FOREIGN KEY (`page_permission_id`) REFERENCES `page_permission` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=373 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of role_permission_item
-- ----------------------------
INSERT INTO `role_permission_item` VALUES ('326', '248', '4');
INSERT INTO `role_permission_item` VALUES ('327', '249', '4');
INSERT INTO `role_permission_item` VALUES ('328', '250', '4');
INSERT INTO `role_permission_item` VALUES ('329', '251', '4');
INSERT INTO `role_permission_item` VALUES ('330', '252', '4');
INSERT INTO `role_permission_item` VALUES ('331', '253', '4');
INSERT INTO `role_permission_item` VALUES ('365', '258', '5');
INSERT INTO `role_permission_item` VALUES ('366', '259', '5');
INSERT INTO `role_permission_item` VALUES ('367', '260', '5');
INSERT INTO `role_permission_item` VALUES ('368', '261', '5');
INSERT INTO `role_permission_item` VALUES ('369', '277', '5');
INSERT INTO `role_permission_item` VALUES ('370', '278', '5');
INSERT INTO `role_permission_item` VALUES ('371', '279', '5');
INSERT INTO `role_permission_item` VALUES ('372', '280', '5');

-- ----------------------------
-- Table structure for todo
-- ----------------------------
DROP TABLE IF EXISTS `todo`;
CREATE TABLE `todo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(20) NOT NULL,
  `desc` longtext NOT NULL,
  `start` int(10) NOT NULL,
  `end` int(10) NOT NULL,
  `status` tinyint(2) DEFAULT '2' COMMENT '1未开始，2进行中，3已完成，4已过期',
  `created_at` int(10) DEFAULT NULL,
  `updated_at` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of todo
-- ----------------------------
INSERT INTO `todo` VALUES ('32', '1', '联系邱总', '联系邱总，询问三个柜子是否需要', '1605888000', '1605888000', '3', '1605928110', '1606711690');
INSERT INTO `todo` VALUES ('30', '1', '联系大单买家送橙子', '联系大单买家送橙子', '1605888000', '1605974400', '3', '1605416818', '1606711698');
INSERT INTO `todo` VALUES ('33', '1', '问发货时间', '问发货时间', '1606320000', '1606406399', '3', '1606381702', '1606711683');
INSERT INTO `todo` VALUES ('34', '3', '测试管理员', '测试管理员', '1606406400', '1606579199', '2', '1606467874', '1606467892');
INSERT INTO `todo` VALUES ('35', '1', '发新中式茶桌', '发新中式茶桌', '1606492800', '1606751999', '3', '1606529896', '1606711665');
