/*
Navicat MySQL Data Transfer

Source Server         : my connection
Source Server Version : 50520
Source Host           : localhost:3306
Source Database       : ewindow

Target Server Type    : MYSQL
Target Server Version : 50520
File Encoding         : 65001

Date: 2012-05-05 18:55:19
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `categories`
-- ----------------------------
DROP TABLE IF EXISTS `categories`;
CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL DEFAULT '0',
  `category_name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of categories
-- ----------------------------
INSERT INTO `categories` VALUES ('1', 'hardware');
INSERT INTO `categories` VALUES ('2', 'softwares');

-- ----------------------------
-- Table structure for `groups`
-- ----------------------------
DROP TABLE IF EXISTS `groups`;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of groups
-- ----------------------------
INSERT INTO `groups` VALUES ('1', 'admin', 'Administrator');
INSERT INTO `groups` VALUES ('2', 'shopper', 'Shoppers');
INSERT INTO `groups` VALUES ('3', 'shop_owner', 'Shop Owners');

-- ----------------------------
-- Table structure for `item`
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `item_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_name` varchar(20) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `time_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `discount` int(11) NOT NULL,
  `promotional_rank` int(11) NOT NULL,
  PRIMARY KEY (`item_id`),
  KEY `shopID` (`shop_id`),
  CONSTRAINT `shopID` FOREIGN KEY (`shop_id`) REFERENCES `shop` (`shop_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('4', 'T-shirt', '4', '1000', '2012-04-24 10:53:54', '0', '0');
INSERT INTO `item` VALUES ('5', 'small shirt', '4', '100', '2012-04-27 00:50:17', '0', '0');
INSERT INTO `item` VALUES ('6', ' T-shirt', '6', '1000', '2012-04-28 19:17:09', '0', '0');

-- ----------------------------
-- Table structure for `item_comments`
-- ----------------------------
DROP TABLE IF EXISTS `item_comments`;
CREATE TABLE `item_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item_comments
-- ----------------------------
INSERT INTO `item_comments` VALUES ('8', '2', '2', 'hello', '2012-04-26 00:58:44');
INSERT INTO `item_comments` VALUES ('9', '4', '2', 'faizan', '2012-04-26 01:08:51');

-- ----------------------------
-- Table structure for `shop`
-- ----------------------------
DROP TABLE IF EXISTS `shop`;
CREATE TABLE `shop` (
  `shop_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `alias` varchar(10) NOT NULL,
  `mission_statement` varchar(250) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_verified` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `logo` varchar(500) DEFAULT NULL,
  `allowed_products` tinyint(4) NOT NULL DEFAULT '25',
  `owner` int(11) NOT NULL,
  PRIMARY KEY (`shop_id`),
  KEY `shop_owner` (`owner`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of shop
-- ----------------------------
INSERT INTO `shop` VALUES ('4', 'Your Shop', 'Ali', 'hello world', '2012-04-19 02:07:22', '0', '1', null, '25', '2');
INSERT INTO `shop` VALUES ('6', 'My Shop', 'blisss-sss', 'This is the mission ', '2012-04-20 23:40:59', '0', '1', null, '25', '2');
INSERT INTO `shop` VALUES ('7', 'Ali garments', 'ali-garmen', 'this is ali garments', '2012-04-24 11:15:01', '0', '1', null, '25', '1');
INSERT INTO `shop` VALUES ('8', 'ali garments', 'Ali', 'aasas', '2012-04-28 20:24:47', '0', '1', null, '25', '2');
INSERT INTO `shop` VALUES ('9', 'ali photos', 'Ali', 'aasas', '2012-04-28 20:27:16', '0', '1', null, '25', '2');
INSERT INTO `shop` VALUES ('10', 'IBM-SQL-DC', 'Ali', 'aasas', '2012-04-28 20:31:28', '0', '1', null, '25', '2');
INSERT INTO `shop` VALUES ('11', 'TimeCommerce2', 'Ali', 'aasas', '2012-04-28 23:28:37', '0', '1', null, '25', '2');

-- ----------------------------
-- Table structure for `shop_categories`
-- ----------------------------
DROP TABLE IF EXISTS `shop_categories`;
CREATE TABLE `shop_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of shop_categories
-- ----------------------------
INSERT INTO `shop_categories` VALUES ('1', '11', '1');
INSERT INTO `shop_categories` VALUES ('2', '11', '2');

-- ----------------------------
-- Table structure for `shop_comments`
-- ----------------------------
DROP TABLE IF EXISTS `shop_comments`;
CREATE TABLE `shop_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of shop_comments
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` int(10) unsigned NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', '2130706433', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', null, null, '1268889823', '1268889823', '1', 'Admin', 'istrator', '0');
INSERT INTO `users` VALUES ('2', '2130706433', 'sh.faizan.ali@gmail.com', 'aad1dfaa80e95e9f51827761f771c968bbab5b22', null, 'sh.faizan.ali@gmail.com', null, null, null, '1335012091', '1335901175', '1', 'Faizan', 'Faizan', '03456345682');
INSERT INTO `users` VALUES ('27', '2130706433', 'sh.faizan.ali@hotmail.com', '0f125b803640cb3c07ce2defe0f84308c866a3d7', null, 'sh.faizan.ali@hotmail.com', null, null, null, '1335289013', '1335697689', '1', 'Faizan', 'Ali', '55321');

-- ----------------------------
-- Table structure for `users_groups`
-- ----------------------------
DROP TABLE IF EXISTS `users_groups`;
CREATE TABLE `users_groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` mediumint(8) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users_groups
-- ----------------------------
INSERT INTO `users_groups` VALUES ('1', '1', '1');
INSERT INTO `users_groups` VALUES ('2', '1', '2');
INSERT INTO `users_groups` VALUES ('30', '27', '2');
INSERT INTO `users_groups` VALUES ('32', '2', '3');
INSERT INTO `users_groups` VALUES ('33', '2', '2');

-- ----------------------------
-- Table structure for `wishlist`
-- ----------------------------
DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `wishlist_name` varchar(150) NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`wishlist_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wishlist
-- ----------------------------
INSERT INTO `wishlist` VALUES ('21', '2', 'clothes', '2012-04-29 15:17:59');
INSERT INTO `wishlist` VALUES ('22', '3', 'chairs', '2012-04-29 19:31:32');
INSERT INTO `wishlist` VALUES ('23', '2', 'my ultimate list', '2012-04-29 19:38:52');

-- ----------------------------
-- Table structure for `wishlist_comments`
-- ----------------------------
DROP TABLE IF EXISTS `wishlist_comments`;
CREATE TABLE `wishlist_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wishlist_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wishlist_comments
-- ----------------------------
INSERT INTO `wishlist_comments` VALUES ('1', '21', '2', 'this is a text comment for my wishlist', '2012-04-29 21:44:32');
INSERT INTO `wishlist_comments` VALUES ('2', '23', '2', 'Exter the comment', '2012-04-30 01:46:06');
INSERT INTO `wishlist_comments` VALUES ('3', '23', '2', 'Exter the comment', '2012-04-30 01:46:25');
INSERT INTO `wishlist_comments` VALUES ('4', '23', '2', 'Exter the comment', '2012-04-30 01:47:07');

-- ----------------------------
-- Table structure for `wishlist_items`
-- ----------------------------
DROP TABLE IF EXISTS `wishlist_items`;
CREATE TABLE `wishlist_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wishlist_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wishlist_items
-- ----------------------------
