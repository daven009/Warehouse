# ************************************************************
# Sequel Pro SQL dump
# Version 3408
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.33)
# Database: warehouse
# Generation Time: 2014-02-15 14:22:49 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table acos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `acos`;

CREATE TABLE `acos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT '',
  `foreign_key` int(10) unsigned DEFAULT NULL,
  `alias` varchar(255) DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table aros
# ------------------------------------------------------------

DROP TABLE IF EXISTS `aros`;

CREATE TABLE `aros` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) DEFAULT NULL,
  `model` varchar(255) DEFAULT '',
  `foreign_key` int(10) unsigned DEFAULT NULL,
  `alias` varchar(255) DEFAULT '',
  `lft` int(10) DEFAULT NULL,
  `rght` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `aros` WRITE;
/*!40000 ALTER TABLE `aros` DISABLE KEYS */;

INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`)
VALUES
	(1,NULL,'Group',1,'',1,4),
	(2,NULL,'Group',2,'',5,8),
	(3,1,'User',1,'',2,3),
	(5,2,'User',3,'',6,7);

/*!40000 ALTER TABLE `aros` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table aros_acos
# ------------------------------------------------------------

DROP TABLE IF EXISTS `aros_acos`;

CREATE TABLE `aros_acos` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `aro_id` int(10) unsigned NOT NULL,
  `aco_id` int(10) unsigned NOT NULL,
  `_create` char(2) NOT NULL DEFAULT '0',
  `_read` char(2) NOT NULL DEFAULT '0',
  `_update` char(2) NOT NULL DEFAULT '0',
  `_delete` char(2) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;



# Dump of table companies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `companies`;

CREATE TABLE `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_group_id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `postal_code` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `company_group_id` (`company_group_id`),
  CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`company_group_id`) REFERENCES `company_groups` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `companies` WRITE;
/*!40000 ALTER TABLE `companies` DISABLE KEYS */;

INSERT INTO `companies` (`id`, `company_group_id`, `name`, `address`, `postal_code`, `created`, `modified`)
VALUES
	(1,1,'Center Company','21 Lower Kent Ridge Rd','119077',NULL,NULL),
	(2,3,'Supplier A','12 York hill','163012','2014-02-09 06:33:42','2014-02-09 06:33:42');

/*!40000 ALTER TABLE `companies` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table company_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `company_groups`;

CREATE TABLE `company_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `company_groups` WRITE;
/*!40000 ALTER TABLE `company_groups` DISABLE KEYS */;

INSERT INTO `company_groups` (`id`, `name`, `created`, `modified`)
VALUES
	(1,'Dealer',NULL,NULL),
	(2,'Distributor',NULL,NULL),
	(3,'Supplier',NULL,NULL);

/*!40000 ALTER TABLE `company_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contact_statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contact_statuses`;

CREATE TABLE `contact_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `contact_statuses` WRITE;
/*!40000 ALTER TABLE `contact_statuses` DISABLE KEYS */;

INSERT INTO `contact_statuses` (`id`, `name`)
VALUES
	(1,'Dealer'),
	(2,'Distributor'),
	(3,'Supplier');

/*!40000 ALTER TABLE `contact_statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contacts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contacts`;

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `photo_dir` varchar(255) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `phone` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `contact_status_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;

INSERT INTO `contacts` (`id`, `company`, `first_name`, `last_name`, `photo`, `photo_dir`, `city`, `phone`, `email`, `contact_status_id`, `user_id`, `created`, `modified`)
VALUES
	(1,'Supplier A','Daven','Shen',NULL,'','Singapore','99999999','daven.shen@gmail.com',3,1,'2014-02-08 11:44:14','2014-02-08 11:44:14');

/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table contacts_events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `contacts_events`;

CREATE TABLE `contacts_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table deal_statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `deal_statuses`;

CREATE TABLE `deal_statuses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `deal_statuses` WRITE;
/*!40000 ALTER TABLE `deal_statuses` DISABLE KEYS */;

