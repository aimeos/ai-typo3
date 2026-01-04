<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2021-2026
 * @package MW
 * @subpackage Password
 */


namespace Aimeos\Base\Password;


/**
 * TYPO3 implementation of the password helper
 *
 * @package MW
 * @subpackage Password
 */
class Typo3 implements \Aimeos\Base\Password\Iface
{
	private \TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashInterface $hasher;


	/**
	 * Initializes the password helper
	 *
	 * @param \TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashInterface $hasher TYPO3 password hasher object
	 */
	public function __construct( \TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashInterface $hasher )
	{
		$this->hasher = $hasher;
	}


	/**
	 * Returns the hashed password
	 *
	 * @param string $password Clear text password string
	 * @return string Hashed password
	 */
	public function hash( string $password ) : string
	{
		return $this->hasher->getHashedPassword( $password );
	}


	/**
	 * Verifies the password
	 *
	 * @param string $password Clear text password string
	 * @param string $hash Hashed password
	 * @return bool TRUE if password and hash match
	 */
	public function verify( string $password, string $hash ) : bool
	{
		return $this->hasher->checkPassword( $password, $hash );
	}
}
