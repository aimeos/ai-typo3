--
-- Customer database definition
--
-- License LGPLv3, http://opensource.org/licenses/LGPL-3.0
-- Copyright (c) Metaways Infosystems GmbH, 2013
-- Copyright (c) Aimeos (aimeos.org), 2014
--


SET SESSION sql_mode='ANSI';



--
-- Table structure for table `fe_users_address`
--
CREATE TABLE "fe_users_address" (
	-- Unique address id
	"id" INTEGER NOT NULL AUTO_INCREMENT,
	-- site id, references mshop_locale_site.id
	"siteid" INTEGER NOT NULL,
	-- parent id for customer
	"parentid" INTEGER NOT NULL,
	-- company name
	"company" VARCHAR(100) NOT NULL,
	-- vatid
	"vatid" VARCHAR(32) NOT NULL,
	-- customer/supplier categorization
	"salutation" VARCHAR(8) NOT NULL,
	-- title of the customer/supplier
	"title" VARCHAR(64) NOT NULL,
	-- first name of customer/supplier
	"firstname" VARCHAR(64) NOT NULL,
	-- last name of customer/supplier
	"lastname" VARCHAR(64) NOT NULL,
	-- Depending on country, e.g. house name
	"address1" VARCHAR(255) NOT NULL,
	-- Depending on country, e.g. street
	"address2" VARCHAR(255) NOT NULL,
	-- Depending on country, e.g. county/suburb
	"address3" VARCHAR(255) NOT NULL,
	-- postal code of customer/supplier
	"postal" VARCHAR(16) NOT NULL,
	-- city name of customer/supplier
	"city" VARCHAR(255) NOT NULL,
	-- state name of customer/supplier
	"state" VARCHAR(255) NOT NULL,
	-- language id
	"langid" VARCHAR(5) NULL,
	-- Country id the customer/supplier is living in
	"countryid" CHAR(2) NULL,
	-- Telephone number of the customer/supplier
	"telephone" VARCHAR(32) NOT NULL,
	-- Email of the customer/supplier
	"email" VARCHAR(255) NOT NULL,
	-- Telefax of the customer/supplier
	"telefax" VARCHAR(255) NOT NULL,
	-- Website of the customer/supplier
	"website" VARCHAR(255) NOT NULL,
	-- Generic flag
	"flag" INTEGER NOT NULL,
	-- Position
	"pos" SMALLINT NOT NULL default 0,
	-- Date of last modification of this database entry
	"mtime" DATETIME NOT NULL,
	-- Date of creation of this database entry
	"ctime" DATETIME NOT NULL,
	-- Editor who modified this entry at last
	"editor" VARCHAR(255) NOT NULL,
CONSTRAINT "pk_t3feuad_id"
	PRIMARY KEY ("id")
) ENGINE=InnoDB CHARACTER SET = utf8;

CREATE INDEX "idx_t3feuad_pid" ON "fe_users_address" ("parentid");

CREATE INDEX "idx_t3feuad_sid_ln_fn" ON "fe_users_address" ("siteid", "lastname", "firstname");

CREATE INDEX "idx_t3feuad_sid_ad1_ad2" ON "fe_users_address" ("siteid", "address1", "address2");

CREATE INDEX "idx_t3feuad_sid_post_ci" ON "fe_users_address" ("siteid", "postal", "city");

CREATE INDEX "idx_t3feuad_sid_rid" ON "fe_users_address" ("siteid", "refid");

CREATE INDEX "idx_t3feuad_sid_lastname" ON "fe_users_address" ("siteid", "lastname");

CREATE INDEX "idx_t3feuad_sid_postal" ON "fe_users_address" ("siteid", "postal");

CREATE INDEX "idx_t3feuad_sid_city" ON "fe_users_address" ("siteid", "city");

CREATE INDEX "idx_t3feuad_sid_addr1" ON "fe_users_address" ("siteid", "address1");

CREATE INDEX "idx_t3feuad_sid_rid" ON "fe_users_address" ("siteid", "email");


