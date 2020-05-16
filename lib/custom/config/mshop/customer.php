<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 */


return array(
	'manager' => array(
		'address' => array(
			'typo3' => array(
				'delete' => array(
					'ansi' => '
						DELETE FROM "fe_users_address"
						WHERE :cond AND siteid = ?
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
							"pos" = ?, "birthday" = ?, "mtime" = ?, "editor" = ?, "siteid" = ?
						WHERE "id" = ?
					',
				),
				'search' => array(
					'ansi' => '
						SELECT :columns
							t3feuad."id" AS "customer.address.id", t3feuad."siteid" AS "customer.address.siteid",
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
							t3feuad."longitude" AS "customer.address.longitude", t3feuad."latitude" AS "customer.address.latitude",
							t3feuad."mtime" AS "customer.address.mtime", t3feuad."editor" AS "customer.address.editor",
							t3feuad."ctime" AS "customer.address.ctime", t3feuad."birthday" AS "customer.address.birthday"
						FROM "fe_users_address" AS t3feuad
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							t3feuad."id" AS "customer.address.id", t3feuad."siteid" AS "customer.address.siteid",
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
							t3feuad."longitude" AS "customer.address.longitude", t3feuad."latitude" AS "customer.address.latitude",
							t3feuad."mtime" AS "customer.address.mtime", t3feuad."editor" AS "customer.address.editor",
							t3feuad."ctime" AS "customer.address.ctime", t3feuad."birthday" AS "customer.address.birthday"
						FROM "fe_users_address" AS t3feuad
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
							SELECT t3feuad."id"
							FROM "fe_users_address" AS t3feuad
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT t3feuad."id"
							FROM "fe_users_address" AS t3feuad
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
							t3feg."uid" AS "customer.group.id", t3feg."title" AS "customer.group.code",
							t3feg."description" AS "customer.group.label", t3feg."crdate", t3feg."tstamp", t3feg.*
						FROM "fe_groups" AS t3feg
						:joins
						WHERE t3feg."deleted" = 0 AND :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT
							t3feg."uid" AS "customer.group.id", t3feg."title" AS "customer.group.code",
							t3feg."description" AS "customer.group.label", t3feg."crdate", t3feg."tstamp", t3feg.*
						FROM "fe_groups" AS t3feg
						:joins
						WHERE t3feg."deleted" = 0 AND :cond
						ORDER BY :order
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT t3feg."uid"
							FROM "fe_groups" AS t3feg
							:joins
							WHERE t3feg."deleted" = 0 AND :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT t3feg."uid"
							FROM "fe_groups" AS t3feg
							:joins
							WHERE t3feg."deleted" = 0 AND :cond
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
								t3feulity."id" AS "customer.lists.type.id", t3feulity."siteid" AS "customer.lists.type.siteid",
								t3feulity."code" AS "customer.lists.type.code", t3feulity."domain" AS "customer.lists.type.domain",
								t3feulity."label" AS "customer.lists.type.label", t3feulity."status" AS "customer.lists.type.status",
								t3feulity."mtime" AS "customer.lists.type.mtime", t3feulity."editor" AS "customer.lists.type.editor",
								t3feulity."ctime" AS "customer.lists.type.ctime", t3feulity."pos" AS "customer.lists.type.position"
							FROM "fe_users_list_type" AS t3feulity
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						',
						'mysql' => '
							SELECT :columns
								t3feulity."id" AS "customer.lists.type.id", t3feulity."siteid" AS "customer.lists.type.siteid",
								t3feulity."code" AS "customer.lists.type.code", t3feulity."domain" AS "customer.lists.type.domain",
								t3feulity."label" AS "customer.lists.type.label", t3feulity."status" AS "customer.lists.type.status",
								t3feulity."mtime" AS "customer.lists.type.mtime", t3feulity."editor" AS "customer.lists.type.editor",
								t3feulity."ctime" AS "customer.lists.type.ctime", t3feulity."pos" AS "customer.lists.type.position"
							FROM "fe_users_list_type" AS t3feulity
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
								SELECT t3feulity."id"
								FROM "fe_users_list_type" AS t3feulity
								:joins
								WHERE :cond
								OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
							) AS LIST
						',
						'mysql' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT t3feulity."id"
								FROM "fe_users_list_type" AS t3feulity
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
						SELECT "key", COUNT("id") AS "count"
						FROM (
							SELECT :key AS "key", t3feuli."id" AS "id"
							FROM "fe_users_list" AS t3feuli
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						) AS list
						GROUP BY "key"
					',
					'mysql' => '
						SELECT "key", COUNT("id") AS "count"
						FROM (
							SELECT :key AS "key", t3feuli."id" AS "id"
							FROM "fe_users_list" AS t3feuli
							:joins
							WHERE :cond
							ORDER BY :order
							LIMIT :size OFFSET :start
						) AS list
						GROUP BY "key"
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
							t3feuli."id" AS "customer.lists.id", t3feuli."parentid" AS "customer.lists.parentid",
							t3feuli."siteid" AS "customer.lists.siteid", t3feuli."type" AS "customer.lists.type",
							t3feuli."domain" AS "customer.lists.domain", t3feuli."refid" AS "customer.lists.refid",
							t3feuli."start" AS "customer.lists.datestart", t3feuli."end" AS "customer.lists.dateend",
							t3feuli."config" AS "customer.lists.config", t3feuli."pos" AS "customer.lists.position",
							t3feuli."status" AS "customer.lists.status", t3feuli."mtime" AS "customer.lists.mtime",
							t3feuli."editor" AS "customer.lists.editor", t3feuli."ctime" AS "customer.lists.ctime"
						FROM "fe_users_list" AS t3feuli
						:joins
						WHERE :cond
						GROUP BY :columns
							t3feuli."id", t3feuli."parentid", t3feuli."siteid", t3feuli."type",
							t3feuli."domain", t3feuli."refid", t3feuli."start", t3feuli."end",
							t3feuli."config", t3feuli."pos", t3feuli."status", t3feuli."mtime",
							t3feuli."editor", t3feuli."ctime"
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							t3feuli."id" AS "customer.lists.id", t3feuli."parentid" AS "customer.lists.parentid",
							t3feuli."siteid" AS "customer.lists.siteid", t3feuli."type" AS "customer.lists.type",
							t3feuli."domain" AS "customer.lists.domain", t3feuli."refid" AS "customer.lists.refid",
							t3feuli."start" AS "customer.lists.datestart", t3feuli."end" AS "customer.lists.dateend",
							t3feuli."config" AS "customer.lists.config", t3feuli."pos" AS "customer.lists.position",
							t3feuli."status" AS "customer.lists.status", t3feuli."mtime" AS "customer.lists.mtime",
							t3feuli."editor" AS "customer.lists.editor", t3feuli."ctime" AS "customer.lists.ctime"
						FROM "fe_users_list" AS t3feuli
						:joins
						WHERE :cond
						GROUP BY :columns
							t3feuli."id", t3feuli."parentid", t3feuli."siteid", t3feuli."type",
							t3feuli."domain", t3feuli."refid", t3feuli."start", t3feuli."end",
							t3feuli."config", t3feuli."pos", t3feuli."status", t3feuli."mtime",
							t3feuli."editor", t3feuli."ctime"
						ORDER BY :order
						LIMIT :size OFFSET :start
					',
				),
				'count' => array(
					'ansi' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT t3feuli."id"
							FROM "fe_users_list" AS t3feuli
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT t3feuli."id"
							FROM "fe_users_list" AS t3feuli
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
								t3feuprty."id" AS "customer.property.type.id", t3feuprty."siteid" AS "customer.property.type.siteid",
								t3feuprty."code" AS "customer.property.type.code", t3feuprty."domain" AS "customer.property.type.domain",
								t3feuprty."label" AS "customer.property.type.label", t3feuprty."status" AS "customer.property.type.status",
								t3feuprty."mtime" AS "customer.property.type.mtime", t3feuprty."editor" AS "customer.property.type.editor",
								t3feuprty."ctime" AS "customer.property.type.ctime", t3feuprty."pos" AS "customer.property.type.position"
							FROM "fe_users_property_type" t3feuprty
							:joins
							WHERE :cond
							ORDER BY :order
							OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
						',
						'mysql' => '
							SELECT :columns
								t3feuprty."id" AS "customer.property.type.id", t3feuprty."siteid" AS "customer.property.type.siteid",
								t3feuprty."code" AS "customer.property.type.code", t3feuprty."domain" AS "customer.property.type.domain",
								t3feuprty."label" AS "customer.property.type.label", t3feuprty."status" AS "customer.property.type.status",
								t3feuprty."mtime" AS "customer.property.type.mtime", t3feuprty."editor" AS "customer.property.type.editor",
								t3feuprty."ctime" AS "customer.property.type.ctime", t3feuprty."pos" AS "customer.property.type.position"
							FROM "fe_users_property_type" t3feuprty
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
								SELECT t3feuprty."id"
								FROM "fe_users_property_type" t3feuprty
								:joins
								WHERE :cond
								OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
							) AS list
						',
						'mysql' => '
							SELECT COUNT(*) AS "count"
							FROM (
								SELECT t3feuprty."id"
								FROM "fe_users_property_type" t3feuprty
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
							t3feupr."id" AS "customer.property.id", t3feupr."parentid" AS "customer.property.parentid",
							t3feupr."siteid" AS "customer.property.siteid", t3feupr."type" AS "customer.property.type",
							t3feupr."langid" AS "customer.property.languageid", t3feupr."value" AS "customer.property.value",
							t3feupr."mtime" AS "customer.property.mtime", t3feupr."editor" AS "customer.property.editor",
							t3feupr."ctime" AS "customer.property.ctime"
						FROM "fe_users_property" AS t3feupr
						:joins
						WHERE :cond
						ORDER BY :order
						OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
					',
					'mysql' => '
						SELECT :columns
							t3feupr."id" AS "customer.property.id", t3feupr."parentid" AS "customer.property.parentid",
							t3feupr."siteid" AS "customer.property.siteid", t3feupr."type" AS "customer.property.type",
							t3feupr."langid" AS "customer.property.languageid", t3feupr."value" AS "customer.property.value",
							t3feupr."mtime" AS "customer.property.mtime", t3feupr."editor" AS "customer.property.editor",
							t3feupr."ctime" AS "customer.property.ctime"
						FROM "fe_users_property" AS t3feupr
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
							SELECT t3feupr."id"
							FROM "fe_users_property" AS t3feupr
							:joins
							WHERE :cond
							OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
						) AS list
					',
					'mysql' => '
						SELECT COUNT(*) AS "count"
						FROM (
							SELECT t3feupr."id"
							FROM "fe_users_property" AS t3feupr
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
			'delete' => array(
				'ansi' => '
					DELETE FROM "fe_users"
					WHERE :cond AND siteid = ?
				',
			),
			'insert' => array(
				'ansi' => '
					INSERT INTO "fe_users" ( :names
						"siteid", "name", "username", "gender", "company", "vatid",
						"title", "first_name", "last_name", "address", "zip", "city", "zone",
						"language", "telephone", "email", "fax", "www", "longitude", "latitude",
						"date_of_birth", "disable", "password", "tstamp", "static_info_country",
						"usergroup", "pid", "crdate"
					) SELECT :values ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,(
						SELECT "cn_iso_3" FROM "static_countries" WHERE "cn_iso_2" = ? LIMIT 1
					),?,?,?
				',
			),
			'update' => array(
				'ansi' => '
					UPDATE "fe_users"
					SET :names
						"siteid" = ?, "name" = ?, "username" = ?, "gender" = ?, "company" = ?, "vatid" = ?, "title" = ?,
						"first_name" = ?, "last_name" = ?, "address" = ?, "zip" = ?, "city" = ?, "zone" = ?,
						"language" = ?, "telephone" = ?, "email" = ?, "fax" = ?, "www" = ?, "longitude" = ?,
						"latitude" = ?, "date_of_birth" = ?, "disable" = ?, "password" = ?, "tstamp" = ?,
						"static_info_country"=( SELECT "cn_iso_3" FROM "static_countries" WHERE "cn_iso_2" = ? LIMIT 1 ),
						"usergroup" = ?, "pid" = ?
					WHERE "uid" = ?
				',
			),
			'search' => array(
				'ansi' => '
					SELECT :columns
						t3feu."uid" AS "customer.id", t3feu."siteid" AS "customer.siteid",
						t3feu."name" AS "customer.label", t3feu."gender",
						t3feu."username" AS "customer.code", t3feu."title" AS "customer.title",
						t3feu."company" AS "customer.company", t3feu."vatid" AS "customer.vatid",
						t3feu."first_name" AS "customer.firstname", t3feu."last_name" AS "customer.lastname",
						t3feu."address" AS "customer.address1", t3feu."zip" AS "customer.postal",
						t3feu."city" AS "customer.city", t3feu."zone" AS "customer.state",
						tsc."cn_iso_2" AS "customer.countryid", t3feu."language" AS "customer.languageid",
						t3feu."telephone" AS "customer.telephone", t3feu."email" AS "customer.email",
						t3feu."fax" AS "customer.telefax", t3feu."www" AS "customer.website",
						t3feu."longitude" AS "customer.longitude", t3feu."latitude" AS "customer.latitude",
						t3feu."password" AS "customer.password", t3feu."date_of_birth",
						t3feu."usergroup" as "groups", t3feu."pid" AS "typo3.pageid",
						t3feu."disable", t3feu."crdate", t3feu."tstamp"
					FROM "fe_users" as t3feu
					LEFT JOIN "static_countries" AS tsc ON t3feu."static_info_country" = tsc."cn_iso_3"
					:joins
					WHERE :cond AND t3feu."deleted" = 0
					GROUP BY :group t3feu."uid", tsc."cn_iso_2"
					ORDER BY :order
					OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
				',
				'mysql' => '
					SELECT :columns
						t3feu."uid" AS "customer.id", t3feu."siteid" AS "customer.siteid",
						t3feu."name" AS "customer.label", t3feu."gender",
						t3feu."username" AS "customer.code", t3feu."title" AS "customer.title",
						t3feu."company" AS "customer.company", t3feu."vatid" AS "customer.vatid",
						t3feu."first_name" AS "customer.firstname", t3feu."last_name" AS "customer.lastname",
						t3feu."address" AS "customer.address1", t3feu."zip" AS "customer.postal",
						t3feu."city" AS "customer.city", t3feu."zone" AS "customer.state",
						tsc."cn_iso_2" AS "customer.countryid", t3feu."language" AS "customer.languageid",
						t3feu."telephone" AS "customer.telephone", t3feu."email" AS "customer.email",
						t3feu."fax" AS "customer.telefax", t3feu."www" AS "customer.website",
						t3feu."longitude" AS "customer.longitude", t3feu."latitude" AS "customer.latitude",
						t3feu."password" AS "customer.password", t3feu."date_of_birth",
						t3feu."usergroup" as "groups", t3feu."pid" AS "typo3.pageid",
						t3feu."disable", t3feu."crdate", t3feu."tstamp"
					FROM "fe_users" as t3feu
					LEFT JOIN "static_countries" AS tsc ON t3feu."static_info_country" = tsc."cn_iso_3"
					:joins
					WHERE :cond AND t3feu."deleted" = 0
					GROUP BY :group t3feu."uid", tsc."cn_iso_2"
					ORDER BY :order
					LIMIT :size OFFSET :start
				',
			),
			'count' => array(
				'ansi' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT t3feu."uid"
						FROM "fe_users" AS t3feu
						LEFT JOIN "static_countries" AS tsc ON t3feu."static_info_country" = tsc."cn_iso_3"
						:joins
						WHERE :cond AND t3feu."deleted" = 0
						GROUP BY t3feu."uid"
						OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
					) AS list
				',
				'mysql' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT t3feu."uid"
						FROM "fe_users" AS t3feu
						LEFT JOIN "static_countries" AS tsc ON t3feu."static_info_country" = tsc."cn_iso_3"
						:joins
						WHERE :cond AND t3feu."deleted" = 0
						GROUP BY t3feu."uid"
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
