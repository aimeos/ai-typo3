<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2011
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */

return array(
	'item' => array(
		'delete' => '
			DELETE FROM "fe_users"
			WHERE :cond
		',
		'insert' => '
			INSERT INTO "fe_users" ("name", "username", "gender", "company", "vatid", "title", "first_name", "last_name",
				"address", "zip", "city", "zone", "language", "telephone", "email",
				"fax", "www", "date_of_birth", "disable", "password", "tstamp", "static_info_country", "crdate", "pid")
			SELECT ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,( SELECT "cn_iso_3" FROM "static_countries" WHERE "cn_iso_2"=? LIMIT 1 ),?,? FROM DUAL
		',
		'update' => '
			UPDATE "fe_users"
			SET "name"=?, "username"=?, "gender"=?, "company"=?, "vatid"=?, "title"=?, "first_name"=?, "last_name"=?,
				"address"=?, "zip"=?, "city"=?, "zone"=?, "language"=?, "telephone"=?, "email"=?,
				"fax"=?, "www"=?, "date_of_birth"=?, "disable"=?, "password"=?, "tstamp"=?,
				"static_info_country"=( SELECT "cn_iso_3" FROM "static_countries" WHERE "cn_iso_2"=? LIMIT 1 )
			WHERE "uid"=?
		',
		'search' => '
			SELECT DISTINCT t3feu."uid" AS "id", t3feu."name" AS "label", t3feu."username" AS "code", t3feu."gender",
				t3feu."company", t3feu."vatid", t3feu."title", t3feu."first_name" AS "firstname", t3feu."last_name" AS "lastname",
				t3feu."address" AS "address1", t3feu."zip" AS "postal", t3feu."city", t3feu."zone" AS "state",
				t3feu."language" AS "langid", tsc."cn_iso_2" AS "countryid", t3feu."telephone", t3feu."email",
				t3feu."fax" AS "telefax", t3feu."www" AS "website", t3feu."date_of_birth", t3feu."disable", t3feu."password",
				t3feu."crdate", t3feu."tstamp"
			FROM "fe_users" as t3feu
			LEFT JOIN "static_countries" AS tsc ON t3feu."static_info_country" = tsc."cn_iso_3"
			:joins
			WHERE :cond
				AND t3feu."deleted" = 0
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
		'count' => '
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
);