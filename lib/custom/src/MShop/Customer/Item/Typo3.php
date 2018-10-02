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
	 * @param \Aimeos\MShop\Common\Lists\Item\Iface[] $listItems List of list items
	 * @param \Aimeos\MShop\Common\Item\Iface[] $refItems List of referenced items
	 * @param string $salt Password salt (optional)
	 * @param \Aimeos\MShop\Common\Item\Helper\Password\Iface|null $helper Password encryption helper object
	 * @param \Aimeos\MShop\Customer\Item\Address\Iface[] $addresses List of delivery addresses
	 * @param \Aimeos\MShop\Common\Item\Property\Iface[] $propItems List of property items
	 */
	public function __construct( \Aimeos\MShop\Common\Item\Address\Iface $address,
		array $values = [], array $listItems = [], array $refItems = [], $salt = null,
		\Aimeos\MShop\Common\Item\Helper\Password\Iface $helper = null, array $addresses = [], array $propItems = [])
	{
		parent::__construct( $address, $values, $listItems, $refItems, $salt, $helper, $addresses, $propItems );

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


	/**
	 * Sets the item values from the given array.
	 *
	 * @param array $list Associative list of item keys and their values
	 * @return array Associative list of keys and their values that are unknown
	 */
	public function fromArray( array $list )
	{
		$unknown = [];
		$list = parent::fromArray( $list );

		foreach( $list as $key => $value )
		{
			switch( $key )
			{
				case 'typo3.pageid': $this->setPageId( $value ); break;
				default: $unknown[$key] = $value;
			}
		}

		return $unknown;
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