--
-- Table structure for table `fe_users_list_type`
--

CREATE TABLE "fe_users_list_type" (
	-- Unique id
	"id" INTEGER NOT NULL AUTO_INCREMENT,
	-- site id, references mshop_locale_site.id
	"siteid" INTEGER NOT NULL,
	-- domain
	"domain" VARCHAR(32) NOT NULL,
	-- code
	"code"  VARCHAR(32) NOT NULL COLLATE utf8_bin,
	-- Name of the list type
	"label" VARCHAR(255) NOT NULL,
	-- Status (0=disabled, 1=enabled, >1 for special)
	"status" SMALLINT NOT NULL,
	-- Date of last modification of this database entry
	"mtime" DATETIME NOT NULL,
	-- Date of creation of this database entry
	"ctime" DATETIME NOT NULL,
	-- Editor who modified this entry at last
	"editor" VARCHAR(255) NOT NULL,
CONSTRAINT "pk_t3feulity_id"
	PRIMARY KEY ("id"),
CONSTRAINT "unq_t3feulity_sid_dom_code"
	UNIQUE ("siteid", "domain", "code")
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX "idx_t3feulity_sid_status" ON "fe_users_list_type" ("siteid", "status");

CREATE INDEX "idx_t3feulity_sid_label" ON "fe_users_list_type" ("siteid", "label");

CREATE INDEX "idx_t3feulity_sid_code" ON "fe_users_list_type" ("siteid", "code");


--
-- Table structure for table `fe_users_list`
--

CREATE TABLE "fe_users_list" (
	-- Unique list id
	"id" INTEGER NOT NULL AUTO_INCREMENT,
	-- text id (parent id)
	"parentid" INTEGER NOT NULL,
	-- site id, references mshop_locale_site.id
	"siteid" INTEGER NOT NULL,
	-- typeid
	"typeid" INTEGER NOT NULL,
	-- domain (e.g.: text, media)
	"domain" VARCHAR(32) NOT NULL,
	-- Reference of the object in given domain
	"refid" VARCHAR(32) NOT NULL,
	-- Valid from
	"start" DATETIME DEFAULT NULL,
	-- Valid until
	"end" DATETIME DEFAULT NULL,
	-- Configuration
	"config" TEXT NOT NULL,
	-- Precedence rating
	"pos" INTEGER NOT NULL,
	-- Status (0=disabled, 1=enabled, >1 for special)
	"status" SMALLINT NOT NULL,
	-- Date of last modification of this database entry
	"mtime" DATETIME NOT NULL,
	-- Date of creation of this database entry
	"ctime" DATETIME NOT NULL,
	-- Editor who modified this entry at last
	"editor" VARCHAR(255) NOT NULL,
CONSTRAINT "pk_t3feuli_id"
	PRIMARY KEY ("id"),
CONSTRAINT "unq_t3feuli_sid_dm_rid_tid_pid"
	UNIQUE ("siteid", "domain", "refid", "typeid", "parentid"),
CONSTRAINT "fk_t3feuli_typeid"
	FOREIGN KEY ( "typeid" )
	REFERENCES "fe_users_list_type" ("id")
	ON DELETE CASCADE
	ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE INDEX "idx_t3feuli_parentid" ON "fe_users_list" ("parentid");

CREATE INDEX "idx_t3feuli_sid_stat_start_end" ON "fe_users_list" ("siteid", "status", "start", "end");

CREATE INDEX "idx_t3feuli_pid_sid_rid_dom_tid" ON "fe_users_list" ("parentid", "siteid", "refid", "domain", "typeid");

CREATE INDEX "idx_t3feuli_pid_sid_start" ON "fe_users_list" ("parentid", "siteid", "start");

CREATE INDEX "idx_t3feuli_pid_sid_end" ON "fe_users_list" ("parentid", "siteid", "end");

CREATE INDEX "idx_t3feuli_pid_sid_pos" ON "fe_users_list" ("parentid", "siteid", "pos");
