<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2016
 */

return array(
	'aggregate' => array(
		'ansi' => '
			SELECT "key", COUNT(DISTINCT "id") AS "count"
			FROM (
				SELECT :key AS "key", t3feuli."id" AS "id"
				FROM "fe_users_list" AS t3feuli
				:joins
				WHERE :cond
				/*-orderby*/ ORDER BY :order /*orderby-*/
				LIMIT :size OFFSET :start
			) AS list
			GROUP BY "key"
		',
	),
	'getposmax' => array(
		'ansi' => '
			SELECT MAX( "pos" ) AS pos
			FROM "fe_users_list"
			WHERE "siteid" = ?
				AND "parentid" = ?
				AND "typeid" = ?
				AND "domain" = ?
		',
	),
	'insert' => array(
		'ansi' => '
			INSERT INTO "fe_users_list"( "parentid", "siteid", "typeid", "domain", "refid", "start", "end",
			"config", "pos", "status", "mtime", "editor", "ctime" )
			VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? )
		',
	),
	'update' => array(
		'ansi' => '
			UPDATE "fe_users_list"
			SET "parentid"=?, "siteid" = ?, "typeid" = ?, "domain" = ?, "refid" = ?, "start" = ?, "end" = ?,
				"config" = ?, "pos" = ?, "status" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
	),
	'updatepos' => array(
		'ansi' => '
			UPDATE "fe_users_list"
				SET "pos" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
	),
	'delete' => array(
		'ansi' => '
			DELETE FROM "fe_users_list"
			WHERE :cond
			AND siteid = ?
		',
	),
	'move' => array(
		'ansi' => '
			UPDATE "fe_users_list"
				SET "pos" = "pos" + ?, "mtime" = ?, "editor" = ?
			WHERE "siteid" = ?
				AND "parentid" = ?
				AND "typeid" = ?
				AND "domain" = ?
				AND "pos" >= ?
		',
	),
	'search' => array(
		'ansi' => '
			SELECT t3feuli."id" AS "customer.lists.id", t3feuli."parentid" AS "customer.lists.parentid",
				t3feuli."siteid" AS "customer.lists.siteid", t3feuli."typeid" AS "customer.lists.typeid",
				t3feuli."domain" AS "customer.lists.domain", t3feuli."refid" AS "customer.lists.refid",
				t3feuli."start" AS "customer.lists.datestart", t3feuli."end" AS "customer.lists.dateend",
				t3feuli."config" AS "customer.lists.config", t3feuli."pos" AS "customer.lists.position",
				t3feuli."status" AS "customer.lists.status", t3feuli."mtime" AS "customer.lists.mtime",
				t3feuli."editor" AS "customer.lists.editor", t3feuli."ctime" AS "customer.lists.ctime"
			FROM "fe_users_list" AS t3feuli
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
				SELECT DISTINCT t3feuli."id"
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
);
