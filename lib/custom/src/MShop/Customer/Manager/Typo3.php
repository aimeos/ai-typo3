<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2020
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager;


/**
 * Typo3 implementation of the customer class.
 *
 * @package MShop
 * @subpackage Customer
 */
class Typo3
	extends \Aimeos\MShop\Customer\Manager\Standard
{
	private $searchConfig = array(
		'customer.id' => array(
			'label' => 'Customer ID',
			'code' => 'customer.id',
			'internalcode' => 't3feu."uid"',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
			'public' => false,
		),
		'customer.siteid' => array(
			'code' => 'customer.siteid',
			'internalcode' => 't3feu."siteid"',
			'label' => 'Customer site ID',
			'type'=> 'string',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
			'public' => false,
		),
		'customer.code' => array(
			'label' => 'Customer username',
			'code' => 'customer.code',
			'internalcode' => 't3feu."username"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR
		),
		'customer.label' => array(
			'label' => 'Customer name',
			'code' => 'customer.label',
			'internalcode' => 't3feu."name"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR
		),
		'customer.salutation' => array(
			'label' => 'Customer salutation',
			'code' => 'customer.salutation',
			'internalcode' => 't3feu."gender"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.company'=> array(
			'label' => 'Customer company',
			'code' => 'customer.company',
			'internalcode' => 't3feu."company"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.vatid'=> array(
			'label' => 'Customer VAT ID',
			'code' => 'customer.vatid',
			'internalcode' => 't3feu."vatid"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.title' => array(
			'label' => 'Customer title',
			'code' => 'customer.title',
			'internalcode' => 't3feu."title"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.firstname' => array(
			'label' => 'Customer firstname',
			'code' => 'customer.firstname',
			'internalcode' => 't3feu."first_name"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.lastname' => array(
			'label' => 'Customer lastname',
			'code' => 'customer.lastname',
			'internalcode' => 't3feu."last_name"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address1' => array(
			'label' => 'Customer address part one',
			'code' => 'customer.address1',
			'internalcode' => 't3feu."address"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address2' => array(
			'label' => 'Customer address part two',
			'code' => 'customer.address2',
			'internalcode' => 't3feu."address"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.address3' => array(
			'label' => 'Customer address part three',
			'code' => 'customer.address3',
			'internalcode' => 't3feu."address"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.postal' => array(
			'label' => 'Customer postal',
			'code' => 'customer.postal',
			'internalcode' => 't3feu."zip"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.city' => array(
			'label' => 'Customer city',
			'code' => 'customer.city',
			'internalcode' => 't3feu."city"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.state' => array(
			'label' => 'Customer state',
			'code' => 'customer.state',
			'internalcode' => 't3feu."zone"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.languageid' => array(
			'label' => 'Customer language',
			'code' => 'customer.languageid',
			'internalcode' => 't3feu."language"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.countryid' => array(
			'label' => 'Customer country',
			'code' => 'customer.countryid',
			'internalcode' => 'tsc."cn_iso_2"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.telephone' => array(
			'label' => 'Customer telephone',
			'code' => 'customer.telephone',
			'internalcode' => 't3feu."telephone"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.email' => array(
			'label' => 'Customer email',
			'code' => 'customer.email',
			'internalcode' => 't3feu."email"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.telefax' => array(
			'label' => 'Customer telefax',
			'code' => 'customer.telefax',
			'internalcode' => 't3feu."fax"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.website' => array(
			'label' => 'Customer website',
			'code' => 'customer.website',
			'internalcode' => 't3feu."www"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.longitude' => array(
			'label' => 'Customer longitude',
			'code' => 'customer.longitude',
			'internalcode' => 't3feu."longitude"',
			'type' => 'float',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_FLOAT,
		),
		'customer.latitude' => array(
			'label' => 'Customer latitude',
			'code' => 'customer.latitude',
			'internalcode' => 't3feu."latitude"',
			'type' => 'float',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_FLOAT,
		),
		'customer.birthday' => array(
			'label' => 'Customer birthday',
			'code' => 'customer.birthday',
			'internalcode' => 't3feu."date_of_birth"',
			'type' => 'date',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.password'=> array(
			'label' => 'Customer password',
			'code' => 'customer.password',
			'internalcode' => 't3feu."password"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.status'=> array(
			'label' => 'Customer status',
			'code' => 'customer.status',
			'internalcode' => 't3feu."disable"',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT
		),
		'customer.dateverified'=> array(
			'label' => 'Customer verification date',
			'code' => 'customer.dateverified',
			'internalcode' => 't3feu."vdate"',
			'type' => 'date',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.ctime'=> array(
			'label' => 'Customer creation time',
			'code' => 'customer.ctime',
			'internalcode' => 't3feu."crdate"',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.mtime'=> array(
			'label' => 'Customer modification time',
			'code' => 'customer.mtime',
			'internalcode' => 't3feu."tstamp"',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		// not available
		'customer.editor'=> array(
			'label' => 'Customer editor',
			'code' => 'customer.editor',
			'internalcode' => null,
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer:has' => array(
			'code' => 'customer:has()',
			'internalcode' => ':site AND :key AND t3feuli."id"',
			'internaldeps' => ['LEFT JOIN "fe_users_list" AS t3feuli ON ( t3feuli."parentid" = t3feu."uid" )'],
			'label' => 'Customer has list item, parameter(<domain>[,<list type>[,<reference ID>)]]',
			'type' => 'null',
			'internaltype' => 'null',
			'public' => false,
		),
		'customer:prop' => array(
			'code' => 'customer:prop()',
			'internalcode' => ':site AND :key AND t3feupr."id"',
			'internaldeps' => ['LEFT JOIN "fe_users_property" AS t3feupr ON ( t3feupr."parentid" = t3feu."uid" )'],
			'label' => 'Customer has property item, parameter(<property type>[,<language code>[,<property value>]])',
			'type' => 'null',
			'internaltype' => 'null',
			'public' => false,
		),
	);


	private $plugins = [];
	private $reverse = [];
	private $helper;
	private $pid;



	/**
	 * Initializes a new customer manager object using the given context object.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context Context object with required objects
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );

		$plugin = new \Aimeos\MW\Criteria\Plugin\T3Salutation();
		$this->plugins['customer.salutation'] = $this->reverse['gender'] = $plugin;

		$plugin = new \Aimeos\MW\Criteria\Plugin\T3Status();
		$this->plugins['customer.status'] = $this->reverse['disable'] = $plugin;

		$plugin = new \Aimeos\MW\Criteria\Plugin\T3Date();
		$this->plugins['customer.birthday'] = $this->reverse['date_of_birth'] = $plugin;

		$plugin = new \Aimeos\MW\Criteria\Plugin\T3Datetime();
		$this->plugins['customer.ctime'] = $this->reverse['crdate'] = $plugin;
		$this->plugins['customer.mtime'] = $this->reverse['tstamp'] = $plugin;

		/** mshop/customer/manager/typo3/pid-default
		 * Page ID the customer records are assigned to
		 *
		 * In TYPO3, you can assign fe_user records to different sysfolders based
		 * on their page ID and for checking user credentials at login, the configured
		 * sysfolder is used. Thus, the page ID of the same sysfolder must be assigned
		 * to the user records so they are allowed to log in after they are created
		 * or modified by Aimeos.
		 *
		 * @param int TYPO3 page ID
		 * @since 2016.10
		 * @see mshop/customer/manager/group/typo3/pid-default
		 */
		$this->pid = $context->getConfig()->get( 'mshop/customer/manager/typo3/pid-default', 0 );


		$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
		$level = $context->getConfig()->get( 'mshop/customer/manager/sitemode', $level );


		$this->searchConfig['customer:has']['function'] = function( &$source, array $params ) use ( $level ) {

			array_walk_recursive( $params, function( &$v ) {
				$v = trim( $v, '\'' );
			} );

			$keys = [];
			$params[1] = isset( $params[1] ) ? $params[1] : '';
			$params[2] = isset( $params[2] ) ? $params[2] : '';

			foreach( (array) $params[1] as $type ) {
				foreach( (array) $params[2] as $id ) {
					$keys[] = $params[0] . '|' . ( $type ? $type . '|' : '' ) . $id;
				}
			}

			$sitestr = $this->getSiteString( 't3feuli."siteid"', $level );
			$keystr = $this->toExpression( 't3feuli."key"', $keys, $params[2] !== '' ? '==' : '=~' );
			$source = str_replace( [':site', ':key'], [$sitestr, $keystr], $source );

			return $params;
		};


		$this->searchConfig['customer:prop']['function'] = function( &$source, array $params ) use ( $level ) {

			array_walk_recursive( $params, function( &$v ) {
				$v = trim( $v, '\'' );
			} );

			$keys = [];
			$params[1] = array_key_exists( 1, $params ) ? $params[1] : '';
			$params[2] = isset( $params[2] ) ? $params[2] : '';

			foreach( (array) $params[1] as $lang ) {
				foreach( (array) $params[2] as $id ) {
					$keys[] = $params[0] . '|' . ( $lang ? $lang . '|' : '' ) . ( $id !== '' ?  md5( $id ) : '' );
				}
			}

			$sitestr = $this->getSiteString( 't3feupr."siteid"', $level );
			$keystr = $this->toExpression( 't3feupr."key"', $keys, $params[2] !== '' ? '==' : '=~' );
			$source = str_replace( [':site', ':key'], [$sitestr, $keystr], $source );

			return $params;
		};
	}


	/**
	 * Removes old entries from the storage.
	 *
	 * @param string[] $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Common\Manager\Iface Same object for fluent interface
	 */
	public function clear( array $siteids ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/customer/manager/submanagers';
		$default = ['address', 'group', 'lists', 'property'];

		foreach( $this->getContext()->getConfig()->get( $path, $default ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/customer/manager/typo3/delete' );
	}


	/**
	 * Creates a new empty item instance
	 *
	 * @param array $values Values the item should be initialized with
	 * @return \Aimeos\MShop\Customer\Item\Iface New site item object
	 */
	public function createItem( array $values = [] ) : \Aimeos\MShop\Common\Item\Iface
	{
		$values['customer.siteid'] = $this->getContext()->getLocale()->getSiteId();
		return $this->createItemBase( $values );
	}


	/**
	 * Removes multiple items.
	 *
	 * @param \Aimeos\MShop\Common\Item\Iface[]|string[] $itemIds List of item objects or IDs of the items
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager object for chaining method calls
	 */
	public function deleteItems( array $itemIds ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/customer/manager/typo3/delete';
		return $this->deleteItemsBase( $itemIds, $path, true, 'uid' )->deleteRefItems( $itemIds );
	}


	/**
	 * Returns the list attributes that can be used for searching.
	 *
	 * @param bool $withsub Return also attributes of sub-managers if true
	 * @return array List of attribute items implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		$path = 'mshop/customer/manager/submanagers';
		return $this->getSearchAttributesBase( $this->searchConfig, $path, ['address'], $withsub );
	}


	/**
	 * Saves a customer item object.
	 *
	 * @param \Aimeos\MShop\Customer\Item\Iface $item Customer item object
	 * @param bool $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Customer\Item\Iface $item Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Customer\Item\Iface $item, bool $fetch = true ) : \Aimeos\MShop\Customer\Item\Iface
	{
		if( !$item->isModified() )
		{
			$item = $this->savePropertyItems( $item, 'customer' );
			$item = $this->saveAddressItems( $item, 'customer' );
			return $this->saveListItems( $item, 'customer' );
		}

		$context = $this->getContext();
		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$id = $item->getId();
			$billingAddress = $item->getPaymentAddress();
			$columns = $this->getObject()->getSaveAttributes();

			if( $id === null )
			{
				/** mshop/customer/manager/typo3/insert
				 * Inserts a new customer record into the database table
				 *
				 * Items with no ID yet (i.e. the ID is NULL) will be created in
				 * the database and the newly created ID retrieved afterwards
				 * using the "newid" SQL statement.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the customer item to the statement before they are
				 * sent to the database server. The number of question marks must
				 * be the same as the number of columns listed in the INSERT
				 * statement. The order of the columns must correspond to the
				 * order in the saveItems() method, so the correct values are
				 * bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for inserting records
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/customer/manager/typo3/update
				 * @see mshop/customer/manager/typo3/newid
				 * @see mshop/customer/manager/typo3/delete
				 * @see mshop/customer/manager/typo3/search
				 * @see mshop/customer/manager/typo3/count
				 */
				$path = 'mshop/customer/manager/typo3/insert';
				$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ) );
			}
			else
			{
				/** mshop/customer/manager/typo3/update
				 * Updates an existing customer record in the database
				 *
				 * Items which already have an ID (i.e. the ID is not NULL) will
				 * be updated in the database.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the customer item to the statement before they are
				 * sent to the database server. The order of the columns must
				 * correspond to the order in the saveItems() method, so the
				 * correct values are bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for updating records
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/customer/manager/typo3/insert
				 * @see mshop/customer/manager/typo3/newid
				 * @see mshop/customer/manager/typo3/delete
				 * @see mshop/customer/manager/typo3/search
				 * @see mshop/customer/manager/typo3/count
				 */
				$path = 'mshop/customer/manager/typo3/update';
				$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ), false );
			}

			$address = $billingAddress->getAddress1();

			if( ( $part = $billingAddress->getAddress2() ) != '' ) {
				$address .= ' ' . $part;
			}

			if( ( $part = $billingAddress->getAddress3() ) != '' ) {
				$address .= ' ' . $part;
			}

			$idx = 1;
			$stmt = $this->getCachedStatement( $conn, $path, $sql );

			foreach( $columns as $name => $entry ) {
				$stmt->bind( $idx++, $item->get( $name ), $entry->getInternalType() );
			}

			// TYPO3 fe_users.static_info_country is a three letter ISO code instead a two letter one
			$stmt->bind( $idx++, $item->getLabel() );
			$stmt->bind( $idx++, $item->getCode() );
			$stmt->bind( $idx++, $this->plugins['customer.salutation']->translate( $billingAddress->getSalutation() ), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, $billingAddress->getCompany() );
			$stmt->bind( $idx++, $billingAddress->getVatID() );
			$stmt->bind( $idx++, $billingAddress->getTitle() );
			$stmt->bind( $idx++, $billingAddress->getFirstname() );
			$stmt->bind( $idx++, $billingAddress->getLastname() );
			$stmt->bind( $idx++, $address );
			$stmt->bind( $idx++, $billingAddress->getPostal() );
			$stmt->bind( $idx++, $billingAddress->getCity() );
			$stmt->bind( $idx++, $billingAddress->getState() );
			$stmt->bind( $idx++, $billingAddress->getLanguageId() );
			$stmt->bind( $idx++, $billingAddress->getTelephone() );
			$stmt->bind( $idx++, $billingAddress->getEmail() );
			$stmt->bind( $idx++, $billingAddress->getTelefax() );
			$stmt->bind( $idx++, $billingAddress->getWebsite() );
			$stmt->bind( $idx++, $billingAddress->getLongitude(), \Aimeos\MW\DB\Statement\Base::PARAM_FLOAT );
			$stmt->bind( $idx++, $billingAddress->getLatitude(), \Aimeos\MW\DB\Statement\Base::PARAM_FLOAT );
			$stmt->bind( $idx++, $this->plugins['customer.birthday']->translate( $billingAddress->getBirthday() ), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, $this->plugins['customer.status']->translate( $item->getStatus() ), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, $item->getPassword() );
			$stmt->bind( $idx++, time(), \Aimeos\MW\DB\Statement\Base::PARAM_INT ); // Modification time
			$stmt->bind( $idx++, $billingAddress->getCountryId() );
			$stmt->bind( $idx++, implode( ',', $item->getGroups() ) );
			$stmt->bind( $idx++, $this->pid, \Aimeos\MW\DB\Statement\Base::PARAM_INT ); // TYPO3 PID value
			$stmt->bind( $idx++, $context->getLocale()->getSiteId() );

			if( $id !== null ) {
				$stmt->bind( $idx, $id, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
				$item->setId( $id );
			} else {
				$stmt->bind( $idx, time(), \Aimeos\MW\DB\Statement\Base::PARAM_INT ); // Creation time
			}

			$stmt->execute()->finish();

			if( $id === null && $fetch === true )
			{
				/** mshop/customer/manager/typo3/newid
				 * Retrieves the ID generated by the database when inserting a new record
				 *
				 * As soon as a new record is inserted into the database table,
				 * the database server generates a new and unique identifier for
				 * that record. This ID can be used for retrieving, updating and
				 * deleting that specific record from the table again.
				 *
				 * For MySQL:
				 *  SELECT LAST_INSERT_ID()
				 * For PostgreSQL:
				 *  SELECT currval('seq_mcus_id')
				 * For SQL Server:
				 *  SELECT SCOPE_IDENTITY()
				 * For Oracle:
				 *  SELECT "seq_mcus_id".CURRVAL FROM DUAL
				 *
				 * There's no way to retrive the new ID by a SQL statements that
				 * fits for most database servers as they implement their own
				 * specific way.
				 *
				 * @param string SQL statement for retrieving the last inserted record ID
				 * @since 2014.03
				 * @category Developer
				 * @see mshop/customer/manager/typo3/insert
				 * @see mshop/customer/manager/typo3/update
				 * @see mshop/customer/manager/typo3/delete
				 * @see mshop/customer/manager/typo3/search
				 * @see mshop/customer/manager/typo3/count
				 */
				$path = 'mshop/customer/manager/typo3/newid';
				$item->setId( $this->newId( $conn, $path ) );
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		$item = $this->savePropertyItems( $item, 'customer' );
		$item = $this->saveAddressItems( $item, 'customer' );
		return $this->saveListItems( $item, 'customer' );
	}


	/**
	 * Returns the item objects matched by the given search criteria.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Search criteria object
	 * @param int|null &$total Number of items that are available in total
	 * @return \Aimeos\Map List of items implementing \Aimeos\MShop\Customer\Item\Iface
	 * @throws \Aimeos\MShop\Customer\Exception If creating items failed
	 */
	public function searchItems( \Aimeos\MW\Criteria\Iface $search, array $ref = [], int &$total = null ) : \Aimeos\Map
	{
		$dbm = $this->getContext()->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );
		$map = [];

		try
		{
			$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
			$cfgPathSearch = 'mshop/customer/manager/typo3/search';
			$cfgPathCount = 'mshop/customer/manager/typo3/count';
			$required = array( 'customer' );

			$results = $this->searchItemsBase( $conn, $search, $cfgPathSearch, $cfgPathCount, $required, $total, $level, $this->plugins );

			while( ( $row = $results->fetch() ) !== null ) {
				$map[(string) $row['customer.id']] = $row;
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		$addrItems = [];
		if( in_array( 'customer/address', $ref, true ) ) {
			$addrItems = $this->getAddressItems( array_keys( $map ), 'customer' );
		}

		$propItems = []; $name = 'customer/property';
		if( isset( $ref[$name] ) || in_array( $name, $ref, true ) )
		{
			$propTypes = isset( $ref[$name] ) && is_array( $ref[$name] ) ? $ref[$name] : null;
			$propItems = $this->getPropertyItems( array_keys( $map ), 'customer', $propTypes );
		}

		return $this->buildItems( $map, $ref, 'customer', $addrItems, $propItems );
	}


	/**
	 * Returns a new manager for customer extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return mixed Manager for different extensions, e.g stock, tags, locations, etc.
	 */
	public function getSubManager( string $manager, string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return $this->getSubManagerBase( 'customer', $manager, ( $name === null ? 'Typo3' : $name ) );
	}


	/**
	 * Creates a new customer item.
	 *
	 * @param array $values List of attributes for customer item
	 * @param \Aimeos\MShop\Common\Lists\Item\Iface[] $listItems List of list items
	 * @param \Aimeos\MShop\Common\Item\Iface[] $refItems List of referenced items
	 * @param \Aimeos\MShop\Common\Item\Address\Iface[] $addrItems List of referenced address items
	 * @param \Aimeos\MShop\Common\Item\Property\Iface[] $propItems List of property items
	 * @return \Aimeos\MShop\Customer\Item\Iface New customer item
	 */
	protected function createItemBase( array $values = [], array $listItems = [], array $refItems = [],
		array $addrItems = [], array $propItems = [] ) : \Aimeos\MShop\Common\Item\Iface
	{
		$helper = $this->getPasswordHelper();
		$values['customer.siteid'] = $this->getContext()->getLocale()->getSiteId();

		if( array_key_exists( 'date_of_birth', $values ) ) {
			$values['customer.birthday'] = $this->reverse['date_of_birth']->reverse( $values['date_of_birth'] );
		}

		if( array_key_exists( 'gender', $values ) ) {
			$values['customer.salutation'] = $this->reverse['gender']->reverse( $values['gender'] );
		}

		if( array_key_exists( 'disable', $values ) ) {
			$values['customer.status'] = $this->reverse['disable']->reverse( $values['disable'] );
		}

		if( array_key_exists( 'tstamp', $values ) ) {
			$values['customer.mtime'] = $this->reverse['tstamp']->reverse( $values['tstamp'] );
		}

		if( array_key_exists( 'crdate', $values ) ) {
			$values['customer.ctime'] = $this->reverse['crdate']->reverse( $values['crdate'] );
		}

		if( array_key_exists( 'groups', $values ) && $values['groups'] !== '' ) {
			$values['customer.groups'] = explode( ',', $values['groups'] );
		}


		$address = new \Aimeos\MShop\Common\Item\Address\Simple( 'customer.', $values );

		return new \Aimeos\MShop\Customer\Item\Standard(
			$address, $values, $listItems, $refItems, $addrItems, $propItems, $helper
		);
	}


	/**
	 * Returns a password helper object based on the configuration.
	 *
	 * @return \Aimeos\MShop\Common\Helper\Password\Iface Password helper object
	 * @throws \Aimeos\MShop\Exception If the name is invalid or the class isn't found
	 */
	protected function getPasswordHelper() : \Aimeos\MShop\Common\Helper\Password\Iface
	{
		if( $this->helper ) {
			return $this->helper;
		}

		$classname = \Aimeos\MShop\Common\Helper\Password\Typo3::class;

		if( class_exists( $classname ) === false ) {
			throw new \Aimeos\MShop\Exception( sprintf( 'Class "%1$s" not available', $classname ) );
		}

		$context = $this->getContext();
		$object = ( method_exists( $context, 'getHasherTypo3' ) ? $context->getHasherTypo3() : null );

		$helper = new $classname( array( 'object' => $object ) );

		return $this->helper = self::checkClass( \Aimeos\MShop\Common\Helper\Password\Iface::class, $helper );
	}
}
