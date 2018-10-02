<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2018
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Lists;


/**
 * TYPO3 implementation of the customer list class.
 *
 * @package MShop
 * @subpackage Customer
 */
class Typo3
	extends \Aimeos\MShop\Customer\Manager\Lists\Standard
{
	private $searchConfig = array(
		'customer.lists.id'=> array(
			'code'=>'customer.lists.id',
			'internalcode'=>'t3feuli."id"',
			'internaldeps' => array( 'LEFT JOIN "fe_users_list" AS t3feuli ON ( t3feu."uid" = t3feuli."parentid" )' ),
			'label'=>'Customer list ID',
			'type'=> 'integer',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.siteid'=> array(
			'code'=>'customer.lists.siteid',
			'internalcode'=>'t3feuli."siteid"',
			'label'=>'Customer list site ID',
			'type'=> 'integer',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.parentid'=> array(
			'code'=>'customer.lists.parentid',
			'internalcode'=>'t3feuli."parentid"',
			'label'=>'Customer list parent ID',
			'type'=> 'integer',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.domain'=> array(
			'code'=>'customer.lists.domain',
			'internalcode'=>'t3feuli."domain"',
			'label'=>'Customer list domain',
			'type'=> 'string',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.typeid' => array(
			'code'=>'customer.lists.typeid',
			'internalcode'=>'t3feuli."typeid"',
			'label'=>'Customer list type ID',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.lists.refid'=> array(
			'code'=>'customer.lists.refid',
			'internalcode'=>'t3feuli."refid"',
			'label'=>'Customer list reference ID',
			'type'=> 'string',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.datestart' => array(
			'code'=>'customer.lists.datestart',
			'internalcode'=>'t3feuli."start"',
			'label'=>'Customer list start date/time',
			'type'=> 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.dateend' => array(
			'code'=>'customer.lists.dateend',
			'internalcode'=>'t3feuli."end"',
			'label'=>'Customer list end date/time',
			'type'=> 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.config' => array(
			'code'=>'customer.lists.config',
			'internalcode'=>'t3feuli."config"',
			'label'=>'Customer list position',
			'type'=> 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.position' => array(
			'code'=>'customer.lists.position',
			'internalcode'=>'t3feuli."pos"',
			'label'=>'Customer list position',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.lists.status' => array(
			'code'=>'customer.lists.status',
			'internalcode'=>'t3feuli."status"',
			'label'=>'Customer list status',
			'type'=> 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.lists.ctime'=> array(
			'code'=>'customer.lists.ctime',
			'internalcode'=>'t3feuli."ctime"',
			'label'=>'Customer list create date/time',
			'type'=> 'datetime',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.mtime'=> array(
			'code'=>'customer.lists.mtime',
			'internalcode'=>'t3feuli."mtime"',
			'label'=>'Customer list modification date/time',
			'type'=> 'datetime',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lists.editor'=> array(
			'code'=>'customer.lists.editor',
			'internalcode'=>'t3feuli."editor"',
			'label'=>'Customer list editor',
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
		$path = 'mshop/customer/manager/lists/submanagers';
		foreach( $this->getContext()->getConfig()->get( $path, ['type'] ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->cleanup( $siteids );
		}

		$this->cleanupBase( $siteids, 'mshop/customer/manager/lists/typo3/delete' );
	}


	/**
	 * Returns the attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array Returns a list of attribtes implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( $withsub = true )
	{
		$path = 'mshop/customer/manager/lists/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, ['type'], $withsub );
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
		return $this->getSubManagerBase( 'customer', 'lists/' . $manager, ( $name === null ? 'Typo3' : $name ) );
	}


	/**
	 * Returns the config path for retrieving the configuration values.
	 *
	 * @return string Configuration path (mshop/customer/manager/lists/type/typo3/item/)
	 */
	protected function getConfigPath()
	{
		return 'mshop/customer/manager/lists/typo3/';
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
