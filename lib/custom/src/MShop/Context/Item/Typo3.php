<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 * @package MShop
 * @subpackage Context
 */


/**
 * Typo3 implementation of the context item
 *
 * @package MShop
 * @subpackage Context
 */
class MShop_Context_Item_Typo3
	extends MShop_Context_Item_Default
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
	 */
	public function setHasherTypo3( \TYPO3\CMS\Saltedpasswords\Salt\SaltInterface $object )
	{
		$this->hasher = $object;
	}
}