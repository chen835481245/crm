/*
Navicat MySQL Data Transfer

Source Server         : 开发服务器
Source Server Version : 50537
Source Host           : 121.40.85.212:3306
Source Database       : crmnew

Target Server Type    : MYSQL
Target Server Version : 50537
File Encoding         : 65001

Date: 2016-11-03 09:10:32
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_dept
-- ----------------------------
DROP TABLE IF EXISTS `admin_dept`;
CREATE TABLE `admin_dept` (
  `deptid` varchar(20) NOT NULL,
  `dept_name` varchar(20) NOT NULL DEFAULT '',
  `remark` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`deptid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_dept
-- ----------------------------
INSERT INTO `admin_dept` VALUES ('001', '总部', '总部备注');

-- ----------------------------
-- Table structure for admin_resource
-- ----------------------------
DROP TABLE IF EXISTS `admin_resource`;
CREATE TABLE `admin_resource` (
  `rid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rescode` varchar(20) NOT NULL DEFAULT '',
  `resindex` tinyint(4) NOT NULL DEFAULT '0',
  `resurl` varchar(100) DEFAULT '',
  `name` varchar(32) NOT NULL,
  `isvalid` tinyint(4) unsigned DEFAULT '1',
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_resource
-- ----------------------------
INSERT INTO `admin_resource` VALUES ('1', '001', '100', '', '系统权限管理', '1');
INSERT INTO `admin_resource` VALUES ('2', '001001', '1', 'userController/userListAc', '操作员管理', '1');
INSERT INTO `admin_resource` VALUES ('3', '001002', '5', 'userController/deptListAc', '部门管理', '1');
INSERT INTO `admin_resource` VALUES ('4', '001003', '10', 'userController/roleListAc', '角色管理', '1');
INSERT INTO `admin_resource` VALUES ('5', '001004', '15', 'userController/sourceListAc', '资源管理', '1');
INSERT INTO `admin_resource` VALUES ('64', '006001', '5', 'gwclientController/clientListAc', '国外客户管理', '1');
INSERT INTO `admin_resource` VALUES ('65', '006002', '0', 'gwclientController/addClientAc', '新增客户资料', '1');
INSERT INTO `admin_resource` VALUES ('60', '005', '5', '', '国内客户管理', '1');
INSERT INTO `admin_resource` VALUES ('61', '005001', '0', 'gnclientController/addClientAc', '增加客户资料', '1');
INSERT INTO `admin_resource` VALUES ('62', '005002', '5', 'gnclientController/clientListAc', '国内客户管理', '1');
INSERT INTO `admin_resource` VALUES ('63', '006', '10', '', '国外客户管理', '1');
INSERT INTO `admin_resource` VALUES ('56', '004', '0', '', '基础管理', '1');
INSERT INTO `admin_resource` VALUES ('57', '004001', '0', 'baseController/sourceListAc', '客户来源', '1');
INSERT INTO `admin_resource` VALUES ('58', '004002', '5', 'baseController/typeListAc', '客户类型', '1');
INSERT INTO `admin_resource` VALUES ('87', '011001', '0', 'statController/getDataStatAc', '数据汇总', '1');
INSERT INTO `admin_resource` VALUES ('86', '011', '22', '', '数据统计', '1');
INSERT INTO `admin_resource` VALUES ('66', '005003', '15', 'gnclientController/clientPubListAc', '公共客户管理', '1');
INSERT INTO `admin_resource` VALUES ('67', '006003', '15', 'gwclientController/clientPubListAc', '公共客户管理', '1');
INSERT INTO `admin_resource` VALUES ('68', '007', '15', '', '客户记录', '1');
INSERT INTO `admin_resource` VALUES ('69', '007001', '0', 'recordController/dynamicAddAc', '增加客户日常动态', '1');
INSERT INTO `admin_resource` VALUES ('70', '007002', '5', 'recordController/dynamicListAc', '查看客户日常动态', '1');
INSERT INTO `admin_resource` VALUES ('71', '007003', '10', 'recordController/marketAddAc', '增加客户营销动态', '1');
INSERT INTO `admin_resource` VALUES ('72', '007004', '20', 'recordController/marketListAc', '查看客户营销动态', '1');
INSERT INTO `admin_resource` VALUES ('73', '008', '20', '', '邮件营销', '1');
INSERT INTO `admin_resource` VALUES ('74', '008001', '0', 'emailController/addClientAc', '新增邮件联系人', '1');
INSERT INTO `admin_resource` VALUES ('75', '008002', '5', 'emailController/addBlackListAc', '黑名单客户', '1');
INSERT INTO `admin_resource` VALUES ('76', '008003', '10', 'emailController/clientListAc', '管理邮件联系人', '1');
INSERT INTO `admin_resource` VALUES ('77', '009', '25', 'pwdController/addTypeListAc', '密码管理', '1');
INSERT INTO `admin_resource` VALUES ('78', '009001', '0', 'pwdController/addTypeListAc', '密码类型', '1');
INSERT INTO `admin_resource` VALUES ('79', '009002', '5', 'pwdController/addPwdAc', '创建我的新密码', '1');
INSERT INTO `admin_resource` VALUES ('80', '009003', '10', 'pwdController/pwdListAc', '查看我的密码', '1');
INSERT INTO `admin_resource` VALUES ('82', '010', '17', '', '客户维护', '1');
INSERT INTO `admin_resource` VALUES ('83', '010001', '5', 'weihuclientController/client30Ac', '30天未联系客户', '1');
INSERT INTO `admin_resource` VALUES ('84', '010002', '10', 'weihuclientController/client60Ac', '60天未联系客户', '1');
INSERT INTO `admin_resource` VALUES ('85', '010003', '15', 'weihuclientController/client90Ac', '90天未联系客户', '1');
INSERT INTO `admin_resource` VALUES ('88', '001005', '3', 'userController/clientChangeAc', '客户移交', '1');
INSERT INTO `admin_resource` VALUES ('89', '007005', '30', 'recordController/checkingAc', '客户检查', '1');
INSERT INTO `admin_resource` VALUES ('90', '007006', '35', 'recordController/customerAc', '动态查询', '1');

-- ----------------------------
-- Table structure for admin_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `roleid` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(20) NOT NULL DEFAULT '',
  `level` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `remark` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`roleid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_role
-- ----------------------------
INSERT INTO `admin_role` VALUES ('1', '系统管理员', '4', '最高级别');
INSERT INTO `admin_role` VALUES ('7', '业务员', '1', '');
INSERT INTO `admin_role` VALUES ('8', '经理', '3', '');

-- ----------------------------
-- Table structure for admin_roleauth
-- ----------------------------
DROP TABLE IF EXISTS `admin_roleauth`;
CREATE TABLE `admin_roleauth` (
  `roleid` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `permission` varchar(255) NOT NULL DEFAULT '0000000000' COMMENT '查看、新增、修改、删除、导出',
  `remark` varchar(100) DEFAULT '',
  PRIMARY KEY (`roleid`,`rid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_roleauth
-- ----------------------------
INSERT INTO `admin_roleauth` VALUES ('5', '7', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('5', '6', '111111', '');
INSERT INTO `admin_roleauth` VALUES ('1', '5', '111111', '');
INSERT INTO `admin_roleauth` VALUES ('1', '4', '111111', '');
INSERT INTO `admin_roleauth` VALUES ('1', '3', '111111', '');
INSERT INTO `admin_roleauth` VALUES ('1', '2', '111111', '');
INSERT INTO `admin_roleauth` VALUES ('1', '1', '111111', '');
INSERT INTO `admin_roleauth` VALUES ('5', '8', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('5', '9', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('5', '1', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('5', '2', '100001', '');
INSERT INTO `admin_roleauth` VALUES ('3', '6', '111111', '');
INSERT INTO `admin_roleauth` VALUES ('3', '7', '111111', '');
INSERT INTO `admin_roleauth` VALUES ('3', '8', '111111', '');
INSERT INTO `admin_roleauth` VALUES ('3', '9', '111111', '');
INSERT INTO `admin_roleauth` VALUES ('6', '18', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('6', '19', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('6', '28', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('6', '20', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('6', '21', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('6', '22', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('6', '23', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('6', '25', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('6', '27', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '2', '100001', '');
INSERT INTO `admin_roleauth` VALUES ('7', '1', '100000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '80', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '79', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '78', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '77', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '76', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '75', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '74', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '73', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '85', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '84', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '83', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '82', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '72', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '71', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '70', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '69', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '68', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('7', '67', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '64', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '65', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '63', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '66', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '62', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '61', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '60', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '58', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('8', '56', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '57', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '58', '110100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '60', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '61', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '62', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '66', '011100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '63', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '65', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '64', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '67', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '68', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('8', '69', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '70', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '71', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '72', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '82', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '83', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '84', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '85', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '73', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '74', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '75', '110100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '76', '011000', '');
INSERT INTO `admin_roleauth` VALUES ('8', '86', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '87', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '77', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '78', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '79', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('8', '80', '111100', '');
INSERT INTO `admin_roleauth` VALUES ('7', '57', '111000', '');
INSERT INTO `admin_roleauth` VALUES ('7', '56', '111000', '');

-- ----------------------------
-- Table structure for admin_user
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `operid` varchar(32) NOT NULL COMMENT '登陆账号',
  `deptid` varchar(10) DEFAULT NULL,
  `rdate` datetime DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `password` varchar(64) NOT NULL,
  `roleid` int(11) NOT NULL,
  `valid` tinyint(1) NOT NULL DEFAULT '0' COMMENT '有效标志',
  PRIMARY KEY (`operid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('sa', '001', '2014-01-09 15:31:13', '系统管理员', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `admin_user` VALUES ('admin', '001', '2014-12-19 17:29:42', '系统管理员1', 'e10adc3949ba59abbe56e057f20f883e', '1', '1');
INSERT INTO `admin_user` VALUES ('gftest', '001', '2015-05-05 10:32:52', 'Test', 'e10adc3949ba59abbe56e057f20f883e', '7', '1');
INSERT INTO `admin_user` VALUES ('gftest2', '001', '2015-05-05 10:47:04', 'test2', 'e10adc3949ba59abbe56e057f20f883e', '7', '1');
INSERT INTO `admin_user` VALUES ('gfm', '001', '2015-05-05 21:56:26', 'manager', 'e10adc3949ba59abbe56e057f20f883e', '8', '1');
INSERT INTO `admin_user` VALUES ('test', '001', '2015-05-15 09:18:43', 'test', 'c33367701511b4f6020ec61ded352059', '7', '1');
INSERT INTO `admin_user` VALUES ('ch1', '001', '2015-07-16 21:40:00', 'ch1', 'e10adc3949ba59abbe56e057f20f883e', '7', '1');
INSERT INTO `admin_user` VALUES ('gftest3', '001', '2015-05-05 10:47:04', 'test2', 'e10adc3949ba59abbe56e057f20f883e', '7', '1');
INSERT INTO `admin_user` VALUES ('gftest4', '001', '2015-05-05 10:47:04', 'test2', 'e10adc3949ba59abbe56e057f20f883e', '7', '1');
INSERT INTO `admin_user` VALUES ('gftest5', '001', '2015-05-05 10:47:04', 'test2', 'e10adc3949ba59abbe56e057f20f883e', '7', '1');
INSERT INTO `admin_user` VALUES ('gftest6', '001', '2015-05-05 10:47:04', 'test2', 'e10adc3949ba59abbe56e057f20f883e', '7', '1');

-- ----------------------------
-- Table structure for client
-- ----------------------------
DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operid` varchar(50) NOT NULL,
  `client_type` smallint(6) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `mail` varchar(50) NOT NULL,
  `country` varchar(60) NOT NULL,
  `company_name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `mobile_phone` varchar(15) DEFAULT NULL,
  `tool_type` varchar(50) DEFAULT NULL,
  `tool_number` varchar(30) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `remark` varchar(300) DEFAULT NULL,
  `is_gw` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0国内 1国外',
  `datetime` datetime NOT NULL,
  `is_pub` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0私有 1公有',
  `follow_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client
-- ----------------------------
INSERT INTO `client` VALUES ('2', 'gftest', '1', '二人', null, '54651@qq.com', '中国', '公司2', '4', '7', null, 'qq:835421256 skype:minsky', '6', '8', '0', '2015-03-30 12:04:16', '1', '2015-03-04 14:27:19');
INSERT INTO `client` VALUES ('3', 'gftest', '1', '万物', null, '5465@qq.com', '中国', '公司3', '34', '66', null, 'qq:835421256', '6', '66', '0', '2015-03-30 13:26:54', '1', '2015-05-04 19:18:11');
INSERT INTO `client` VALUES ('4', 'gftest', '1', '1', '2', '33', '中国', '5', '2', '4', null, '5', '5', '5', '0', '2015-03-31 11:42:19', '1', '2015-01-01 14:27:24');
INSERT INTO `client` VALUES ('5', 'gftest', '1', 'Asdas', 'Asdfqww', '5', '安提瓜和巴布达', '5', '4', '5', null, '5', '5', '5', '1', '2015-03-31 11:44:25', '1', '2015-05-04 14:27:27');
INSERT INTO `client` VALUES ('6', 'gftest', '2', '31', '31', '561', 'Niue', '61', '341', '6661', null, '61', '61', '61', '1', '2015-03-31 11:45:21', '0', '2015-05-04 14:27:30');
INSERT INTO `client` VALUES ('8', 'gftest', '1', 'Sadas', 'Sadasd', '3123', 'Angola', '2131232', '12321312', '123123', null, '3123', '12312', '312312', '1', '2015-04-13 00:17:12', '0', '2015-01-01 14:27:32');
INSERT INTO `client` VALUES ('9', 'gftest', '1', 'A', 'B', 'asa@sina.com', 'Burkina Faso', '', '4445432', '', null, '', '', '', '1', '2015-04-20 12:04:15', '0', '2015-05-04 15:00:37');
INSERT INTO `client` VALUES ('14', 'gftest2', '1', 'Kerin', 'Zhao', 'kerin@chinaszshh.com', 'United States', 'GF', '008675588824458', '', null, 'Skype:chinaszshh.com', 'www.chinaszshh.com', 'just for test only', '1', '2015-04-27 19:16:44', '0', '2015-07-01 09:21:35');
INSERT INTO `client` VALUES ('15', 'sa', '1', 'TIM', 'ZHAO', 'tim@goods-list.com', 'China', '', '075588824458', '', null, '', '', '', '1', '2015-05-04 18:13:05', '0', '2015-07-01 09:21:40');
INSERT INTO `client` VALUES ('16', 'sa', '1', '公司', null, '79879811@qq.com', '中国', '', '11111111111', '', null, '', '', '', '0', '2015-05-04 18:16:07', '0', '2015-07-01 09:21:44');
INSERT INTO `client` VALUES ('17', 'sa', '1', '12312', null, '798798@qq.com', '中国', '3123123', '2131323', '12312', null, '', '3123', '123123123', '0', '2015-05-04 19:36:40', '0', '2015-04-01 23:19:52');
INSERT INTO `client` VALUES ('18', 'sa', '1', '23123', '123123', '1231231231231@qq.com', 'Antigua and Barbuda', '12312', '123123123', '312321', null, '312312', '312312', '3123123', '1', '2015-05-05 09:06:25', '0', '2015-03-01 23:19:58');
INSERT INTO `client` VALUES ('19', 'sa', '1', '赵德明', null, 'zdm@gf9188.com', '中国', '新满杰', '075588824458', '1388888888', null, 'QQ:123456,Skype:chinaflash', 'www.gf9188.com', '', '0', '2015-05-05 10:36:18', '0', '2015-02-01 10:40:52');
INSERT INTO `client` VALUES ('20', 'sa', '1', 'Tim', 'Zhao', 'tim2@goods-list.com', 'United Kingdom', 'GF', '07666666', '15088888888', null, 'QQ: 123209358,Skype:chinaflash', 'gf9188.com', '', '1', '2015-05-05 10:37:58', '0', '2015-01-01 10:41:10');
INSERT INTO `client` VALUES ('21', 'sa', '1', 'wqeqweqwe', null, 'qweqw@qq.com', '中国', 'qweqweqweq', '111111111111111', '111111111111111', null, '1111111', '11111111111111', '11111111111', '0', '2015-05-09 21:46:43', '0', '1970-01-01 00:00:00');
INSERT INTO `client` VALUES ('22', 'sa', '1', '222222222222', null, '2222222@qq.com', '中国', '11111111111111111111211', '22222222222222222222', '11111111112', null, '111111111111111112', '2222', '222', '0', '2015-05-09 21:48:43', '0', '2015-07-01 09:16:20');
INSERT INTO `client` VALUES ('23', 'sa', '1', '123123', null, '12312312@qq.com', '中国', '222222222222222222', '123123', '222222222222222', null, '2222222222', '22222222222222', '22222222222222222222', '0', '2015-05-09 21:49:44', '0', '1970-01-01 00:00:00');
INSERT INTO `client` VALUES ('24', 'sa', '1', '国内客户', null, '333333333333333@qq.com', '中国', '4444444444444444444444444444444', '33333333', '4444', null, '444444444444444444', '444444444444444444', '44444444444444', '0', '2015-05-09 21:51:33', '0', '1970-01-01 00:00:00');
INSERT INTO `client` VALUES ('25', 'sa', '1', 'Qwe', 'Werrrr', '423423@qq.com', 'Argentina', '123', '33333333', '21312312', null, '12312', '3123', '12312312', '1', '2015-05-09 21:52:21', '0', '1970-01-01 00:00:00');
INSERT INTO `client` VALUES ('26', 'sa', '1', 'Fddf', 'Dsfdsf', '234324@qq.com', 'Austria', '2434', '234324234', 'ewqeqw', null, '234w3432', '4wew', 'eqweqwe', '1', '2015-05-10 19:49:51', '0', '1970-01-01 00:00:00');
INSERT INTO `client` VALUES ('27', 'sa', '1', '水水水水', null, '222@qq.com', '中国', '2', '22', '2', null, '22', '2', '2', '0', '2015-07-14 11:45:35', '0', '1970-01-01 00:00:00');

-- ----------------------------
-- Table structure for client_black
-- ----------------------------
DROP TABLE IF EXISTS `client_black`;
CREATE TABLE `client_black` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(100) NOT NULL,
  `operid` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL,
  `remark` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_black
-- ----------------------------
INSERT INTO `client_black` VALUES ('3', 'heimail@qq.com', 'sa', '2015-04-19 23:31:32', null);
INSERT INTO `client_black` VALUES ('6', 'heimail2@qq.com', 'sa', '2015-04-19 23:35:53', null);
INSERT INTO `client_black` VALUES ('7', 'zxcsz@qq.com', 'sa', '2015-04-20 21:48:41', null);
INSERT INTO `client_black` VALUES ('8', '12333@qq.com', 'sa', '2015-04-28 15:24:44', null);
INSERT INTO `client_black` VALUES ('9', '123209358@qq.com', 'sa', '2015-04-28 15:25:16', null);
INSERT INTO `client_black` VALUES ('10', '123209358@qq.com', 'sa', '2015-04-28 15:25:16', null);
INSERT INTO `client_black` VALUES ('11', 'sadsadsad@qq.com', 'sa', '2015-05-05 09:17:02', null);
INSERT INTO `client_black` VALUES ('12', '23432@qq.com', 'sa', '2015-05-05 09:17:47', '213123123');
INSERT INTO `client_black` VALUES ('13', 'dada@qq.com', 'gftest', '2015-05-05 10:42:51', '同行');

-- ----------------------------
-- Table structure for client_email
-- ----------------------------
DROP TABLE IF EXISTS `client_email`;
CREATE TABLE `client_email` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mail` varchar(50) NOT NULL,
  `datetime` datetime NOT NULL,
  `deal_date` date DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `remark` varchar(300) DEFAULT NULL,
  `is_deal` tinyint(1) NOT NULL DEFAULT '0',
  `operid` varchar(50) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_email
-- ----------------------------
INSERT INTO `client_email` VALUES ('2', '12312312@qq.com', '2015-05-09 21:49:44', '2015-05-09', '123123', '', '22222222222222222222', '0', 'sa', 'China');
INSERT INTO `client_email` VALUES ('3', '333333333333333@qq.com', '2015-05-09 21:51:33', '2015-05-09', '33333333333', '', '44444444444444', '0', 'sa', 'China');
INSERT INTO `client_email` VALUES ('4', '423423@qq.com', '2015-05-09 21:52:21', '2015-05-09', 'Qwe', 'Werrrr', '12312312', '0', 'sa', 'Argentina');
INSERT INTO `client_email` VALUES ('5', '234324@qq.com', '2015-05-10 19:49:51', '2015-05-10', 'Fddf', 'Dsfdsf', 'eqweqwe', '0', 'sa', 'Austria');
INSERT INTO `client_email` VALUES ('6', '222@qq.com', '2015-07-14 11:45:36', '2015-07-14', '水水水水', '', '2', '0', 'sa', 'China');

-- ----------------------------
-- Table structure for client_source
-- ----------------------------
DROP TABLE IF EXISTS `client_source`;
CREATE TABLE `client_source` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of client_source
-- ----------------------------
INSERT INTO `client_source` VALUES ('2', '涞源1');
INSERT INTO `client_source` VALUES ('3', '涞源2');
INSERT INTO `client_source` VALUES ('9', '涞源3');
INSERT INTO `client_source` VALUES ('10', '涞源4');

-- ----------------------------
-- Table structure for client_tool
-- ----------------------------
DROP TABLE IF EXISTS `client_tool`;
CREATE TABLE `client_tool` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of client_tool
-- ----------------------------
INSERT INTO `client_tool` VALUES ('1', 'QQ');
INSERT INTO `client_tool` VALUES ('2', 'Skype');

-- ----------------------------
-- Table structure for client_type
-- ----------------------------
DROP TABLE IF EXISTS `client_type`;
CREATE TABLE `client_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of client_type
-- ----------------------------
INSERT INTO `client_type` VALUES ('1', '有来往客户');
INSERT INTO `client_type` VALUES ('2', '成交客户');

-- ----------------------------
-- Table structure for dynamic_track
-- ----------------------------
DROP TABLE IF EXISTS `dynamic_track`;
CREATE TABLE `dynamic_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content` varchar(500) NOT NULL,
  `datetime` datetime NOT NULL,
  `client_id` int(11) NOT NULL,
  `operid` varchar(60) NOT NULL,
  `keywords` varchar(300) DEFAULT NULL,
  `is_help` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of dynamic_track
-- ----------------------------
INSERT INTO `dynamic_track` VALUES ('1', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('2', '222', '2015-07-01 09:16:01', '14', 'sa', '', '0');
INSERT INTO `dynamic_track` VALUES ('3', '22222', '2015-07-01 09:16:12', '15', 'sa', '', '0');
INSERT INTO `dynamic_track` VALUES ('4', '22222', '2015-07-01 09:16:16', '16', 'sa', '', '0');
INSERT INTO `dynamic_track` VALUES ('5', '3333', '2015-07-01 09:16:20', '22', 'sa', '', '0');
INSERT INTO `dynamic_track` VALUES ('6', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('7', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('8', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('9', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('10', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('11', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('12', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('13', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('14', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('15', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('16', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('17', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('18', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('19', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('20', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('21', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');
INSERT INTO `dynamic_track` VALUES ('22', 'werewrewrw', '2015-05-10 19:51:18', '15', 'sa', 'werwerwer', '0');

-- ----------------------------
-- Table structure for market_track
-- ----------------------------
DROP TABLE IF EXISTS `market_track`;
CREATE TABLE `market_track` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `datetime` datetime NOT NULL,
  `content` varchar(600) NOT NULL,
  `keywords` varchar(300) NOT NULL,
  `client_id` int(11) NOT NULL,
  `operid` varchar(50) NOT NULL,
  `is_back` tinyint(1) NOT NULL DEFAULT '0' COMMENT '无反馈  1有反馈',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of market_track
-- ----------------------------
INSERT INTO `market_track` VALUES ('1', '2015-05-10 19:51:39', 'wqeqweqw', 'eqweqwe', '15', 'sa', '0');
INSERT INTO `market_track` VALUES ('2', '2015-07-01 09:21:35', '222', '', '14', 'sa', '0');
INSERT INTO `market_track` VALUES ('3', '2015-07-01 09:21:40', '3333', '', '15', 'sa', '0');
INSERT INTO `market_track` VALUES ('4', '2015-07-01 09:21:44', '44444', '', '16', 'sa', '0');

-- ----------------------------
-- Table structure for pwd_owner
-- ----------------------------
DROP TABLE IF EXISTS `pwd_owner`;
CREATE TABLE `pwd_owner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operid` varchar(50) NOT NULL,
  `recode_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pwd_owner
-- ----------------------------
INSERT INTO `pwd_owner` VALUES ('12', 'gftest', '5');
INSERT INTO `pwd_owner` VALUES ('13', 'sa', '5');
INSERT INTO `pwd_owner` VALUES ('15', 'gftest', '4');
INSERT INTO `pwd_owner` VALUES ('16', 'sa', '4');
INSERT INTO `pwd_owner` VALUES ('17', 'gftest', '6');
INSERT INTO `pwd_owner` VALUES ('18', 'sa', '7');
INSERT INTO `pwd_owner` VALUES ('19', 'admin', '7');
INSERT INTO `pwd_owner` VALUES ('20', 'admin', '8');
INSERT INTO `pwd_owner` VALUES ('21', 'ch1', '9');
INSERT INTO `pwd_owner` VALUES ('22', 'sa', '10');
INSERT INTO `pwd_owner` VALUES ('23', 'admin', '10');
INSERT INTO `pwd_owner` VALUES ('24', 'ch1', '10');

-- ----------------------------
-- Table structure for pwd_recode
-- ----------------------------
DROP TABLE IF EXISTS `pwd_recode`;
CREATE TABLE `pwd_recode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type_id` int(11) NOT NULL,
  `operid` varchar(50) NOT NULL,
  `username` varchar(100) NOT NULL,
  `pwd` varchar(100) NOT NULL,
  `url` varchar(100) DEFAULT NULL,
  `admin_url` varchar(100) DEFAULT NULL,
  `remark` varchar(300) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pwd_recode
-- ----------------------------
INSERT INTO `pwd_recode` VALUES ('4', '1', 'sa', 'hxq0509@126.com', 'qwewqe', 'http://www.baidu.com', 'http://www.baidu.com', 'asdsadas', '2015-04-21 14:35:28');
INSERT INTO `pwd_recode` VALUES ('5', '4', 'sa', '1231233', '1231233', '1231233', '1231233', '123123123', '2015-04-21 14:35:04');
INSERT INTO `pwd_recode` VALUES ('6', '1', 'gftest', 'ADMIN', 'ADMIN', '', '', 'test22', '2015-05-05 10:44:35');
INSERT INTO `pwd_recode` VALUES ('7', '1', 'sa', 'admin', '123123', '123123', '123123123', '', '2015-05-22 20:00:53');
INSERT INTO `pwd_recode` VALUES ('8', '1', 'sa', 'wwww', 'wwww', 'www', 'www', 'wwww', '2015-07-16 21:38:01');
INSERT INTO `pwd_recode` VALUES ('9', '1', 'sa', '222', '22222', '222', '2222', '', '2015-07-16 21:40:20');
INSERT INTO `pwd_recode` VALUES ('10', '1', 'sa', 'sdasdqwe', 'qweqw', 'qwe', 'eqweqwe', '', '2015-07-16 22:15:52');

-- ----------------------------
-- Table structure for pwd_type
-- ----------------------------
DROP TABLE IF EXISTS `pwd_type`;
CREATE TABLE `pwd_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pwd_type
-- ----------------------------
INSERT INTO `pwd_type` VALUES ('1', '阿里国际站-goods-list.biz');
INSERT INTO `pwd_type` VALUES ('2', '阿里国际站-chinaszshh.biz');
INSERT INTO `pwd_type` VALUES ('3', '阿里国际站-leddots.biz');
INSERT INTO `pwd_type` VALUES ('4', '公司主站-goods-list.com');
