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
 * Criteria plugin for TYPO3 date/time values.
 *
 * @package MW
 * @subpackage Common
 */
class T3Datetime implements \Aimeos\MW\Criteria\Plugin\Iface
{
	/**
	 * Translates ISO dates into seconds relative to the epoch.
	 *
	 * @param string $value ISO date string (YYYY-MM-DD HH:mm:ss)
	 * @return integer Seconds relative to the epoch
	 */
	public function translate( $value )
	{
		return ( $value != null ? strtotime( $value ) : 0 );
	}


	/**
	 * Reverses the translation from seconds relative to the epoch to the ISO date string (YYYY-MM-DD HH:mm:ss).
	 *
	 * @param integer $value Seconds relative to the epoch
	 * @return string ISO date string (YYYY-MM-DD HH:mm:ss)
	 */
	public function reverse( $value )
	{
		return ( $value != 0 ? date( 'Y-m-d H:i:s', $value ) : null );
	}
}
