
ALTER TABLE `bank_transfer_tickets`.`users` 
ADD COLUMN `role` tinyint(2) UNSIGNED NULL DEFAULT 2 AFTER `remember_token`;


/*
Navicat MySQL Data Transfer

Source Server         : DEV 133
Source Server Version : 50735
Source Host           : 192.168.129.133:3306
Source Database       : bank_transfer_tickets

Target Server Type    : MYSQL
Target Server Version : 50735
File Encoding         : 65001

Date: 2022-06-23 13:20:41
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for workflows
-- ----------------------------
DROP TABLE IF EXISTS `workflows`;
CREATE TABLE `workflows` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `previous_group` bigint(20) unsigned DEFAULT NULL,
  `current_group` bigint(20) unsigned DEFAULT NULL,
  `current_status` bigint(20) unsigned DEFAULT NULL,
  `transfer_group` bigint(20) unsigned DEFAULT NULL,
  `transfer_status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `workflows_previous_group_foreign` (`previous_group`),
  KEY `workflows_current_group_foreign` (`current_group`),
  KEY `workflows_current_status_foreign` (`current_status`),
  KEY `workflows_transfer_group_foreign` (`transfer_group`),
  KEY `workflows_category_id_foreign` (`category_id`),
  CONSTRAINT `workflows_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `workflows_ibfk_2` FOREIGN KEY (`current_group`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `workflows_ibfk_3` FOREIGN KEY (`current_status`) REFERENCES `statuses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `workflows_ibfk_4` FOREIGN KEY (`previous_group`) REFERENCES `groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `workflows_ibfk_5` FOREIGN KEY (`transfer_group`) REFERENCES `groups` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of workflows
-- ----------------------------
INSERT INTO `workflows` VALUES ('1', null, '1', '1', '3', '1', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('3', '1', '3', '1', '4', '1', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('5', '1', '3', '1', '7', '1', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('6', '3', '4', '1', '2', '2', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('8', '4', '2', '2', '4', '7', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('9', '4', '2', '2', '4', '8', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('10', '2', '4', '7', '8', '2', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('11', '4', '8', '2', '1', '5', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('12', '4', '8', '2', '1', '6', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('13', '3', '7', '1', '5', '2', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('14', '7', '8', '2', '1', '5', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('15', '7', '8', '2', '1', '6', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('16', null, '1', '5', '1', '9', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('18', null, '1', '9', '1', '9', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('19', '3', '4', '1', '4', '3', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('20', '3', '4', '1', '1', '4', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('21', '3', '2', '1', '2', '2', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('22', '3', '2', '1', '2', '3', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('23', '3', '2', '1', '2', '4', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('24', '3', '5', '1', '2', '2', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('25', '3', '5', '1', '2', '3', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('26', '3', '5', '1', '2', '4', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('27', null, '1', '4', '3', '1', '1', null, null, null);
INSERT INTO `workflows` VALUES ('28', '7', '8', '2', '1', '10', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('29', '4', '8', '2', '1', '10', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('30', null, '1', '10', '1', '10', '1', null, null, null);
INSERT INTO `workflows` VALUES ('31', '4', '4', '3', '2', '2', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('32', '4', '4', '3', '1', '4', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('33', '2', '4', '8', '2', '2', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('34', '2', '4', '8', '1', '4', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('35', '3', '7', '1', '7', '3', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('36', '3', '7', '1', '1', '4', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('37', '7', '7', '3', '5', '2', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('38', '7', '7', '3', '1', '4', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('39', '7', '5', '2', '7', '7', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('40', '7', '5', '2', '7', '8', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('41', null, '7', '8', '5', '2', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('42', '5', '7', '8', '1', '4', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('43', '5', '7', '8', '5', '2', '1', null, null, '1');
INSERT INTO `workflows` VALUES ('44', '5', '7', '7', '8', '2', '1', null, null, null);
