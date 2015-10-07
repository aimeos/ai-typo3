<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */

return array(
	'item' => array(
		'insert' => '
			INSERT INTO "fe_users_list_type"( "siteid", "code", "domain", "label", "status",
				"mtime", "editor", "ctime" )
			VALUES ( ?, ?, ?, ?, ?, ?, ?, ? )
		',
		'update' => '
			UPDATE "fe_users_list_type"
			SET "siteid"=?, "code" = ?, "domain" = ?, "label" = ?, "status" = ?, "mtime" = ?, "editor" = ?
			WHERE "id" = ?
		',
		'delete' => '
			DELETE FROM "fe_users_list_type"
			WHERE :cond
			AND siteid = ?
		',
		'search' => '
			SELECT t3feulity."id", t3feulity."siteid", t3feulity."code", t3feulity."domain", t3feulity."label", t3feulity."status",
				t3feulity."mtime", t3feulity."editor", t3feulity."ctime"
			FROM "fe_users_list_type" AS t3feulity
			:joins
			WHERE
				:cond
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
		'count' => '
			SELECT COUNT(*) AS "count"
			FROM (
				SELECT DISTINCT t3feulity."id"
				FROM "fe_users_list_type" AS t3feulity
				:joins
				WHERE :cond
				LIMIT 10000 OFFSET 0
			) AS LIST
		',
	),
);
