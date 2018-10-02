<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2018
 * @package MShop
 * @subpackage Common
 */


namespace Aimeos\MW\Criteria\Plugin;


/**
 * Criteria plugin for TYPO3 salutation/gender.
 *
 * @package MW
 * @subpackage Common
 */
class T3Salutation implements \Aimeos\MW\Criteria\Plugin\Iface
{
	/**
	 * Translates the MShop value into its TYPO3 equivalent.
	 *
	 * @param string $value Address constant from \Aimeos\MShop\Common\Item\Address\Base
	 * @return integer TYPO3 gender value or 99 if nothing matches
	 */
	public function translate( $value )
	{
		switch( $value )
		{
			case \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MR:
				return 0;
			case \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MRS:
				return 1;
			case \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MISS:
				return 2;
			case \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_COMPANY:
				return 10;
		}

		return 99;
	}


	/**
	 * Reverses the translation from the TYPO3 value to the MShop constant.
	 *
	 * @param string $value TYPO3 value or empty if not set
	 * @return string Address constant from \Aimeos\MShop\Common\Item\Address\Base
	 */
	public function reverse( $value )
	{
		switch( $value )
		{
			case 0:
				return \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MR;
			case 1:
				return \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MRS;
			case 2:
				return \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_MISS;
			case 10:
				return \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_COMPANY;
		}

		return \Aimeos\MShop\Common\Item\Address\Base::SALUTATION_UNKNOWN;
	}
}
