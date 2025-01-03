<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2025
 */


return array(
	'manager' => array(
		'typo3' => array(
			'aggregate' => array(
				'ansi' => '
					SELECT :keys, COUNT("val") AS "count"
					FROM (
						SELECT :acols, :val AS "val"
						FROM "fe_users" mcus
						:joins
						WHERE :cond
						GROUP BY mcus.uid, :cols, :val
						ORDER BY mcus.uid DESC
					OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					) AS list
					GROUP BY :keys
				',
				'mysql' => '
					SELECT :keys, COUNT("val") AS "count"
					FROM (
						SELECT :acols, :val AS "val"
						FROM "fe_users" mcus
						:joins
						WHERE :cond
						GROUP BY mcus.uid, :cols, :val
						ORDER BY mcus.uid DESC
						LIMIT :size OFFSET :start
					) AS list
					GROUP BY :keys
				'
			),
			'clear' => array(
				'ansi' => '
					DELETE FROM "fe_users"
					WHERE :cond AND "siteid" LIKE ?
				',
			),
			'delete' => array(
				'ansi' => '
					DELETE FROM "fe_users"
					WHERE :cond AND ( "siteid" LIKE ? OR siteid = ? )
				',
			),
			'insert' => array(
				'ansi' => '
					INSERT INTO "fe_users" ( :names
						"name", "username", "gender", "company", "vatid",
						"title", "first_name", "last_name", "address", "zip", "city", "zone",
						"language", "telephone", "mobile", "email", "fax", "www", "longitude", "latitude",
						"date_of_birth", "disable", "password", "tstamp", "static_info_country",
						"usergroup", "pid", "editor", "siteid", "crdate"
					) VALUES ( :values
						?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
					)
				',
			),
			'update' => array(
				'ansi' => '
					UPDATE "fe_users"
					SET :names
						"name" = ?, "username" = ?, "gender" = ?, "company" = ?, "vatid" = ?, "title" = ?,
						"first_name" = ?, "last_name" = ?, "address" = ?, "zip" = ?, "city" = ?, "zone" = ?,
						"language" = ?, "telephone" = ?, "mobile" = ?, "email" = ?, "fax" = ?, "www" = ?, "longitude" = ?,
						"latitude" = ?, "date_of_birth" = ?, "disable" = ?, "password" = ?, "tstamp" = ?,
						"static_info_country" = ?, "usergroup" = ?, "pid" = ?, "editor" = ?
					WHERE ( "siteid" LIKE ? OR siteid = ? ) AND "uid" = ?
				',
			),
			'search' => array(
				'ansi' => '
					SELECT :columns
					FROM "fe_users" as mcus
					:joins
					WHERE :cond AND mcus."deleted" = 0
					GROUP BY :group
					ORDER BY :order
					OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
				',
				'mysql' => '
					SELECT :columns
					FROM "fe_users" as mcus
					:joins
					WHERE :cond AND mcus."deleted" = 0
					GROUP BY :group
					ORDER BY :order
					LIMIT :size OFFSET :start
				',
			),
			'count' => array(
				'ansi' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT mcus."uid"
						FROM "fe_users" mcus
						:joins
						WHERE :cond AND mcus."deleted" = 0
						GROUP BY mcus."uid"
						OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
					) AS list
				',
				'mysql' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT mcus."uid"
						FROM "fe_users" mcus
						:joins
						WHERE :cond AND mcus."deleted" = 0
						GROUP BY mcus."uid"
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
		),
	),
);
