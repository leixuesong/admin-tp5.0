/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : retailer

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2020-07-20 16:00:57
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_node
-- ----------------------------
DROP TABLE IF EXISTS `admin_node`;
CREATE TABLE `admin_node` (
  `node_id` int(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` varchar(255) COLLATE utf8_bin NOT NULL COMMENT '节点名称',
  `sort` int(5) unsigned NOT NULL DEFAULT 0 COMMENT '节点排序',
  `pid` int(5) unsigned NOT NULL COMMENT '父级节点',
  `level` int(1) unsigned NOT NULL DEFAULT 0 COMMENT '节点级别',
  `controller` varchar(100) COLLATE utf8_bin NOT NULL COMMENT '请求控制',
  `method` varchar(80) COLLATE utf8_bin NOT NULL COMMENT '请求方法',
  `style` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '附加样式',
  `icon` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '图标',
  `status` tinyint(1) unsigned DEFAULT 0 COMMENT '节点状态: 0 正常 1 停用',
  PRIMARY KEY (`node_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of admin_node
-- ----------------------------
INSERT INTO `admin_node` VALUES ('1', '111', '0', '0', '0', '1', '1', null, '1', '1');
INSERT INTO `admin_node` VALUES ('2', '444', '0', '0', '0', '44', '444', null, '44', '0');
INSERT INTO `admin_node` VALUES ('3', '6777', '0', '0', '0', '66', '66', null, '66', '1');
INSERT INTO `admin_node` VALUES ('4', '444', '0', '1', '0', '44', '44', null, '44', '1');
INSERT INTO `admin_node` VALUES ('5', '11', '0', '0', '0', '11', '11', null, '11', '0');

-- ----------------------------
-- Table structure for admin_role
-- ----------------------------
DROP TABLE IF EXISTS `admin_role`;
CREATE TABLE `admin_role` (
  `role_id` int(4) unsigned NOT NULL COMMENT '主键',
  `name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '名称',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态 0 正常 1 停用',
  `remarks` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `node_id` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '节点id,逗号分隔',
  PRIMARY KEY (`role_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of admin_role
-- ----------------------------

-- ----------------------------
-- Table structure for admin_user
-- ----------------------------
DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `admin_account` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '账号',
  `admin_password` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '密码',
  `last_login_ip` varchar(25) COLLATE utf8_bin NOT NULL COMMENT '最后登录IP',
  `login_count` int(6) unsigned DEFAULT NULL COMMENT '登录计数',
  `admin_phone` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT '管理员手机号',
  `admin_email` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '管理员邮箱',
  `admin_remarks` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT '备注',
  `admin_status` tinyint(1) unsigned DEFAULT NULL COMMENT '管理员状态:0 正常 1 停用 2 删除',
  ` verify_key` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT 'google验证密钥',
  `admin_verify` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT '短信验证码',
  `verify_passtime` datetime DEFAULT NULL COMMENT '短信过期时间',
  `verify_type` tinyint(1) unsigned NOT NULL COMMENT '验证方式 0.短信验证 1.google 身份证',
  `admin_permit_ip` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '白名单IP',
  `admin_session_sign` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '单点登录session',
  `admin_create_time` datetime NOT NULL COMMENT '创建时间',
  `admin_update_time` datetime DEFAULT NULL COMMENT '更新时间',
  `admin_last_login_time` datetime DEFAULT NULL COMMENT '最后登陆时间',
  `admin_role_id` int(4) unsigned DEFAULT NULL COMMENT '角色id',
  `admin_date` date DEFAULT NULL COMMENT '操作日期',
  `admin_time` time DEFAULT NULL COMMENT '操作时间',
  PRIMARY KEY (`admin_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of admin_user
-- ----------------------------
INSERT INTO `admin_user` VALUES ('1', '1', 'c4ca4238a0b923820dcc509a6f75849b', '1', null, null, null, null, '0', '1', null, null, '1', null, '04509a81d0065fc052bed187a5af2bdf', '2020-07-15 13:44:30', null, null, null, null, null);

-- ----------------------------
-- Table structure for agent
-- ----------------------------
DROP TABLE IF EXISTS `agent`;
CREATE TABLE `agent` (
  `agent_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `agent_acc` varchar(25) COLLATE utf8_bin NOT NULL COMMENT '代理商账号',
  `agent_pwd` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '代理商密码',
  `permit_IP` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '白名单IP(以逗号分割,不限制为空)',
  `last_log_ip` varchar(25) COLLATE utf8_bin DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登陆时间',
  `login_count` int(6) unsigned DEFAULT NULL COMMENT '登录计数',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态: 0正常 1 待审核 2 停用 ',
  `email` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT '邮箱',
  `phone` varchar(20) COLLATE utf8_bin NOT NULL COMMENT '手机号码',
  `session_sign` varchar(32) COLLATE utf8_bin DEFAULT '' COMMENT '单点登录session',
  `agent_level` tinyint(1) unsigned NOT NULL COMMENT '代理商级别  0 高级代理商 1 普通代理商',
  `agent_up_level` int(6) DEFAULT NULL COMMENT '上级代理商 id',
  `agent_share` decimal(8,2) DEFAULT NULL COMMENT '分润比例',
  `verify_key` varchar(50) COLLATE utf8_bin NOT NULL COMMENT 'google 验证key',
  `sms_verify` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT '短信验证码',
  `sms_passtime` datetime DEFAULT NULL COMMENT '短信过期时间',
  `verify_type` tinyint(1) unsigned DEFAULT NULL COMMENT '验证方式 0.短信验证 1.google身份验证',
  `agent_number` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '代理商推广码',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`agent_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of agent
-- ----------------------------
INSERT INTO `agent` VALUES ('1', '1', 'c4ca4238a0b923820dcc509a6f75849b', null, null, null, null, '0', null, '1', '97f597a2d17ef2325877b1681dff8d15', '0', null, null, '1', null, null, null, '1', '2020-07-20 14:18:03', '2020-07-20 14:18:05');

-- ----------------------------
-- Table structure for commodity
-- ----------------------------
DROP TABLE IF EXISTS `commodity`;
CREATE TABLE `commodity` (
  `comm_id` int(8) unsigned NOT NULL AUTO_INCREMENT,
  `comm_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '商品名称',
  `comm_img` varchar(80) COLLATE utf8_bin NOT NULL COMMENT '商品图片',
  `comm_note` varchar(150) COLLATE utf8_bin DEFAULT NULL COMMENT '商品说明',
  `comm_amount` decimal(10,2) unsigned NOT NULL COMMENT '产品金额',
  `mer_id` int(6) unsigned NOT NULL COMMENT '所属商户',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态: 0正常 1 停用  2 待审核',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  PRIMARY KEY (`comm_id`,`mer_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of commodity
-- ----------------------------

-- ----------------------------
-- Table structure for merchant
-- ----------------------------
DROP TABLE IF EXISTS `merchant`;
CREATE TABLE `merchant` (
  `mer_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `mer_acc` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '商户账号',
  `mer_pwd` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '商户密码',
  `permit_IP` varchar(255) COLLATE utf8_bin DEFAULT NULL COMMENT '白名单IP(以逗号分割,不限制为空)',
  `last_log_ip` varchar(25) COLLATE utf8_bin DEFAULT NULL COMMENT '最后登录ip',
  `last_login_time` datetime DEFAULT NULL COMMENT '最后登陆时间',
  `login_count` int(6) unsigned DEFAULT NULL COMMENT '登录计数',
  `status` tinyint(1) unsigned NOT NULL COMMENT '状态: 0正常 1 待审核 2 停用 ',
  `email` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT '邮箱',
  `phone` varchar(20) COLLATE utf8_bin DEFAULT NULL COMMENT '手机号码',
  `session_sign` varchar(50) COLLATE utf8_bin DEFAULT NULL COMMENT '单点登录session',
  `agent_id` int(6) DEFAULT NULL COMMENT '所属代理商',
  `verify_key` varchar(80) COLLATE utf8_bin DEFAULT NULL COMMENT 'google验证密钥',
  `sms_verify` varchar(10) COLLATE utf8_bin DEFAULT NULL COMMENT '短信验证码',
  `sms_passtime` datetime DEFAULT NULL COMMENT '短信过期时间',
  `app_key` varchar(80) COLLATE utf8_bin NOT NULL COMMENT 'app加密key 随机32 位字符',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `update_time` datetime DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`mer_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of merchant
-- ----------------------------

-- ----------------------------
-- Table structure for order
-- ----------------------------
DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
  `order_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `order_number` varchar(80) COLLATE utf8_bin NOT NULL COMMENT '订单号',
  `order_addtime` datetime NOT NULL COMMENT '订单生成时间',
  `order_process_time` datetime DEFAULT NULL COMMENT '订单处理时间',
  `order_amount` decimal(10,2) unsigned NOT NULL COMMENT '订单金额',
  `comm_id` int(8) unsigned NOT NULL COMMENT '所属商品',
  `mer_id` int(6) unsigned NOT NULL COMMENT '所商户',
  `agent_id` int(6) unsigned NOT NULL COMMENT '所属代理商',
  `agent_up_id` int(6) unsigned NOT NULL COMMENT '上级代理商',
  `order_state` tinyint(1) NOT NULL,
  PRIMARY KEY (`order_id`,`order_number`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of order
-- ----------------------------

-- ----------------------------
-- Table structure for share
-- ----------------------------
DROP TABLE IF EXISTS `share`;
CREATE TABLE `share` (
  `share_id` int(10) unsigned NOT NULL,
  `order_number` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '订单号',
  `order_amount` decimal(10,2) unsigned NOT NULL COMMENT '订单金额',
  `share_time` datetime NOT NULL COMMENT '生成时间',
  `share_amount` decimal(10,2) NOT NULL COMMENT '分润金额',
  `agent_id` int(6) NOT NULL,
  PRIMARY KEY (`share_id`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of share
-- ----------------------------

-- ----------------------------
-- Table structure for sys_log
-- ----------------------------
DROP TABLE IF EXISTS `sys_log`;
CREATE TABLE `sys_log` (
  `sys_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `sys_log_role` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作角色',
  `sys_log_id` int(5) unsigned NOT NULL COMMENT '操作角色ID',
  `sys_log_ip` varchar(25) COLLATE utf8_bin NOT NULL COMMENT '操作IP',
  `sys_log_city` varchar(80) COLLATE utf8_bin NOT NULL COMMENT '操作员所在城市',
  `sys_log_name` varchar(50) COLLATE utf8_bin NOT NULL COMMENT '操作名称',
  `sys_log_note` varchar(100) COLLATE utf8_bin DEFAULT NULL COMMENT '操作备注',
  `sys_log_time` datetime NOT NULL,
  PRIMARY KEY (`sys_id`) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin ROW_FORMAT=DYNAMIC;

-- ----------------------------
-- Records of sys_log
-- ----------------------------
INSERT INTO `sys_log` VALUES ('1', '1', '1', '1', '1', '1', '1', '2020-07-16 13:54:47');
