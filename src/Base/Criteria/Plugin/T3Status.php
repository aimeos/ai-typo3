<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2023
 * @package MShop
 * @subpackage Common
 */


namespace Aimeos\Base\Criteria\Plugin;


/**
 * Criteria plugin for TYPO3 status/disable.
 *
 * @package MW
 * @subpackage Common
 */
class T3Status implements \Aimeos\Base\Criteria\Plugin\Iface
{
	/**
	 * Translates the MShop value into its TYPO3 equivalent.
	 *
	 * @param integer $value Status value
	 * @param mixed $type Expected value type
	 * @return integer Value for TYPO3 "disabled" field
	 */
	public function translate( $value, $type = null )
	{
		return ( $value == 1 ? 0 : 1 );
	}


	/**
	 * Reverses the translation from the TYPO3 value to the MShop constant.
	 *
	 * @param integer $value Value for TYPO3 "disabled" field
	 * @param mixed $type Expected value type
	 * @return integer Status value
	 */
	public function reverse( $value, $type = null )
	{
		return ( $value == 1 ? 0 : 1 );
	}
}
