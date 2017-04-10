SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- ----------------------------
-- Database for `cmt`
-- ----------------------------
DROP DATABASE IF EXISTS cmt;
CREATE DATABASE cmt DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE cmt;

-- ----------------------------
-- Table structure for `cmt_admin_user`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_admin_user`;
CREATE TABLE `cmt_admin_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type` varchar(20) NOT NULL COMMENT '用户类型',
  `name` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) NOT NULL COMMENT '密码',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='系统用户';

-- ----------------------------
-- Records of cmt_admin_user
-- ----------------------------
INSERT INTO `cmt_admin_user` VALUES ('1', 'superAdmin', 'eyJpdiI6InlJbTkzSFwvUURuNTVBZ2ZPXC80UkE0QT09IiwidmFsdWUiOiJGSUZ2eGNvWDBiZ1pLUFdiTmtDb2dnVk9tYzFMMUxRbG9cL3lJRUUzbENFTT0iLCJtYWMiOiI1Yjk2N2IwNDZlZDk2NjMyNzVkNDA2N2FhZTIzYzE4M2ZhNGZiMmZmOWYxZmRiNDA2NzhiN2IxYThkNjU1OTY5In0=', '26983727');
INSERT INTO `cmt_admin_user` VALUES ('2', 'operation', 'eyJpdiI6InJpbE4yVkRQRm4xMm5RZ0I2ODhHT2c9PSIsInZhbHVlIjoiaERERHJERVFBQk1mME82QkRXTHoydz09IiwibWFjIjoiNGUxYTc4ODEzMjQ0MTJkMzg2NWI2ZTIwOTI1MTljODU1ZWFhMTIxYzU1YWRhYzc4ZTE2NmIyNDdhMDNhYzFjNyJ9', '2017');
INSERT INTO `cmt_admin_user` VALUES ('3', 'maintenance', 'eyJpdiI6IlFMait1XC81akNCaDdwSG96TGxWa0tRPT0iLCJ2YWx1ZSI6IklCYVExY2ZBWjJqQ2c3SlBCcW5Lc2cxNkRuZVd6RWVpU2x0emVlUzN1bkk9IiwibWFjIjoiZDJmYjY4YjQ4OTQxMDEyZDVmMDUwZTA1MmZkMDcyOWU5ZTQ5NzU4NTllZjRkYTBiNWNkYjBkOGQxNDRmMzE0MiJ9', '666666');
INSERT INTO `cmt_admin_user` VALUES ('4', 'factorySet', 'eyJpdiI6IjYzeEV2WU1YSU1BN2k1QmZlMW1jcnc9PSIsInZhbHVlIjoiRzNpYU9teGFwZ1JLcHZcL1k3QjNMR28xNWZQRWhEWThRbWtkSlNDSTlHWTQ9IiwibWFjIjoiYjEzOGM0YmI0Y2M4MzVkMTRhNTExZWJmNzhjMjljZTRlODQzZWZmMWI4NzJjMGRhOThiZmM5MzFlZjczOWRlZSJ9', '999999999');

-- ----------------------------
-- Table structure for `cmt_auto_export`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_auto_export`;
CREATE TABLE `cmt_auto_export` (
  `export_id` int(11) NOT NULL AUTO_INCREMENT,
  `auto_export` int(11) DEFAULT NULL,
  `export_days` int(11) DEFAULT NULL,
  `export_months` int(11) DEFAULT NULL,
  `export_weeks` int(11) DEFAULT NULL,
  `export_protocol` int(11) DEFAULT NULL,
  `export_url` varchar(100) DEFAULT NULL,
  `export_format` int(11) DEFAULT NULL,
  `export_type` int(11) DEFAULT NULL,
  `export_username` varchar(100) DEFAULT NULL,
  `export_password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`export_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_auto_export
-- ----------------------------
INSERT INTO `cmt_auto_export` VALUES ('1', '1', '1', '1', '1', '4', '', '1', '2', '', '');

-- ----------------------------
-- Table structure for `cmt_cabin`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_cabin`;
CREATE TABLE `cmt_cabin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(2) NOT NULL,
  `ship` tinyint(1) NOT NULL,
  `startrow` tinyint(2) NOT NULL,
  `endrow` tinyint(2) NOT NULL,
  `number` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=112 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_cabin
-- ----------------------------
INSERT INTO `cmt_cabin` VALUES ('100', '1', '0', '1', '10', '4');
INSERT INTO `cmt_cabin` VALUES ('104', '3', '0', '1', '10', '2');
INSERT INTO `cmt_cabin` VALUES ('102', '2', '0', '1', '10', '4');
INSERT INTO `cmt_cabin` VALUES ('109', '1', '2', '11', '20', '6');
INSERT INTO `cmt_cabin` VALUES ('110', '2', '2', '11', '20', '6');
INSERT INTO `cmt_cabin` VALUES ('111', '3', '2', '11', '20', '2');

-- ----------------------------
-- Table structure for `cmt_config`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_config`;
CREATE TABLE `cmt_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `var_name` varchar(255) NOT NULL COMMENT '参数名称',
  `info` varchar(255) NOT NULL COMMENT '参数描述',
  `var_value` varchar(255) NOT NULL COMMENT '参数值',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='系统配置';

-- ----------------------------
-- Records of cmt_config
-- ----------------------------
INSERT INTO `cmt_config` VALUES ('1', 'play_protocol', '播放协议', 'http');
INSERT INTO `cmt_config` VALUES ('2', 'ip', '服务器ip', '192.168.2.99');
INSERT INTO `cmt_config` VALUES ('3', 'port', '0-65535', '80');
INSERT INTO `cmt_config` VALUES ('5', 'plane_id', '飞机注册号', '19001890');
INSERT INTO `cmt_config` VALUES ('6', 'system_id', '系统序列号', 'B5102');
INSERT INTO `cmt_config` VALUES ('7', 'cap_replace', 'CAP替换标签', '3');
INSERT INTO `cmt_config` VALUES ('8', 'export_time', '上一次任务导出时间', '1469429019');
INSERT INTO `cmt_config` VALUES ('9', 'max_altitude', '飞行过程中最大高度值', '2000');
INSERT INTO `cmt_config` VALUES ('10', 'bite_statue', '一键检测的状态标识', '4');
INSERT INTO `cmt_config` VALUES ('11', 'factory_id', '厂商导出日志的标示', '782430910');
INSERT INTO `cmt_config` VALUES ('12', 'tail_number', '飞机机尾号', 'CS790');
INSERT INTO `cmt_config` VALUES ('13', 'flight_number', '航班号', 'A973');
INSERT INTO `cmt_config` VALUES ('14', 'last_export_time', '上一次任务导出时间', '0');
INSERT INTO `cmt_config` VALUES ('15', 'valid_upload_ip', '上传到南航服务器有效IP地址', '125.88.33.207');
INSERT INTO `cmt_config` VALUES ('16', 'take_off_time', '飞机起飞开始记录飞行日志时刻', '0');
INSERT INTO `cmt_config` VALUES ('17', 'ftp_latest_version', '本地最新wifi系统版本', 'Version.1.2.3');
INSERT INTO `cmt_config` VALUES ('18', 'ftp_upgraded_flag', '本地最新wifi系统版本更新标志', '1');
INSERT INTO `cmt_config` VALUES ('19', 'ftp_remote_upgraded_flag', 'ftp服务器最新wifi系统版本更新标志', '2');
INSERT INTO `cmt_config` VALUES ('20', 'ftp_remote_latest_version', 'ftp服务器最新wifi系统版本', '0');

-- ----------------------------
-- Table structure for `cmt_contry`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_contry`;
CREATE TABLE `cmt_contry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contry` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_contry
-- ----------------------------
INSERT INTO `cmt_contry` VALUES ('1', '中国');
INSERT INTO `cmt_contry` VALUES ('2', '美国');
INSERT INTO `cmt_contry` VALUES ('3', '日本');
INSERT INTO `cmt_contry` VALUES ('4', '澳大利亚');
INSERT INTO `cmt_contry` VALUES ('5', '德国');
INSERT INTO `cmt_contry` VALUES ('6', '英国');
INSERT INTO `cmt_contry` VALUES ('7', '俄罗斯');

-- ----------------------------
-- Table structure for `cmt_demand_info`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_demand_info`;
CREATE TABLE `cmt_demand_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `goods_id` int(11) DEFAULT NULL,
  `mail` varchar(32) NOT NULL,
  `telephone` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_demand_info
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_diagnosis_result`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_diagnosis_result`;
CREATE TABLE `cmt_diagnosis_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `err_time` varchar(100) DEFAULT NULL,
  `err_code` int(11) DEFAULT NULL,
  `err_msg` varchar(100) DEFAULT NULL,
  `err_type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_diagnosis_result
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_eliterequirments`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_eliterequirments`;
CREATE TABLE `cmt_eliterequirments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `language` tinyint(2) NOT NULL,
  `create_time` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `member_id` varchar(20) NOT NULL,
  `takeouttimes` varchar(200) NOT NULL,
  `othermember` varchar(200) NOT NULL,
  `bookticketsway` varchar(200) NOT NULL,
  `getinfoway` varchar(200) NOT NULL,
  `readRUIway` varchar(200) NOT NULL,
  `tobemember` varchar(200) NOT NULL,
  `especialservices` varchar(200) NOT NULL,
  `wingsclub` varchar(200) NOT NULL,
  `communication` varchar(200) NOT NULL,
  `satisfaction` varchar(200) NOT NULL,
  `improve` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_eliterequirments
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_export_config`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_export_config`;
CREATE TABLE `cmt_export_config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `export_type` int(11) DEFAULT NULL COMMENT 'ftp/http/scp/sftp/',
  `export_url` varchar(100) DEFAULT NULL,
  `username` varchar(100) DEFAULT NULL,
  `passwd` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_export_config
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_export_task`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_export_task`;
CREATE TABLE `cmt_export_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `start_time` varchar(100) DEFAULT NULL,
  `end_time` varchar(100) DEFAULT NULL,
  `export_protocol` int(11) DEFAULT NULL,
  `export_url` varchar(100) DEFAULT NULL,
  `export_format` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `export_logpath` varchar(100) DEFAULT NULL,
  `export_username` varchar(100) DEFAULT NULL,
  `export_password` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_export_task
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_goods`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_goods`;
CREATE TABLE `cmt_goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `sn` varchar(50) NOT NULL,
  `cate_id` smallint(6) NOT NULL,
  `language_id` smallint(6) NOT NULL,
  `market_price` decimal(10,2) NOT NULL,
  `discount_price` decimal(10,2) NOT NULL,
  `air_stock` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `points` int(11) NOT NULL,
  `hot_order` int(11) NOT NULL,
  `top_order` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `description` text NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `air_price` decimal(10,2) NOT NULL,
  `air_points` int(11) NOT NULL,
  `image` text NOT NULL,
  `thumb` varchar(200) NOT NULL,
  `discount` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '折扣',
  `brand` varchar(50) NOT NULL COMMENT '品牌',
  `mileage` int(11) NOT NULL COMMENT '里程兑换',
  `currency` varchar(10) NOT NULL DEFAULT '￥' COMMENT '币种',
  `mcurrency` varchar(10) NOT NULL DEFAULT '￥' COMMENT '币种',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_goods_cate`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_goods_cate`;
CREATE TABLE `cmt_goods_cate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `pid` int(11) NOT NULL,
  `language_id` smallint(6) NOT NULL,
  `image` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  `deleted` tinyint(4) NOT NULL,
  `cate_note` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_goods_cate
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_investigate`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_investigate`;
CREATE TABLE `cmt_investigate` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `member_id` varchar(50) NOT NULL COMMENT '会员卡号',
  `entertainment` varchar(200) NOT NULL COMMENT '休闲娱乐',
  `info` varchar(200) NOT NULL COMMENT '信息',
  `avenues` varchar(200) NOT NULL COMMENT '渠道',
  `service` varchar(200) NOT NULL COMMENT '贵宾服务',
  `language` tinyint(2) NOT NULL,
  `create_time` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_investigate
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_member`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_member`;
CREATE TABLE `cmt_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ryg_sn` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `password` char(32) NOT NULL,
  `sex` tinyint(4) NOT NULL,
  `points` int(11) NOT NULL,
  `l_name_zh` varchar(50) NOT NULL,
  `f_name_zh` varchar(50) NOT NULL,
  `l_name_en` varchar(50) NOT NULL,
  `f_name_en` varchar(50) NOT NULL,
  `id_type` tinyint(4) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `birthday` int(11) NOT NULL,
  `address` text NOT NULL,
  `create_at` int(11) NOT NULL,
  `from` tinyint(4) NOT NULL,
  `sync` tinyint(4) NOT NULL DEFAULT '0',
  `sync_time` int(11) NOT NULL,
  `update_time` int(11) NOT NULL,
  `nationality` tinyint(4) NOT NULL,
  `passport_id` varchar(50) DEFAULT NULL COMMENT '护照号码',
  `other_id` varchar(50) DEFAULT NULL COMMENT '其他证件号码',
  `flight_number` varchar(50) DEFAULT NULL COMMENT '航班号',
  `flight_date` date DEFAULT NULL,
  `flight_leg` varchar(50) DEFAULT NULL COMMENT '航段',
  `flight_seat` varchar(50) DEFAULT NULL COMMENT '座位号',
  `contact_type` enum('1','2') DEFAULT '1' COMMENT '希望联系方式, 1:home, 2:office',
  `home_contry` tinyint(4) DEFAULT NULL,
  `home_province` varchar(200) DEFAULT NULL COMMENT '家庭-省',
  `home_city` varchar(200) DEFAULT NULL COMMENT '家庭-城市',
  `home_address` varchar(255) DEFAULT NULL COMMENT '家庭-地址',
  `home_zip` varchar(50) DEFAULT NULL COMMENT '家庭-邮编',
  `home_phone` varchar(50) DEFAULT NULL COMMENT '家庭-电话',
  `office_contry` tinyint(4) DEFAULT NULL,
  `office_province` varchar(200) DEFAULT NULL COMMENT '单位-省',
  `office_city` varchar(200) DEFAULT NULL COMMENT '单位-城市',
  `office_address` varchar(255) DEFAULT NULL COMMENT '单位地址',
  `office_company` varchar(255) DEFAULT NULL COMMENT '单位名称',
  `office_post` varchar(200) DEFAULT NULL COMMENT '职位',
  `office_zip` varchar(50) DEFAULT NULL,
  `office_phone` varchar(50) DEFAULT NULL COMMENT '办公电话',
  `contact_language` enum('1','2') DEFAULT '1' COMMENT '希望联络语言',
  `get_mileage_mode` enum('1','2','3') DEFAULT '1' COMMENT '获取里程的方式，1：电子邮件，2：在线查询，3：不发送',
  `hnair_userid` bigint(20) unsigned DEFAULT NULL COMMENT '金鹏俱乐部卡号，来自海航数据库',
  PRIMARY KEY (`id`),
  UNIQUE KEY `hnair_userid` (`hnair_userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_member
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_member_export`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_member_export`;
CREATE TABLE `cmt_member_export` (
  `export_time` int(11) NOT NULL,
  `start_time` char(8) NOT NULL,
  `end_time` char(8) NOT NULL,
  PRIMARY KEY (`export_time`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_member_export
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_member_tmp`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_member_tmp`;
CREATE TABLE `cmt_member_tmp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `password` char(32) DEFAULT NULL,
  `sex` tinyint(4) DEFAULT NULL,
  `points` int(11) DEFAULT NULL,
  `l_name_zh` varchar(50) DEFAULT NULL,
  `f_name_zh` varchar(50) DEFAULT NULL,
  `l_name_en` varchar(50) DEFAULT NULL,
  `f_name_en` varchar(50) DEFAULT NULL,
  `id_type` tinyint(4) DEFAULT NULL,
  `id_number` varchar(50) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `birthday` int(11) DEFAULT NULL,
  `address` text,
  `create_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_member_tmp
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_operate`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_operate`;
CREATE TABLE `cmt_operate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operate_time` datetime NOT NULL COMMENT '操作时间',
  `operater` varchar(20) NOT NULL COMMENT '操作人',
  `comment` varchar(256) NOT NULL COMMENT '操作描述',
  `equipment` varchar(10) NOT NULL COMMENT '操作设备',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1569 DEFAULT CHARSET=utf8 COMMENT='操作日志';

-- ----------------------------
-- Records of cmt_operate
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_order`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_order`;
CREATE TABLE `cmt_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `planeSN` varchar(200) DEFAULT NULL COMMENT '航班次',
  `seat_no` varchar(50) DEFAULT NULL COMMENT '座位号',
  `amount` decimal(10,2) NOT NULL,
  `points` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `pay_money` decimal(10,2) NOT NULL,
  `pay_points` int(11) NOT NULL,
  `pay_type` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `recipient` varchar(200) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(50) NOT NULL,
  `post_fee` decimal(10,2) NOT NULL,
  `create_at` int(11) NOT NULL,
  `pay_at` int(11) NOT NULL,
  `post_at` int(11) NOT NULL,
  `comments` text NOT NULL,
  `sync` tinyint(4) NOT NULL,
  `r_points` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_order
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_order_details`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_order_details`;
CREATE TABLE `cmt_order_details` (
  `order_id` int(11) NOT NULL,
  `goods_id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `goods_sn` varchar(50) NOT NULL,
  `goods_name` varchar(255) NOT NULL,
  `points` int(11) NOT NULL DEFAULT '0',
  KEY `order_id` (`order_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_order_details
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_play_files`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_play_files`;
CREATE TABLE `cmt_play_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(10) NOT NULL,
  `name` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `length` varchar(5) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_play_files
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_pppoe_log`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_pppoe_log`;
CREATE TABLE `cmt_pppoe_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID，主键',
  `message` varchar(512) DEFAULT NULL COMMENT '拨号日志信息',
  `create_time` datetime NOT NULL COMMENT '拨号记录时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='4G拨号日志';

-- ----------------------------
-- Records of cmt_pppoe_log
-- ----------------------------
INSERT INTO `cmt_pppoe_log` VALUES ('1', 'Get MAT ok!@Get ATS0 ok!@Get ATE ok!@Set Isp Access Gateway Ok!@4G Dial Normal!', '2014-05-26 14:40:37');

-- ----------------------------
-- Table structure for `cmt_pram`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_pram`;
CREATE TABLE `cmt_pram` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL COMMENT '名称，如 安全通知 等',
  `language_id` smallint(6) NOT NULL COMMENT '语言id',
  `order` int(11) NOT NULL COMMENT '显示顺序',
  `duration` int(11) NOT NULL COMMENT '时长，单位秒',
  `create_at` int(11) NOT NULL COMMENT '创建时间',
  `filename` varchar(200) NOT NULL COMMENT '文件名',
  `file_size` bigint(20) NOT NULL,
  `url` varchar(255) NOT NULL COMMENT '文件路径',
  `abs_path` varchar(255) NOT NULL,
  `is_mapping` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_pram
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_receive_address`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_receive_address`;
CREATE TABLE `cmt_receive_address` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `language_id` int(11) DEFAULT NULL,
  `receiver` varchar(32) DEFAULT NULL,
  `receiver_tel` varchar(32) DEFAULT NULL,
  `address` text,
  `note` text,
  `deleted` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_receive_address
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_seat`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_seat`;
CREATE TABLE `cmt_seat` (
  `id` int(11) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `seat` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_seat
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_task`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_task`;
CREATE TABLE `cmt_task` (
  `TaskID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID，主键',
  `Weekday` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '星期(1-7对应周一至周日， 0表示临时任务，只有手动模式才有该值)',
  `ScheduleTime` time NOT NULL COMMENT '计划执行时间',
  `TaskDesc` varchar(64) DEFAULT NULL COMMENT '任务类型描述，实际对应oam_mail_info的MailType值',
  `Active` int(11) DEFAULT NULL COMMENT '任务活动状态：0-Inactive 1-Active',
  PRIMARY KEY (`TaskID`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='任务';

-- ----------------------------
-- Records of cmt_task
-- ----------------------------
INSERT INTO `cmt_task` VALUES ('1', '0', '00:00:00', 'export_log', '1');
INSERT INTO `cmt_task` VALUES ('2', '0', '00:00:00', 'ca_log', '1');
INSERT INTO `cmt_task` VALUES ('3', '0', '00:00:00', 'cmt_log', '0');
INSERT INTO `cmt_task` VALUES ('4', '0', '00:00:00', 'jp_member', '0');
INSERT INTO `cmt_task` VALUES ('5', '4', '00:00:00', 'jp_vip', '0');
INSERT INTO `cmt_task` VALUES ('6', '4', '00:00:00', 'kh_question', '0');
INSERT INTO `cmt_task` VALUES ('7', '4', '00:00:00', 'kh_suggestion', '0');
INSERT INTO `cmt_task` VALUES ('8', '4', '00:00:00', 'kh_comments', '0');
INSERT INTO `cmt_task` VALUES ('9', '4', '00:00:00', 'xw_statistics', '0');
INSERT INTO `cmt_task` VALUES ('10', '0', '00:00:00', 'operate_log', '0');

-- ----------------------------
-- Table structure for `cmt_task_instance`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_task_instance`;
CREATE TABLE `cmt_task_instance` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `TaskID` int(11) DEFAULT NULL COMMENT 'ID，主键',
  `CreateTime` datetime NOT NULL COMMENT '任务创建时间',
  `EndTime` datetime NOT NULL COMMENT '任务截止时间，在截止时间内有效。',
  `FinishTime` datetime NOT NULL COMMENT '任务完成时间(邮件发送时间)',
  `MailDataID` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '对应邮件数据oam_mail_data的NoID',
  `FilePath` varchar(100) DEFAULT NULL COMMENT '文件路径',
  `TransType` int(11) DEFAULT NULL COMMENT '传输方式(比特表示)：1-USB 2-4G 4-ATG 8-Ku 16-TWLU',
  `TaskMode` int(11) NOT NULL COMMENT '任务模式：0-自动,1-手动',
  `Descs` varchar(256) NOT NULL COMMENT '任务实例描述，用于记录操作结果',
  `Status` int(11) DEFAULT '0' COMMENT '任务状态：0-初始化 1-正在导出数据 2-导出成功，等待发送 3-导出失败，等待重试 4-发送成功 5-发送失败',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=374 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC COMMENT='任务实例';

-- ----------------------------
-- Records of cmt_task_instance
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_thirdparty_manager`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_thirdparty_manager`;
CREATE TABLE `cmt_thirdparty_manager` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '包名',
  `version` varchar(100) DEFAULT NULL COMMENT '版本信息',
  `appid` varchar(100) DEFAULT NULL COMMENT '唯一标示app的id',
  `description` text COMMENT '更新包说明',
  `partnum` varchar(100) DEFAULT NULL COMMENT '件号',
  `md5` varchar(100) DEFAULT NULL COMMENT 'app包的md5值',
  `status` int(11) DEFAULT '0' COMMENT '当前app的更新状态',
  `time` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=114 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_thirdparty_manager
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_va`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_va`;
CREATE TABLE `cmt_va` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL COMMENT '名称，如 安全通知 等',
  `language_id` smallint(6) NOT NULL COMMENT '语言id',
  `order` int(11) NOT NULL COMMENT '显示顺序',
  `duration` int(11) NOT NULL COMMENT '时长，单位秒',
  `create_at` int(11) NOT NULL COMMENT '创建时间',
  `filename` varchar(200) NOT NULL COMMENT '文件名',
  `file_size` bigint(20) NOT NULL,
  `url` varchar(255) NOT NULL COMMENT '文件路径',
  `abs_path` varchar(255) NOT NULL,
  `is_mapping` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cmt_va
-- ----------------------------

-- ----------------------------
-- Table structure for `cmt_version`
-- ----------------------------
DROP TABLE IF EXISTS `cmt_version`;
CREATE TABLE `cmt_version` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID，主键',
  `DevType` smallint(6) NOT NULL COMMENT '设备类型',
  `DevPosition` varchar(24) NOT NULL COMMENT '设备位置',
  `DevNumber` varchar(24) NOT NULL COMMENT '设备件号',
  `CurVersion` varchar(64) NOT NULL COMMENT '当前软件版本',
  `CurSysVersion` varchar(64) NOT NULL COMMENT '当前系统版本',
  `CurAppVersion` varchar(64) NOT NULL COMMENT '当前应用版本',
  `CurConfVersion` varchar(64) NOT NULL,
  `PkgVersion` varchar(64) NOT NULL COMMENT '更新包软件版本',
  `PkgSysVersion` varchar(64) NOT NULL COMMENT '更新包系统版本',
  `PkgAppVersion` varchar(64) NOT NULL COMMENT '更新包应用版本',
  `PkgConfVersion` varchar(64) NOT NULL,
  `DevSeq` varchar(100) NOT NULL COMMENT '设备生产序列号',
  `DevModel` varchar(100) NOT NULL COMMENT '设备型号',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='版本信息';

-- ----------------------------
-- Records of cmt_version
-- ----------------------------

INSERT INTO `cmt_version` VALUES ('1', '4', '0-b', '830-600-001', ' SERVER_V.000.00.001.001-20170310', ' SERVER_SYSTEM_V.000.00.001.001-20170310', 'SERVER_APP_V.000.00.001.001-20170310', 'SERVER_CONF_V.000.00.001.001-20170310', '', '', '', '', '1314520', '02');
INSERT INTO `cmt_version` VALUES ('2', '15', '0-ap-1', '800-340-003', 'CAP_V.2.0.1-P-20140905', 'CAP_SYSTEM_V.2.0.1-P-20140905', 'CAP_APP_V.1.0.1-P-20140905', '', '', '', '', '', '', '');
INSERT INTO `cmt_version` VALUES ('3', '15', '0-ap-2', '800-340-003', 'CAP_V.2.0.1-P-20140905', 'CAP_SYSTEM_V.2.0.1-P-20140905', 'CAP_APP_V.1.0.1-P-20140905', '', '', '', '', '', '222', '');
INSERT INTO `cmt_version` VALUES ('4', '15', '0-ap-3', '800-340-003', 'CAP_V.2.0.1-P-20140905', 'CAP_SYSTEM_V.2.0.1-P-20140905', 'CAP_APP_V.1.0.1-P-20140905', '', '', '', '', '', '', '');


-- ----------------------------
-- Table structure for `hnair_number`
-- ----------------------------
DROP TABLE IF EXISTS `hnair_number`;
CREATE TABLE `hnair_number` (
  `userid` bigint(20) NOT NULL COMMENT '会员卡号',
  `used` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否使用',
  PRIMARY KEY (`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='海航临时会员卡号';

-- ----------------------------
-- Records of hnair_number
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_airplane`
-- ----------------------------
DROP TABLE IF EXISTS `oam_airplane`;
CREATE TABLE `oam_airplane` (
  `ID` smallint(6) NOT NULL AUTO_INCREMENT,
  `AircraftID` varchar(12) NOT NULL COMMENT '飞机序列号',
  `Manufacturer` varchar(12) DEFAULT NULL COMMENT '飞机制造商',
  `Type` varchar(8) NOT NULL COMMENT '飞机机型',
  `ManufactureDate` datetime DEFAULT NULL COMMENT '生产日期',
  `RegisterNation` varchar(4) DEFAULT NULL COMMENT '注册国籍(缩写)',
  `RegisterDate` datetime DEFAULT NULL COMMENT '注册日期',
  `RegisterNo` varchar(12) NOT NULL COMMENT '飞机注册号',
  `ProductNo` varchar(12) DEFAULT NULL COMMENT '系统型号，如：WiFi-1003',
  `ComponentNo` varchar(16) DEFAULT NULL COMMENT '头端服务器序列号',
  `ImagePath` varchar(128) DEFAULT NULL COMMENT '飞机图片位置信息',
  `Descs` varchar(1024) DEFAULT NULL COMMENT '飞机介绍信息',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='飞机信息';

-- ----------------------------
-- Records of oam_airplane
-- ----------------------------
INSERT INTO `oam_airplane` VALUES ('1', 'C6502', '波音', '737-800', '2013-11-20 09:00:00', '美国', '2014-01-01 10:00:00', '31', 'WiFi-1003', 'H201311200010', 'images/guohangplane.png', 'C6501是有美国波音公司生产的737-800系列大型客机，是各大航空公司的首选机型。');

-- ----------------------------
-- Table structure for `oam_alarmmessage`
-- ----------------------------
DROP TABLE IF EXISTS `oam_alarmmessage`;
CREATE TABLE `oam_alarmmessage` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '告警信息ID',
  `DeviceID` varchar(24) NOT NULL COMMENT '设备ID',
  `AlarmCSN` varchar(32) DEFAULT NULL COMMENT '告警CSN',
  `AlarmOccurTime` datetime NOT NULL COMMENT '告警发生时间',
  `AlarmID` int(11) DEFAULT NULL COMMENT '告警码',
  `AlarmCategory` smallint(6) NOT NULL COMMENT '告警分类，1：系统告警，2：数据库告警，3：网络告警， 4：处理错误告警，5：服务质量告警，6：环境告警',
  `AlarmLevel` smallint(6) NOT NULL COMMENT '告警级别，1：信息，2：警告，3：错误',
  `AlarmExtendInfo` varchar(512) DEFAULT NULL COMMENT '告警定位信息',
  `AlarmProbalCause` varchar(512) DEFAULT NULL COMMENT '告警产生原因',
  `AlarmAdditionalInfo` varchar(512) DEFAULT NULL COMMENT '告警附件信息',
  `CreateTime` datetime DEFAULT NULL COMMENT '告警记录时间',
  `ClearFlag` tinyint(4) unsigned NOT NULL DEFAULT '0' COMMENT '告警是否清除：0-未清除  1-清除',
  `ClearTime` datetime DEFAULT NULL COMMENT '告警清除时间',
  `ClearCause` varchar(512) DEFAULT NULL COMMENT '告警清除原因',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=721 DEFAULT CHARSET=utf8 COMMENT='告警信息';

-- ----------------------------
-- Records of oam_alarmmessage
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_application`
-- ----------------------------
DROP TABLE IF EXISTS `oam_application`;
CREATE TABLE `oam_application` (
  `ID` varchar(6) NOT NULL DEFAULT '' COMMENT '设备应用ID',
  `CategoryID` smallint(6) NOT NULL COMMENT '设备类别',
  `AppName` varchar(24) DEFAULT NULL COMMENT '应用程序名，操作系统也可作为一个特殊的应用',
  `Descs` varchar(128) DEFAULT NULL COMMENT '应用描述',
  `AppType` smallint(6) NOT NULL DEFAULT '1' COMMENT '应用类型：1-普通程序 2-操作系统 3-温度 4-AC',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设备应用';

-- ----------------------------
-- Records of oam_application
-- ----------------------------
INSERT INTO `oam_application` VALUES ('13-1', '13', 'AC', 'AC', '4');
INSERT INTO `oam_application` VALUES ('3-1', '3', 'CMA', 'CMA', '1');
INSERT INTO `oam_application` VALUES ('3-10', '3', 'OS', 'OS', '2');
INSERT INTO `oam_application` VALUES ('3-11', '3', 'Controller', 'Controller', '1');
INSERT INTO `oam_application` VALUES ('3-12', '3', 'Wistreamer', 'Wistreamer', '1');
INSERT INTO `oam_application` VALUES ('3-13', '3', 'CPUTMP', 'CPUTMP', '3');
INSERT INTO `oam_application` VALUES ('3-3', '3', 'Suu', 'Suu', '1');
INSERT INTO `oam_application` VALUES ('3-5', '3', '4G', '4G', '1');
INSERT INTO `oam_application` VALUES ('3-6', '3', 'Upgrade', 'Upgrade', '1');
INSERT INTO `oam_application` VALUES ('3-7', '3', 'Pcu', 'Pcu', '1');
INSERT INTO `oam_application` VALUES ('3-8', '3', 'Playsub', 'Playsub', '1');
INSERT INTO `oam_application` VALUES ('3-9', '3', 'Proxysyn', 'Proxysyn', '1');
INSERT INTO `oam_application` VALUES ('4-1', '4', 'CMD', 'CMD', '1');
INSERT INTO `oam_application` VALUES ('4-10', '4', 'Relay', 'Relay', '1');
INSERT INTO `oam_application` VALUES ('4-11', '4', 'OS', 'OS', '2');
INSERT INTO `oam_application` VALUES ('4-12', '4', 'CPUTMP', 'CPUTMP', '3');
INSERT INTO `oam_application` VALUES ('4-13', '4', 'CPE_Agent', 'cpe_agent', '1');
INSERT INTO `oam_application` VALUES ('4-2', '4', 'CMA', 'CMA', '1');
INSERT INTO `oam_application` VALUES ('4-4', '4', 'Suu', 'Suu', '1');
INSERT INTO `oam_application` VALUES ('4-5', '4', 'Proxydb', 'Proxydb', '1');
INSERT INTO `oam_application` VALUES ('4-7', '4', 'Arinc', 'Arinc', '1');
INSERT INTO `oam_application` VALUES ('4-8', '4', 'Seat', 'Seat', '1');
INSERT INTO `oam_application` VALUES ('4-9', '4', 'Live', 'Live', '1');
INSERT INTO `oam_application` VALUES ('14-1', '14', 'CPE', 'CPE', '2');
INSERT INTO `oam_application` VALUES ('15-0', '15', 'CAP', 'CAP', '2');
INSERT INTO `oam_application` VALUES ('15-1', '15', 'CAP', 'CAP', '2');
INSERT INTO `oam_application` VALUES ('15-2', '15', 'CAP', 'CAP', '2');
INSERT INTO `oam_application` VALUES ('15-3', '15', 'CAP', 'CAP', '2');

-- ----------------------------
-- Table structure for oam_appmap
-- ----------------------------
DROP TABLE IF EXISTS `oam_appmap`;
CREATE TABLE `oam_appmap` (
  `ID` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `paramId` varchar(255) NOT NULL,
  `appName` varchar(255) NOT NULL,
  `appType` int(5) unsigned NOT NULL,
  `descs` varchar(255) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oam_appmap
-- ----------------------------
INSERT INTO `oam_appmap` VALUES ('1', '3-1-1', 'CMA', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('2', '3-1-2', 'CMA', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('3', '3-3-1', 'Suu', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('4', '3-3-2', 'Suu', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('5', '3-5-1', '4G', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('6', '3-5-2', '4G', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('7', '3-6-1', 'Upgrade', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('8', '3-6-2', 'Upgrade', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('9', '3-7-1', 'Pcu', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('10', '3-7-2', 'Pcu', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('11', '3-8-1', 'Playsub', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('12', '3-8-2', 'Playsub', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('13', '3-9-1', 'Proxysyn', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('14', '3-9-2', 'Proxysyn', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('15', '3-10-3', 'OS', '2', '空闲CPU');
INSERT INTO `oam_appmap` VALUES ('16', '3-10-4', 'OS', '2', '总内存');
INSERT INTO `oam_appmap` VALUES ('17', '3-10-5', 'OS', '2', '空闲内存');
INSERT INTO `oam_appmap` VALUES ('18', '3-11-1', 'Controller', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('19', '3-11-2', 'Controller', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('20', '3-12-1', 'Wistreamer', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('21', '3-12-2', 'Wistreamer', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('22', '3-13-6', 'CPUTMP', '3', 'CPU温度');
INSERT INTO `oam_appmap` VALUES ('23', '3-13-7', 'CPUTMP', '3', '系统温度');
INSERT INTO `oam_appmap` VALUES ('24', '3-5-32', '4G', '1', '4G状态');
INSERT INTO `oam_appmap` VALUES ('25', '3-5-33', '4G', '1', 'WoW');
INSERT INTO `oam_appmap` VALUES ('26', '3-5-38', '4G', '1', '4G IP地址');
INSERT INTO `oam_appmap` VALUES ('27', '3-7-34', 'Pcu', '1', 'PA状态');
INSERT INTO `oam_appmap` VALUES ('28', '4-1-1', 'CMD', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('29', '4-1-2', 'CMD', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('30', '4-2-1', 'CMA', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('31', '4-2-2', 'CMA', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('32', '4-4-1', 'Suu', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('33', '4-4-2', 'Suu', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('34', '4-5-1', 'Proxydb', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('35', '4-5-2', 'Proxydb', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('36', '4-7-1', 'Arinc', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('37', '4-7-2', 'Arinc', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('38', '4-8-1', 'Seat', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('39', '4-8-2', 'Seat', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('40', '4-9-1', 'Live', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('41', '4-9-2', 'Live', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('42', '4-10-1', 'Relay', '1', '运行状态');
INSERT INTO `oam_appmap` VALUES ('43', '4-10-2', 'Relay', '1', '运行时间');
INSERT INTO `oam_appmap` VALUES ('44', '4-11-3', 'OS', '2', '空闲CPU');
INSERT INTO `oam_appmap` VALUES ('45', '4-11-4', 'OS', '2', '总内存');
INSERT INTO `oam_appmap` VALUES ('46', '4-11-5', 'OS', '2', '空闲内存');
INSERT INTO `oam_appmap` VALUES ('47', '4-12-6', 'CPUTMP', '3', 'CPU温度');
INSERT INTO `oam_appmap` VALUES ('48', '4-12-7', 'CPUTMP', '3', '系统温度');
INSERT INTO `oam_appmap` VALUES ('49', '15-0-67', 'CAP', '2', '无线连接状态');
INSERT INTO `oam_appmap` VALUES ('50', '15-0-68', 'CAP', '2', '在线CAP在线人数总和');
INSERT INTO `oam_appmap` VALUES ('51', '15-0-72', 'CAP', '2', '在线CAP接收流量总和');
INSERT INTO `oam_appmap` VALUES ('52', '15-0-76', 'CAP', '2', '在线CAP发送流量总和');
INSERT INTO `oam_appmap` VALUES ('53', '15-3-64', 'CAP', '2', '软件版本');
INSERT INTO `oam_appmap` VALUES ('54', '15-3-65', 'CAP', '2', '2.4G的SSID');
INSERT INTO `oam_appmap` VALUES ('55', '15-3-66', 'CAP', '2', '5G的SSID');
INSERT INTO `oam_appmap` VALUES ('56', '15-3-67', 'CAP', '2', '无线连接状态');
INSERT INTO `oam_appmap` VALUES ('57', '15-3-69', 'CAP', '2', 'CAP在线人数');
INSERT INTO `oam_appmap` VALUES ('58', '15-3-70', 'CAP', '2', 'CAP 2.4G频段在线人数');
INSERT INTO `oam_appmap` VALUES ('59', '15-3-71', 'CAP', '2', 'CAP 5G频段在线人数');
INSERT INTO `oam_appmap` VALUES ('60', '15-3-73', 'CAP', '2', 'CAP接收流量');
INSERT INTO `oam_appmap` VALUES ('61', '15-3-74', 'CAP', '2', 'CAP 2.4G频段接收流量');
INSERT INTO `oam_appmap` VALUES ('62', '15-3-75', 'CAP', '2', 'CAP 5G频段接收流量');
INSERT INTO `oam_appmap` VALUES ('63', '15-3-77', 'CAP', '2', 'CAP发送流量');
INSERT INTO `oam_appmap` VALUES ('64', '15-3-78', 'CAP', '2', 'CAP 2.4G频段发送流量');
INSERT INTO `oam_appmap` VALUES ('65', '15-3-79', 'CAP', '2', 'CAP 5G频段发送流量');

-- ----------------------------
-- Table structure for oam_apstatus
-- ----------------------------
DROP TABLE IF EXISTS `oam_apstatus`;
CREATE TABLE `oam_apstatus` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID,主键',
  `Name` char(6) NOT NULL COMMENT 'AP名称',
  `Descs` varchar(64) DEFAULT NULL COMMENT 'AP描述(AC中对应的AP信息)',
  `NodeID` int(11) unsigned DEFAULT NULL COMMENT '节点编号',
  `PositionID` smallint(5) unsigned NOT NULL COMMENT '位置编号',
  `IPAddress` varchar(32) DEFAULT NULL COMMENT 'IP地址',
  `Mac` varchar(24) NOT NULL COMMENT 'Mac地址(AP)',
  `UpTime` varchar(64) DEFAULT NULL COMMENT '上线时间',
  `AlarmState` smallint(6) DEFAULT '1' COMMENT '告警状态：0-告警  1-无告警',
  `OperationalState` smallint(6) DEFAULT '2' COMMENT '可操作状态：1-启用 2-禁用',
  `AvailStatus` smallint(6) DEFAULT '2' COMMENT '可接入状态：3-可接入 2-禁止接入',
  `CreateTime` datetime DEFAULT NULL COMMENT '自检时间',
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Name` (`Name`),
  UNIQUE KEY `PositionID` (`PositionID`),
  UNIQUE KEY `Mac` (`Mac`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='AP状态信息';

-- ----------------------------
-- Records of oam_apstatus
-- ----------------------------
INSERT INTO `oam_apstatus` VALUES ('1', 'CAP-1', null, null, '1', '192.168.2.21', '00:00:00:00:00:01', null, '1', '2', '2', null);
INSERT INTO `oam_apstatus` VALUES ('2', 'CAP-2', null, null, '2', '192.168.2.22', '00:00:00:00:00:02', null, '1', '2', '2', null);
INSERT INTO `oam_apstatus` VALUES ('3', 'CAP-3', null, null, '3', '192.168.2.23', '00:00:00:00:00:03', null, '1', '2', '2', null);

-- ----------------------------
-- Table structure for `oam_biteparam`
-- ----------------------------
DROP TABLE IF EXISTS `oam_biteparam`;
CREATE TABLE `oam_biteparam` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID标识',
  `DevType` smallint(6) NOT NULL COMMENT '设备类型，关联到DeviceCategory表',
  `BiteTime` datetime NOT NULL COMMENT '设备最后一次自检时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='设备自检索引表，自检信息存放在表BITEParamValue，根据时间进行关联';

-- ----------------------------
-- Records of oam_biteparam
-- ----------------------------
INSERT INTO `oam_biteparam` VALUES ('1', '13', '2014-03-12 13:46:33');

-- ----------------------------
-- Table structure for `oam_biteparamvalue`
-- ----------------------------
DROP TABLE IF EXISTS `oam_biteparamvalue`;
CREATE TABLE `oam_biteparamvalue` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID,主键',
  `ParamID` varchar(8) NOT NULL COMMENT '自检参数ID，关联到MonitorParam表中的ID',
  `DeviceID` varchar(24) NOT NULL COMMENT '设备ID，关联到Device表中的DevID',
  `CreateTime` datetime NOT NULL COMMENT '自检时间，根据时间进行关联表BITEParam中的BiteTime字段',
  `ParamValue` varchar(64) DEFAULT NULL COMMENT '自检信息值，存放自检参数的数值',
  `SerialNumber` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '记录流水号(插入时为0，每次更新时加1)',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=utf8 COMMENT='设备自检信息值表，存放自检信息产生的数值，根据时间进行关联表BITEParam中的BiteTime字段';

-- ----------------------------
-- Records of oam_biteparamvalue
-- ----------------------------
INSERT INTO `oam_biteparamvalue` VALUES ('1', '3-1-1', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '1', '1');
INSERT INTO `oam_biteparamvalue` VALUES ('2', '3-1-2', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '170879', '2');
INSERT INTO `oam_biteparamvalue` VALUES ('3', '3-11-1', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '1', '3');
INSERT INTO `oam_biteparamvalue` VALUES ('4', '3-11-2', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '170907', '4');
INSERT INTO `oam_biteparamvalue` VALUES ('5', '3-12-1', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '1', '5');
INSERT INTO `oam_biteparamvalue` VALUES ('6', '3-12-2', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '170878', '6');
INSERT INTO `oam_biteparamvalue` VALUES ('7', '3-3-1', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '1', '7');
INSERT INTO `oam_biteparamvalue` VALUES ('8', '3-3-2', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '170879', '8');
INSERT INTO `oam_biteparamvalue` VALUES ('9', '3-5-1', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '1', '9');
INSERT INTO `oam_biteparamvalue` VALUES ('10', '3-5-2', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '83268', '10');
INSERT INTO `oam_biteparamvalue` VALUES ('11', '3-6-1', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '1', '11');
INSERT INTO `oam_biteparamvalue` VALUES ('12', '3-6-2', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '170877', '12');
INSERT INTO `oam_biteparamvalue` VALUES ('13', '3-7-1', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '1', '13');
INSERT INTO `oam_biteparamvalue` VALUES ('14', '3-7-2', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '170880', '14');
INSERT INTO `oam_biteparamvalue` VALUES ('15', '3-8-1', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '1', '15');
INSERT INTO `oam_biteparamvalue` VALUES ('16', '3-8-2', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '170906', '16');
INSERT INTO `oam_biteparamvalue` VALUES ('17', '3-9-1', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '1', '17');
INSERT INTO `oam_biteparamvalue` VALUES ('18', '3-9-2', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '697', '18');
INSERT INTO `oam_biteparamvalue` VALUES ('19', '3-10-3', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '89', '19');
INSERT INTO `oam_biteparamvalue` VALUES ('20', '3-10-4', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '387328', '20');
INSERT INTO `oam_biteparamvalue` VALUES ('21', '3-10-5', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '73280', '21');
INSERT INTO `oam_biteparamvalue` VALUES ('22', '3-13-6', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '38', '22');
INSERT INTO `oam_biteparamvalue` VALUES ('23', '3-13-7', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '39', '23');
INSERT INTO `oam_biteparamvalue` VALUES ('24', '4-1-1', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '1', '24');
INSERT INTO `oam_biteparamvalue` VALUES ('25', '4-1-2', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '629', '25');
INSERT INTO `oam_biteparamvalue` VALUES ('26', '4-10-1', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '1', '26');
INSERT INTO `oam_biteparamvalue` VALUES ('27', '4-10-2', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '639', '27');
INSERT INTO `oam_biteparamvalue` VALUES ('28', '4-2-1', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '1', '28');
INSERT INTO `oam_biteparamvalue` VALUES ('29', '4-2-2', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '649', '29');
INSERT INTO `oam_biteparamvalue` VALUES ('30', '4-4-1', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '1', '30');
INSERT INTO `oam_biteparamvalue` VALUES ('31', '4-4-2', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '649', '31');
INSERT INTO `oam_biteparamvalue` VALUES ('32', '4-5-1', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '1', '32');
INSERT INTO `oam_biteparamvalue` VALUES ('33', '4-5-2', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '639', '33');
INSERT INTO `oam_biteparamvalue` VALUES ('34', '4-7-1', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '1', '34');
INSERT INTO `oam_biteparamvalue` VALUES ('35', '4-7-2', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '639', '35');
INSERT INTO `oam_biteparamvalue` VALUES ('36', '4-8-1', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '1', '36');
INSERT INTO `oam_biteparamvalue` VALUES ('37', '4-8-2', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '649', '37');
INSERT INTO `oam_biteparamvalue` VALUES ('38', '4-9-1', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '1', '38');
INSERT INTO `oam_biteparamvalue` VALUES ('39', '4-9-2', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '639', '39');
INSERT INTO `oam_biteparamvalue` VALUES ('40', '3-5-32', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '0', '40');
INSERT INTO `oam_biteparamvalue` VALUES ('41', '3-5-33', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '1', '41');
INSERT INTO `oam_biteparamvalue` VALUES ('42', '3-5-38', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', 'N/A', '42');
INSERT INTO `oam_biteparamvalue` VALUES ('43', '3-7-34', '00:16:e8:13:68:8a', '2016-12-16 11:17:43', '0', '43');
INSERT INTO `oam_biteparamvalue` VALUES ('44', '4-11-3', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '92', '45');
INSERT INTO `oam_biteparamvalue` VALUES ('45', '4-11-4', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '16545448', '45');
INSERT INTO `oam_biteparamvalue` VALUES ('46', '4-11-5', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '16124328', '46');
INSERT INTO `oam_biteparamvalue` VALUES ('47', '4-12-6', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '42', '47');
INSERT INTO `oam_biteparamvalue` VALUES ('48', '15-3-64', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '9.8.1.0.101', '47');
INSERT INTO `oam_biteparamvalue` VALUES ('49', '15-3-67', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '1', '48');
INSERT INTO `oam_biteparamvalue` VALUES ('50', '15-0-67', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '1', '49');
INSERT INTO `oam_biteparamvalue` VALUES ('51', '15-3-65', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '\"SW.RDT(down)-2.4G\",\"SW.RDT.Admin(down)-2.4G\"', '50');
INSERT INTO `oam_biteparamvalue` VALUES ('52', '15-3-66', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '\"SW.RDT(down)-5G\",\"SW.RDT(down).Admin-5G\"', '51');
INSERT INTO `oam_biteparamvalue` VALUES ('53', '15-3-69', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '1', '52');
INSERT INTO `oam_biteparamvalue` VALUES ('54', '15-3-70', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '1', '53');
INSERT INTO `oam_biteparamvalue` VALUES ('55', '15-3-71', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '0', '54');
INSERT INTO `oam_biteparamvalue` VALUES ('56', '15-3-73', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '1.03 MB', '55');
INSERT INTO `oam_biteparamvalue` VALUES ('57', '15-3-74', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '949.2 KB', '56');
INSERT INTO `oam_biteparamvalue` VALUES ('58', '15-3-75', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '109.7 KB', '57');
INSERT INTO `oam_biteparamvalue` VALUES ('59', '15-3-77', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '1.13 MB', '58');
INSERT INTO `oam_biteparamvalue` VALUES ('60', '15-3-78', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '1.08 MB', '59');
INSERT INTO `oam_biteparamvalue` VALUES ('61', '15-3-79', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '44.3 KB', '60');
INSERT INTO `oam_biteparamvalue` VALUES ('62', '15-0-68', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '1', '61');
INSERT INTO `oam_biteparamvalue` VALUES ('63', '15-0-72', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '1.03 MB', '62');
INSERT INTO `oam_biteparamvalue` VALUES ('64', '15-0-76', '6c:aa:b3:01:6c:70', '2016-12-16 11:20:14', '1.13 MB', '63');
INSERT INTO `oam_biteparamvalue` VALUES ('65', '4-12-7', '00:22:46:20:b7:3b', '2016-12-16 11:17:43', '48', '574');

-- ----------------------------
-- Table structure for `oam_calibrationconfig`
-- ----------------------------
DROP TABLE IF EXISTS `oam_calibrationconfig`;
CREATE TABLE `oam_calibrationconfig` (
  `CalibrationMode` char(1) DEFAULT NULL COMMENT '校准方式：1 - 自动(默认)，2 - 手动(暂不支持)',
  `Source` char(1) DEFAULT NULL COMMENT '校准源：0 - 地面中心GPS，1 - ARINC 429 (默认)。只有当校准方式为自动时，该字段才有意义。',
  `InitailTime` datetime DEFAULT NULL COMMENT '校准时系统本地初始时间，包含年月日时分秒微秒',
  `CalibrationTime` datetime DEFAULT NULL COMMENT '校准的系统时间，包含年月日时分秒微秒'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='时钟校准模式配置表';

-- ----------------------------
-- Records of oam_calibrationconfig
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_callservice`
-- ----------------------------
DROP TABLE IF EXISTS `oam_callservice`;
CREATE TABLE `oam_callservice` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FlightInfoID` int(11) NOT NULL COMMENT '航班信息ID',
  `Seat` varchar(20) NOT NULL COMMENT '座位号，关联cmt_seat(seat)',
  `CallTime` datetime DEFAULT NULL COMMENT '呼叫时间',
  `CallEvent` varchar(32) DEFAULT NULL COMMENT '呼叫事件',
  `Sync` char(1) DEFAULT NULL COMMENT '是否与地面中心同步：0 - 没同步，1 - 同步',
  `SyncTime` datetime DEFAULT NULL COMMENT '同步时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='乘客呼叫服务';

-- ----------------------------
-- Records of oam_callservice
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_content`
-- ----------------------------
DROP TABLE IF EXISTS `oam_content`;
CREATE TABLE `oam_content` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ContentName` varchar(64) DEFAULT NULL COMMENT '内容名称',
  `Religion` varchar(10) DEFAULT NULL COMMENT '宗教信仰相关：0 - 无宗教(数据类型待定，用位表示每种宗教还是其他)',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容表(仅为示意表)';

-- ----------------------------
-- Records of oam_content
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_contentgroup`
-- ----------------------------
DROP TABLE IF EXISTS `oam_contentgroup`;
CREATE TABLE `oam_contentgroup` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `ContentGroupName` varchar(16) DEFAULT NULL COMMENT '内容组别表，比如：VIP组，PG组，针对不同航空公司定义不同',
  `Descs` varchar(255) DEFAULT NULL COMMENT 'Descs 属于 内容组别表(这个是针对EPG定义)',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容组别表(这个是针对EPG定义)';

-- ----------------------------
-- Records of oam_contentgroup
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_contentgroupmember`
-- ----------------------------
DROP TABLE IF EXISTS `oam_contentgroupmember`;
CREATE TABLE `oam_contentgroupmember` (
  `ContentGroupID` int(11) DEFAULT NULL COMMENT 'refer to contentgroup(ID)',
  `ContentID` int(11) DEFAULT NULL COMMENT 'refer to content(ID)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='内容组成员(这个表是否存在，依赖于GMC制作内容而定义)';

-- ----------------------------
-- Records of oam_contentgroupmember
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_dashboard_info`
-- ----------------------------
DROP TABLE IF EXISTS `oam_dashboard_info`;
CREATE TABLE `oam_dashboard_info` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID,主键',
  `Name` varchar(64) NOT NULL COMMENT '参数名称',
  `Value` varchar(64) NOT NULL COMMENT '参数数值',
  `Available` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否存在该参数：0-Inavailable 1-Available',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT COMMENT='控制面板信息(包含舱门，PA，高度，速度，WIFI，4G，卫星，TWLU等)';

-- ----------------------------
-- Records of oam_dashboard_info
-- ----------------------------
INSERT INTO `oam_dashboard_info` VALUES ('1', 'Altitude', '45', '1');
INSERT INTO `oam_dashboard_info` VALUES ('2', 'AirSpeed', '200', '1');
INSERT INTO `oam_dashboard_info` VALUES ('3', 'Latitude', '120', '1');
INSERT INTO `oam_dashboard_info` VALUES ('4', 'Longitude', '80', '1');
INSERT INTO `oam_dashboard_info` VALUES ('5', 'UTCTime', '', '1');
INSERT INTO `oam_dashboard_info` VALUES ('6', 'Ground Speed', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('7', 'FlightNumber', '', '1');
INSERT INTO `oam_dashboard_info` VALUES ('8', 'OriginalCity', '2', '1');
INSERT INTO `oam_dashboard_info` VALUES ('9', 'DestinationCity', '', '1');
INSERT INTO `oam_dashboard_info` VALUES ('10', 'TAT', '', '1');
INSERT INTO `oam_dashboard_info` VALUES ('11', '4G', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('12', 'PA', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('13', 'WoW', '1', '1');
INSERT INTO `oam_dashboard_info` VALUES ('14', 'ATG', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('15', 'lET', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('16', 'rET', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('17', 'lCM', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('18', 'rCM', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('19', 'lCMO', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('20', 'rCMO', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('21', 'lEgNG', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('22', 'rEgNG', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('23', 'lEgLOP', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('24', 'rEgLOP', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('25', 'lEgLOT', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('26', 'rEgLOT', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('27', 'lEgPS', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('28', 'rEgPS', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('29', 'leftITT', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('30', 'rightITT', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('31', 'mHeading', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('32', 'fPAgl', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('33', 'pAtti', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('34', 'rAtti', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('35', 'bPRate', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('36', 'bRRate', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('37', 'bYRate', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('38', 'loAcce', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('39', 'laAcce', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('40', 'noAcce', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('41', 'pAlt', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('42', 'bCAlt', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('43', 'cASpeed', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('44', 'tATemp', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('45', 'sATemp', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('46', 'aRate', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('47', 'OnlineUsers', '20', '1');
INSERT INTO `oam_dashboard_info` VALUES ('48', 'WiFi', '1', '1');
INSERT INTO `oam_dashboard_info` VALUES ('49', 'VA', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('50', 'Door', '1', '1');
INSERT INTO `oam_dashboard_info` VALUES ('51', 'pa_open_time', '2016-07-11 11:11:39', '1');
INSERT INTO `oam_dashboard_info` VALUES ('52', 'pa_close_time', '2016-07-11 11:11:48', '1');
INSERT INTO `oam_dashboard_info` VALUES ('53', 'door_open_time', '2016-07-25 20:00:10', '1');
INSERT INTO `oam_dashboard_info` VALUES ('54', 'door_close_time', '2016-07-19 11:20:48', '1');
INSERT INTO `oam_dashboard_info` VALUES ('55', 'is_3g_available', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('56', '3g_signal_strength', '30', '1');
INSERT INTO `oam_dashboard_info` VALUES ('57', '3g_dail_result', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('58', 'Baro Corrected Altitude', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('59', 'Inertial Altitude', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('60', 'LAN', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('61', 'USB', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('62', 'WiFiSwitch', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('63', '4GSwitch', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('64', '4GNET', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('65', '4G1STA', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('66', '4G1NET', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('67', '4G1SIG', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('68', '4G1ERR', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('69', '4G1IP', 'N/A', '1');
INSERT INTO `oam_dashboard_info` VALUES ('70', '4G2STA', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('71', '4G2NET', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('72', '4G2SIG', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('73', '4G2ERR', '0', '1');
INSERT INTO `oam_dashboard_info` VALUES ('74', '4G2IP', 'N/A', '1');
-- ----------------------------
-- Table structure for `oam_device`
-- ----------------------------
DROP TABLE IF EXISTS `oam_device`;
CREATE TABLE `oam_device` (
  `DevID` varchar(24) NOT NULL DEFAULT '' COMMENT '设备ID，该表基于MAC地址保证记录的唯一性',
  `DevType` smallint(6) NOT NULL COMMENT '设备类型，0:all, 1:smartLCD, 2:SEB, 3:CMT, 4:server, 5:adb, 6:PCU, 7:SIC, 8:WEB PAGE, 9:AIRBORNE COUNT, 11:PDL, 12:ACU, 13:AC',
  `DevStatus` smallint(6) NOT NULL DEFAULT '3' COMMENT '设备状态，0-initializing , 1-registered , 2-proxied , 3-offine',
  `IPAddress` varchar(32) NOT NULL COMMENT 'IP地址，必须唯一',
  `RegisterDate` datetime DEFAULT NULL COMMENT '设备最后一次登记的时间',
  `RealCmty` varchar(24) NOT NULL COMMENT '实际团体名称，配置在各代理设备上',
  `DevPosition` varchar(24) DEFAULT NULL COMMENT '设备位置',
  `DevCategory` tinyint(4) NOT NULL DEFAULT '1' COMMENT '设备标记：0:static device, 1:dynamic device',
  PRIMARY KEY (`DevID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设备表';

-- ----------------------------
-- Records of oam_device
-- ----------------------------
INSERT INTO `oam_device` VALUES ('00:00:00:00:00:00', '15', '3', '192.168.2.21', '2016-07-22 09:15:24', 'public', '0-ap-1', '0');
INSERT INTO `oam_device` VALUES ('6c:aa:b3:01:b8:e0', '15', '3', '192.168.2.22', '2016-07-25 20:00:52', 'public', '0-ap-2', '0');
INSERT INTO `oam_device` VALUES ('6c:aa:b3:01:6c:70', '15', '2', '192.168.2.23', '2016-12-16 11:08:26', 'public', '0-ap-3', '0');
INSERT INTO `oam_device` VALUES ('00:22:46:20:b7:3b', '4', '2', '192.168.2.99', '2016-12-16 11:07:13', 'public', '0-b', '1');


-- ----------------------------
-- Table structure for `oam_devicecategory`
-- ----------------------------
DROP TABLE IF EXISTS `oam_devicecategory`;
CREATE TABLE `oam_devicecategory` (
  `ID` smallint(6) NOT NULL DEFAULT '0' COMMENT '设备类型ID',
  `AirplaneID` smallint(6) NOT NULL COMMENT '飞机ID，关联Airplane表中的ID',
  `Name` varchar(32) NOT NULL COMMENT '设备类型名称',
  `Type` tinyint(4) NOT NULL COMMENT '设备类型类别，0 - All, 1 - Server，2 - CMT， 3 - ADB， 4 - SEB， 5 - SmartLCD， 13 - Cap, 14 - 飞机交联',
  `Descs` varchar(256) DEFAULT NULL COMMENT '设备类型描述',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='设备类别表';

-- ----------------------------
-- Records of oam_devicecategory
-- ----------------------------
INSERT INTO `oam_devicecategory` VALUES ('0', '1', 'ALL', '0', '所有终端');
INSERT INTO `oam_devicecategory` VALUES ('1', '1', 'SmartLCD', '1', '智能终端(包括iPad，平板电脑，智能手机等)');
INSERT INTO `oam_devicecategory` VALUES ('2', '1', 'SEB', '2', '座位电子控制盒(Seat Electronic Box)');
INSERT INTO `oam_devicecategory` VALUES ('3', '1', 'CMT', '3', '客舱管理终端(Cabin Manager Terminal)');
INSERT INTO `oam_devicecategory` VALUES ('4', '1', 'Server', '4', 'Server');
INSERT INTO `oam_devicecategory` VALUES ('5', '1', 'ADB', '5', '区域分配盒(Area Distribution Box)');
INSERT INTO `oam_devicecategory` VALUES ('6', '1', 'PCU', '6', '旅客操作手柄(Passenger Control Unit)');
INSERT INTO `oam_devicecategory` VALUES ('7', '1', 'SIC', '7', 'SIC');
INSERT INTO `oam_devicecategory` VALUES ('8', '1', 'CMT PAGE', '8', '客舱管理网站应用');
INSERT INTO `oam_devicecategory` VALUES ('9', '1', 'AIRBRONE_COUNT', '9', '航空电子控制单元');
INSERT INTO `oam_devicecategory` VALUES ('10', '1', 'UNKNOWN', '10', '未知(预留)');
INSERT INTO `oam_devicecategory` VALUES ('11', '1', 'PDL', '11', '便携式内容装载机(Portable Data Loader)');
INSERT INTO `oam_devicecategory` VALUES ('12', '1', 'ACU', '12', '访问控制单元(Access Control Unit)');
INSERT INTO `oam_devicecategory` VALUES ('13', '1', 'APs', '13', '无线接入设备(Wireless Access Portals)');
INSERT INTO `oam_devicecategory` VALUES ('14', '1', 'CPE', '14', '客户终端设备（Customer Premise Equipment）');
INSERT INTO `oam_devicecategory` VALUES ('15', '1', 'CAP', '15', 'Cabin Access Point');

-- ----------------------------
-- Table structure for `oam_dinnerservice`
-- ----------------------------
DROP TABLE IF EXISTS `oam_dinnerservice`;
CREATE TABLE `oam_dinnerservice` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FlightNumber` varchar(32) DEFAULT NULL COMMENT '航班号',
  `Seat` varchar(20) DEFAULT NULL COMMENT '座位号,refer to cmt_seat(seat)',
  `DinnerTime` datetime DEFAULT NULL COMMENT '点餐时间',
  `DinnerContent` varchar(32) DEFAULT NULL COMMENT '点餐事件',
  `Sync` char(1) DEFAULT NULL COMMENT '是否与地面中心同步：0 - 没同步，1 - 同步',
  `SyncTime` datetime DEFAULT NULL COMMENT '同步时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='点餐服务';

-- ----------------------------
-- Records of oam_dinnerservice
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_flightinfo`
-- ----------------------------
DROP TABLE IF EXISTS `oam_flightinfo`;
CREATE TABLE `oam_flightinfo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `AirplaneID` smallint(6) NOT NULL DEFAULT '1' COMMENT '飞机ID',
  `AirlineID` varchar(10) DEFAULT NULL COMMENT '航空公司标识',
  `AircraftID` varchar(12) DEFAULT NULL COMMENT '飞机序列号',
  `AircraftType` char(4) DEFAULT NULL COMMENT '飞机类型',
  `AircraftTail` varchar(7) DEFAULT NULL COMMENT '飞机尾翼号',
  `FlightNumber` varchar(6) DEFAULT NULL COMMENT '航班号',
  `Origin` varchar(6) DEFAULT NULL COMMENT '出发地',
  `Destination` varchar(6) DEFAULT NULL COMMENT '目的地',
  `PlanDepartureTime` datetime DEFAULT NULL COMMENT '预计起飞时间',
  `PlanArrivalTime` datetime DEFAULT NULL COMMENT '预计到达时间',
  `ActualDepartureTime` datetime DEFAULT NULL COMMENT '实际起飞时间',
  `ActualArrivalTime` datetime DEFAULT NULL COMMENT '实际达到时间',
  `DestinationIntro` varchar(1024) DEFAULT NULL COMMENT '目的地介绍',
  `DiscountInfo` varchar(1024) DEFAULT NULL COMMENT '航班优惠信息',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='航班信息';

-- ----------------------------
-- Records of oam_flightinfo
-- ----------------------------
INSERT INTO `oam_flightinfo` VALUES ('1', '1', 'CA', 'C6501', '800', '737', 'CA1835', '北京', '上海虹桥', '2014-01-16 07:30:00', '2014-01-17 09:19:00', '2014-01-17 07:41:00', '2014-01-17 09:19:00', '上海是中国的国际化大都市，素有“魔都”之城，是中国的经济中心。', '');
INSERT INTO `oam_flightinfo` VALUES ('2', '1', 'CA', 'C6501', '800', '737', 'CA1835', '北京', '上海虹桥', '2014-01-17 08:00:00', '2014-01-17 09:51:00', '2014-01-17 08:06:00', '2014-01-17 09:46:00', '上海是中国的国际化大都市，素有“魔都”之城，是中国的经济中心。', null);
INSERT INTO `oam_flightinfo` VALUES ('3', '1', 'CA', 'C6501', '800', '737', 'CA1502', '北京', '上海虹桥', '2014-01-17 08:30:00', '2014-01-17 10:16:00', '2014-01-17 08:38:00', '2014-01-17 10:20:00', '上海是中国的国际化大都市，素有“魔都”之城，是中国的经济中心。', '');

-- ----------------------------
-- Table structure for `oam_flightinfodetail`
-- ----------------------------
DROP TABLE IF EXISTS `oam_flightinfodetail`;
CREATE TABLE `oam_flightinfodetail` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FlightInfoID` int(11) NOT NULL COMMENT '航班ID',
  `CreateDate` datetime DEFAULT NULL COMMENT '采集时间',
  `Latitude` decimal(10,2) DEFAULT NULL COMMENT '纬度',
  `Longitude` decimal(10,2) DEFAULT NULL COMMENT '经度',
  `BaroCorrected` decimal(10,2) DEFAULT NULL COMMENT '修正气压高度',
  `ComputedAirSpeed` decimal(10,2) DEFAULT NULL COMMENT '计算空速',
  `TrueAirSpeed` decimal(10,2) DEFAULT NULL COMMENT '真空速',
  `Mach` decimal(10,2) DEFAULT NULL COMMENT '马赫数',
  `TrueHeading` decimal(10,2) DEFAULT NULL COMMENT '真航向',
  `StaticAirTemp` decimal(10,2) DEFAULT NULL COMMENT '静态空气温度',
  `VerticalSpeed` decimal(10,2) DEFAULT NULL COMMENT '垂直速度',
  `DistanceToDestiation` decimal(10,2) DEFAULT NULL COMMENT '到达目的地距离',
  `TimeToDestiation` decimal(10,2) DEFAULT NULL COMMENT '到达目的地时间',
  `WindSpeed` decimal(10,2) DEFAULT NULL COMMENT '风速',
  `WindDirection` decimal(10,2) DEFAULT NULL COMMENT '风向',
  `OOOI` varchar(10) DEFAULT NULL COMMENT 'OOOI',
  `WOW` varchar(10) DEFAULT NULL COMMENT '空地信号',
  PRIMARY KEY (`ID`),
  KEY `FK_oam_flightinfodetail_oam_flightinfo` (`FlightInfoID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='航班信息详单';

-- ----------------------------
-- Records of oam_flightinfodetail
-- ----------------------------
INSERT INTO `oam_flightinfodetail` VALUES ('1', '1', '2014-01-17 07:45:29', '65.32', '245.01', '65.78', '96.58', '98.12', '4.20', '132.64', '1.20', '12.30', '741.00', '3650.00', '8.20', '124.36', '离地', '正常');
INSERT INTO `oam_flightinfodetail` VALUES ('2', '1', '2014-01-17 07:45:36', '65.30', '246.23', '65.78', '96.58', '98.12', '4.20', '132.64', '1.20', '12.30', '721.34', '3550.00', '8.20', '124.36', '离地', '正常');

-- ----------------------------
-- Table structure for `oam_flightreligion`
-- ----------------------------
DROP TABLE IF EXISTS `oam_flightreligion`;
CREATE TABLE `oam_flightreligion` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `FlightNumber` varchar(32) DEFAULT NULL COMMENT '航班号，同FlightInfo，导入航班信息时，同时导入该表，由空乘填写是否存在宗教限制',
  `Religion` varchar(10) DEFAULT NULL COMMENT '宗教限制：0 - 无限制(默认)',
  `Descs` varchar(255) DEFAULT NULL COMMENT '描述',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='航班宗教';

-- ----------------------------
-- Records of oam_flightreligion
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_ftp_info`
-- ----------------------------
DROP TABLE IF EXISTS `oam_ftp_info`;
CREATE TABLE `oam_ftp_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(100) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `passwd` varchar(50) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of oam_ftp_info
-- ----------------------------
INSERT INTO `oam_ftp_info` VALUES ('1', 'ftp://192.168.2.2/update', 'avod', '123456', '1');
INSERT INTO `oam_ftp_info` VALUES ('2', '', '', '', '4');
INSERT INTO `oam_ftp_info` VALUES ('3', '', '', '', '19');

-- ----------------------------
-- Table structure for `oam_harddiskparam`
-- ----------------------------
DROP TABLE IF EXISTS `oam_harddiskparam`;
CREATE TABLE `oam_harddiskparam` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `DevID` varchar(24) NOT NULL COMMENT '设备ID，MAC地址，必须唯一',
  `Partion` varchar(128) DEFAULT NULL COMMENT '硬盘分区',
  `DiskTotal` varchar(32) DEFAULT NULL COMMENT '分区总容量(KB)',
  `DiskUsed` varchar(32) DEFAULT NULL COMMENT '分区已使用容量(KB)',
  `DiskAvail` varchar(32) DEFAULT NULL COMMENT '分区有效容量(KB)',
  `DiskPercent` varchar(24) DEFAULT NULL COMMENT '分区已使用容量百分比(%)',
  `CreateTime` datetime DEFAULT NULL COMMENT '自检时间，关联BiteParam表中的BiteTime字段',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=60304 DEFAULT CHARSET=utf8 COMMENT='磁盘监控';

-- ----------------------------
-- Records of oam_harddiskparam
-- ----------------------------
INSERT INTO `oam_harddiskparam` VALUES ('60292', '00:22:46:20:b7:3b', '/', '9142288', '3344260', '5326124', '39', '2016-12-16 11:17:43');
INSERT INTO `oam_harddiskparam` VALUES ('60293', '00:22:46:20:b7:3b', '/opt', '3773656', '773408', '2805460', '22', '2016-12-16 11:17:43');
INSERT INTO `oam_harddiskparam` VALUES ('60294', '00:22:46:20:b7:3b', '/boot', '194442', '11625', '172778', '6', '2016-12-16 11:17:43');
INSERT INTO `oam_harddiskparam` VALUES ('60295', '00:22:46:20:b7:3b', '/dev/shm', '8272724', '4', '8272720', '0', '2016-12-16 11:17:43');
INSERT INTO `oam_harddiskparam` VALUES ('60296', '00:22:46:20:b7:3b', '/usr/donica/update', '41508368', '1310104', '38089736', '3', '2016-12-16 11:17:43');
INSERT INTO `oam_harddiskparam` VALUES ('60297', '00:22:46:20:b7:3b', '/opt/lampp/htdocs/files/program0', '489242424', '217676', '464172596', '0', '2016-12-16 11:17:43');
INSERT INTO `oam_harddiskparam` VALUES ('60298', '00:22:46:20:b7:3b', '/opt/lampp/htdocs/epg', '20762196', '263280', '19444252', '1', '2016-12-16 11:17:43');
INSERT INTO `oam_harddiskparam` VALUES ('60299', '00:16:e8:13:68:8a', '/tmp', '193664', '1440', '192224', '1', '2016-12-16 11:17:43');
INSERT INTO `oam_harddiskparam` VALUES ('60300', '00:16:e8:13:68:8a', '/tmp/sda2', '15749532', '1340228', '13609256', '9', '2016-12-16 11:17:43');
INSERT INTO `oam_harddiskparam` VALUES ('60301', '00:16:e8:13:68:8a', '/tmp/sda3', '45758488', '197004', '43237056', '0', '2016-12-16 11:17:43');
INSERT INTO `oam_harddiskparam` VALUES ('60302', '00:16:e8:13:68:8a', '/tango', '56765', '5283', '48551', '10', '2016-12-16 11:17:43');
INSERT INTO `oam_harddiskparam` VALUES ('60303', '00:16:e8:13:68:8a', '/tmp/sdb1', '7664640', '1576596', '6088044', '21', '2016-12-16 11:17:43');

-- ----------------------------
-- Table structure for `oam_mail_data`
-- ----------------------------
DROP TABLE IF EXISTS `oam_mail_data`;
CREATE TABLE `oam_mail_data` (
  `NoID` int(11) NOT NULL AUTO_INCREMENT COMMENT '主键',
  `Data` longblob NOT NULL COMMENT '附件二进制数据',
  `Len` int(11) NOT NULL COMMENT '附件文件大小',
  `RecvID` varchar(50) NOT NULL COMMENT '收件人',
  `SendID` varchar(50) NOT NULL COMMENT '发件人',
  `MailType` varchar(20) NOT NULL COMMENT '邮件模板类型',
  `BuildTime` int(11) NOT NULL COMMENT '创建时间',
  `MailState` char(1) NOT NULL DEFAULT '0' COMMENT '邮件状态',
  `SynTime` int(11) NOT NULL COMMENT '状态更新时间',
  `MailBeginTime` int(11) DEFAULT NULL COMMENT '开始时间(用于替换主题、正文中的变量)',
  `MailEndTime` int(11) DEFAULT NULL COMMENT '结束时间(用于替换主题、正文中的变量)',
  PRIMARY KEY (`NoID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='邮件数据';

-- ----------------------------
-- Records of oam_mail_data
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_mail_info`
-- ----------------------------
DROP TABLE IF EXISTS `oam_mail_info`;
CREATE TABLE `oam_mail_info` (
  `MailType` varchar(50) NOT NULL,
  `UserID` varchar(50) NOT NULL,
  `Subject` varchar(200) NOT NULL,
  `Context` text NOT NULL,
  PRIMARY KEY (`MailType`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='收件人邮箱配置';

-- ----------------------------
-- Records of oam_mail_info
-- ----------------------------
INSERT INTO `oam_mail_info` (`MailType`, `UserID`, `Subject`, `Context`) VALUES
('export_log', 'techsupports@donica.com', 'WiFi-6000的系统日志', '${receiver_email}：\r\n飞机[${system_id}]的运行日志文件包含五方面日志：\r\n1.系统运行记录信息\r\n2.系统告警信息\r\n3.应用程序状态信息\r\n4.系统诊断信息\r\n5.硬盘信息\r\n--------------------------------------\r\n${send_time}\r\n深圳市多尼卡电子技术有限公司\r\n深圳市南山区智恒产业园1栋5楼\r\n邮编：518057\r\n电话：+86-755-26983727\r\n传真：+86-755-26013757\r\n邮箱：techsupports@donica.com\r\n主页：www.donica.com'),
('ca_log', 'techsupports@donica.com', 'WiFi-6000的系统日志([${start_time}] ~ [${end_time}])', '${receiver_email}：\r\n飞机[${system_id}]的运行日志文件包含五方面日志：\r\n1.系统运行记录信息\r\n2.系统告警信息\r\n3.应用程序状态信息\r\n4.系统诊断信息\r\n5.硬盘信息\r\n--------------------------------------\r\n${send_time}\r\n深圳市多尼卡电子技术有限公司\r\n深圳市南山区智恒产业园1栋5楼\r\n邮编：518057\r\n电话：+86-755-26983727\r\n传真：+86-755-26013757\r\n邮箱：techsupports@donica.com\r\n主页：www.donica.com');

-- ----------------------------
-- Table structure for `oam_mail_user`
-- ----------------------------
DROP TABLE IF EXISTS `oam_mail_user`;
CREATE TABLE `oam_mail_user` (
  `UserID` varchar(100) NOT NULL COMMENT '用户邮箱',
  `Pwd` varchar(100) NOT NULL COMMENT '密码',
  `SmtpSvr` varchar(200) NOT NULL COMMENT 'SMTP服务器',
  `Port` varchar(10) NOT NULL COMMENT 'SMTP端口',
  PRIMARY KEY (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='发件人邮箱配置';

-- ----------------------------
-- Records of oam_mail_user
-- ----------------------------
INSERT INTO `oam_mail_user` VALUES ('techsupports@donica.com', 'Donica@26983727', '123.125.50.210', '25');

-- ----------------------------
-- Table structure for `oam_monitorparam`
-- ----------------------------
DROP TABLE IF EXISTS `oam_monitorparam`;
CREATE TABLE `oam_monitorparam` (
  `ID` varchar(8) NOT NULL DEFAULT '' COMMENT 'ID标识',
  `ApplicationID` varchar(6) NOT NULL COMMENT '应用ID，表示设备类别标示符，格式(xx-yy，其中xx：设备类型，yy：应用类型)',
  `ParamType` smallint(5) unsigned NOT NULL COMMENT '参数类型，关联ParamType表中的ID',
  `OID` varchar(64) NOT NULL COMMENT 'OID，表示SNMP查询使用的参数',
  `GroupID` smallint(11) NOT NULL COMMENT '参数组： 0-应用程序 1-系统参数 2-AC参数 3-飞机信号',
  `DisplayName` varchar(64) DEFAULT NULL COMMENT '显示名称',
  `Descs` varchar(255) DEFAULT NULL COMMENT '参数描述',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='监控参数';

-- ----------------------------
-- Records of oam_monitorparam
-- ----------------------------
INSERT INTO `oam_monitorparam` VALUES ('13-1-10', '13-1', '10', '.1.3.6.1.4.1.15983.1.1.3.1.13.3.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-11', '13-1', '11', '.1.3.6.1.4.1.15983.1.1.3.1.13.4.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-12', '13-1', '12', '.1.3.6.1.4.1.15983.1.1.3.1.13.5.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-13', '13-1', '13', '.1.3.6.1.4.1.15983.1.1.3.1.13.6.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-14', '13-1', '14', '.1.3.6.1.4.1.15983.1.1.3.1.13.7.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-15', '13-1', '15', '.1.3.6.1.4.1.15983.1.1.3.1.13.8.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-16', '13-1', '16', '.1.3.6.1.4.1.15983.1.1.3.1.13.9.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-17', '13-1', '17', '.1.3.6.1.4.1.15983.1.1.3.1.13.10.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-18', '13-1', '18', '.1.3.6.1.4.1.15983.1.1.3.1.13.11.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-19', '13-1', '19', '.1.3.6.1.4.1.15983.1.1.3.1.13.12.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-20', '13-1', '20', '.1.3.6.1.4.1.15983.1.1.3.1.13.13.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-21', '13-1', '21', '.1.3.6.1.4.1.15983.1.1.3.1.13.14.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-22', '13-1', '22', '.1.3.6.1.4.1.15983.1.1.3.1.13.15.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-23', '13-1', '23', '.1.3.6.1.4.1.15983.1.1.3.1.13.16.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-24', '13-1', '24', '.1.3.6.1.4.1.15983.1.1.3.1.13.17.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-25', '13-1', '25', '.1.3.6.1.4.1.15983.1.1.3.1.13.18.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-26', '13-1', '26', '.1.3.6.1.4.1.15983.1.1.3.1.13.19.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-27', '13-1', '27', '.1.3.6.1.4.1.15983.1.1.3.1.13.20.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-28', '13-1', '28', '.1.3.6.1.4.1.15983.1.1.3.1.13.21.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-29', '13-1', '29', '.1.3.6.1.4.1.15983.1.1.3.1.13.22.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-30', '13-1', '30', '.1.3.6.1.4.1.15983.1.1.3.1.13.23.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-31', '13-1', '31', '.1.3.6.1.4.1.15983.1.1.3.1.13.24.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-35', '13-1', '35', '.1.3.6.1.4.1.15983.1.1.3.1.16.5.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-36', '13-1', '36', '.1.3.6.1.4.1.15983.1.1.3.1.16.6.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-8', '13-1', '8', '.1.3.6.1.4.1.15983.1.1.3.1.13.1.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('13-1-9', '13-1', '9', '.1.3.6.1.4.1.15983.1.1.3.1.13.2.0', '4', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-1-1', '3-1', '1', '.1.3.6.1.4.1.654.3.30.1.2.2.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-1-2', '3-1', '2', '.1.3.6.1.4.1.654.3.30.1.2.2.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-10-3', '3-10', '3', '.1.3.6.1.4.1.2021.11.11.0', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-10-4', '3-10', '4', '.1.3.6.1.4.1.2021.4.5.0', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-10-5', '3-10', '5', '.1.3.6.1.4.1.2021.4.6.0', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-11-1', '3-11', '1', '.1.3.6.1.4.1.654.3.30.1.2.13.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-11-2', '3-11', '2', '.1.3.6.1.4.1.654.3.30.1.2.13.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-12-1', '3-12', '1', '.1.3.6.1.4.1.654.3.30.1.2.14.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-12-2', '3-12', '2', '.1.3.6.1.4.1.654.3.30.1.2.14.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-13-6', '3-13', '6', '.1.3.6.1.4.1.654.3.30.1.2.15.2.0', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-13-7', '3-13', '7', '.1.3.6.1.4.1.654.3.30.1.2.15.1.0', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-3-1', '3-3', '1', '.1.3.6.1.4.1.654.3.30.1.2.4.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-3-2', '3-3', '2', '.1.3.6.1.4.1.654.3.30.1.2.4.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-5-1', '3-5', '1', '.1.3.6.1.4.1.654.3.30.1.2.7.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-5-2', '3-5', '2', '.1.3.6.1.4.1.654.3.30.1.2.7.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-6-1', '3-6', '1', '.1.3.6.1.4.1.654.3.30.1.2.8.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-6-2', '3-6', '2', '.1.3.6.1.4.1.654.3.30.1.2.8.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-7-1', '3-7', '1', '.1.3.6.1.4.1.654.3.30.1.2.9.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-7-2', '3-7', '2', '.1.3.6.1.4.1.654.3.30.1.2.9.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-8-1', '3-8', '1', '.1.3.6.1.4.1.654.3.30.1.2.10.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-8-2', '3-8', '2', '.1.3.6.1.4.1.654.3.30.1.2.10.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-9-1', '3-9', '1', '.1.3.6.1.4.1.654.3.30.1.2.11.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('3-9-2', '3-9', '2', '.1.3.6.1.4.1.654.3.30.1.2.11.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-1-1', '4-1', '1', '.1.3.6.1.4.1.654.3.20.1.3.2.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-1-2', '4-1', '2', '.1.3.6.1.4.1.654.3.20.1.3.2.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-11-3', '4-11', '3', '.1.3.6.1.4.1.2021.11.11.0', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-11-4', '4-11', '4', '.1.3.6.1.4.1.2021.4.5.0', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-11-5', '4-11', '5', '.1.3.6.1.4.1.2021.4.6.0', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-12-6', '4-12', '6', '.1.3.6.1.4.1.654.3.20.1.3.12.1.0', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-12-7', '4-12', '7', '.1.3.6.1.4.1.654.3.20.1.3.12.2.0', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-1', '4-2', '1', '.1.3.6.1.4.1.654.3.20.1.3.3.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-2', '4-2', '2', '.1.3.6.1.4.1.654.3.20.1.3.3.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-4-1', '4-4', '1', '.1.3.6.1.4.1.654.3.20.1.3.5.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-4-2', '4-4', '2', '.1.3.6.1.4.1.654.3.20.1.3.5.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-80', '4-2', '80', '.1.3.6.1.4.1.654.3.20.1.3.13.1.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-81', '4-2', '81', '.1.3.6.1.4.1.654.3.20.1.3.13.2.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-82', '4-2', '82', '.1.3.6.1.4.1.654.3.20.1.3.13.3.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-83', '4-2', '83', '.1.3.6.1.4.1.654.3.20.1.3.13.4.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-84', '4-2', '84', '.1.3.6.1.4.1.654.3.20.1.3.13.5.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-85', '4-2', '85', '.1.3.6.1.4.1.654.3.20.1.3.14.1.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-86', '4-2', '86', '.1.3.6.1.4.1.654.3.20.1.3.14.2.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-87', '4-2', '87', '.1.3.6.1.4.1.654.3.20.1.3.14.3.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-88', '4-2', '88', '.1.3.6.1.4.1.654.3.20.1.3.14.5.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-89', '4-2', '89', '.1.3.6.1.4.1.654.3.20.1.3.14.4.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-90', '4-2', '90', '.1.3.6.1.4.1.654.3.20.1.3.14.6.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-91', '4-2', '91', '.1.3.6.1.4.1.654.3.20.1.3.14.7.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-92', '4-2', '92', '.1.3.6.1.4.1.654.3.20.1.3.14.9.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-93', '4-2', '93', '.1.3.6.1.4.1.654.3.20.1.3.14.8.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-94', '4-2', '94', '.1.3.6.1.4.1.654.3.20.1.3.14.10.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-95', '4-2', '95', '.1.3.6.1.4.1.654.3.20.1.3.14.11.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-2-96', '4-2', '96', '.1.3.6.1.4.1.654.3.20.1.3.14.12.0', '8', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-7-1', '4-7', '1', '.1.3.6.1.4.1.654.3.20.1.3.8.1.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('4-7-2', '4-7', '2', '.1.3.6.1.4.1.654.3.20.1.3.8.2.0', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-39', '14-1', '39', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-40', '14-1', '40', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-41', '14-1', '41', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-42', '14-1', '42', '', '128', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-43', '14-1', '43', '', '128', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-44', '14-1', '44', '', '128', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-45', '14-1', '45', '', '128', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-46', '14-1', '46', '', '128', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-47', '14-1', '47', '', '128', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-48', '14-1', '48', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-49', '14-1', '49', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-50', '14-1', '50', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-51', '14-1', '51', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-52', '14-1', '52', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-53', '14-1', '53', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-54', '14-1', '54', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-55', '14-1', '55', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-56', '14-1', '56', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-57', '14-1', '57', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-58', '14-1', '58', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-59', '14-1', '59', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('14-1-60', '14-1', '60', '', '1', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-65', '15-1', '65', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-66', '15-1', '66', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-65', '15-2', '65', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-65', '15-3', '65', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-66', '15-2', '66', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-66', '15-3', '66', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-67', '15-1', '67', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-67', '15-2', '67', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-67', '15-3', '67', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-69', '15-1', '69', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-69', '15-2', '69', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-69', '15-3', '69', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-70', '15-1', '70', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-70', '15-2', '70', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-70', '15-3', '70', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-71', '15-1', '71', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-71', '15-2', '71', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-71', '15-3', '71', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-73', '15-1', '73', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-73', '15-2', '73', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-73', '15-3', '73', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-74', '15-1', '74', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-74', '15-2', '74', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-74', '15-3', '74', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-75', '15-1', '75', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-75', '15-2', '75', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-75', '15-3', '75', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-77', '15-1', '77', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-77', '15-2', '77', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-77', '15-3', '77', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-78', '15-1', '78', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-78', '15-2', '78', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-78', '15-3', '78', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-1-79', '15-1', '79', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-2-79', '15-2', '79', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-3-79', '15-3', '79', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-0-67', '15-0', '67', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-0-68', '15-0', '68', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-0-72', '15-0', '72', '', '2', '', '');
INSERT INTO `oam_monitorparam` VALUES ('15-0-76', '15-0', '76', '', '2', '', '');

-- ----------------------------
-- Table structure for `oam_monitorparamvalue`
-- ----------------------------
DROP TABLE IF EXISTS `oam_monitorparamvalue`;
CREATE TABLE `oam_monitorparamvalue` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'ID,主键',
  `ParamID` varchar(8) NOT NULL COMMENT '监控参数ID，格式为(xx-yy-zz xx表示设备分类 yy表示应用ID zz表示应用参数ID)',
  `DeviceID` varchar(24) NOT NULL COMMENT '设备ID，MAC Address',
  `CreateTime` datetime NOT NULL COMMENT '监控数值产生时间',
  `ParamValue` varchar(64) DEFAULT NULL COMMENT '监控参数数值',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=utf8 COMMENT='监控参数值';

-- ----------------------------
-- Records of oam_monitorparamvalue
-- ----------------------------

INSERT INTO `oam_monitorparamvalue` VALUES ('1', '3-1-1', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('2', '3-1-2', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '742');
INSERT INTO `oam_monitorparamvalue` VALUES ('3', '3-3-1', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('4', '3-3-2', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '742');
INSERT INTO `oam_monitorparamvalue` VALUES ('5', '3-5-1', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('6', '3-5-2', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '762');
INSERT INTO `oam_monitorparamvalue` VALUES ('7', '3-6-1', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('8', '3-6-2', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '742');
INSERT INTO `oam_monitorparamvalue` VALUES ('9', '3-7-1', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('10', '3-7-2', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '742');
INSERT INTO `oam_monitorparamvalue` VALUES ('11', '3-8-1', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('12', '3-8-2', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '771');
INSERT INTO `oam_monitorparamvalue` VALUES ('13', '3-9-1', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('14', '3-9-2', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '732');
INSERT INTO `oam_monitorparamvalue` VALUES ('15', '3-10-3', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '86');
INSERT INTO `oam_monitorparamvalue` VALUES ('16', '3-10-4', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '387328');
INSERT INTO `oam_monitorparamvalue` VALUES ('17', '3-10-5', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '251216');
INSERT INTO `oam_monitorparamvalue` VALUES ('18', '3-11-1', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('19', '3-11-2', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '771');
INSERT INTO `oam_monitorparamvalue` VALUES ('20', '3-12-1', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('21', '3-12-2', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '742');
INSERT INTO `oam_monitorparamvalue` VALUES ('22', '3-13-6', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '41');
INSERT INTO `oam_monitorparamvalue` VALUES ('23', '3-13-7', '00:16:e8:2d:c6:11', '2016-08-07 14:39:30', '42');
INSERT INTO `oam_monitorparamvalue` VALUES ('24', '4-1-1', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('25', '4-1-2', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '600');
INSERT INTO `oam_monitorparamvalue` VALUES ('26', '4-2-1', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('27', '4-2-2', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '7050');
INSERT INTO `oam_monitorparamvalue` VALUES ('28', '4-4-1', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('29', '4-4-2', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '6440');
INSERT INTO `oam_monitorparamvalue` VALUES ('30', '4-5-1', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('31', '4-5-2', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '5820');
INSERT INTO `oam_monitorparamvalue` VALUES ('32', '4-8-1', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('33', '4-8-2', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '6440');
INSERT INTO `oam_monitorparamvalue` VALUES ('34', '4-9-1', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('35', '4-9-2', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '5820');
INSERT INTO `oam_monitorparamvalue` VALUES ('36', '4-4-1', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('37', '4-4-2', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '7050');
INSERT INTO `oam_monitorparamvalue` VALUES ('38', '4-5-1', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('39', '4-5-2', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '7040');
INSERT INTO `oam_monitorparamvalue` VALUES ('40', '4-7-1', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('41', '4-7-2', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '7040');
INSERT INTO `oam_monitorparamvalue` VALUES ('42', '4-8-1', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('43', '4-8-2', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '7050');
INSERT INTO `oam_monitorparamvalue` VALUES ('44', '4-9-1', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '1');
INSERT INTO `oam_monitorparamvalue` VALUES ('45', '4-9-2', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '7650');
INSERT INTO `oam_monitorparamvalue` VALUES ('46', '4-11-3', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '95');
INSERT INTO `oam_monitorparamvalue` VALUES ('47', '4-11-4', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '16545448');
INSERT INTO `oam_monitorparamvalue` VALUES ('48', '4-11-5', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '15784608');
INSERT INTO `oam_monitorparamvalue` VALUES ('49', '4-12-6', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '46');
INSERT INTO `oam_monitorparamvalue` VALUES ('50', '4-12-7', '00:22:46:20:9a:ea', '2016-08-07 14:39:30', '50');

-- ----------------------------
-- Table structure for `oam_paramtype`
-- ----------------------------
DROP TABLE IF EXISTS `oam_paramtype`;
CREATE TABLE `oam_paramtype` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '参数类型ID',
  `TypeName` varchar(64) DEFAULT NULL COMMENT '参数名称',
  `Descs` varchar(256) DEFAULT NULL COMMENT '参数描述',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=80 DEFAULT CHARSET=utf8 COMMENT='参数类型';

-- ----------------------------
-- Records of oam_paramtype
-- ----------------------------
INSERT INTO `oam_paramtype` VALUES ('1', 'RunState', '运行状态');
INSERT INTO `oam_paramtype` VALUES ('2', 'RunTime', '运行时间');
INSERT INTO `oam_paramtype` VALUES ('3', 'CPUIdle', '空闲CPU');
INSERT INTO `oam_paramtype` VALUES ('4', 'TotalMemory', '总内存');
INSERT INTO `oam_paramtype` VALUES ('5', 'FreeMemory', '空闲内存');
INSERT INTO `oam_paramtype` VALUES ('6', 'CPU1Temp', 'CPU温度');
INSERT INTO `oam_paramtype` VALUES ('7', 'CPUSysTemp', '系统温度');
INSERT INTO `oam_paramtype` VALUES ('8', 'Name', 'AC名称');
INSERT INTO `oam_paramtype` VALUES ('9', 'Model', 'AC型号');
INSERT INTO `oam_paramtype` VALUES ('10', 'Version', 'AC版本');
INSERT INTO `oam_paramtype` VALUES ('11', 'Update', '上线时间');
INSERT INTO `oam_paramtype` VALUES ('12', 'MaxApLimit', '最大AP数量限制');
INSERT INTO `oam_paramtype` VALUES ('13', 'MaxClientLimit', '最大客户数限制');
INSERT INTO `oam_paramtype` VALUES ('14', 'InstalledApLicenses', 'AP已安装许可');
INSERT INTO `oam_paramtype` VALUES ('15', 'InUseApLicenses', 'AP使用许可');
INSERT INTO `oam_paramtype` VALUES ('16', 'TotalOnlineAps', '在线AP数量');
INSERT INTO `oam_paramtype` VALUES ('17', 'TotalOfflineAps', '离线AP数量');
INSERT INTO `oam_paramtype` VALUES ('18', 'TotalWirelessStations', '无线用户数');
INSERT INTO `oam_paramtype` VALUES ('19', 'Total24GStations', '2.4G用户数');
INSERT INTO `oam_paramtype` VALUES ('20', 'Total5GStations', '5G用户数');
INSERT INTO `oam_paramtype` VALUES ('21', 'TotalWiredStations', '有线用户数');
INSERT INTO `oam_paramtype` VALUES ('22', 'TotalAlarms', 'WiFi总告警数');
INSERT INTO `oam_paramtype` VALUES ('23', 'TotalCritAlarms', 'WiFi关键告警数');
INSERT INTO `oam_paramtype` VALUES ('24', 'TotalMajorAlarms', 'WiFi重要告警数');
INSERT INTO `oam_paramtype` VALUES ('25', 'TotalMinorAlarms', 'WiFi次要告警数');
INSERT INTO `oam_paramtype` VALUES ('26', 'TotalRogueAps', '非法AP数量');
INSERT INTO `oam_paramtype` VALUES ('27', 'TotalRogueStations', '非法用户数');
INSERT INTO `oam_paramtype` VALUES ('28', 'TotalRogueUnknownDevices', '非法未知设备数');
INSERT INTO `oam_paramtype` VALUES ('29', 'TotalClearEssProfiles', '明文ESS模板数量');
INSERT INTO `oam_paramtype` VALUES ('30', 'TotalSecureEssProfiles', '加密ESS模板数量');
INSERT INTO `oam_paramtype` VALUES ('31', 'TotalCaptivePortalEssPro', '网页认证ESS模板数量');
INSERT INTO `oam_paramtype` VALUES ('35', 'TotalWlanSystemRxBytes', 'WIFI总接收流');
INSERT INTO `oam_paramtype` VALUES ('36', 'TotalWlanSystemTxBytes', 'WIFI总发送流');
INSERT INTO `oam_paramtype` VALUES ('37', 'MemSwapErrorMsg', '交换内存告警');
INSERT INTO `oam_paramtype` VALUES ('38', '3G IP', '4G IP地址');
INSERT INTO `oam_paramtype` VALUES ('39', 'aubloadver', 'AUB版本加载自检结果');
INSERT INTO `oam_paramtype` VALUES ('40', 'rfuloadver', 'RFU版本加载自检结果');
INSERT INTO `oam_paramtype` VALUES ('41', 'rfurfcalib', 'RFU射频定标自检结果');
INSERT INTO `oam_paramtype` VALUES ('42', 'onlinetime', '上线时间');
INSERT INTO `oam_paramtype` VALUES ('43', 'atgcond', '空地状态');
INSERT INTO `oam_paramtype` VALUES ('44', 'pubipaddr', '公网IP地址');
INSERT INTO `oam_paramtype` VALUES ('45', 'rcvbytesnum', '总接收字节数');
INSERT INTO `oam_paramtype` VALUES ('46', 'sendbytesnum', '总发送字节数');
INSERT INTO `oam_paramtype` VALUES ('47', 'ifenetaddrpool', 'IFE因特网地址池');
INSERT INTO `oam_paramtype` VALUES ('48', 'devname', 'CPE设备名称');
INSERT INTO `oam_paramtype` VALUES ('49', 'devmodel', 'CPE设备型号');
INSERT INTO `oam_paramtype` VALUES ('50', 'devseqnum', 'CPE序列号');
INSERT INTO `oam_paramtype` VALUES ('51', 'partnum', 'CPE件号');
INSERT INTO `oam_paramtype` VALUES ('52', 'modelnum', 'CPE Model序号');
INSERT INTO `oam_paramtype` VALUES ('53', 'atgpktver', 'CPE软件版本');
INSERT INTO `oam_paramtype` VALUES ('54', 'aubcpuver', 'AUB CPU OS版本');
INSERT INTO `oam_paramtype` VALUES ('55', 'rfucpuver', 'RFU CPU OS版本');
INSERT INTO `oam_paramtype` VALUES ('56', 'devip', 'CPE IP地址');
INSERT INTO `oam_paramtype` VALUES ('57', 'devmac', 'CPE Mac地址');
INSERT INTO `oam_paramtype` VALUES ('58', 'imsi', 'IMSI');
INSERT INTO `oam_paramtype` VALUES ('59', 'maxupbw', '最大上行带宽');
INSERT INTO `oam_paramtype` VALUES ('60', 'maxdownbw', '最大下行带宽');
INSERT INTO `oam_paramtype` VALUES ('61', 'CAPDevName', 'CAP名称');
INSERT INTO `oam_paramtype` VALUES ('62', 'CAPModelName', 'CAP 型号');
INSERT INTO `oam_paramtype` VALUES ('63', 'CAPSerialNum', 'CAP 序列号');
INSERT INTO `oam_paramtype` VALUES ('64', 'SoftwareVersion', '软件版本');
INSERT INTO `oam_paramtype` VALUES ('65', 'CAP_SSID_24G', '2.4G的SSID');
INSERT INTO `oam_paramtype` VALUES ('66', 'CAP_SSID_5G', '5G的SSID');
INSERT INTO `oam_paramtype` VALUES ('67', 'ConnectState', '无线连接状态');
INSERT INTO `oam_paramtype` VALUES ('68', 'CAP\'s_OnlineNum', '在线CAP在线人数总和');
INSERT INTO `oam_paramtype` VALUES ('69', 'Cap_OnlineNum', 'CAP在线人数');
INSERT INTO `oam_paramtype` VALUES ('70', 'Cap_OnlineNum_24G.4G', 'CAP 2.4G频段在线人数');
INSERT INTO `oam_paramtype` VALUES ('71', 'Cap_OnlineNum_5G', 'CAP 5G频段在线人数');
INSERT INTO `oam_paramtype` VALUES ('72', 'CAP\'s_RxBytes', '在线CAP接收流量总和');
INSERT INTO `oam_paramtype` VALUES ('73', 'CAP_RxBytes', 'CAP接收流量');
INSERT INTO `oam_paramtype` VALUES ('74', 'CAP_RxBytes_24G', 'CAP 2.4G频段接收流量');
INSERT INTO `oam_paramtype` VALUES ('75', 'CAP_RxBytes_5G', 'CAP 5G频段接收流量');
INSERT INTO `oam_paramtype` VALUES ('76', 'CAP\'s_TxBytes', '在线CAP发送流量总和');
INSERT INTO `oam_paramtype` VALUES ('77', 'CAP_TxBytes', 'CAP发送流量');
INSERT INTO `oam_paramtype` VALUES ('78', 'CAP_TxBytes_24G', 'CAP 2.4G频段发送流量');
INSERT INTO `oam_paramtype` VALUES ('79', 'CAP_TxBytes_5G', 'CAP 5G频段发送流量');
INSERT INTO `oam_paramtype` VALUES ('80', 'PAStatus', 'PA状态');
INSERT INTO `oam_paramtype` VALUES ('81', 'AGStatus', '空地状态');
INSERT INTO `oam_paramtype` VALUES ('82', 'DoorStatus', '舱门状态');
INSERT INTO `oam_paramtype` VALUES ('83', 'UsbStatus', 'USB口状态');
INSERT INTO `oam_paramtype` VALUES ('84', 'EthStatus', '以太网口状态');
INSERT INTO `oam_paramtype` VALUES ('85', '4GDailStatus', '4G状态拨号');
INSERT INTO `oam_paramtype` VALUES ('86', '4G1DailStatus', '4G模块1拨号状态');
INSERT INTO `oam_paramtype` VALUES ('87', '4G1SigStrength', '4G模块1信号强度');
INSERT INTO `oam_paramtype` VALUES ('88', '4G1DialErrCode', '4G模块1拨号错误码');
INSERT INTO `oam_paramtype` VALUES ('89', '4G1IPAddr', '4G模块1IP地址');
INSERT INTO `oam_paramtype` VALUES ('90', '4G2DailStatus', '4G模块2拨号状态');
INSERT INTO `oam_paramtype` VALUES ('91', '4G2SigStrength', '4G模块2信号强度');
INSERT INTO `oam_paramtype` VALUES ('92', '4G2DialErrCode', '4G模块2拨号错误码');
INSERT INTO `oam_paramtype` VALUES ('93', '4G2IPAddr', '4G模块2IP地址');
INSERT INTO `oam_paramtype` VALUES ('94', '4GNetStatus', '4G网络状态');
INSERT INTO `oam_paramtype` VALUES ('95', '4G1NetStatus', '4G模块1网络状态');
INSERT INTO `oam_paramtype` VALUES ('96', '4G2NetStatus', '4G模块2网络状态');


-- ----------------------------
-- Table structure for `oam_passengerinfo`
-- ----------------------------
DROP TABLE IF EXISTS `oam_passengerinfo`;
CREATE TABLE `oam_passengerinfo` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '乘客ID',
  `FlightInfoID` int(11) NOT NULL COMMENT '航班信息ID',
  `Origin` varchar(32) DEFAULT NULL COMMENT '出发地',
  `Destination` varchar(32) DEFAULT NULL COMMENT '到达站',
  `FlightDate` datetime DEFAULT NULL COMMENT '飞行日期',
  `ChineseName` varchar(32) DEFAULT NULL COMMENT 'ChineseName属于乘客信息(该表结构需与航空公司协商，待定)',
  `EnglishName` varchar(32) DEFAULT NULL COMMENT 'EnglishName属于乘客信息(该表结构需与航空公司协商，待定)',
  `Class` char(2) DEFAULT NULL COMMENT '舱位等级：(0-头等舱 1-商务舱 其他-经济舱)',
  `No` int(11) DEFAULT NULL COMMENT '序号',
  `Gate` varchar(16) DEFAULT NULL COMMENT '登机口',
  `BoardingTime` datetime DEFAULT NULL COMMENT '登机时间',
  `Seat` varchar(20) DEFAULT NULL COMMENT '座位号, refer to cmt_seat(seat)',
  `ID_Type` char(10) DEFAULT NULL COMMENT '证件类型(1-身份证 2-军官证 3-护照 4-其他)',
  `ID_Number` varchar(24) DEFAULT NULL COMMENT '证件号',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='乘客信息(该表结构需与航空公司协商，待定)';

-- ----------------------------
-- Records of oam_passengerinfo
-- ----------------------------
INSERT INTO `oam_passengerinfo` VALUES ('1', '2', '北京', '上海虹桥', '2014-01-17 07:30:00', '张三', 'Zhang San', '2', '21', 'C31', '2014-01-17 07:15:00', '07B', '1', '123456789123456789');
INSERT INTO `oam_passengerinfo` VALUES ('12', '2', '北京', '上海虹桥', '2014-01-17 08:00:00', '李四', 'Li Si', '1', '14', 'C31', '2014-01-17 07:45:00', '08C', '3', '987654321987654321');

-- ----------------------------
-- Table structure for `oam_proxymap`
-- ----------------------------
DROP TABLE IF EXISTS `oam_proxymap`;
CREATE TABLE `oam_proxymap` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `DevID` varchar(24) DEFAULT NULL COMMENT 'MAC地址，必须唯一',
  `VirtualCmty` varchar(24) DEFAULT NULL COMMENT '虚拟的Community名称，对应于Manager端，由Proxy分配的',
  `VirtualCtx` varchar(24) DEFAULT NULL COMMENT 'Context名称',
  `Username` varchar(24) DEFAULT NULL COMMENT '安全用户名',
  `AuthProtocol` varchar(24) DEFAULT NULL COMMENT '认证协议',
  `PrivacyProtocol` varchar(24) DEFAULT NULL COMMENT '加密协议',
  `ProxyType` int(11) DEFAULT NULL COMMENT '代理类型：0 - 静态，1 - 动态, 2 - 没有',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='实体映射表';

-- ----------------------------
-- Records of oam_proxymap
-- ----------------------------
INSERT INTO `oam_proxymap` VALUES ('5', '6c:aa:b3:01:b8:e0', 'cmty_15_4', 'ctx_15_4', '0', '0', '0', '0');
INSERT INTO `oam_proxymap` VALUES ('2', '00:22:46:20:9a:ea', 'public', '', '0', '0', '0', '2');
INSERT INTO `oam_proxymap` VALUES ('21', '00:16:e8:2d:c6:11', 'cmty_3_20', 'ctx_3_20', '0', '0', '0', '0');
INSERT INTO `oam_proxymap` VALUES ('22', '02:10:18:f5:16:3b', 'cmty_5_21', 'ctx_5_21', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `oam_seatcontent`
-- ----------------------------
DROP TABLE IF EXISTS `oam_seatcontent`;
CREATE TABLE `oam_seatcontent` (
  `ContentID` int(11) DEFAULT NULL COMMENT 'refer to content(ID)',
  `Seat` varchar(20) DEFAULT NULL COMMENT '座位号,refer to cmt_seat(seat)，指向cmt_seat(ID)更加准确(待定)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='座位允许观看内容表';

-- ----------------------------
-- Records of oam_seatcontent
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_seatgroup`
-- ----------------------------
DROP TABLE IF EXISTS `oam_seatgroup`;
CREATE TABLE `oam_seatgroup` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SeatGroupName` varchar(32) DEFAULT NULL COMMENT '座位组别名，如：VIP、公务舱、头等舱、经济舱、儿童舱等',
  `Descs` varchar(255) DEFAULT NULL COMMENT 'descs 属于 座位组1',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='座位组1';

-- ----------------------------
-- Records of oam_seatgroup
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_seatgroupmember`
-- ----------------------------
DROP TABLE IF EXISTS `oam_seatgroupmember`;
CREATE TABLE `oam_seatgroupmember` (
  `SeatgroupID` int(11) DEFAULT NULL COMMENT 'refer to seatgroup(ID)',
  `Seat` varchar(20) DEFAULT NULL COMMENT '座位号,refer to cmt_seat(seat)，指向cmt_seat(ID)更加准确(待定)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='座位组成员';

-- ----------------------------
-- Records of oam_seatgroupmember
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_seatgroupprivilege`
-- ----------------------------
DROP TABLE IF EXISTS `oam_seatgroupprivilege`;
CREATE TABLE `oam_seatgroupprivilege` (
  `SeatGroupID` int(11) DEFAULT NULL COMMENT 'refer to seatgroup(ID)',
  `ContentGroupID` int(11) DEFAULT NULL COMMENT 'refer to contentGroup(ID)'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='座位组权限';

-- ----------------------------
-- Records of oam_seatgroupprivilege
-- ----------------------------

-- ----------------------------
-- Table structure for `oam_troublemessage`
-- ----------------------------
DROP TABLE IF EXISTS `oam_troublemessage`;
CREATE TABLE `oam_troublemessage` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Type` int(11) DEFAULT NULL COMMENT '检测项类型：1-4G，2-WiFi，3-部件',
  `TroubleCode` int(11) DEFAULT NULL COMMENT '故障码',
  `Description` varchar(128) DEFAULT NULL COMMENT '故障描述',
  `CreateTime` datetime DEFAULT NULL COMMENT '故障发生时间',
  `Visible` int(11) DEFAULT '0' COMMENT '是否可见，0-不可见，1-可见',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='故障消息';

-- ----------------------------
-- Records of oam_troublemessage
-- ----------------------------
INSERT INTO `oam_troublemessage` VALUES ('1', '1', '1', '网络故障，4G信号过弱，请联系机务人员', '2016-07-26 13:44:29', '0');
INSERT INTO `oam_troublemessage` VALUES ('2', '1', '2', '4G卡被拔除，请联系机务人员', '2016-07-26 13:44:29', '0');
INSERT INTO `oam_troublemessage` VALUES ('3', '1', '3', '4G硬开关被人为关闭，请拨至ON位置', '2016-07-26 13:44:29', '0');
INSERT INTO `oam_troublemessage` VALUES ('4', '1', '4', '拨号失败，请尝试重启系统或联系机务人员', '2016-07-26 13:44:29', '0');
INSERT INTO `oam_troublemessage` VALUES ('5', '2', '1', '存在CAP无法连接，请联系机务人员', '2016-07-26 13:44:29', '0');
INSERT INTO `oam_troublemessage` VALUES ('6', '2', '2', 'WiFi网络故障，请联系机务人员', '2016-07-26 13:44:29', '1');

-- ----------------------------
-- Table structure for `oam_twluconfig`
-- ----------------------------
DROP TABLE IF EXISTS `oam_twluconfig`;
CREATE TABLE `oam_twluconfig` (
  `ID` smallint(6) NOT NULL AUTO_INCREMENT COMMENT 'ID标识',
  `SSID` varchar(24) DEFAULT NULL COMMENT 'SSID',
  `SecureMode` char(2) DEFAULT NULL COMMENT '加密方式：0 - 开放(默认)，1 - WAP-PSK，2 - WAP2-PSK，etc',
  `Password` varchar(16) DEFAULT NULL COMMENT '密码',
  `IPMode` char(1) DEFAULT NULL COMMENT 'IP 设置，0 - 静态IP， 1 - 动态IP(默认)',
  `Gateway` varchar(24) DEFAULT NULL COMMENT '网关',
  `Netmask` varchar(24) DEFAULT NULL COMMENT '子网掩码',
  `DNS` varchar(24) DEFAULT NULL COMMENT 'DNS',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='航站楼WiFi配置表';

-- ----------------------------
-- Records of oam_twluconfig
-- ----------------------------
INSERT INTO `oam_twluconfig` VALUES ('1', 'ChinaAir', '1', '12345678', '1', '192.168.0.1', '255.255.255.0', '120.80.88.88');
INSERT INTO `oam_twluconfig` VALUES ('4', 'ChinaAir-2', '0', '88888888', '0', '192.168.2.1', '255.255.255.0', '192.168.2.80');

-- ----------------------------
-- Table structure for `oam_upgradeservice`
-- ----------------------------
DROP TABLE IF EXISTS `oam_upgradeservice`;
CREATE TABLE `oam_upgradeservice` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `FlightNumber` varchar(32) DEFAULT NULL COMMENT '航班号',
  `Seat` varchar(20) DEFAULT NULL COMMENT '座位号,refer to cmt_seat(seat)',
  `UpgradeToSeat` varchar(32) DEFAULT NULL COMMENT '升舱后座位号',
  `UpgradeApplyTime` datetime DEFAULT NULL COMMENT '升舱申请时间',
  `UpgradeAcceptTime` varchar(32) DEFAULT NULL COMMENT '升舱受理时间',
  `Sync` char(1) DEFAULT NULL COMMENT '是否与地面中心同步：0 - 没同步，1 - 同步',
  `SyncTime` datetime DEFAULT NULL COMMENT '同步时间',
  PRIMARY KEY (`Id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='升舱服务(需要与航空公司协商后定义)';

-- ----------------------------
-- Records of oam_upgradeservice
-- ----------------------------



DROP VIEW IF EXISTS `oam_device_detail`;
CREATE ALGORITHM=UNDEFINED DEFINER=`hhwifi`@`%` SQL SECURITY DEFINER VIEW `oam_device_detail` AS (select `od`.`DevID` AS `DevID`,`od`.`DevType` AS `DevType`,`od`.`IPAddress` AS `IPAddress`,`od`.`DevPosition` AS `DevPosition`,`od`.`DevStatus` AS `DevStatus`,`od`.`RegisterDate` AS `RegisterDate`,`odc`.`Name` AS `Name`,`odc`.`Descs` AS `Descs` from (`oam_device` `od` left join `oam_devicecategory` `odc` on((`od`.`DevType` = `odc`.`ID`)))) ;

DROP VIEW IF EXISTS `oam_param_map`;
CREATE ALGORITHM=UNDEFINED DEFINER=`hhwifi`@`%` SQL SECURITY DEFINER VIEW `oam_param_map` AS (select `omp`.`ID` AS `ParamID`,`omp`.`ApplicationID` AS `AppID`,`omp`.`ParamType` AS `ParamType`,`opt`.`Descs` AS `ParamName`,`omp`.`OID` AS `OID`,`oa`.`AppName` AS `AppName`,`oa`.`CategoryID` AS `CategoryID`,`odc`.`Name` AS `CategoryName`,`omp`.`GroupID` AS `GroupID` from (((`oam_monitorparam` `omp` left join `oam_application` `oa` on((`omp`.`ApplicationID` = `oa`.`ID`))) left join `oam_paramtype` `opt` on((`omp`.`ParamType` = `opt`.`ID`))) left join `oam_devicecategory` `odc` on((`odc`.`ID` = `oa`.`CategoryID`)))) ;





