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
	 * @param string $key Key of the value to retrieve
	 * @param mixed $default Default value if value for key isn't found
	 * @return mixed Configuration value for the given key or default value
	 */
	protected function getValue( array $config, string $key, $default = null )
	{
		switch( $key )
		{
			case 'absoluteUri': return true;
			case 'chash': return false;
		}

		return parent::getValue( $config, $key, $default );
	}
}
