<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org], 2014-2022
 */


return [
	'name' => 'ai-typo3',
	'depends' => [
		'aimeos-core',
	],
	'include' => [
		'src',
	],
	'config' => [
		'config',
	],
	'setup' => [
		'setup',
	],
	'custom' => [
		'admin/jqadm' => [
			'manifest.jsb2',
		],
	],
];
