--
-- License LGPLv3, http://opensource.org/licenses/LGPL-3.0
-- Copyright (c) Metaways Infosystems GmbH, 2011
-- Copyright (c) Aimeos (aimeos.org), 2014-2015
--


-- Do not enable for setup as this hides errors
-- SET NAMES 'utf8';


--
-- TYPO3 table strutures
--

CREATE TABLE IF NOT EXISTS `fe_users` (
	`uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
	`pid` int(11) unsigned NOT NULL DEFAULT '0',
	`tstamp` int(11) unsigned NOT NULL DEFAULT '0',
	`siteid` int(11) DEFAULT NULL,
	`username` varchar(50) DEFAULT NULL,
	`password` varchar(40) DEFAULT NULL,
	`usergroup` tinytext,
	`disable` tinyint(4) unsigned NOT NULL DEFAULT '0',
	`starttime` int(11) unsigned NOT NULL DEFAULT '0',
	`endtime` int(11) unsigned NOT NULL DEFAULT '0',
	`name` varchar(100) DEFAULT '',
	`first_name` varchar(50) DEFAULT NULL,
	`middle_name` varchar(50) DEFAULT NULL,
	`last_name` varchar(50) DEFAULT NULL,
	`address` varchar(255) DEFAULT NULL,
	`telephone` varchar(20) DEFAULT NULL,
	`fax` varchar(20) DEFAULT NULL,
	`email` varchar(80) DEFAULT NULL,
	`crdate` int(11) unsigned NOT NULL DEFAULT '0',
	`cruser_id` int(11) unsigned NOT NULL DEFAULT '0',
	`lockToDomain` varchar(50) DEFAULT NULL,
	`deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
	`uc` blob,
	`title` varchar(40) DEFAULT NULL,
	`zip` varchar(20) DEFAULT '',
	`city` varchar(50) DEFAULT NULL,
	`country` varchar(60) DEFAULT '',
	`www` varchar(80) DEFAULT NULL,
	`company` varchar(80) DEFAULT NULL,
	`vatid` varchar(32) DEFAULT NULL,
	`image` tinytext,
	`TSconfig` text,
	`fe_cruser_id` int(10) unsigned NOT NULL DEFAULT '0',
	`lastlogin` int(10) unsigned NOT NULL DEFAULT '0',
	`is_online` int(10) unsigned NOT NULL DEFAULT '0',
	`felogin_redirectPid` tinytext,
	`felogin_forgotHash` varchar(80) DEFAULT NULL,
	`tx_extbase_type` varchar(255) DEFAULT NULL,
	`static_info_country` char(3) NOT NULL DEFAULT '',
	`zone` varchar(45) NOT NULL DEFAULT '',
	`language` char(2) NOT NULL DEFAULT '',
	`gender` int(11) unsigned NOT NULL DEFAULT '99',
	`cnum` varchar(50) NOT NULL DEFAULT '',
	`status` int(11) unsigned NOT NULL DEFAULT '0',
	`comments` text NOT NULL,
	`by_invitation` tinyint(4) unsigned NOT NULL DEFAULT '0',
	`module_sys_dmail_html` tinyint(3) unsigned NOT NULL DEFAULT '0',
	`terms_acknowledged` tinyint(4) unsigned NOT NULL DEFAULT '0',
	`token` varchar(32) NOT NULL DEFAULT '',
	`tx_srfeuserregister_password` blob NOT NULL,
	`date_of_birth` int(11) NOT NULL DEFAULT '0',
	`longitude` decimal(8,6) DEFAULT NULL,
	`latitude` decimal(8,6) DEFAULT NULL,
	PRIMARY KEY (`uid`),
	KEY `parent` (`pid`,`username`),
	KEY `username` (`username`),
	KEY `is_online` (`is_online`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `fe_groups` (
  `tx_extbase_type` varchar(255) NOT NULL DEFAULT '0',
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned NOT NULL DEFAULT '0',
  `tstamp` int(11) unsigned NOT NULL DEFAULT '0',
  `crdate` int(11) unsigned NOT NULL DEFAULT '0',
  `cruser_id` int(11) unsigned NOT NULL DEFAULT '0',
  `title` varchar(50) NOT NULL DEFAULT '',
  `hidden` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `lockToDomain` varchar(50) NOT NULL DEFAULT '',
  `deleted` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `description` text NOT NULL,
  `subgroup` tinytext NOT NULL,
  `TSconfig` text NOT NULL,
  `felogin_redirectPid` tinytext,
  `tx_phpunit_is_dummy_record` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE IF NOT EXISTS `static_countries` (
  `uid` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) unsigned DEFAULT '0',
  `deleted` tinyint(4) NOT NULL DEFAULT '0',
  `cn_iso_2` char(2) DEFAULT '',
  `cn_iso_3` char(3) DEFAULT '',
  `cn_iso_nr` int(11) unsigned DEFAULT '0',
  `cn_parent_tr_iso_nr` int(11) unsigned DEFAULT '0',
  `cn_official_name_local` varchar(128) DEFAULT '',
  `cn_official_name_en` varchar(128) DEFAULT '',
  `cn_capital` varchar(45) DEFAULT '',
  `cn_tldomain` char(2) DEFAULT '',
  `cn_currency_iso_3` char(3) DEFAULT '',
  `cn_currency_iso_nr` int(10) unsigned DEFAULT '0',
  `cn_phone` int(10) unsigned DEFAULT '0',
  `cn_eu_member` tinyint(3) unsigned DEFAULT '0',
  `cn_address_format` tinyint(3) unsigned DEFAULT '0',
  `cn_zone_flag` tinyint(4) DEFAULT '0',
  `cn_short_local` varchar(70) DEFAULT '',
  `cn_short_en` varchar(50) DEFAULT '',
  `cn_uno_member` tinyint(3) unsigned DEFAULT '0',
  PRIMARY KEY (`uid`),
  KEY `parent` (`pid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


START TRANSACTION;


--
-- Typo3 tables
--
DELETE FROM `fe_users_property` WHERE parentid IN ( SELECT `uid` FROM `fe_users` WHERE `lockToDomain` = 'unittest.aimeos.org' );
DELETE FROM `fe_users_address` WHERE parentid IN ( SELECT `uid` FROM `fe_users` WHERE `lockToDomain` = 'unittest.aimeos.org' );
DELETE FROM `fe_users_list` WHERE parentid IN ( SELECT `uid` FROM `fe_users` WHERE `lockToDomain` = 'unittest.aimeos.org' );
DELETE FROM `fe_users` WHERE `lockToDomain` = 'unittest.aimeos.org';
DELETE FROM `fe_groups` WHERE `lockToDomain` = 'unittest.aimeos.org';


--
-- Typo3 frontend users
--
INSERT INTO `fe_users` ( `lockToDomain`, `name`, `username`, `gender`, `company`, `vatid`, `title`, `first_name`, `last_name`, `address`, `zip`, `city`, `zone`, `language`, `static_info_country`, `telephone`, `email`, `fax`, `www`, `date_of_birth`, `disable`, `password`, `tstamp`, `crdate`, `usergroup`, `longitude`, `latitude`)
	VALUES ( 'unittest.aimeos.org', 'unitCustomer1', 'UTC001', 0, 'ABC GmbH', 'DE999999999', 'Dr.', 'Max', 'Mustermann', 'Musterstraße 1a', '20001', 'Musterstadt', 'Hamburg', 'de', 'DEU', '055544332211', 'unitCustomer1@aimeos.org', '055544332212', 'unittest.aimeos.org', 0, '0', '5f4dcc3b5aa765d61d8327deb882cf99', 1294916626, 1294916616, '', '10.0', '50.0');
INSERT INTO `fe_users` ( `lockToDomain`, `name`, `username`, `gender`, `company`, `vatid`, `title`, `first_name`, `last_name`, `address`, `zip`, `city`, `zone`, `language`, `static_info_country`, `telephone`, `email`, `fax`, `www`, `date_of_birth`, `disable`, `password`, `tstamp`, `crdate`, `usergroup`, `longitude`, `latitude`)
	VALUES ( 'unittest.aimeos.org', 'unitCustomer2', 'UTC002', 1, 'ABC GmbH', 'DE999999999', 'Prof. Dr.', 'Erika', 'Mustermann', 'Heidestraße 17', '45632', 'Köln', '', 'de', 'DEU', '055544332211', 'unitCustomer2@aimeos.org', '055544332212', 'unittest.aimeos.org', 0, '1', '5f4dcc3b5aa765d61d8327deb882cf99', 1295916627, 1294916617, '1', '10.5', '51.0');
INSERT INTO `fe_users` ( `lockToDomain`, `name`, `username`, `gender`, `company`, `vatid`, `title`, `first_name`, `last_name`, `address`, `zip`, `city`, `zone`, `language`, `static_info_country`, `telephone`, `email`, `fax`, `www`, `date_of_birth`, `disable`, `password`, `tstamp`, `crdate`, `usergroup`, `longitude`, `latitude`)
	VALUES ( 'unittest.aimeos.org', 'unitCustomer3', 'UTC003', 0, 'ABC GmbH', 'DE999999999', '', 'Franz-Xaver', 'Gabler', 'Phantasiestraße 2', '23643', 'Berlin', 'Berlin', 'de', 'DEU', '055544332221', 'unitCustomer3@aimeos.org', '055544333212', 'unittest.aimeos.org', 0, '0', '5f4dcc3b5aa765d61d8327deb882cf99', 1295916628, 1294916618, '1,2,3', '11.0', '52.0');

--
-- Typo3 frontend groups
--
INSERT INTO `fe_groups` ( `lockToDomain`, `title`, `tstamp`, `crdate`, `tx_phpunit_is_dummy_record`)
	VALUES ( 'unittest.aimeos.org', 'Unit test group', 1294916626, 1294916616, 1);

--
-- Typo3 countries
--
INSERT INTO `static_countries` (`pid`, `deleted`, `cn_iso_2`, `cn_iso_3`, `cn_iso_nr`, `cn_parent_tr_iso_nr`, `cn_official_name_local`, `cn_official_name_en`, `cn_capital`, `cn_tldomain`, `cn_currency_iso_3`, `cn_currency_iso_nr`, `cn_phone`, `cn_eu_member`, `cn_address_format`, `cn_zone_flag`, `cn_short_local`, `cn_short_en`, `cn_uno_member`)
SELECT 0, 0, 'DE', 'DEU', 276, 155, 'Bundesrepublik Deutschland', 'Federal Republic of Germany', 'Berlin', 'de', 'EUR', 978, 49, 1, 1, 0, 'Deutschland', 'Germany', 1 FROM DUAL WHERE NOT EXISTS ( SELECT `cn_iso_2` FROM `static_countries` WHERE `cn_iso_2` = 'DE' );


COMMIT;