INSERT INTO `deal_statuses` (`id`, `name`)
VALUES
	(4,'Process'),
	(5,'Accepted'),
	(6,'Rejected');

/*!40000 ALTER TABLE `deal_statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table deals
# ------------------------------------------------------------

DROP TABLE IF EXISTS `deals`;

CREATE TABLE `deals` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_id` int(11) DEFAULT NULL,
  `deal_status_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `amount` decimal(20,6) DEFAULT '0.000000',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table event_types
# ------------------------------------------------------------

DROP TABLE IF EXISTS `event_types`;

CREATE TABLE `event_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `event_types` WRITE;
/*!40000 ALTER TABLE `event_types` DISABLE KEYS */;

INSERT INTO `event_types` (`id`, `name`, `color`)
VALUES
	(1,'Default Type','Orange');

/*!40000 ALTER TABLE `event_types` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_type_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime NOT NULL,
  `all_day` tinyint(1) NOT NULL DEFAULT '1',
  `status` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Scheduled',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created` date DEFAULT NULL,
  `modified` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table events_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `events_users`;

CREATE TABLE `events_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table goods
# ------------------------------------------------------------

DROP TABLE IF EXISTS `goods`;

CREATE TABLE `goods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `unit` varchar(10) NOT NULL DEFAULT '',
  `sales_price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `remark` text,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `goods` WRITE;
/*!40000 ALTER TABLE `goods` DISABLE KEYS */;

INSERT INTO `goods` (`id`, `name`, `description`, `unit`, `sales_price`, `remark`, `created`, `modified`)
VALUES
	(1,'Item A','This is a test item','PC',10.00,'This is a remark',NULL,NULL),
	(2,'Item B','this is another item','PC',11.00,'test remark','2014-02-15 11:37:39','2014-02-15 11:52:29'),
	(3,'Item C','This is a test item','PC',10.00,'This is a remark',NULL,NULL),
	(4,'Item D','this is another item','PC',11.00,'test remark','2014-02-15 11:37:39','2014-02-15 11:52:29'),
	(5,'Item C','This is a test item','PC',10.00,'This is a remark',NULL,NULL),
	(6,'Item D','this is another item','PC',11.00,'test remark','2014-02-15 11:37:39','2014-02-15 11:52:29'),
	(7,'Item C','This is a test item','PC',10.00,'This is a remark',NULL,NULL),
	(8,'Item D','this is another item','PC',11.00,'test remark','2014-02-15 11:37:39','2014-02-15 11:52:29'),
	(9,'Item C','This is a test item','PC',10.00,'This is a remark',NULL,NULL),
	(10,'Item D','this is another item','PC',11.00,'test remark','2014-02-15 11:37:39','2014-02-15 11:52:29'),
	(11,'Item C','This is a test item','PC',10.00,'This is a remark',NULL,NULL),
	(12,'Item D','this is another item','PC',11.00,'test remark','2014-02-15 11:37:39','2014-02-15 11:52:29'),
	(13,'Item C','This is a test item','PC',10.00,'This is a remark',NULL,NULL),
	(14,'Item D','this is another item','PC',11.00,'test remark','2014-02-15 11:37:39','2014-02-15 11:52:29'),
	(15,'Item C','This is a test item','PC',10.00,'This is a remark',NULL,NULL),
	(16,'Item D','this is another item','PC',11.00,'test remark','2014-02-15 11:37:39','2014-02-15 11:52:29'),
	(17,'Item C','This is a test item','PC',10.00,'This is a remark',NULL,NULL),
	(18,'Item D','this is another item','PC',11.00,'test remark','2014-02-15 11:37:39','2014-02-15 11:52:29'),
	(19,'Item C','This is a test item','PC',10.00,'This is a remark',NULL,NULL),
	(20,'Item D','this is another item','PC',11.00,'test remark','2014-02-15 11:37:39','2014-02-15 11:52:29'),
	(21,'Item C','This is a test item','PC',10.00,'This is a remark',NULL,NULL),
	(22,'Item D','this is another item','PC',11.00,'test remark','2014-02-15 11:37:39','2014-02-15 11:52:29');

