<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2018
 */


return array(
	'name' => 'ai-typo3',
	'depends' => array(
		'aimeos-core',
	),
	'include' => array(
		'lib/custom/src',
	),
	'config' => array(
		'lib/custom/config',
	),
	'setup' => array(
		'lib/custom/setup',
	),
	'custom' => array(
		'admin/jqadm' => array(
			'admin/jqadm/manifest.jsb2',
		),
	),
);
