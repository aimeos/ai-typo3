<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2018
 * @package MW
 * @subpackage View
 */


namespace Aimeos\MW\View\Helper\Url;


/**
 * TYPO3 view helper class for building URLs on the command line
 *
 * @package MW
 * @subpackage View
 */
class T3Cli
	extends \Aimeos\MW\View\Helper\Url\Typo3
	implements \Aimeos\MW\View\Helper\Url\Iface
{
	/**
	 * Returns the sanitized configuration values.
	 *
	 * @param array $config Associative list of key/value pairs
	 * @return array Associative list of sanitized key/value pairs
	 */
	protected function getValues( array $config )
	{
		$values = parent::getValues( $config );

		$values['absoluteUri'] = true;
		$values['chash'] = false;

		return $values;
	}
}
