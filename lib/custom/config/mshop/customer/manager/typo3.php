<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014
 */

return array(
	'delete' => array(
		'ansi' => '
			DELETE FROM "fe_users"
			WHERE :cond
		',
	),
	'insert' => array(
		'ansi' => '
			INSERT INTO "fe_users" ("name", "username", "gender", "company", "vatid", "title", "first_name", "last_name",
				"address", "zip", "city", "zone", "language", "telephone", "email",
				"fax", "www", "date_of_birth", "disable", "password", "tstamp", "static_info_country", "usergroup", "crdate", "pid")
			SELECT ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,( SELECT "cn_iso_3" FROM "static_countries" WHERE "cn_iso_2"=? LIMIT 1 ),?,?,? FROM DUAL
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "fe_users"
			SET "name"=?, "username"=?, "gender"=?, "company"=?, "vatid"=?, "title"=?, "first_name"=?, "last_name"=?,
				"address"=?, "zip"=?, "city"=?, "zone"=?, "language"=?, "telephone"=?, "email"=?,
				"fax"=?, "www"=?, "date_of_birth"=?, "disable"=?, "password"=?, "tstamp"=?,
				"static_info_country"=( SELECT "cn_iso_3" FROM "static_countries" WHERE "cn_iso_2"=? LIMIT 1 ), "usergroup"=?
			WHERE "uid"=?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT DISTINCT t3feu."uid" AS "customer.id", t3feu."name" AS "customer.label",
				t3feu."username" AS "customer.code", t3feu."title" AS "customer.title",
				t3feu."company" AS "customer.company", t3feu."vatid" AS "customer.vatid",
				t3feu."first_name" AS "customer.firstname", t3feu."last_name" AS "customer.lastname",
				t3feu."address" AS "customer.address1", t3feu."zip" AS "customer.postal",
				t3feu."city" AS "customer.city", t3feu."zone" AS "customer.state",
				tsc."cn_iso_2" AS "customer.countryid", t3feu."language" AS "customer.languageid",
				t3feu."telephone" AS "customer.telephone", t3feu."email" AS "customer.email",
				t3feu."fax" AS "customer.telefax", t3feu."www" AS "customer.website",
				t3feu."password" AS "customer.password", t3feu."gender",
				t3feu."date_of_birth", t3feu."disable",
				t3feu."crdate", t3feu."tstamp",
				t3feu."usergroup" as "groups"
			FROM "fe_users" as t3feu
			LEFT JOIN "static_countries" AS tsc ON t3feu."static_info_country" = tsc."cn_iso_3"
			:joins
			WHERE :cond
				AND t3feu."deleted" = 0
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
	),
	'count' => array(
		'ansi' => '
			SELECT COUNT(*) AS "count"
			FROM (
				SELECT DISTINCT t3feu."uid"
				FROM "fe_users" AS t3feu
				LEFT JOIN "static_countries" AS tsc ON t3feu."static_info_country" = tsc."cn_iso_3"
				:joins
				WHERE :cond
					AND t3feu."deleted" = 0
				LIMIT 10000 OFFSET 0
			) AS list
		',
	),
	'newid' => array(
		'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
		'mysql' => 'SELECT LAST_INSERT_ID()',
		'oracle' => 'SELECT fe_users.CURRVAL FROM DUAL',
		'pgsql' => 'SELECT lastval()',
		'sqlite' => 'SELECT last_insert_rowid()',
		'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
		'sqlanywhere' => 'SELECT @@IDENTITY',
	),
);