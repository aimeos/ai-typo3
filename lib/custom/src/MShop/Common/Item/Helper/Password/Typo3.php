<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Common
 */


namespace Aimeos\MShop\Common\Item\Helper\Password;


/**
 * TYPO3 implementation of the password helper item
 *
 * @package MShop
 * @subpackage Common
 */
class Typo3 implements \Aimeos\MShop\Common\Item\Helper\Password\Iface
{
	private $hasher;


	/**
	 * Initializes the password helper.
	 *
	 * @param array Associative list of key/value pairs of options specific for the hashing method
	 */
	public function __construct( array $options )
	{
		if( !array_key_exists( 'object', $options ) ) {
			throw new \Aimeos\MShop\Exception( sprintf( 'No TYPO3 password hash object available' ) );
		}

		$this->hasher = $options['object'];
	}


	/**
	 * Returns the hashed password.
	 *
	 * @param string $password Clear text password string
	 * @param string|null $salt Password salt
	 * @return string Hashed password
	 */
	public function encode( $password, $salt = null )
	{
		return ( isset( $this->hasher ) ? $this->hasher->getHashedPassword( $password, $salt ) : $password );
	}
}
