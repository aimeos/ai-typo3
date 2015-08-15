<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */

return array(
	'item' => array(
		'search' => '
			SELECT DISTINCT t3feg."uid" AS "id", t3feg."title" AS "code",
				t3feg."title" AS "label", t3feg."crdate", t3feg."tstamp"
			FROM "fe_groups" AS t3feg
			:joins
			WHERE :cond
			/*-orderby*/ ORDER BY :order /*orderby-*/
			LIMIT :size OFFSET :start
		',
		'count' => '
			SELECT COUNT(*) AS "count"
			FROM (
				SELECT DISTINCT t3feg."uid"
				FROM "fe_groups" AS t3feg
				:joins
				WHERE :cond
				LIMIT 10000 OFFSET 0
			) AS list
		',
	),
);