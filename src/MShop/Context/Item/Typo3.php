<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2024
 * @package MShop
 * @subpackage Context
 */


namespace Aimeos\MShop\Context\Item;


/**
 * Typo3 implementation of the context item
 *
 * @package MShop
 * @subpackage Context
 * @deprecated 2022.01
 */
class Typo3
	extends \Aimeos\MShop\Context
{
	private ?\TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashInterface $hasher = null;


	/**
	 * Returns the TYPO3 password hasher object
	 *
	 * @return \TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashInterface|null Password factory object or null
	 */
	public function getHasherTypo3() : ?\TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashInterface
	{
		return $this->hasher;
	}


	/**
	 * Sets the TYPO3 password hasher object
	 *
	 * @param \TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashInterface $object
	 * @return \Aimeos\MShop\ContextIface Context item for chaining method calls
	 */
	public function setHasherTypo3( \TYPO3\CMS\Core\Crypto\PasswordHashing\PasswordHashInterface $object ) : \Aimeos\MShop\ContextIface
	{
		$this->hasher = $object;
		return $this;
	}
}
