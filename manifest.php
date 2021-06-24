<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org], 2014-2021
 */


return [
	'name' => 'ai-typo3',
	'depends' => [
		'aimeos-core',
	],
	'include' => [
		'lib/custom/src',
	],
	'config' => [
		'lib/custom/config',
	],
	'setup' => [
		'lib/custom/setup',
	],
	'custom' => [
		'admin/jqadm' => [
			'admin/jqadm/manifest.jsb2',
		],
	],
];
