/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50625
Source Host           : localhost:3306
Source Database       : laravel_test

Target Server Type    : MYSQL
Target Server Version : 50625
File Encoding         : 65001

Date: 2017-02-28 18:46:46
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
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_slug` (`slug`) USING HASH
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of chats
-- ----------------------------
INSERT INTO `chats` VALUES ('2', 'test', 'test', '0', '115851488224976.jpg', '1');
INSERT INTO `chats` VALUES ('3', 'test1', 'test1', '1', '115851488224976.jpg', '1');

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
  CONSTRAINT `fk_chat_id` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sms
-- ----------------------------
INSERT INTO `sms` VALUES ('3', '2', '1', 'asd');
INSERT INTO `sms` VALUES ('4', '2', '1', 'qwe');
INSERT INTO `sms` VALUES ('5', '3', '1', 'zxc');

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'user', 'asd@asd.asd', '$2y$10$ix2iPY5JsZ02CYZfW6dPpu97uxFzt6iYvgdmxHxw.uXSuKUlfm7xa', 'd27kQKTexvCrOMhcxOMzJsT2GvoyfbectgBxOntof9hXRtrYDOvDkjaGTF2T', '2017-02-27 13:38:16', '2017-02-27 20:41:39');
