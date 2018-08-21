/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50719
Source Host           : localhost:3306
Source Database       : mini

Target Server Type    : MYSQL
Target Server Version : 50719
File Encoding         : 65001

Date: 2018-08-21 22:02:16
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for admin_job
-- ----------------------------
DROP TABLE IF EXISTS `admin_job`;
CREATE TABLE `admin_job` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `job_name` varchar(36) DEFAULT NULL,
  `explain` varchar(240) DEFAULT NULL,
  `vaild` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_job
-- ----------------------------
INSERT INTO `admin_job` VALUES ('2', '超级管理员', '管理员', '1');
INSERT INTO `admin_job` VALUES ('3', '管理员', '管理员', '1');

-- ----------------------------
-- Table structure for admin_job_auth
-- ----------------------------
DROP TABLE IF EXISTS `admin_job_auth`;
CREATE TABLE `admin_job_auth` (
  `admin_job_id` int(8) NOT NULL,
  `func_key` varchar(24) NOT NULL,
  `auth_key` varchar(24) NOT NULL,
  PRIMARY KEY (`admin_job_id`,`func_key`,`auth_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of admin_job_auth
-- ----------------------------
INSERT INTO `admin_job_auth` VALUES ('2', 'admin', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'adminLog', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'adminLog', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'adminLog', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'adminLog', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'article', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'article', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'article', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'article', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'brand', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'brand', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'brand', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'brand', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'front', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'func', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'func', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'func', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'func', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'goods', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'goods', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'goods', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'goods', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'goodsClassify', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'goodsClassify', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'goodsClassify', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'goodsClassify', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'job', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'job', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'job', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'job', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'menu', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'menu', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'menu', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'menu', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'sale', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'sale', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'sale', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'sale', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'shop', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'shop', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'shop', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'shop', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'silde', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'silde', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'silde', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'silde', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'slide', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'slide', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'slide', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'slide', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'specs', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'specs', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'specs', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'specs', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'staff', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'staff', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'staff', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'staff', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'tag', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'tag', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'tag', 'edit');
INSERT INTO `admin_job_auth` VALUES ('2', 'tag', 'export');
INSERT INTO `admin_job_auth` VALUES ('2', 'user', 'add');
INSERT INTO `admin_job_auth` VALUES ('2', 'user', 'delete');
INSERT INTO `admin_job_auth` VALUES ('2', 'user', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'admin', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'adminLog', 'add');
INSERT INTO `admin_job_auth` VALUES ('3', 'adminLog', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'article', 'add');
INSERT INTO `admin_job_auth` VALUES ('3', 'article', 'delete');
INSERT INTO `admin_job_auth` VALUES ('3', 'article', 'edit');
INSERT INTO `admin_job_auth` VALUES ('3', 'article', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'brand', 'delete');
INSERT INTO `admin_job_auth` VALUES ('3', 'brand', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'front', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'func', 'edit');
INSERT INTO `admin_job_auth` VALUES ('3', 'func', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'goods', 'add');
INSERT INTO `admin_job_auth` VALUES ('3', 'goods', 'delete');
INSERT INTO `admin_job_auth` VALUES ('3', 'goods', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'goodsClassify', 'add');
INSERT INTO `admin_job_auth` VALUES ('3', 'goodsClassify', 'delete');
INSERT INTO `admin_job_auth` VALUES ('3', 'goodsClassify', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'job', 'add');
INSERT INTO `admin_job_auth` VALUES ('3', 'job', 'edit');
INSERT INTO `admin_job_auth` VALUES ('3', 'job', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'menu', 'add');
INSERT INTO `admin_job_auth` VALUES ('3', 'menu', 'delete');
INSERT INTO `admin_job_auth` VALUES ('3', 'menu', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'sale', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'shop', 'add');
INSERT INTO `admin_job_auth` VALUES ('3', 'shop', 'delete');
INSERT INTO `admin_job_auth` VALUES ('3', 'shop', 'edit');
INSERT INTO `admin_job_auth` VALUES ('3', 'shop', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'slide', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'specs', 'add');
INSERT INTO `admin_job_auth` VALUES ('3', 'specs', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'staff', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'tag', 'export');
INSERT INTO `admin_job_auth` VALUES ('3', 'user', 'add');
INSERT INTO `admin_job_auth` VALUES ('3', 'user', 'delete');
INSERT INTO `admin_job_auth` VALUES ('3', 'user', 'edit');
INSERT INTO `admin_job_auth` VALUES ('3', 'user', 'export');
INSERT INTO `admin_job_auth` VALUES ('4', 'article', 'export');

-- ----------------------------
-- Table structure for article
-- ----------------------------
DROP TABLE IF EXISTS `article`;
CREATE TABLE `article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_img` text,
  `title` varchar(30) NOT NULL,
  `type` int(6) NOT NULL DEFAULT '0',
  `summary` varchar(450) DEFAULT NULL,
  `content` text,
  `created_at` int(24) DEFAULT NULL,
  `update_at` int(24) DEFAULT NULL,
  `is_show` int(1) DEFAULT '1',
  `valid` int(1) NOT NULL DEFAULT '1',
  `show_place` int(1) DEFAULT NULL,
  `sort` int(3) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article
-- ----------------------------
INSERT INTO `article` VALUES ('2', '/upload/2018-01-12/1515724814941540.jpg', '登录帮会组', '1', '简介', '<p>是可怜的积分卡阿达</p>', '1515724823', '1515983304', '1', '1', '1', '100');
INSERT INTO `article` VALUES ('3', '/upload/2018-01-15/1515983283130479.jpg', '新闻动态', '3', '佳节', '<p>春节</p>', '1515983291', '1515983291', '1', '0', '1', '100');
INSERT INTO `article` VALUES ('4', '/upload/2018-08-19/1534668197462793.jpg', 'test1', '1', 'asda', '<p>asda</p>', '1534668228', '1534668228', '1', '1', '1', '100');

-- ----------------------------
-- Table structure for article_type
-- ----------------------------
DROP TABLE IF EXISTS `article_type`;
CREATE TABLE `article_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `named` char(12) DEFAULT NULL,
  `insert_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of article_type
-- ----------------------------
INSERT INTO `article_type` VALUES ('1', '帮助中心', '1515724746');
INSERT INTO `article_type` VALUES ('3', '新闻动态', '1515983189');

-- ----------------------------
-- Table structure for background_func
-- ----------------------------
DROP TABLE IF EXISTS `background_func`;
CREATE TABLE `background_func` (
  `key` varchar(24) NOT NULL,
  `func_name` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of background_func
-- ----------------------------
INSERT INTO `background_func` VALUES ('admin', '后台管理');
INSERT INTO `background_func` VALUES ('article', '文章管理');
INSERT INTO `background_func` VALUES ('front', '前端管理');
INSERT INTO `background_func` VALUES ('func', '功能管理');
INSERT INTO `background_func` VALUES ('job', '职位管理');
INSERT INTO `background_func` VALUES ('menu', '菜单管理');
INSERT INTO `background_func` VALUES ('slide', '幻灯片');
INSERT INTO `background_func` VALUES ('staff', '管理员管理');

-- ----------------------------
-- Table structure for func_auth
-- ----------------------------
DROP TABLE IF EXISTS `func_auth`;
CREATE TABLE `func_auth` (
  `func_key` varchar(24) NOT NULL,
  `key` varchar(24) NOT NULL,
  `auth_name` varchar(24) DEFAULT NULL,
  PRIMARY KEY (`func_key`,`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of func_auth
-- ----------------------------
INSERT INTO `func_auth` VALUES ('action', 'add', '添加');
INSERT INTO `func_auth` VALUES ('article', 'add', '添加');
INSERT INTO `func_auth` VALUES ('article', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('article', 'edit', '编辑');
INSERT INTO `func_auth` VALUES ('func', 'add', '添加');
INSERT INTO `func_auth` VALUES ('func', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('func', 'edit', '编辑');
INSERT INTO `func_auth` VALUES ('job', 'add', '添加');
INSERT INTO `func_auth` VALUES ('job', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('job', 'edit', '编辑');
INSERT INTO `func_auth` VALUES ('menu', 'add', '添加');
INSERT INTO `func_auth` VALUES ('menu', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('menu', 'edit', '编辑');
INSERT INTO `func_auth` VALUES ('slide', 'add', '添加');
INSERT INTO `func_auth` VALUES ('slide', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('slide', 'edit', '编辑');
INSERT INTO `func_auth` VALUES ('staff', 'add', '添加');
INSERT INTO `func_auth` VALUES ('staff', 'delete', '删除');
INSERT INTO `func_auth` VALUES ('staff', 'edit', '编辑');

-- ----------------------------
-- Table structure for jobs
-- ----------------------------
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE `jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of jobs
-- ----------------------------

-- ----------------------------
-- Table structure for menu
-- ----------------------------
DROP TABLE IF EXISTS `menu`;
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `named` varchar(36) DEFAULT NULL,
  `icon` varchar(120) DEFAULT NULL,
  `url` varchar(120) DEFAULT NULL,
  `sort` int(3) DEFAULT '100',
  `level` int(2) DEFAULT '1',
  `parent` int(11) DEFAULT '0',
  `screen_auth` varchar(120) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of menu
-- ----------------------------
INSERT INTO `menu` VALUES ('1', '后台管理', null, null, '100', '0', '0', '{\"admin\":[\"export\"]}');
INSERT INTO `menu` VALUES ('2', '管理员管理', '', '/staff', '100', '1', '1', '{\"staff\":[\"export\"]}');
INSERT INTO `menu` VALUES ('3', '职位管理', '', '/job', '100', '1', '1', '{\"job\":[\"export\"]}');
INSERT INTO `menu` VALUES ('4', '功能管理', '', '/func', '100', '1', '1', '{\"func\":[\"export\"]}');
INSERT INTO `menu` VALUES ('6', '前端管理', null, null, '300', '0', '0', '{\"front\":[\"export\"]}');
INSERT INTO `menu` VALUES ('8', '文章管理', '', '/article', '100', '1', '6', '{\"article\":[\"export\"]}');
INSERT INTO `menu` VALUES ('9', '轮播图管理', null, '/slide', '100', '1', '6', '{\"silde\":[\"export\"]}');
INSERT INTO `menu` VALUES ('13', '菜单管理', null, '/menu', '100', '1', '1', '{\"menu\":[\"export\"]}');

-- ----------------------------
-- Table structure for slide
-- ----------------------------
DROP TABLE IF EXISTS `slide`;
CREATE TABLE `slide` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) DEFAULT NULL,
  `img` varchar(180) NOT NULL,
  `url` varchar(120) DEFAULT NULL,
  `sort` int(3) NOT NULL DEFAULT '50',
  `update_at` int(24) NOT NULL,
  `created_at` int(24) DEFAULT NULL,
  `type` int(3) NOT NULL DEFAULT '0',
  `is_show` int(1) DEFAULT NULL,
  `valid` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of slide
-- ----------------------------
INSERT INTO `slide` VALUES ('3', '测试', '/upload/2018-01-12/1515724066610820.jpg', 'https://goods.bzywifi.cn/', '100', '1515724068', '1515724068', '2', '1', '1');

-- ----------------------------
-- Table structure for slide_type
-- ----------------------------
DROP TABLE IF EXISTS `slide_type`;
CREATE TABLE `slide_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `named` char(12) DEFAULT NULL,
  `insert_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of slide_type
-- ----------------------------
INSERT INTO `slide_type` VALUES ('2', '轮播图', '1515723652');

-- ----------------------------
-- Table structure for staff
-- ----------------------------
DROP TABLE IF EXISTS `staff`;
CREATE TABLE `staff` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(24) NOT NULL,
  `true_name` varchar(24) DEFAULT NULL,
  `sex` varchar(9) DEFAULT NULL,
  `header_img` varchar(120) DEFAULT NULL,
  `staff_num` varchar(16) DEFAULT NULL,
  `pwd` varchar(64) NOT NULL,
  `job` varchar(128) DEFAULT NULL,
  `created_at` int(11) DEFAULT NULL,
  `update_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of staff
-- ----------------------------
INSERT INTO `staff` VALUES ('1', 'admin', '超级管理员', '1', '/upload/2017-10-16/1508154229584747.png', '001', 'e10adc3949ba59abbe56e057f20f883e', '[2]', '1508154231', '1515810833');
INSERT INTO `staff` VALUES ('3', 'test', '管理员', '2', null, '002', 'e10adc3949ba59abbe56e057f20f883e', '[3]', '1507961965', '1507961965');

-- ----------------------------
-- Table structure for staff_job
-- ----------------------------
DROP TABLE IF EXISTS `staff_job`;
CREATE TABLE `staff_job` (
  `staff_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  PRIMARY KEY (`staff_id`,`job_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of staff_job
-- ----------------------------
INSERT INTO `staff_job` VALUES ('1', '2');
INSERT INTO `staff_job` VALUES ('3', '3');
