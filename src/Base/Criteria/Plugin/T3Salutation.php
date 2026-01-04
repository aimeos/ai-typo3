<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2026
 * @package MShop
 * @subpackage Common
 */


namespace Aimeos\Base\Criteria\Plugin;


/**
 * Criteria plugin for TYPO3 salutation/gender.
 *
 * @package MW
 * @subpackage Common
 */
class T3Salutation implements \Aimeos\Base\Criteria\Plugin\Iface
{
	/**
	 * Translates the MShop value into its TYPO3 equivalent.
	 *
	 * @param string $value Address constant from \Aimeos\MShop\Common\Item\Address\Base
	 * @param mixed $type Expected value type
	 * @return integer TYPO3 gender value or 99 if nothing matches
	 */
	public function translate( $value, $type = null )
	{
		switch( $value )
		{
			case 'mr':
				return 0;
			case 'ms':
				return 1;
			case 'company':
				return 10;
		}

		return 99;
	}


	/**
	 * Reverses the translation from the TYPO3 value to the MShop constant.
	 *
	 * @param string $value TYPO3 value or empty if not set
	 * @param mixed $type Expected value type
	 * @return string Address constant from \Aimeos\MShop\Common\Item\Address\Base
	 */
	public function reverse( $value, $type = null )
	{
		switch( $value )
		{
			case 0:
				return 'mr';
			case 1:
				return 'ms';
			case 10:
				return 'company';
		}

		return '';
	}
}
