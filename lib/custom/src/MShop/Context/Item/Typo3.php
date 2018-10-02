<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Context
 */


namespace Aimeos\MShop\Context\Item;


/**
 * Typo3 implementation of the context item
 *
 * @package MShop
 * @subpackage Context
 */
class Typo3
	extends \Aimeos\MShop\Context\Item\Standard
{
	private $hasher;


	/**
	 * Returns the TYPO3 password hasher object
	 *
	 * @return \TYPO3\CMS\Saltedpasswords\Salt\SaltInterface|null Password factory object or null
	 */
	public function getHasherTypo3()
	{
		return $this->hasher;
	}


	/**
	 * Sets the TYPO3 password hasher object
	 *
	 * @param \TYPO3\CMS\Saltedpasswords\Salt\SaltInterface $object
	 * @return \Aimeos\MShop\Context\Item\Iface Context item for chaining method calls
	 */
	public function setHasherTypo3( \TYPO3\CMS\Saltedpasswords\Salt\SaltInterface $object )
	{
		$this->hasher = $object;
		return $this;
	}
}