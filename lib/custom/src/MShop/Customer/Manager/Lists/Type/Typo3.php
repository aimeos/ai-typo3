<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2018
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
	private $searchConfig = array(
		'customer.lists.type.id' => array(
			'code'=>'customer.lists.type.id',
			'internalcode'=>'t3feulity."id"',
			'internaldeps'=>array( 'LEFT JOIN "fe_users_list_type" AS t3feulity ON ( t3feuli."typeid" = t3feulity."id" )' ),
			'label'=>'Customer list type ID',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.type.siteid' => array(
			'code'=>'customer.lists.type.siteid',
			'internalcode'=>'t3feulity."siteid"',
			'label'=>'Customer list type site ID',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.type.code' => array(
			'code'=>'customer.lists.type.code',
			'internalcode'=>'t3feulity."code"',
			'label'=>'Customer list type code',
			'type'=> 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.type.domain' => array(
			'code'=>'customer.lists.type.domain',
			'internalcode'=>'t3feulity."domain"',
			'label'=>'Customer list type domain',
			'type'=> 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.type.label' => array(
			'code'=>'customer.lists.type.label',
			'internalcode'=>'t3feulity."label"',
			'label'=>'Customer list type label',
			'type'=> 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.type.position' => array(
			'code'=>'customer.lists.type.position',
			'internalcode'=>'t3feulity."pos"',
			'label'=>'Customer list type position',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.lists.type.status' => array(
			'code'=>'customer.lists.type.status',
			'internalcode'=>'t3feulity."status"',
			'label'=>'Customer list type status',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.lists.type.ctime'=> array(
			'code'=>'customer.lists.type.ctime',
			'internalcode'=>'t3feulity."ctime"',
			'label'=>'Customer list type create date/time',
			'type'=> 'datetime',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.type.mtime'=> array(
			'code'=>'customer.lists.type.mtime',
			'internalcode'=>'t3feulity."mtime"',
			'label'=>'Customer list type modification date/time',
			'type'=> 'datetime',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.type.editor'=> array(
			'code'=>'customer.lists.type.editor',
			'internalcode'=>'t3feulity."editor"',
			'label'=>'Customer list type editor',
			'type'=> 'string',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
	);


	/**
	 * Removes old entries from the storage.
	 *
	 * @param array $siteids List of IDs for sites whose entries should be deleted
	 */
	public function cleanup( array $siteids )
	{
		$path = 'mshop/customer/manager/lists/type/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, [] ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->cleanup( $siteids );
		}

		$this->cleanupBase( $siteids, 'mshop/customer/manager/lists/type/typo3/delete' );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array Returns a list of attribtes implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( $withsub = true )
	{
		$path = 'mshop/customer/manager/lists/type/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, [], $withsub );
	}


	/**
	 * Returns a new manager for customer extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return mixed Manager for different extensions, e.g stock, tags, locations, etc.
	 */
	public function getSubManager( $manager, $name = null )
	{
		return $this->getSubManagerBase( 'customer', 'lists/type/' . $manager, ( $name === null ? 'Typo3' : $name ) );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path (mshop/customer/manager/lists/type/typo3/item/)
	 */
	protected function getConfigPath()
	{
		return 'mshop/customer/manager/lists/type/typo3/';
	}


	/**
	 * Returns the search configuration for searching items.
	 *
	 * @return array Associative list of search keys and search definitions
	 */
	protected function getSearchConfig()
	{
		return $this->searchConfig;
	}
}
