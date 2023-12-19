<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2023
 */


return array(
	'manager' => array(
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
					SELECT :columns
					FROM "fe_groups" mgro
					:joins
					WHERE mgro."deleted" = 0 AND :cond
					ORDER BY :order
					OFFSET :start ROWS FETCH NEXT :size ROWS ONLY
				',
				'mysql' => '
					SELECT :columns
					FROM "fe_groups" mgro
					:joins
					WHERE mgro."deleted" = 0 AND :cond
					ORDER BY :order
					LIMIT :size OFFSET :start
				',
			),
			'count' => array(
				'ansi' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT mgro."uid"
						FROM "fe_groups" mgro
						:joins
						WHERE mgro."deleted" = 0 AND :cond
						OFFSET 0 ROWS FETCH NEXT 10000 ROWS ONLY
					) AS list
				',
				'mysql' => '
					SELECT COUNT(*) AS "count"
					FROM (
						SELECT mgro."uid"
						FROM "fe_groups" mgro
						:joins
						WHERE mgro."deleted" = 0 AND :cond
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
);
