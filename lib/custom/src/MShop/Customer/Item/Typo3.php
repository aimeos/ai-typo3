<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016-2018
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Item;


/**
 * TYPO3 customer objects used by the shop
 *
 * @package MShop
 * @subpackage Customer
 */
class Typo3 extends Standard implements Iface
{
	private $values;


	/**
	 * Initializes the customer item object
	 *
	 * @param \Aimeos\MShop\Common\Item\Address\Iface $address Payment address item object
	 * @param array $values List of attributes that belong to the customer item
	 * @param \Aimeos\MShop\Common\Item\Lists\Iface[] $listItems List of list items
	 * @param \Aimeos\MShop\Common\Item\Iface[] $refItems List of referenced items
	 * @param \Aimeos\MShop\Common\Item\Address\Iface[] $addrItems List of delivery addresses
	 * @param \Aimeos\MShop\Common\Item\Property\Iface[] $propItems List of property items
	 * @param \Aimeos\MShop\Common\Helper\Password\Iface|null $helper Password encryption helper object
	 * @param string|null $salt Password salt
	 */
	public function __construct( \Aimeos\MShop\Common\Item\Address\Iface $address, array $values = [],
		array $listItems = [], array $refItems = [], array $addrItems = [], array $propItems = [],
		\Aimeos\MShop\Common\Helper\Password\Iface $helper = null, $salt = null )
	{
		parent::__construct( $address, $values, $listItems, $refItems, $addrItems, $propItems, $helper, $salt );

		$this->values = $values;
	}


	/**
	 * Returns the TYPO3 page ID of the user
	 *
	 * @return integer Page ID of the user
	 */
	public function getPageId()
	{
		if( isset( $this->values['typo3.pageid'] ) ) {
			return (int) $this->values['typo3.pageid'];
		}

		return 0;
	}


	/**
	 * Sets the TYPO3 page ID for the user
	 *
	 * @param integer $value Page ID of the user
	 * @return \Aimeos\MShop\Customer\Item\Iface Customer item for chaining method calls
	 */
	public function setPageId( $value )
	{
		if( (int) $value !== $this->getPageId() )
		{
			$this->values['typo3.pageid'] = (int) $value;
			$this->setModified();
		}

		return $this;
	}


	/*
	 * Sets the item values from the given array and removes that entries from the list
	 *
	 * @param array &$list Associative list of item keys and their values
	 * @return \Aimeos\MShop\Customer\Item\Iface Customer item for chaining method calls
	 */
	public function fromArray( array &$list )
	{
		$item = parent::fromArray( $list );

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case 'typo3.pageid': $item = $item->setPageId( $value ); break;
				default: continue 2;
			}

			unset( $list[$key] );
		}

		return $item;
	}


	/**
	 * Returns the item values as array.
	 *
	 * @param boolean True to return private properties, false for public only
	 * @return array Associative list of item properties and their values
	 */
	public function toArray( $private = false )
	{
		$list = parent::toArray( $private );

		if( $private === true ) {
			$list['typo3.pageid'] = $this->getPageId();
		}

		return $list;
	}
}
