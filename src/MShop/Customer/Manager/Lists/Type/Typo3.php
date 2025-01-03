<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2025
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Lists\Type;


/**
 * TYPO3 implementation of the customer list type class.
 *
 * @package MShop
 * @subpackage Customer
 */
class Typo3
	extends \Aimeos\MShop\Customer\Manager\Lists\Type\Standard
{
	/**
	 * Returns a new manager for customer lists type extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions, e.g Type, List's etc.
	 */
	public function getSubManager( string $manager, ?string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return parent::getSubManager( $manager, $name ?: 'Typo3' );
	}


	/**
	 * Returns the name of the used table
	 *
	 * @return string Table name e.g. "mshop_product_list_type"
	 */
	protected function table() : string
	{
		return 'fe_users_list_type';
	}
}
