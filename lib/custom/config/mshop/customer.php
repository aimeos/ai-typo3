<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 */


return array(
	'manager' => array(
		'address' => array(
			'typo3' => array(
				'clear' => array(
					'ansi' => '
						DELETE FROM "fe_users_address"
						WHERE :cond AND siteid = ?
					',
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "fe_users_address"
						WHERE :cond AND ( siteid = ? OR siteid = \'\' )
					',
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "fe_users_address" ( :names
							"parentid", "company", "vatid", "salutation", "title",
							"firstname", "lastname", "address1", "address2", "address3",
							"postal", "city", "state", "countryid", "langid", "telephone",
							"email", "telefax", "website", "longitude", "latitude",
							"pos", "birthday", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					',
				),
				'update' => array(
					'ansi' => '
						UPDATE "fe_users_address"
						SET :names
							"parentid" = ?, "company" = ?, "vatid" = ?, "salutation" = ?,
							"title" = ?, "firstname" = ?, "lastname" = ?, "address1" = ?,
							"address2" = ?, "address3" = ?, "postal" = ?, "city" = ?,
							"state" = ?, "countryid" = ?, "langid" = ?, "telephone" = ?,
							"email" = ?, "telefax" = ?, "website" = ?, "longitude" = ?, "latitude" = ?,
							"pos" = ?, "birthday" = ?, "mtime" = ?, "editor" = ?
						WHERE ( siteid = ? OR siteid = \'\' ) AND "id" = ?
					',
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mcusad."id" AS "customer.address.id", mcusad."siteid" AS "customer.address.siteid",
							mcusad."parentid" AS "customer.address.parentid", mcusad."pos" AS "customer.address.position",
							mcusad."company" AS "customer.address.company", mcusad."vatid" AS "customer.address.vatid",
							mcusad."salutation" AS "customer.address.salutation", mcusad."title" AS "customer.address.title",
							mcusad."firstname" AS "customer.address.firstname", mcusad."lastname" AS "customer.address.lastname",
							mcusad."address1" AS "customer.address.address1", mcusad."address2" AS "customer.address.address2",
							mcusad."address3" AS "customer.address.address3", mcusad."postal" AS "customer.address.postal",
							mcusad."city" AS "customer.address.city", mcusad."state" AS "customer.address.state",
							mcusad."countryid" AS "customer.address.countryid", mcusad."langid" AS "customer.address.languageid",
							mcusad."telephone" AS "customer.address.telephone", mcusad."email" AS "customer.address.email",
							mcusad."telefax" AS "customer.address.telefax", mcusad."website" AS "customer.address.website",
							mcusad."longitude" AS "customer.address.longitude", mcusad."latitude" AS "customer.address.latitude",
							mcusad."mtime" AS "customer.address.mtime", mcusad."editor" AS "customer.address.editor",
							mcusad."ctime" AS "customer.address.ctime", mcusad."birthday" AS "customer.address.birthday"
						FROM "fe_users_address" mcusad
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							mcusad."id" AS "customer.address.id", mcusad."siteid" AS "customer.address.siteid",
							mcusad."parentid" AS "customer.address.parentid", mcusad."pos" AS "customer.address.position",
							mcusad."company" AS "customer.address.company", mcusad."vatid" AS "customer.address.vatid",
							mcusad."salutation" AS "customer.address.salutation", mcusad."title" AS "customer.address.title",
							mcusad."firstname" AS "customer.address.firstname", mcusad."lastname" AS "customer.address.lastname",
							mcusad."address1" AS "customer.address.address1", mcusad."address2" AS "customer.address.address2",
							mcusad."address3" AS "customer.address.address3", mcusad."postal" AS "customer.address.postal",
							mcusad."city" AS "customer.address.city", mcusad."state" AS "customer.address.state",
							mcusad."countryid" AS "customer.address.countryid", mcusad."langid" AS "customer.address.languageid",
							mcusad."telephone" AS "customer.address.telephone", mcusad."email" AS "customer.address.email",
							mcusad."telefax" AS "customer.address.telefax", mcusad."website" AS "customer.address.website",
							mcusad."longitude" AS "customer.address.longitude", mcusad."latitude" AS "customer.address.latitude",
							mcusad."mtime" AS "customer.address.mtime", mcusad."editor" AS "customer.address.editor",
							mcusad."ctime" AS "customer.address.ctime", mcusad."birthday" AS "customer.address.birthday"
						FROM "fe_users_address" mcusad
						:joins
						WHERE :cond
						ORDER BY :order
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcusad."id"
							FROM "fe_users_address" mcusad
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcusad."id"
							FROM "fe_users_address" mcusad
							:joins
							WHERE :cond
							LIMIT 10000 OFFSET 0
						) AS list
					',
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT fe_users_address.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'group' => array(
			'typo3' => array(
				'delete' => array(
					'ansi' => '
						DELETE FROM "fe_groups"
						WHERE :cond
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "fe_groups" ( :names
							"pid", "title", "description", "tstamp", "crdate"
						) VALUES ( :values
							?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "fe_groups"
						SET :names
							"pid" = ?, "title" = ?, "description" = ?, "tstamp" = ?
						WHERE "uid" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT
							mcusgr."uid" AS "customer.group.id", mcusgr."title" AS "customer.group.code",
							mcusgr."description" AS "customer.group.label", mcusgr."crdate", mcusgr."tstamp", mcusgr.*
						FROM "fe_groups" mcusgr
						:joins
						WHERE mcusgr."deleted" = 0 AND :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT
							mcusgr."uid" AS "customer.group.id", mcusgr."title" AS "customer.group.code",
							mcusgr."description" AS "customer.group.label", mcusgr."crdate", mcusgr."tstamp", mcusgr.*
						FROM "fe_groups" mcusgr
						:joins
						WHERE mcusgr."deleted" = 0 AND :cond
						ORDER BY :order
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcusgr."uid"
							FROM "fe_groups" mcusgr
							:joins
							WHERE mcusgr."deleted" = 0 AND :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcusgr."uid"
							FROM "fe_groups" mcusgr
							:joins
							WHERE mcusgr."deleted" = 0 AND :cond
							LIMIT 10000 OFFSET 0
						) AS list
					',
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT fe_groups_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'lists' => array(
			'type' => array(
				'typo3' => array(
					'insert' => array(
						'ansi' => '
							INSERT INTO "fe_users_list_type" ( :names
								"code", "domain", "label", "pos", "status",
								"mtime", "editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						',
					),
					'update' => array(
						'ansi' => '
							UPDATE "fe_users_list_type"
							SET :names
								"code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
								"status" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" = ? AND "id" = ?
						',
					),
					'delete' => array(
						'ansi' => '
							DELETE FROM "fe_users_list_type"
							WHERE :cond AND siteid = ?
						',
					),
					'search' => array(
						'ansi' => '
							SELECT :columns
								mcuslity."id" AS "customer.lists.type.id", mcuslity."siteid" AS "customer.lists.type.siteid",
								mcuslity."code" AS "customer.lists.type.code", mcuslity."domain" AS "customer.lists.type.domain",
								mcuslity."label" AS "customer.lists.type.label", mcuslity."status" AS "customer.lists.type.status",
								mcuslity."mtime" AS "customer.lists.type.mtime", mcuslity."editor" AS "customer.lists.type.editor",
								mcuslity."ctime" AS "customer.lists.type.ctime", mcuslity."pos" AS "customer.lists.type.position"
							FROM "fe_users_list_type" mcuslity
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						',
						'mysql' => '
							SELECT :columns
								mcuslity."id" AS "customer.lists.type.id", mcuslity."siteid" AS "customer.lists.type.siteid",
								mcuslity."code" AS "customer.lists.type.code", mcuslity."domain" AS "customer.lists.type.domain",
								mcuslity."label" AS "customer.lists.type.label", mcuslity."status" AS "customer.lists.type.status",
								mcuslity."mtime" AS "customer.lists.type.mtime", mcuslity."editor" AS "customer.lists.type.editor",
								mcuslity."ctime" AS "customer.lists.type.ctime", mcuslity."pos" AS "customer.lists.type.position"
							FROM "fe_users_list_type" mcuslity
							:joins
							WHERE :cond
							ORDER BY :order
							LIMIT :size OFFSET :start
						',
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mcuslity."id"
								FROM "fe_users_list_type" mcuslity
								:joins
								WHERE :cond
								OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
							) AS LIST
						',
						'mysql' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mcuslity."id"
								FROM "fe_users_list_type" mcuslity
								:joins
								WHERE :cond
								LIMIT 10000 OFFSET 0
							) AS LIST
						',
					),
					'newid' => array(
						'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
						'mysql' => 'SELECT LAST_INSERT_ID()',
						'oracle' => 'SELECT fe_users_list_type.CURRVAL FROM DUAL',
						'pgsql' => 'SELECT lastval()',
						'sqlite' => 'SELECT last_insert_rowid()',
						'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
						'sqlanywhere' => 'SELECT @@IDENTITY',
					),
				),
			),
			'typo3' => array(
				'aggregate' => array(
					'ansi' => '
						SELECT :keys, COUNT("id") AS "count"
						FROM (
							SELECT :acols, mcusli."id" AS "id"
							FROM "fe_users_list" mcusli
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						) AS list
						GROUP BY :keys
					',
					'mysql' => '
						SELECT :keys, COUNT("id") AS "count"
						FROM (
							SELECT :acols, mcusli."id" AS "id"
							FROM "fe_users_list" mcusli
							:joins
							WHERE :cond
							ORDER BY :order
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY :keys
					',
				),
				'delete' => array(
					'ansi' => '
						DELETE FROM "fe_users_list"
						WHERE :cond AND siteid = ?
					',
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "fe_users_list" ( :names
							"parentid", "key", "type", "domain", "refid", "start", "end",
							"config", "pos", "status", "mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					',
				),
				'update' => array(
					'ansi' => '
						UPDATE "fe_users_list"
						SET :names
							"parentid" = ?, "key" = ?, "type" = ?, "domain" = ?, "refid" = ?, "start" = ?,
							"end" = ?, "config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					',
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mcusli."id" AS "customer.lists.id", mcusli."parentid" AS "customer.lists.parentid",
							mcusli."siteid" AS "customer.lists.siteid", mcusli."type" AS "customer.lists.type",
							mcusli."domain" AS "customer.lists.domain", mcusli."refid" AS "customer.lists.refid",
							mcusli."start" AS "customer.lists.datestart", mcusli."end" AS "customer.lists.dateend",
							mcusli."config" AS "customer.lists.config", mcusli."pos" AS "customer.lists.position",
							mcusli."status" AS "customer.lists.status", mcusli."mtime" AS "customer.lists.mtime",
							mcusli."editor" AS "customer.lists.editor", mcusli."ctime" AS "customer.lists.ctime"
						FROM "fe_users_list" mcusli
						:joins
						WHERE :cond
						GROUP BY :columns
							mcusli."id", mcusli."parentid", mcusli."siteid", mcusli."type",
							mcusli."domain", mcusli."refid", mcusli."start", mcusli."end",
							mcusli."config", mcusli."pos", mcusli."status", mcusli."mtime",
							mcusli."editor", mcusli."ctime"
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							mcusli."id" AS "customer.lists.id", mcusli."parentid" AS "customer.lists.parentid",
							mcusli."siteid" AS "customer.lists.siteid", mcusli."type" AS "customer.lists.type",
							mcusli."domain" AS "customer.lists.domain", mcusli."refid" AS "customer.lists.refid",
							mcusli."start" AS "customer.lists.datestart", mcusli."end" AS "customer.lists.dateend",
							mcusli."config" AS "customer.lists.config", mcusli."pos" AS "customer.lists.position",
							mcusli."status" AS "customer.lists.status", mcusli."mtime" AS "customer.lists.mtime",
							mcusli."editor" AS "customer.lists.editor", mcusli."ctime" AS "customer.lists.ctime"
						FROM "fe_users_list" mcusli
						:joins
						WHERE :cond
						GROUP BY :columns
							mcusli."id", mcusli."parentid", mcusli."siteid", mcusli."type",
							mcusli."domain", mcusli."refid", mcusli."start", mcusli."end",
							mcusli."config", mcusli."pos", mcusli."status", mcusli."mtime",
							mcusli."editor", mcusli."ctime"
						ORDER BY :order
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcusli."id"
							FROM "fe_users_list" mcusli
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcusli."id"
							FROM "fe_users_list" mcusli
							:joins
							WHERE :cond
							LIMIT 10000 OFFSET 0
						) AS list
					',
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT fe_users_list.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
		'property' => array(
			'type' => array(
				'typo3' => array(
					'delete' => array(
						'ansi' => '
							DELETE FROM "fe_users_property_type"
							WHERE :cond AND siteid = ?
						'
					),
					'insert' => array(
						'ansi' => '
							INSERT INTO "fe_users_property_type" ( :names
								"code", "domain", "label", "pos", "status",
								"mtime", "editor", "siteid", "ctime"
							) VALUES ( :values
								?, ?, ?, ?, ?, ?, ?, ?, ?
							)
						'
					),
					'update' => array(
						'ansi' => '
							UPDATE "fe_users_property_type"
							SET :names
								"code" = ?, "domain" = ?, "label" = ?, "pos" = ?,
								"status" = ?, "mtime" = ?, "editor" = ?
							WHERE "siteid" = ? AND "id" = ?
						'
					),
					'search' => array(
						'ansi' => '
							SELECT :columns
								mcusprty."id" AS "customer.property.type.id", mcusprty."siteid" AS "customer.property.type.siteid",
								mcusprty."code" AS "customer.property.type.code", mcusprty."domain" AS "customer.property.type.domain",
								mcusprty."label" AS "customer.property.type.label", mcusprty."status" AS "customer.property.type.status",
								mcusprty."mtime" AS "customer.property.type.mtime", mcusprty."editor" AS "customer.property.type.editor",
								mcusprty."ctime" AS "customer.property.type.ctime", mcusprty."pos" AS "customer.property.type.position"
							FROM "fe_users_property_type" mcusprty
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						',
						'mysql' => '
							SELECT :columns
								mcusprty."id" AS "customer.property.type.id", mcusprty."siteid" AS "customer.property.type.siteid",
								mcusprty."code" AS "customer.property.type.code", mcusprty."domain" AS "customer.property.type.domain",
								mcusprty."label" AS "customer.property.type.label", mcusprty."status" AS "customer.property.type.status",
								mcusprty."mtime" AS "customer.property.type.mtime", mcusprty."editor" AS "customer.property.type.editor",
								mcusprty."ctime" AS "customer.property.type.ctime", mcusprty."pos" AS "customer.property.type.position"
							FROM "fe_users_property_type" mcusprty
							:joins
							WHERE :cond
							ORDER BY :order
							LIMIT :size OFFSET :start
						'
					),
					'count' => array(
						'ansi' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mcusprty."id"
								FROM "fe_users_property_type" mcusprty
								:joins
								WHERE :cond
								OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
							) AS list
						',
						'mysql' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT mcusprty."id"
								FROM "fe_users_property_type" mcusprty
								:joins
								WHERE :cond
								LIMIT 10000 OFFSET 0
							) AS list
						'
					),
					'newid' => array(
						'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
						'mysql' => 'SELECT LAST_INSERT_ID()',
						'oracle' => 'SELECT fe_users_property_type_seq.CURRVAL FROM DUAL',
						'pgsql' => 'SELECT lastval()',
						'sqlite' => 'SELECT last_insert_rowid()',
						'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
						'sqlanywhere' => 'SELECT @@IDENTITY',
					),
				),
			),
			'typo3' => array(
				'delete' => array(
					'ansi' => '
						DELETE FROM "fe_users_property"
						WHERE :cond AND siteid = ?
					'
				),
				'insert' => array(
					'ansi' => '
						INSERT INTO "fe_users_property" ( :names
							"parentid", "key", "type", "langid", "value",
							"mtime", "editor", "siteid", "ctime"
						) VALUES ( :values
							?, ?, ?, ?, ?, ?, ?, ?, ?
						)
					'
				),
				'update' => array(
					'ansi' => '
						UPDATE "fe_users_property"
						SET :names
							"parentid" = ?, "key" = ?, "type" = ?, "langid" = ?,
							"value" = ?, "mtime" = ?, "editor" = ?
						WHERE "siteid" = ? AND "id" = ?
					'
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							mcuspr."id" AS "customer.property.id", mcuspr."parentid" AS "customer.property.parentid",
							mcuspr."siteid" AS "customer.property.siteid", mcuspr."type" AS "customer.property.type",
							mcuspr."langid" AS "customer.property.languageid", mcuspr."value" AS "customer.property.value",
							mcuspr."mtime" AS "customer.property.mtime", mcuspr."editor" AS "customer.property.editor",
							mcuspr."ctime" AS "customer.property.ctime"
						FROM "fe_users_property" mcuspr
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							mcuspr."id" AS "customer.property.id", mcuspr."parentid" AS "customer.property.parentid",
							mcuspr."siteid" AS "customer.property.siteid", mcuspr."type" AS "customer.property.type",
							mcuspr."langid" AS "customer.property.languageid", mcuspr."value" AS "customer.property.value",
							mcuspr."mtime" AS "customer.property.mtime", mcuspr."editor" AS "customer.property.editor",
							mcuspr."ctime" AS "customer.property.ctime"
						FROM "fe_users_property" mcuspr
						:joins
						WHERE :cond
						ORDER BY :order
						LIMIT :size OFFSET :start
					'
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcuspr."id"
							FROM "fe_users_property" mcuspr
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT mcuspr."id"
							FROM "fe_users_property" mcuspr
							:joins
							WHERE :cond
							LIMIT 10000 OFFSET 0
						) AS list
					'
				),
				'newid' => array(
					'db2' => 'SELECT IDENTITY_VAL_LOCAL()',
					'mysql' => 'SELECT LAST_INSERT_ID()',
					'oracle' => 'SELECT fe_users_property_seq.CURRVAL FROM DUAL',
					'pgsql' => 'SELECT lastval()',
					'sqlite' => 'SELECT last_insert_rowid()',
					'sqlsrv' => 'SELECT SCOPE_IDENTITY()',
					'sqlanywhere' => 'SELECT @@IDENTITY',
				),
			),
		),
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
					WHERE :cond AND siteid = ?
				',
			),
			'delete' => array(
				'ansi' => '
					DELETE FROM "fe_users"
					WHERE :cond AND ( siteid = ? OR siteid = \'\' )
				',
			),
			'insert' => array(
				'ansi' => '
					INSERT INTO "fe_users" ( :names
						"name", "username", "gender", "company", "vatid",
						"title", "first_name", "last_name", "address", "zip", "city", "zone",
						"language", "telephone", "email", "fax", "www", "longitude", "latitude",
						"date_of_birth", "disable", "password", "tstamp", "static_info_country",
						"usergroup", "pid", "siteid", "crdate"
					) VALUES ( :values
						?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
					)
				',
			),
			'update' => array(
				'ansi' => '
					UPDATE "fe_users"
					SET :names
						"name" = ?, "username" = ?, "gender" = ?, "company" = ?, "vatid" = ?, "title" = ?,
						"first_name" = ?, "last_name" = ?, "address" = ?, "zip" = ?, "city" = ?, "zone" = ?,
						"language" = ?, "telephone" = ?, "email" = ?, "fax" = ?, "www" = ?, "longitude" = ?,
						"latitude" = ?, "date_of_birth" = ?, "disable" = ?, "password" = ?, "tstamp" = ?,
						"static_info_country" = ?, "usergroup" = ?, "pid" = ?
					WHERE ( siteid = ? OR siteid = \'\' ) AND "uid" = ?
				',
			),
			'search' => array(
				'ansi' => '
					SELECT :columns
						mcus."uid" AS "customer.id", mcus."siteid" AS "customer.siteid",
						mcus."name" AS "customer.label", mcus."gender" AS "customer.salutation",
						mcus."username" AS "customer.code", mcus."title" AS "customer.title",
						mcus."company" AS "customer.company", mcus."vatid" AS "customer.vatid",
						mcus."first_name" AS "customer.firstname", mcus."last_name" AS "customer.lastname",
						mcus."address" AS "customer.address1", mcus."zip" AS "customer.postal",
						mcus."city" AS "customer.city", mcus."zone" AS "customer.state",
						mcus."static_info_country" AS "customer.countryid", mcus."language" AS "customer.languageid",
						mcus."telephone" AS "customer.telephone", mcus."email" AS "customer.email",
						mcus."fax" AS "customer.telefax", mcus."www" AS "customer.website",
						mcus."longitude" AS "customer.longitude", mcus."latitude" AS "customer.latitude",
						mcus."password" AS "customer.password", mcus."date_of_birth" AS "customer.birthday",
						mcus."usergroup" as "customer.groups", mcus."pid" AS "typo3.pageid",
						mcus."disable" AS "customer.status", mcus."crdate" AS "customer.ctime",
						mcus."tstamp" AS "customer.mtime"
					FROM "fe_users" as mcus
					:joins
					WHERE :cond AND mcus."deleted" = 0
					GROUP BY :columns :group
						mcus."uid", mcus."siteid", mcus."name", mcus."gender", mcus."username", mcus."title",
						mcus."company", mcus."vatid", mcus."first_name", mcus."last_name", mcus."address", mcus."zip",
						mcus."city", mcus."zone", mcus."static_info_country", mcus."language", mcus."telephone", mcus."email",
						mcus."fax", mcus."www", mcus."longitude", mcus."latitude", mcus."password", mcus."date_of_birth",
						mcus."usergroup", mcus."pid", mcus."disable", mcus."crdate", mcus."tstamp"
					ORDER BY :order
					OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
				',
				'mysql' => '
					SELECT :columns
						mcus."uid" AS "customer.id", mcus."siteid" AS "customer.siteid",
						mcus."name" AS "customer.label", mcus."gender" AS "customer.salutation",
						mcus."username" AS "customer.code", mcus."title" AS "customer.title",
						mcus."company" AS "customer.company", mcus."vatid" AS "customer.vatid",
						mcus."first_name" AS "customer.firstname", mcus."last_name" AS "customer.lastname",
						mcus."address" AS "customer.address1", mcus."zip" AS "customer.postal",
						mcus."city" AS "customer.city", mcus."zone" AS "customer.state",
						mcus."static_info_country" AS "customer.countryid", mcus."language" AS "customer.languageid",
						mcus."telephone" AS "customer.telephone", mcus."email" AS "customer.email",
						mcus."fax" AS "customer.telefax", mcus."www" AS "customer.website",
						mcus."longitude" AS "customer.longitude", mcus."latitude" AS "customer.latitude",
						mcus."password" AS "customer.password", mcus."date_of_birth" AS "customer.birthday",
						mcus."usergroup" as "customer.groups", mcus."pid" AS "typo3.pageid",
						mcus."disable" AS "customer.status", mcus."crdate" AS "customer.ctime",
						mcus."tstamp" AS "customer.mtime"
					FROM "fe_users" as mcus
					:joins
					WHERE :cond AND mcus."deleted" = 0
					GROUP BY :group mcus."uid", mcus."static_info_country"
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
