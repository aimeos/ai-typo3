<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */

return array(
	'delete' => array(
		'ansi' => '
			DELETE FROM "fe_users_address"
			WHERE :cond
			AND siteid = ?
		',
	),
	'insert' => array(
		'ansi' => '
			INSERT INTO "fe_users_address" ("siteid", "parentid", "company", "vatid","salutation","title",
				"firstname","lastname","address1","address2","address3","postal","city","state",
				"countryid","langid","telephone","email","telefax","website","flag","pos", "mtime", "editor", "ctime" )
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "fe_users_address"
			SET "siteid"=?, "parentid"=?, "company"=?, "vatid"=?, "salutation"=?, "title"=?, "firstname"=?, "lastname"=?,
				"address1"=?, "address2"=?, "address3"=?, "postal"=?, "city"=?, "state"=?, "countryid"=?,
				"langid"=?, "telephone"=?, "email"=?, "telefax"=?, "website"=?, "flag"=?, "pos"=?,
				"mtime"=?, "editor"=?
			WHERE "id"=?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT t3feuad."id" AS "customer.address.id", t3feuad."siteid" AS "customer.address.siteid",
				t3feuad."parentid" AS "customer.address.parentid", t3feuad."pos" AS "customer.address.position",
				t3feuad."company" AS "customer.address.company", t3feuad."vatid" AS "customer.address.vatid",
				t3feuad."salutation" AS "customer.address.salutation", t3feuad."title" AS "customer.address.title",
				t3feuad."firstname" AS "customer.address.firstname", t3feuad."lastname" AS "customer.address.lastname",
				t3feuad."address1" AS "customer.address.address1", t3feuad."address2" AS "customer.address.address2",
				t3feuad."address3" AS "customer.address.address3", t3feuad."postal" AS "customer.address.postal",
				t3feuad."city" AS "customer.address.city", t3feuad."state" AS "customer.address.state",
				t3feuad."countryid" AS "customer.address.countryid", t3feuad."langid" AS "customer.address.languageid",
				t3feuad."telephone" AS "customer.address.telephone", t3feuad."email" AS "customer.address.email",
				t3feuad."telefax" AS "customer.address.telefax", t3feuad."website" AS "customer.address.website",
				t3feuad."flag" AS "customer.address.flag", t3feuad."mtime" AS "customer.address.mtime",
				t3feuad."editor" AS "customer.address.editor", t3feuad."ctime" AS "customer.address.ctime"
			FROM "fe_users_address" AS t3feuad
			:joins
			WHERE :cond
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
	),
	'count' => array(
		'ansi' => '
			SELECT COUNT(*) AS "count"
			FROM (
				SELECT DISTINCT t3feuad."id"
				FROM "fe_users_address" AS t3feuad
				:joins
				WHERE :cond
				LIMIT 10000 OFFSET 0
			) AS list
		',
	),
	'newid' => array(
		'mysql' => 'SELECT LAST_INSERT_ID()'
	),
);
