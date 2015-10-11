<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
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
			SELECT t3feuli."id", t3feuli."parentid", t3feuli."siteid", t3feuli."typeid",
				t3feuli."domain", t3feuli."refid", t3feuli."start", t3feuli."end", t3feuli."config", t3feuli."pos",
				t3feuli."status", t3feuli."mtime", t3feuli."editor", t3feuli."ctime"
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
		'mysql' => 'SELECT LAST_INSERT_ID()'
	),
);
