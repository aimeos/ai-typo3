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
			INSERT INTO "fe_users_address" ("siteid", "refid", "company", "vatid","salutation","title",
				"firstname","lastname","address1","address2","address3","postal","city","state",
				"countryid","langid","telephone","email","telefax","website","flag","pos", "mtime", "editor", "ctime" )
			VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "fe_users_address"
			SET "siteid"=?, "refid"=?, "company"=?, "vatid"=?, "salutation"=?, "title"=?, "firstname"=?, "lastname"=?,
				"address1"=?, "address2"=?, "address3"=?, "postal"=?, "city"=?, "state"=?, "countryid"=?,
				"langid"=?, "telephone"=?, "email"=?, "telefax"=?, "website"=?, "flag"=?, "pos"=?,
				"mtime"=?, "editor"=?
			WHERE "id"=?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT t3feuad."id", t3feuad."siteid", t3feuad."refid", t3feuad."company", t3feuad."vatid", t3feuad."salutation", t3feuad."title",
				t3feuad."firstname", t3feuad."lastname", t3feuad."address1", t3feuad."address2", t3feuad."address3",
				t3feuad."postal", t3feuad."city", t3feuad."state", t3feuad."countryid", t3feuad."langid", t3feuad."telephone",
				t3feuad."email", t3feuad."telefax", t3feuad."website", t3feuad."flag", t3feuad."pos",
				t3feuad."mtime", t3feuad."editor", t3feuad."ctime"
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
