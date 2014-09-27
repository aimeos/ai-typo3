<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2011
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @package MShop
 * @subpackage Customer
 */


/**
 * Typo3 implementation of the customer class.
 *
 * @package MShop
 * @subpackage Customer
 */
class MShop_Customer_Manager_Typo3
	extends MShop_Customer_Manager_Default
{
	private $_searchConfig = array(
		'customer.id' => array(
			'label' => 'Customer ID',
			'code' => 'customer.id',
			'internalcode' => 't3feu."uid"',
			'type' => 'integer',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_INT
		),
		'customer.label' => array(
			'label' => 'Customer name',
			'code' => 'customer.label',
			'internalcode' => 't3feu."name"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR
		),
		'customer.code' => array(
			'label' => 'Customer username',
			'code' => 'customer.code',
			'internalcode' => 't3feu."username"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR
		),
		'customer.salutation' => array(
			'label' => 'Customer salutation',
			'code' => 'customer.salutation',
			'internalcode' => 't3feu."gender"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.company'=> array(
			'label' => 'Customer company',
			'code' => 'customer.company',
			'internalcode' => 't3feu."company"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.vatid'=> array(
			'label' => 'Customer VAT ID',
			'code' => 'customer.vatid',
			'internalcode' => 't3feu."vatid"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.title' => array(
			'label' => 'Customer title',
			'code' => 'customer.title',
			'internalcode' => 't3feu."title"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.firstname' => array(
			'label' => 'Customer firstname',
			'code' => 'customer.firstname',
			'internalcode' => 't3feu."first_name"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.lastname' => array(
			'label' => 'Customer lastname',
			'code' => 'customer.lastname',
			'internalcode' => 't3feu."last_name"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.address1' => array(
			'label' => 'Customer address part one',
			'code' => 'customer.address1',
			'internalcode' => 't3feu."address"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.address2' => array(
			'label' => 'Customer address part two',
			'code' => 'customer.address2',
			'internalcode' => 't3feu."address"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.address3' => array(
			'label' => 'Customer address part three',
			'code' => 'customer.address3',
			'internalcode' => 't3feu."address"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.postal' => array(
			'label' => 'Customer postal',
			'code' => 'customer.postal',
			'internalcode' => 't3feu."zip"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.city' => array(
			'label' => 'Customer city',
			'code' => 'customer.city',
			'internalcode' => 't3feu."city"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.state' => array(
			'label' => 'Customer state',
			'code' => 'customer.state',
			'internalcode' => 't3feu."zone"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.languageid' => array(
			'label' => 'Customer language',
			'code' => 'customer.languageid',
			'internalcode' => 't3feu."language"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.countryid' => array(
			'label' => 'Customer country',
			'code' => 'customer.countryid',
			'internalcode' => 'tsc."cn_iso_2"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.telephone' => array(
			'label' => 'Customer telephone',
			'code' => 'customer.telephone',
			'internalcode' => 't3feu."telephone"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.email' => array(
			'label' => 'Customer email',
			'code' => 'customer.email',
			'internalcode' => 't3feu."email"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.telefax' => array(
			'label' => 'Customer telefax',
			'code' => 'customer.telefax',
			'internalcode' => 't3feu."fax"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.website' => array(
			'label' => 'Customer website',
			'code' => 'customer.website',
			'internalcode' => 't3feu."www"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.birthday' => array(
			'label' => 'Customer birthday',
			'code' => 'customer.birthday',
			'internalcode' => 't3feu."date_of_birth"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.password'=> array(
			'label' => 'Customer password',
			'code' => 'customer.password',
			'internalcode' => 't3feu."password"',
			'type' => 'string',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.status'=> array(
			'label' => 'Customer status',
			'code' => 'customer.status',
			'internalcode' => 't3feu."disable"',
			'type' => 'integer',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_INT
		),
		'customer.ctime'=> array(
			'label' => 'Customer creation time',
			'code' => 'customer.ctime',
			'internalcode' => 't3feu."crdate"',
			'type' => 'datetime',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		'customer.mtime'=> array(
			'label' => 'Customer modification time',
			'code' => 'customer.mtime',
			'internalcode' => 't3feu."tstamp"',
			'type' => 'datetime',
			'internaltype' => MW_DB_Statement_Abstract::PARAM_STR,
		),
		// not available
		'customer.editor'=> array(
			'label'=>'Customer editor',
			'code'=>'customer.editor',
			'internalcode'=>'1',
			'type'=> 'string',
			'internaltype'=> MW_DB_Statement_Abstract::PARAM_STR,
		),
	);

	private $_plugins = array();
	private $_reverse = array();
	private $_pid;



	/**
	 * Initializes a new customer manager object using the given context object.
	 *
	 * @param MShop_Context_Interface $context Context object with required objects
	 */
	public function __construct( MShop_Context_Item_Interface $context )
	{
		parent::__construct( $context );

		$plugin = new MW_Common_Criteria_Plugin_T3Salutation();
		$this->_plugins['customer.salutation'] = $this->_reverse['gender'] = $plugin;

		$plugin = new MW_Common_Criteria_Plugin_T3Status();
		$this->_plugins['customer.status'] = $this->_reverse['disable'] = $plugin;

		$plugin = new MW_Common_Criteria_Plugin_T3Date();
		$this->_plugins['customer.birthday'] = $this->_reverse['date_of_birth'] = $plugin;

		$plugin = new MW_Common_Criteria_Plugin_T3Datetime();
		$this->_plugins['customer.ctime'] = $this->_reverse['crdate'] = $plugin;
		$this->_plugins['customer.mtime'] = $this->_reverse['tstamp'] = $plugin;

		$this->_pid = $context->getConfig()->get( 'mshop/customer/manager/typo3/pid-default', 0 );
	}


	/**
	 * Creates a criteria object for searching.
	 *
	 * @param boolean $default Include default criteria like the status
	 * @return MW_Common_Criteria_Interface Search criteria object
	 */
	public function createSearch( $default = false )
	{
		if( $default === true )
		{
			$dbm = $this->_getContext()->getDatabaseManager();
			$conn = $dbm->acquire();

			$object = new MW_Common_Criteria_SQL( $conn );
			$object->setConditions( $object->compare( '==', 'customer.status', 1 ) );

			$dbm->release( $conn );

			return $object;
		}

		return parent::createSearch();
	}


	/**
	 * Returns the list attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array List of attribute items implementing MW_Common_Criteria_Attribute_Interface
	 */
	public function getSearchAttributes( $withsub = true )
	{
		$path = 'classes/customer/manager/submanagers';

		return $this->_getSearchAttributes( $this->_searchConfig, $path, array( 'address', 'list' ), $withsub );
	}


	/**
	 * Instantiates a new customer item object.
	 *
	 * @return MShop_Customer_Item_Interface New customer item object
	 */
	public function createItem()
	{
		return $this->_createItem();
	}


	/**
	 * Deletes a customer item object from the permanent storage.
	 *
	 * @param array $ids List of customer IDs
	 */
	public function deleteItems( array $ids )
	{
		$path = 'mshop/customer/manager/typo3/item/delete';
		$this->_deleteItems( $ids, $this->_getContext()->getConfig()->get( $path, $path ), false, 'uid' );
	}


	/**
	 * Saves a customer item object.
	 *
	 * @param MShop_Customer_Item_Interface $item Customer item object
	 * @param boolean $fetch True if the new ID should be returned in the item
	 */
	public function saveItem( MShop_Common_Item_Interface $item, $fetch = true )
	{
		$iface = 'MShop_Customer_Item_Interface';
		if( !( $item instanceof $iface ) ) {
			throw new MShop_Customer_Exception( sprintf( 'Object is not of required type "%1$s"', $iface ) );
		}

		if( !$item->isModified() ) { return; }

		$context = $this->_getContext();
		$dbm = $context->getDatabaseManager();
		$conn = $dbm->acquire();

		try
		{
			$id = $item->getId();
			$billingAddress = $item->getPaymentAddress();

			if( $id === null )
			{
				/** mshop/customer/manager/typo3/item/insert
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
				 * @see mshop/customer/manager/typo3/item/update
				 * @see mshop/customer/manager/typo3/item/newid
				 * @see mshop/customer/manager/typo3/item/delete
				 * @see mshop/customer/manager/typo3/item/search
				 * @see mshop/customer/manager/typo3/item/count
				 */
				$path = 'mshop/customer/manager/typo3/item/insert';
			}
			else
			{
				/** mshop/customer/manager/typo3/item/update
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
				 * @see mshop/customer/manager/typo3/item/insert
				 * @see mshop/customer/manager/typo3/item/newid
				 * @see mshop/customer/manager/typo3/item/delete
				 * @see mshop/customer/manager/typo3/item/search
				 * @see mshop/customer/manager/typo3/item/count
				 */
				$path = 'mshop/customer/manager/typo3/item/update';
			}

			$stmt = $this->_getCachedStatement( $conn, $path );

			$address = $billingAddress->getAddress1();

			if( ( $part = $billingAddress->getAddress2() ) != '' ) {
				$address .= ' ' . $part;
			}

			if( ( $part = $billingAddress->getAddress3() ) != '' ) {
				$address .= ' ' . $part;
			}

			// TYPO3 fe_users.static_info_country is a three letter ISO code instead a two letter one
			$stmt->bind( 1, $item->getLabel() );
			$stmt->bind( 2, $item->getCode() );
			$stmt->bind( 3, $this->_plugins['customer.salutation']->translate( $billingAddress->getSalutation() ), MW_DB_Statement_Abstract::PARAM_INT );
			$stmt->bind( 4, $billingAddress->getCompany() );
			$stmt->bind( 5, $billingAddress->getVatID() );
			$stmt->bind( 6, $billingAddress->getTitle() );
			$stmt->bind( 7, $billingAddress->getFirstname() );
			$stmt->bind( 8, $billingAddress->getLastname() );
			$stmt->bind( 9, $address );
			$stmt->bind( 10, $billingAddress->getPostal() );
			$stmt->bind( 11, $billingAddress->getCity() );
			$stmt->bind( 12, $billingAddress->getState() );
			$stmt->bind( 13, $billingAddress->getLanguageId() );
			$stmt->bind( 14, $billingAddress->getTelephone() );
			$stmt->bind( 15, $billingAddress->getEmail() );
			$stmt->bind( 16, $billingAddress->getTelefax() );
			$stmt->bind( 17, $billingAddress->getWebsite() );
			$stmt->bind( 18, $this->_plugins['customer.birthday']->translate( $item->getBirthday() ), MW_DB_Statement_Abstract::PARAM_INT );
			$stmt->bind( 19, $this->_plugins['customer.status']->translate( $item->getStatus() ), MW_DB_Statement_Abstract::PARAM_INT );
			$stmt->bind( 20, $item->getPassword() );
			$stmt->bind( 21, time(), MW_DB_Statement_Abstract::PARAM_INT ); // Modification time
			$stmt->bind( 22, $billingAddress->getCountryId() );

			if( $id !== null ) {
				$stmt->bind( 23, $id, MW_DB_Statement_Abstract::PARAM_INT );
				$item->setId( $id );
			} else {
				$stmt->bind( 23, time() ); // Creation time
				$stmt->bind( 24, $this->_pid ); // TYPO3 PID value
			}

			$stmt->execute()->finish();

			if( $id === null && $fetch === true )
			{
				/** mshop/customer/manager/typo3/item/newid
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
				 * @see mshop/customer/manager/typo3/item/insert
				 * @see mshop/customer/manager/typo3/item/update
				 * @see mshop/customer/manager/typo3/item/delete
				 * @see mshop/customer/manager/typo3/item/search
				 * @see mshop/customer/manager/typo3/item/count
				 */
				$path = 'mshop/customer/manager/typo3/item/newid';
				$item->setId( $this->_newId( $conn, $context->getConfig()->get( $path, $path ) ) );
			}

			$dbm->release( $conn );
		}
		catch( Exception $e )
		{
			$dbm->release( $conn );
			throw $e;
		}
	}


	/**
	 * Returns the item objects matched by the given search criteria.
	 *
	 * @param MW_Common_Criteria_Interface $search Search criteria object
	 * @param integer &$total Number of items that are available in total
	 * @return array List of items implementing MShop_Customer_Item_Interface
	 * @throws MShop_Customer_Exception If creating items failed
	 */
	public function searchItems( MW_Common_Criteria_Interface $search, array $ref = array(), &$total = null )
	{
		$dbm = $this->_getContext()->getDatabaseManager();
		$conn = $dbm->acquire();
		$map = array();

		try
		{
			$level = MShop_Locale_Manager_Abstract::SITE_ALL;
			$cfgPathSearch = 'mshop/customer/manager/typo3/item/search';
			$cfgPathCount = 'mshop/customer/manager/typo3/item/count';
			$required = array( 'customer' );

			$results = $this->_searchItems( $conn, $search, $cfgPathSearch, $cfgPathCount, $required, $total, $level, $this->_plugins );
			while( ( $row = $results->fetch() ) !== false ) {
				$map[ $row['id'] ] = $row;
			}

			$dbm->release( $conn );
		}
		catch( Exception $e )
		{
			$dbm->release( $conn );
			throw $e;
		}

		return $this->_buildItems( $map, $ref, 'customer' );
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
		return $this->_getSubManager( 'customer', $manager, ( $name === null ? 'Typo3' : $name ) );
	}


	/**
	 * Creates a new customer item.
	 *
	 * @param array $values List of attributes for customer item
	 * @param array $listItems List items associated to the customer item
	 * @param array $refItems Items referenced by the customer item via the list items
	 * @return MShop_Customer_Item_Interface New customer item
	 */
	protected function _createItem( array $values = array(), array $listItems = array(), array $refItems = array() )
	{
		$address = $this->_getAddressManager()->createItem();
		$values['siteid'] = $this->_getContext()->getLocale()->getSiteId();

		if( array_key_exists( 'date_of_birth', $values ) ) {
			$values['birthday'] = $this->_reverse['date_of_birth']->reverse( $values['date_of_birth'] );
		}

		if( array_key_exists( 'gender', $values ) ) {
			$values['salutation'] = $this->_reverse['gender']->reverse( $values['gender'] );
		}

		if( array_key_exists( 'disable', $values ) ) {
			$values['status'] = $this->_reverse['disable']->reverse( $values['disable'] );
		}

		if( array_key_exists( 'tstamp', $values ) ) {
			$values['mtime'] = $this->_reverse['tstamp']->reverse( $values['tstamp'] );
		}

		if( array_key_exists( 'crdate', $values ) ) {
			$values['ctime'] = $this->_reverse['crdate']->reverse( $values['crdate'] );
		}

		if( array_key_exists( 'langid', $values ) ) {
			$values['langid'] = strtolower( $values['langid'] );
		}

		return new MShop_Customer_Item_Default( $address, $values, $listItems, $refItems );
	}


	/**
	 * Returns the address sub-manager.
	 *
	 * @return MShop_Common_Manager_Interface Customer address manager
	 */
	protected function _getAddressManager()
	{
		if( !isset( $this->_addressManager ) ) {
			$this->_addressManager = $this->getSubManager( 'address' );
		}

		return $this->_addressManager;
	}
}