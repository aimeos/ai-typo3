<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2011
 * @copyright Copyright (c) Aimeos (aimeos.org), 2014
 */

return array(
	'name' => 'ai-typo3',
	'depends' => array(
		'arcavias-core',
	),
	'include' => array(
		'lib/custom/src',
	),
	'config' => array(
		'mysql' => array(
			'lib/custom/config/common',
			'lib/custom/config/mysql',
		),
	),
	'setup' => array(
		'lib/custom/setup',
	),
);
