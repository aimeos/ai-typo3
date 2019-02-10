<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2018
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
		// customer.siteid is only for informational purpuse, not for filtering
		'customer.id' => array(
			'label' => 'Customer ID',
			'code' => 'customer.id',
			'internalcode' => 't3feu."uid"',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
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
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.latitude' => array(
			'label' => 'Customer latitude',
			'code' => 'customer.latitude',
			'internalcode' => 't3feu."latitude"',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.birthday' => array(
			'label' => 'Customer birthday',
			'code' => 'customer.birthday',
			'internalcode' => 't3feu."date_of_birth"',
			'type' => 'string',
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
			'label'=>'Customer editor',
			'code'=>'customer.editor',
			'internalcode'=>'1',
			'type'=> 'string',
			'internaltype'=> \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
	);

	private $plugins = [];
	private $reverse = [];
	private $helper;
	private $pid;



	/**
	 * Initializes a new customer manager object using the given context object.
	 *
	 * @param \Aimeos\MShop\Context\Iface $context Context object with required objects
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

		$this->pid = $context->getConfig()->get( 'mshop/customer/manager/typo3/pid-default', 0 );
	}


	/**
	 * Returns the list attributes that can be used for searching.
	 *
	 * @param boolean $withsub Return also attributes of sub-managers if true
	 * @return array List of attribute items implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( $withsub = true )
	{
		$path = 'mshop/customer/manager/submanagers';
		$default = ['address', 'lists', 'property'];

		return $this->getSearchAttributesBase( $this->searchConfig, $path, $default, $withsub );
	}


	/**
	 * Removes old entries from the storage.
	 *
	 * @param array $siteids List of IDs for sites whose entries should be deleted
	 */
	public function cleanup( array $siteids )
	{
		$path = 'mshop/customer/manager/submanagers';
		$default = ['address', 'group', 'lists', 'property'];

		foreach( $this->getContext()->getConfig()->get( $path, $default ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->cleanup( $siteids );
		}
	}


	/**
	 * Creates a new empty item instance
	 *
	 * @param string|null Type the item should be created with
	 * @param string|null Domain of the type the item should be created with
	 * @param array $values Values the item should be initialized with
	 * @return \Aimeos\MShop\Common\Item\Site\Iface New site item object
	 */
	public function createItem( $type = null, $domain = null, array $values = [] )
	{
		$values['customer.siteid'] = $this->getContext()->getLocale()->getSiteId();
		$values['typo3.pageid'] = $this->pid;

		return $this->createItemBase( $values );
	}


	/**
	 * Deletes a customer item object from the permanent storage.
	 *
	 * @param array $ids List of customer IDs
	 */
	public function deleteItems( array $ids )
	{
		$path = 'mshop/customer/manager/typo3/delete';
		$this->deleteItemsBase( $ids, $path, false, 'uid' );
	}


	/**
	 * Saves a customer item object.
	 *
	 * @param \Aimeos\MShop\Customer\Item\Iface $item Customer item object
	 * @param boolean $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Common\Item\Iface $item Updated item including the generated ID
	 */
	public function saveItem( \Aimeos\MShop\Common\Item\Iface $item, $fetch = true )
	{
		self::checkClass( '\\Aimeos\\MShop\\Customer\\Item\\Iface', $item );

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
			}

			$stmt = $this->getCachedStatement( $conn, $path );

			$address = $billingAddress->getAddress1();

			if( ( $part = $billingAddress->getAddress2() ) != '' ) {
				$address .= ' ' . $part;
			}

			if( ( $part = $billingAddress->getAddress3() ) != '' ) {
				$address .= ' ' . $part;
			}

			// TYPO3 fe_users.static_info_country is a three letter ISO code instead a two letter one
			$stmt->bind( 1, $context->getLocale()->getSiteId(), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( 2, $item->getLabel() );
			$stmt->bind( 3, $item->getCode() );
			$stmt->bind( 4, $this->plugins['customer.salutation']->translate( $billingAddress->getSalutation() ), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( 5, $billingAddress->getCompany() );
			$stmt->bind( 6, $billingAddress->getVatID() );
			$stmt->bind( 7, $billingAddress->getTitle() );
			$stmt->bind( 8, $billingAddress->getFirstname() );
			$stmt->bind( 9, $billingAddress->getLastname() );
			$stmt->bind( 10, $address );
			$stmt->bind( 11, $billingAddress->getPostal() );
			$stmt->bind( 12, $billingAddress->getCity() );
			$stmt->bind( 13, $billingAddress->getState() );
			$stmt->bind( 14, $billingAddress->getLanguageId() );
			$stmt->bind( 15, $billingAddress->getTelephone() );
			$stmt->bind( 16, $billingAddress->getEmail() );
			$stmt->bind( 17, $billingAddress->getTelefax() );
			$stmt->bind( 18, $billingAddress->getWebsite() );
			$stmt->bind( 19, $billingAddress->getLongitude() );
			$stmt->bind( 20, $billingAddress->getLatitude() );
			$stmt->bind( 21, $this->plugins['customer.birthday']->translate( $item->getBirthday() ), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( 22, $this->plugins['customer.status']->translate( $item->getStatus() ), \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( 23, $item->getPassword() );
			$stmt->bind( 24, time(), \Aimeos\MW\DB\Statement\Base::PARAM_INT ); // Modification time
			$stmt->bind( 25, $billingAddress->getCountryId() );
			$stmt->bind( 26, implode( ',', $item->getGroups() ) );
			$stmt->bind( 27, $item->getPageId(), \Aimeos\MW\DB\Statement\Base::PARAM_INT ); // TYPO3 PID value

			if( $id !== null ) {
				$stmt->bind( 28, $id, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
				$item->setId( $id );
			} else {
				$stmt->bind( 28, time(), \Aimeos\MW\DB\Statement\Base::PARAM_INT ); // Creation time
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
	 * @param integer &$total Number of items that are available in total
	 * @return array List of items implementing \Aimeos\MShop\Customer\Item\Iface
	 * @throws \Aimeos\MShop\Customer\Exception If creating items failed
	 */
	public function searchItems( \Aimeos\MW\Criteria\Iface $search, array $ref = [], &$total = null )
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
			while( ( $row = $results->fetch() ) !== false ) {
				$map[ $row['customer.id'] ] = $row;
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname  );
			throw $e;
		}

		$addrItems = [];
		if( in_array( 'customer/address', $ref, true ) ) {
			$addrItems = $this->getAddressItems( array_keys( $map ), 'customer' );
		}

		$propItems = [];
		if( in_array( 'customer/property', $ref, true ) ) {
			$propItems = $this->getPropertyItems( array_keys( $map ), 'customer' );
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
	public function getSubManager( $manager, $name = null )
	{
		return $this->getSubManagerBase( 'customer', $manager, ( $name === null ? 'Typo3' : $name ) );
	}


	/**
	 * Creates a new customer item.
	 *
	 * @param array $values List of attributes for customer item
	 * @param array $listItems List items associated to the customer item
	 * @param array $refItems Items referenced by the customer item via the list items
	 * @param array $addresses List of address items of the customer item
	 * @param array $propItems List of property items of the customer item
	 * @return \Aimeos\MShop\Customer\Item\Iface New customer item
	 */
	protected function createItemBase( array $values = [], array $listItems = [], array $refItems = [],
		array $addresses = [], array $propItems = [] )
	{
		$helper = $this->getPasswordHelper();
		$address = $this->getAddressManager()->createItem();
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

		if( array_key_exists( 'groups', $values ) ) {
			$values['groups'] = explode( ',', $values['groups'] );
		}

		return new \Aimeos\MShop\Customer\Item\Typo3(
			$address, $values, $listItems, $refItems,
			null, $helper, $addresses, $propItems
		);
	}


	/**
	 * Returns the address sub-manager.
	 *
	 * @return \Aimeos\MShop\Common\Manager\Iface Customer address manager
	 */
	protected function getAddressManager()
	{
		if( !isset( $this->addressManager ) ) {
			$this->addressManager = $this->getObject()->getSubManager( 'address' );
		}

		return $this->addressManager;
	}


	/**
	 * Returns a password helper object based on the configuration.
	 *
	 * @return \Aimeos\MShop\Common\Item\Helper\Password\Iface Password helper object
	 * @throws \Aimeos\MShop\Exception If the name is invalid or the class isn't found
	 */
	protected function getPasswordHelper()
	{
		if( $this->helper ) {
			return $this->helper;
		}

		$classname = '\\Aimeos\\MShop\\Common\\Item\\Helper\\Password\\Typo3';

		if( class_exists( $classname ) === false ) {
			throw new \Aimeos\MShop\Exception( sprintf( 'Class "%1$s" not available', $classname ) );
		}

		$context = $this->getContext();
		$object = ( method_exists( $context, 'getHasherTypo3' ) ? $context->getHasherTypo3() : null );

		$helper = new $classname( array( 'object' => $object ) );

		self::checkClass( '\\Aimeos\\MShop\\Common\\Item\\Helper\\Password\\Iface', $helper );

		$this->helper = $helper;

		return $helper;
	}
}
