<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018-2021
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Property;


/**
 * Default property manager implementation.
 *
 * @package MShop
 * @subpackage Customer
 */
class Typo3
	extends \Aimeos\MShop\Customer\Manager\Property\Standard
{
	private $searchConfig = array(
		'customer.property.id' => array(
			'code' => 'customer.property.id',
			'internalcode' => 't3feupr."id"',
			'internaldeps' => ['LEFT JOIN "fe_users_property" AS t3feupr ON ( t3feupr."parentid" = t3feu."uid" )'],
			'label' => 'Property ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.property.parentid' => array(
			'code' => 'customer.property.parentid',
			'internalcode' => 't3feupr."parentid"',
			'label' => 'Property parent ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.property.siteid' => array(
			'code' => 'customer.property.siteid',
			'internalcode' => 't3feupr."siteid"',
			'label' => 'Property site ID',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.property.type' => array(
			'code' => 'customer.property.type',
			'internalcode' => 't3feupr."type"',
			'label' => 'Property type',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.property.value' => array(
			'code' => 'customer.property.value',
			'internalcode' => 't3feupr."value"',
			'label' => 'Property value',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.property.languageid' => array(
			'code' => 'customer.property.languageid',
			'internalcode' => 't3feupr."langid"',
			'label' => 'Property language ID',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.property.ctime' => array(
			'code' => 'customer.property.ctime',
			'internalcode' => 't3feupr."ctime"',
			'label' => 'Property create date/time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.property.mtime' => array(
			'code' => 'customer.property.mtime',
			'internalcode' => 't3feupr."mtime"',
			'label' => 'Property modify date',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.property.editor' => array(
			'code' => 'customer.property.editor',
			'internalcode' => 't3feupr."editor"',
			'label' => 'Property editor',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
	);


	/**
	 * Removes old entries from the storage.
	 *
	 * @param iterable $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Common\Manager\Iface Same object for fluent interface
	 */
	public function clear( iterable $siteids ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/customer/manager/property/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, ['type'] ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/customer/manager/property/typo3/delete' );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param bool $withsub Return also attributes of sub-managers if true
	 * @return array Returns a list of attribtes implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		$path = 'mshop/customer/manager/property/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, [], $withsub );
	}


	/**
	 * Returns a new manager for customer extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from
	 * configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions, e.g property types, property lists etc.
	 */
	public function getSubManager( string $manager, string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return $this->getSubManagerBase( 'customer', 'property/' . $manager, ( $name === null ? 'Typo3' : $name ) );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path
	 */
	protected function getConfigPath() : string
	{
		return 'mshop/customer/manager/property/typo3/';
	}


	/**
	 * Returns the search configuration for searching items.
	 *
	 * @return array Associative list of search keys and search definitions
	 */
	protected function getSearchConfig() : array
	{
		return $this->searchConfig;
	}
}
