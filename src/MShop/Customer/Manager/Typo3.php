<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2024
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
	private array $plugins = [];
	private int $pid;


	/**
	 * Initializes a new customer manager object using the given context object.
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object with required objects
	 */
	public function __construct( \Aimeos\MShop\ContextIface $context )
	{
		parent::__construct( $context );

		$plugin = new \Aimeos\Base\Criteria\Plugin\T3Datetime();
		$this->plugins['customer.ctime'] = $plugin;
		$this->plugins['customer.mtime'] = $plugin;
		$this->plugins['customer.salutation'] = new \Aimeos\Base\Criteria\Plugin\T3Salutation();
		$this->plugins['customer.status'] = new \Aimeos\Base\Criteria\Plugin\T3Status();
		$this->plugins['customer.birthday'] = new \Aimeos\Base\Criteria\Plugin\T3Date();

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
		 * @see mshop/group/manager/typo3/pid-default
		 */
		$this->pid = (int) $context->config()->get( 'mshop/customer/manager/typo3/pid-default', 0 );
	}


	/**
	 * Counts the number items that are available for the values of the given key.
	 *
	 * @param \Aimeos\Base\Criteria\Iface $search Search criteria
	 * @param array|string $key Search key or list of key to aggregate items for
	 * @param string|null $value Search key for aggregating the value column
	 * @param string|null $type Type of the aggregation, empty string for count or "sum" or "avg" (average)
	 * @return \Aimeos\Map List of the search keys as key and the number of counted items as value
	 */
	public function aggregate( \Aimeos\Base\Criteria\Iface $search, $key, string $value = null, string $type = null ) : \Aimeos\Map
	{
		/** mshop/customer/manager/typo3//aggregate/mysql
		 * Counts the number of records grouped by the values in the key column and matched by the given criteria
		 *
		 * @see mshop/customer/manager/typo3//aggregate/ansi
		 */

		/** mshop/customer/manager/typo3//aggregate/ansi
		 * Counts the number of records grouped by the values in the key column and matched by the given criteria
		 *
		 * Groups all records by the values in the key column and counts their
		 * occurence. The matched records can be limited by the given criteria
		 * from the customer database. The records must be from one of the sites
		 * that are configured via the context item. If the current site is part
		 * of a tree of sites, the statement can count all records from the
		 * current site and the complete sub-tree of sites.
		 *
		 * As the records can normally be limited by criteria from sub-managers,
		 * their tables must be joined in the SQL context. This is done by
		 * using the "internaldeps" property from the definition of the ID
		 * column of the sub-managers. These internal dependencies specify
		 * the JOIN between the tables and the used columns for joining. The
		 * ":joins" placeholder is then replaced by the JOIN strings from
		 * the sub-managers.
		 *
		 * To limit the records matched, conditions can be added to the given
		 * criteria object. It can contain comparisons like column names that
		 * must match specific values which can be combined by AND, OR or NOT
		 * operators. The resulting string of SQL conditions replaces the
		 * ":cond" placeholder before the statement is sent to the database
		 * server.
		 *
		 * This statement doesn't return any records. Instead, it returns pairs
		 * of the different values found in the key column together with the
		 * number of records that have been found for that key values.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for aggregating customer items
		 * @since 2021.04
		 * @category Developer
		 * @see mshop/customer/manager/typo3//insert/ansi
		 * @see mshop/customer/manager/typo3//update/ansi
		 * @see mshop/customer/manager/typo3//newid/ansi
		 * @see mshop/customer/manager/typo3//delete/ansi
		 * @see mshop/customer/manager/typo3//search/ansi
		 * @see mshop/customer/manager/typo3//count/ansi
		 */

		$cfgkey = 'mshop/customer/manager/typo3/aggregate' . $type;
		return $this->aggregateBase( $search, $key, $cfgkey, ['customer'], $value );
	}


	/**
	 * Removes old entries from the storage.
	 *
	 * @param iterable $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Common\Manager\Iface Same object for fluent interface
	 */
	public function clear( iterable $siteids ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/customer/manager/submanagers';

		foreach( $this->context()->config()->get( $path, [] ) as $domain ) {
			$this->object()->getSubManager( $domain )->clear( $siteids );
		}

		return $this->clearBase( $siteids, 'mshop/customer/manager/typo3/clear' );
	}


	/**
	 * Creates a new empty item instance
	 *
	 * @param array $values Values the item should be initialized with
	 * @return \Aimeos\MShop\Customer\Item\Iface New customer item object
	 */
	public function create( array $values = [] ) : \Aimeos\MShop\Common\Item\Iface
	{
		return parent::create( $this->transform( $values ) );
	}


	/**
	 * Removes multiple items.
	 *
	 * @param \Aimeos\MShop\Common\Item\Iface[]|string[] $items List of item objects or IDs of the items
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager object for chaining method calls
	 */
	public function delete( $items ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/customer/manager/typo3/delete';
		return $this->deleteItemsBase( $items, $path, true, 'uid' )->deleteRefItems( $items );
	}


	/**
	 * Returns the list attributes that can be used for searching.
	 *
	 * @param bool $withsub Return also attributes of sub-managers if true
	 * @return array List of attribute items implementing \Aimeos\Base\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;
		$level = $this->context()->config()->get( 'mshop/customer/manager/sitemode', $level );

		return array_replace( parent::getSearchAttributes( $withsub ), $this->createAttributes( [
			'customer.id' => [
				'label' => 'ID',
				'internalcode' => 'uid',
				'type' => 'int',
				'public' => false,
			],
			'customer.code' => [
				'label' => 'Username',
				'internalcode' => 'username',
			],
			'customer.label' => [
				'label' => 'Label',
				'internalcode' => 'name',
			],
			'customer.salutation' => [
				'label' => 'Salutation',
				'internalcode' => 'gender',
			],
			'customer.firstname' => [
				'label' => 'Firstname',
				'internalcode' => 'first_name',
			],
			'customer.lastname' => [
				'label' => 'Lastname',
				'internalcode' => 'last_name',
			],
			'customer.address1' => [
				'label' => 'Address part one',
				'internalcode' => 'address',
			],
			'customer.address2' => [
				'label' => 'Address part two',
				'internalcode' => 'address',
			],
			'customer.address3' => [
				'label' => 'Address part three',
				'internalcode' => 'address',
			],
			'customer.postal' => [
				'label' => 'Postal',
				'internalcode' => 'zip',
			],
			'customer.state' => [
				'label' => 'State',
				'internalcode' => 'zone',
			],
			'customer.languageid' => [
				'label' => 'Language',
				'internalcode' => 'language',
			],
			'customer.countryid' => [
				'label' => 'Country',
				'internalcode' => 'static_info_country',
			],
			'customer.telefax' => [
				'label' => 'Facsimile',
				'internalcode' => 'fax',
			],
			'customer.website' => [
				'label' => 'Web site',
				'internalcode' => 'www',
			],
			'customer.birthday' => [
				'label' => 'Birthday',
				'internalcode' => 'date_of_birth',
			],
			'customer.status' => [
				'label' => 'Status',
				'internalcode' => 'disable',
				'type' => 'int',
			],
			'customer.ctime' => [
				'label' => 'Create date/time',
				'internalcode' => 'crdate',
				'type' => 'datetime',
				'public' => false,
			],
			'customer.mtime' => [
				'label' => 'Modify date/time',
				'internalcode' => 'tstamp',
				'type' => 'datetime',
				'public' => false,
			],
			'customer:has' => [
				'code' => 'customer:has()',
				'internalcode' => ':site AND :key AND mcusli."id"',
				'internaldeps' => ['LEFT JOIN "fe_users_list" AS mcusli ON ( mcusli."parentid" = mcus."uid" )'],
				'label' => 'Customer has list item, parameter(<domain>[,<list type>[,<reference ID>)]]',
				'type' => 'null',
				'public' => false,
				'function' => function( &$source, array $params ) use ( $level ) {
					$keys = [];

					foreach( (array) ( $params[1] ?? '' ) as $type ) {
						foreach( (array) ( $params[2] ?? '' ) as $id ) {
							$keys[] = $params[0] . '|' . ( $type ? $type . '|' : '' ) . $id;
						}
					}

					$sitestr = $this->siteString( 'mcusli."siteid"', $level );
					$keystr = $this->toExpression( 'mcusli."key"', $keys, ( $params[2] ?? null ) ? '==' : '=~' );
					$source = str_replace( [':site', ':key'], [$sitestr, $keystr], $source );

					return $params;
				}
			],
			'customer:prop' => [
				'code' => 'customer:prop()',
				'internalcode' => ':site AND :key AND mcuspr."id"',
				'internaldeps' => ['LEFT JOIN "fe_users_property" AS mcuspr ON ( mcuspr."parentid" = mcus."uid" )'],
				'label' => 'Customer has property item, parameter(<property type>[,<language code>[,<property value>]])',
				'type' => 'null',
				'public' => false,
				'function' => function( &$source, array $params ) use ( $level ) {
					$keys = [];
					$langs = array_key_exists( 1, $params ) ? ( $params[1] ?? 'null' ) : '';

					foreach( (array) $langs as $lang ) {
						foreach( (array) ( $params[2] ?? '' ) as $val ) {
							$keys[] = substr( $params[0] . '|' . ( $lang === null ? 'null|' : ( $lang ? $lang . '|' : '' ) ) . $val, 0, 255 );
						}
					}

					$sitestr = $this->siteString( 'mcuspr."siteid"', $level );
					$keystr = $this->toExpression( 'mcuspr."key"', $keys, ( $params[2] ?? null ) ? '==' : '=~' );
					$source = str_replace( [':site', ':key'], [$sitestr, $keystr], $source );

					return $params;
				}
			],
			// TYPO3 specific
			'customer.groups' => [
				'label' => 'Customer groups',
				'internalcode' => 'mcus."usergroup"',
				'type' => 'string',
			]
		] ) );
	}


	/**
	 * Saves a customer item object.
	 *
	 * @param \Aimeos\MShop\Customer\Item\Iface $item Customer item object
	 * @param bool $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Customer\Item\Iface $item Updated item including the generated ID
	 */
	protected function saveItem( \Aimeos\MShop\Customer\Item\Iface $item, bool $fetch = true ) : \Aimeos\MShop\Customer\Item\Iface
	{
		if( !$item->isModified() ) {
			return $this->object()->saveRefs( $item, $fetch );
		}

		$context = $this->context();
		$conn = $context->db( $this->getResourceName() );
		$time = date_create_from_format( 'Y-m-d H:i:s', $context->datetime() )->getTimestamp();

		$id = $item->getId();
		$billingAddress = $item->getPaymentAddress();
		$columns = $this->object()->getSaveAttributes();

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
			 * order in the save() method, so the correct values are
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
			 * correspond to the order in the save() method, so the
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

		$address = join( ' ', array_filter( [
			$billingAddress->getAddress1(),
			$billingAddress->getAddress2(),
			$billingAddress->getAddress3(),
		] ) );

		$idx = 1;
		$stmt = $this->getCachedStatement( $conn, $path, $sql );

		foreach( $columns as $name => $entry ) {
			$stmt->bind( $idx++, $item->get( $name ), \Aimeos\Base\Criteria\SQL::type( $entry->getType() ) );
		}

		// TYPO3 fe_users.static_info_country is a three letter ISO code instead a two letter one
		$stmt->bind( $idx++, $item->getLabel() );
		$stmt->bind( $idx++, $item->getCode() );
		$stmt->bind( $idx++, $this->plugins['customer.salutation']->translate( $billingAddress->getSalutation() ), \Aimeos\Base\DB\Statement\Base::PARAM_INT );
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
		$stmt->bind( $idx++, $billingAddress->getMobile() );
		$stmt->bind( $idx++, $billingAddress->getEmail() );
		$stmt->bind( $idx++, $billingAddress->getTelefax() );
		$stmt->bind( $idx++, $billingAddress->getWebsite() );
		$stmt->bind( $idx++, $billingAddress->getLongitude(), \Aimeos\Base\DB\Statement\Base::PARAM_FLOAT );
		$stmt->bind( $idx++, $billingAddress->getLatitude(), \Aimeos\Base\DB\Statement\Base::PARAM_FLOAT );
		$stmt->bind( $idx++, $this->plugins['customer.birthday']->translate( $billingAddress->getBirthday() ), \Aimeos\Base\DB\Statement\Base::PARAM_INT );
		$stmt->bind( $idx++, $this->plugins['customer.status']->translate( $item->getStatus() ), \Aimeos\Base\DB\Statement\Base::PARAM_INT );
		$stmt->bind( $idx++, $item->getPassword() );
		$stmt->bind( $idx++, $time, \Aimeos\Base\DB\Statement\Base::PARAM_INT ); // Modification time
		$stmt->bind( $idx++, $billingAddress->getCountryId() );
		$stmt->bind( $idx++, implode( ',', $item->getGroups() ) );
		$stmt->bind( $idx++, $this->pid, \Aimeos\Base\DB\Statement\Base::PARAM_INT ); // TYPO3 PID value
		$stmt->bind( $idx++, $context->editor() );

		if( $id !== null ) {
			$stmt->bind( $idx++, $context->locale()->getSiteId() . '%' );
			$stmt->bind( $idx++, $this->getUser()?->getSiteId() );
			$stmt->bind( $idx, $id, \Aimeos\Base\DB\Statement\Base::PARAM_INT );
			$item->setId( $id );
		} else {
			$stmt->bind( $idx++, $this->siteId( $item->getSiteId(), \Aimeos\MShop\Locale\Manager\Base::SITE_SUBTREE ) );
			$stmt->bind( $idx, $time, \Aimeos\Base\DB\Statement\Base::PARAM_INT ); // Creation time
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
			$id = $this->newId( $conn, $path );
		}

		return $this->object()->saveRefs( $item->setId( $id ), $fetch );
	}


	/**
	 * Returns the full configuration key for the passed last part
	 *
	 * @param string $name Configuration last part
	 * @return string Full configuration key
	 */
	protected function getConfigKey( string $name, string $default = '' ) : string
	{
		if( $this->context()->config()->get( 'mshop/customer/manager/typo3/' . $name ) ) {
			return 'mshop/customer/manager/typo3/' . $name;
		}

		return parent::getConfigKey( $name, $default );
	}


	/**
	 * Returns a new manager for customer extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions, e.g stock, tags, locations, etc.
	 */
	public function getSubManager( string $manager, string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return $this->getSubManagerBase( 'customer', $manager, ( $name === null ? 'Typo3' : $name ) );
	}


	/**
	 * Returns the name of the used table
	 *
	 * @return string Table name
	 */
	protected function table() : string
	{
		return 'fe_users';
	}


	/**
	 * Returns the search plugins for transforming the search criteria
	 *
	 * @return \Aimeos\MW\Criteria\Plugin\Iface[] List of search plugins
	 */
	protected function searchPlugins() : array
	{
		return $this->plugins;
	}


	/**
	 * Returns a password helper object based on the configuration.
	 *
	 * @return \Aimeos\MShop\Common\Helper\Password\Iface Password helper object
	 * @throws \Aimeos\MShop\Exception If the name is invalid or the class isn't found
	 * @deprecated 2025.01 Use \Aimeos\Base\Password\Iface instead
	 */
	protected function getPasswordHelper() : \Aimeos\MShop\Common\Helper\Password\Iface
	{
		return new \Aimeos\MShop\Common\Helper\Password\Typo3( ['object' => $this->context()->password()] );
	}


	/**
	 * Transforms the application specific values to Aimeos standard values.
	 *
	 * @param array $values Associative list of key/value pairs from the storage
	 * @return array Associative list of key/value pairs with standard Aimeos values
	 */
	protected function transform( array $values ) : array
	{
		if( array_key_exists( 'customer.birthday', $values ) ) {
			$values['customer.birthday'] = $this->plugins['customer.birthday']->reverse( $values['customer.birthday'] );
		}

		if( array_key_exists( 'customer.salutation', $values ) ) {
			$values['customer.salutation'] = $this->plugins['customer.salutation']->reverse( $values['customer.salutation'] );
		}

		if( array_key_exists( 'customer.status', $values ) ) {
			$values['customer.status'] = $this->plugins['customer.status']->reverse( $values['customer.status'] );
		}

		if( array_key_exists( 'customer.mtime', $values ) ) {
			$values['customer.mtime'] = $this->plugins['customer.mtime']->reverse( $values['customer.mtime'] );
		}

		if( array_key_exists( 'customer.ctime', $values ) ) {
			$values['customer.ctime'] = $this->plugins['customer.ctime']->reverse( $values['customer.ctime'] );
		}

		if( array_key_exists( 'customer.groups', $values ) && $values['customer.groups'] !== '' ) {
			$values['customer.groups'] = explode( ',', $values['customer.groups'] );
		}

		return $values;
	}
}