/*!40000 ALTER TABLE `goods` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `groups`;

CREATE TABLE `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;

INSERT INTO `groups` (`id`, `name`, `created`, `modified`)
VALUES
	(1,'Administrator','2013-02-13 19:02:52','2013-02-13 19:02:52'),
	(2,'Employee','2013-02-13 19:04:13','2013-02-13 19:04:13'),
	(9999,'Super Admin','2013-02-13 19:04:13','2013-02-13 19:04:13');

/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table i18n
# ------------------------------------------------------------

DROP TABLE IF EXISTS `i18n`;

CREATE TABLE `i18n` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `locale` varchar(6) NOT NULL,
  `model` varchar(255) NOT NULL,
  `foreign_key` int(10) NOT NULL,
  `field` varchar(255) NOT NULL,
  `content` mediumtext,
  PRIMARY KEY (`id`),
  KEY `locale` (`locale`),
  KEY `model` (`model`),
  KEY `row_id` (`foreign_key`),
  KEY `field` (`field`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table options
# ------------------------------------------------------------

DROP TABLE IF EXISTS `options`;

CREATE TABLE `options` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) DEFAULT NULL,
  `value` longtext,
  `logo` varchar(255) DEFAULT NULL,
  `logo_dir` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;

INSERT INTO `options` (`id`, `name`, `value`, `logo`, `logo_dir`)
VALUES
	(1,'title','Zhen CRM',NULL,NULL),
	(2,'copyright','Telerim','E6B9D681-EACB-4563-AB84-F5DA585E5ED0.jpg','2'),
	(4,'email','admin@zhen-crm.com',NULL,NULL),
	(5,'email_title','Zhen-CRM',NULL,NULL),
	(6,'currency','$',NULL,NULL);

/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table stocks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `stocks`;

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `good_id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `remark` text,
  `model` varchar(40) DEFAULT NULL,
  `foreign_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `good_id` (`good_id`),
  KEY `company_id` (`company_id`),
  CONSTRAINT `stocks_ibfk_1` FOREIGN KEY (`good_id`) REFERENCES `goods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `stocks_ibfk_2` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

LOCK TABLES `stocks` WRITE;
/*!40000 ALTER TABLE `stocks` DISABLE KEYS */;

INSERT INTO `stocks` (`id`, `good_id`, `company_id`, `quantity`, `remark`, `model`, `foreign_id`, `created`, `modified`)
VALUES
	(1,1,1,10,NULL,NULL,NULL,NULL,NULL),
	(2,1,1,12,NULL,NULL,NULL,NULL,NULL),
	(3,1,1,2,'Test',NULL,NULL,'2014-02-10 18:13:09','2014-02-10 18:13:09');

/*!40000 ALTER TABLE `stocks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` char(50) NOT NULL,
  `group_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `token` char(50) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `company_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `username`, `password`, `group_id`, `created`, `modified`, `first_name`, `last_name`, `email`, `token`, `active`, `company_id`)
VALUES
	(1,'admin','7f6d406256568db88d5ed3cfc312565debdb2d8e',9999,'2013-02-13 19:05:34','2014-02-09 07:05:09','Adam','Smith','admin@domain.com','INeVF57PBYcMrA#lS13wayU4Zd#m08sjzO$ELpgX',1,1),
	(6,'user','7f6d406256568db88d5ed3cfc312565debdb2d8e',2,'2014-02-02 04:14:21','2014-02-09 07:24:17','User','Normal','user@test.com',NULL,1,1),
	(8,'supplieradmin','7f6d406256568db88d5ed3cfc312565debdb2d8e',1,'2014-02-15 14:16:04','2014-02-15 14:16:04','Admin','Supplier A','suppliera@test.com',NULL,1,2);

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
