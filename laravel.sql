/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : laravel

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2017-03-01 23:46:13
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for chats
-- ----------------------------
DROP TABLE IF EXISTS `chats`;
CREATE TABLE `chats` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `image_name` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `users_online` varchar(255) DEFAULT NULL,
  `is_only_slug` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_slug` (`slug`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of chats
-- ----------------------------
INSERT INTO `chats` VALUES ('5', 'user1 test1 only slug', 'u1t1', '0', '154701488396449.jpg', '4', null, '1');
INSERT INTO `chats` VALUES ('6', 'user1 test2', 'u1t2', '0', '334581488396485.jpg', '4', '{\"5\":{\"count\":1,\"date\":1488396712},\"guest_8101488396674164\":{\"count\":1,\"date\":1488396714}}', '0');
INSERT INTO `chats` VALUES ('7', 'user 2 test 1 private', 'u2t1', '1', '989251488396609.jpg', '5', null, '0');
INSERT INTO `chats` VALUES ('8', 'user 2 test 2', 'u2t2', '0', '832001488396743.jpg', '5', null, '0');

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('2014_10_12_100000_create_password_resets_table', '1');

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for sms
-- ----------------------------
DROP TABLE IF EXISTS `sms`;
CREATE TABLE `sms` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `chat_id` int(11) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `text` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_user_id` (`user_id`),
  KEY `fk_chat_id` (`chat_id`),
  CONSTRAINT `fk_chat_id` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sms
-- ----------------------------
INSERT INTO `sms` VALUES ('36', '6', '5', 'Hi');
INSERT INTO `sms` VALUES ('37', '6', '0', 'How are you?');
INSERT INTO `sms` VALUES ('38', '8', '0', 'Hi');
INSERT INTO `sms` VALUES ('39', '8', '5', 'Hi, How are you?');
INSERT INTO `sms` VALUES ('43', '8', '0', 'I\'m fine and you?');
INSERT INTO `sms` VALUES ('44', '8', '4', 'I\'m fine too');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('4', 'User1', 'a@a.a', '$2y$10$Y0AynGNTOpqg30QRI46/9upm5d.Gjz6u7X20GhmnPel/GOZazgt1m', null, '2017-03-01 19:25:46', '2017-03-01 19:25:46');
INSERT INTO `users` VALUES ('5', 'User2', 'b@b.b', '$2y$10$mo/Tj8vnI8lGUq3NhcqHfO0SYfcaUQcMUl2g4zFu/DxebglPgGxrq', null, '2017-03-01 19:29:25', '2017-03-01 19:29:25');
