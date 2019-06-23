<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MShop
 * @subpackage Customer
 */


namespace Aimeos\MShop\Customer\Manager\Group;


/**
 * TYPO3 implementation of the customer group class
 *
 * @package MShop
 * @subpackage Customer
 */
class Typo3
	extends \Aimeos\MShop\Customer\Manager\Group\Standard
{
	private $searchConfig = array(
		'customer.group.id' => array(
			'code' => 'customer.group.id',
			'internalcode' => 't3feg."uid"',
			'label' => 'Customer group ID',
			'type' => 'integer',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_INT,
		),
		'customer.group.code' => array(
			'code' => 'customer.group.code',
			'internalcode' => 't3feg."title"',
			'label' => 'Customer group code',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.group.label' => array(
			'code' => 'customer.group.label',
			'internalcode' => 't3feg."title"',
			'label' => 'Customer group label',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.group.ctime'=> array(
			'code' => 'customer.group.ctime',
			'internalcode' => 't3feg."crdate"',
			'label' => 'Customer group creation time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.group.mtime'=> array(
			'code' => 'customer.group.mtime',
			'internalcode' => 't3feg."tstamp"',
			'label' => 'Customer group modification time',
			'type' => 'datetime',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
		'customer.group.editor'=> array(
			'code' => 'customer.group.editor',
			'internalcode' => '1',
			'label' => 'Customer group editor',
			'type' => 'string',
			'internaltype' => \Aimeos\MW\DB\Statement\Base::PARAM_STR,
		),
	);

	private $plugins = [];
	private $reverse = [];
	private $pid;


	/**
	 * Initializes the customer group manager object
	 *
	 * @param \Aimeos\MShop\Context\Iface $context Context object with required objects
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context )
	{
		parent::__construct( $context );

		$plugin = new \Aimeos\MW\Criteria\Plugin\T3Datetime();
		$this->plugins['customer.ctime'] = $this->reverse['crdate'] = $plugin;
		$this->plugins['customer.mtime'] = $this->reverse['tstamp'] = $plugin;

		$this->pid = $context->getConfig()->get( 'mshop/customer/manager/typo3/pid-default', 0 );
		$this->pid = $context->getConfig()->get( 'mshop/customer/manager/group/typo3/pid-default', $this->pid );
	}


	/**
	 * Removes old entries from the database
	 *
	 * @param integer[] $siteids List of IDs for sites whose entries should be deleted
	 */
	public function cleanup( array $siteids )
	{
		$path = 'mshop/customer/manager/group/submanagers';

		foreach( $this->getContext()->getConfig()->get( $path, [] ) as $domain ) {
			$this->getObject()->getSubManager( $domain )->cleanup( $siteids );
		}
	}


	/**
	 * Removes multiple items specified by their IDs
	 *
	 * @param array $ids List of IDs
	 */
	public function deleteItems( array $ids )
	{
		/** mshop/customer/manager/group/typo3/delete/mysql
		 * Deletes the items matched by the given IDs from the database
		 *
		 * @see mshop/customer/manager/group/typo3/delete/ansi
		 */

		/** mshop/customer/manager/group/typo3/delete/ansi
		 * Deletes the items matched by the given IDs from the database
		 *
		 * Removes the records specified by the given IDs from the customer group
		 * database. The records must be from the site that is configured via the
		 * context item.
		 *
		 * The ":cond" placeholder is replaced by the name of the ID column and
		 * the given ID or list of IDs while the site ID is bound to the question
		 * mark.
		 *
		 * The SQL statement should conform to the ANSI standard to be
		 * compatible with most relational database systems. This also
		 * includes using double quotes for table and column names.
		 *
		 * @param string SQL statement for deleting items
		 * @since 2015.08
		 * @category Developer
		 * @see mshop/customer/manager/group/typo3/insert/ansi
		 * @see mshop/customer/manager/group/typo3/update/ansi
		 * @see mshop/customer/manager/group/typo3/newid/ansi
		 * @see mshop/customer/manager/group/typo3/search/ansi
		 * @see mshop/customer/manager/group/typo3/count/ansi
		 */
		$path = 'mshop/customer/manager/group/typo3/delete';

		return $this->deleteItemsBase( $ids, $path, false, 'uid' );
	}


	/**
	 * Returns the attributes that can be used for searching
	 *
	 * @param boolean $withsub Return attributes of sub-managers too if true
	 * @return array List of attribute items implementing \Aimeos\MW\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( $withsub = true )
	{
		$path = 'mshop/customer/manager/group/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, [], $withsub );
	}


	/**
	 * Returns a new manager for customer group extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions
	 */
	public function getSubManager( $manager, $name = null )
	{
		return $this->getSubManagerBase( 'customer/group', $manager, ( $name === null ? 'Typo3' : $name ) );
	}


	/**
	 * Inserts a new or updates an existing customer group item
	 *
	 * @param \Aimeos\MShop\Customer\Item\Group\Iface $item Customer group item
	 * @param boolean $fetch True if the new ID should be returned in the item
	 */
	public function saveItem( \Aimeos\MShop\Common\Item\Iface $item, $fetch = true )
	{
		self::checkClass( \Aimeos\MShop\Customer\Item\Group\Iface::class, $item );

		if( !$item->isModified() ) {
			return $item;
		}

		$context = $this->getContext();

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$id = $item->getId();

			if( $id === null )
			{
				/** mshop/customer/manager/group/typo3/insert/mysql
				 * Inserts a new customer group record into the database table
				 *
				 * @see mshop/customer/manager/group/typo3/insert/ansi
				 */

				/** mshop/customer/manager/group/typo3/insert/ansi
				 * Inserts a new customer group record into the database table
				 *
				 * Items with no ID yet (i.e. the ID is NULL) will be created in
				 * the database and the newly created ID retrieved afterwards
				 * using the "newid" SQL statement.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the customer group item to the statement before
				 * they are sent to the database server. The number of question
				 * marks must be the same as the number of columns listed in the
				 * INSERT statement. The order of the columns must correspond to
				 * the order in the saveItems() method, so the correct values are
				 * bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for inserting records
				 * @since 2015.08
				 * @category Developer
				 * @see mshop/customer/manager/group/typo3/update/ansi
				 * @see mshop/customer/manager/group/typo3/newid/ansi
				 * @see mshop/customer/manager/group/typo3/delete/ansi
				 * @see mshop/customer/manager/group/typo3/search/ansi
				 * @see mshop/customer/manager/group/typo3/count/ansi
				 */
				$path = 'mshop/customer/manager/group/typo3/insert';
			}
			else
			{
				/** mshop/customer/manager/group/typo3/update/mysql
				 * Updates an existing customer group record in the database
				 *
				 * @see mshop/customer/manager/group/typo3/update/ansi
				 */

				/** mshop/customer/manager/group/typo3/update/ansi
				 * Updates an existing customer group record in the database
				 *
				 * Items which already have an ID (i.e. the ID is not NULL) will
				 * be updated in the database.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the customer group item to the statement before
				 * they are sent to the database server. The order of the columns
				 * must correspond to the order in the saveItems() method, so the
				 * correct values are bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for updating records
				 * @since 2015.08
				 * @category Developer
				 * @see mshop/customer/manager/group/typo3/insert/ansi
				 * @see mshop/customer/manager/group/typo3/newid/ansi
				 * @see mshop/customer/manager/group/typo3/delete/ansi
				 * @see mshop/customer/manager/group/typo3/search/ansi
				 * @see mshop/customer/manager/group/typo3/count/ansi
				 */
				$path = 'mshop/customer/manager/group/typo3/update';
			}

			$stmt = $this->getCachedStatement( $conn, $path );

			$stmt->bind( 1, $this->pid, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
			$stmt->bind( 2, $item->getCode() );
			$stmt->bind( 3, $item->getLabel() );
			$stmt->bind( 4, time(), \Aimeos\MW\DB\Statement\Base::PARAM_INT ); // mtime

			if( $id !== null ) {
				$stmt->bind( 5, $id, \Aimeos\MW\DB\Statement\Base::PARAM_INT );
				$item->setId( $id );
			} else {
				$stmt->bind( 5, time() ); // ctime
			}

			$stmt->execute()->finish();

			if( $id === null && $fetch === true )
			{
				/** mshop/customer/manager/group/typo3/newid/mysql
				 * Retrieves the ID generated by the database when inserting a new record
				 *
				 * @see mshop/customer/manager/group/typo3/newid/ansi
				 */

				/** mshop/customer/manager/group/typo3/newid/ansi
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
				 * @since 2015.08
				 * @category Developer
				 * @see mshop/customer/manager/group/typo3/insert/ansi
				 * @see mshop/customer/manager/group/typo3/update/ansi
				 * @see mshop/customer/manager/group/typo3/delete/ansi
				 * @see mshop/customer/manager/group/typo3/search/ansi
				 * @see mshop/customer/manager/group/typo3/count/ansi
				 */
				$path = 'mshop/customer/manager/group/typo3/newid';
				$item->setId( $this->newId( $conn, $path ) );
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		return $item;
	}


	/**
	 * Returns the item objects matched by the given search criteria.
	 *
	 * @param \Aimeos\MW\Criteria\Iface $search Search criteria object
	 * @param array $ref List of domain items that should be fetched too
	 * @param integer &$total Number of items that are available in total
	 * @return array List of items implementing \Aimeos\MShop\Customer\Item\Group\Iface
	 * @throws \Aimeos\MShop\Exception If retrieving items failed
	 */
	public function searchItems( \Aimeos\MW\Criteria\Iface $search, array $ref = [], &$total = null )
	{
		$map = [];
		$context = $this->getContext();

		$dbm = $context->getDatabaseManager();
		$dbname = $this->getResourceName();
		$conn = $dbm->acquire( $dbname );

		try
		{
			$required = array( 'customer.group' );
			$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;

			/** mshop/customer/manager/group/typo3/search
			 * Retrieves the records matched by the given criteria in the database
			 *
			 * Fetches the records matched by the given criteria from the customer
			 * database. The records must be from one of the sites that are
			 * configured via the context item. If the current site is part of
			 * a tree of sites, the SELECT statement can retrieve all records
			 * from the current site and the complete sub-tree of sites.
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
			 * If the records that are retrieved should be ordered by one or more
			 * columns, the generated string of column / sort direction pairs
			 * replaces the ":order" placeholder. In case no ordering is required,
			 * the complete ORDER BY part including the "\/*-orderby*\/...\/*orderby-*\/"
			 * markers is removed to speed up retrieving the records. Columns of
			 * sub-managers can also be used for ordering the result set but then
			 * no index can be used.
			 *
			 * The number of returned records can be limited and can start at any
			 * number between the begining and the end of the result set. For that
			 * the ":size" and ":start" placeholders are replaced by the
			 * corresponding values from the criteria object. The default values
			 * are 0 for the start and 100 for the size value.
			 *
			 * The SQL statement should conform to the ANSI standard to be
			 * compatible with most relational database systems. This also
			 * includes using double quotes for table and column names.
			 *
			 * @param string SQL statement for searching items
			 * @since 2015.08
			 * @category Developer
			 * @see mshop/customer/manager/group/typo3/count
			 */
			$cfgPathSearch = 'mshop/customer/manager/group/typo3/search';

			/** mshop/customer/manager/group/typo3/count
			 * Counts the number of records matched by the given criteria in the database
			 *
			 * Counts all records matched by the given criteria from the customer
			 * database. The records must be from one of the sites that are
			 * configured via the context item. If the current site is part of
			 * a tree of sites, the statement can count all records from the
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
			 * Both, the strings for ":joins" and for ":cond" are the same as for
			 * the "search" SQL statement.
			 *
			 * Contrary to the "search" statement, it doesn't return any records
			 * but instead the number of records that have been found. As counting
			 * thousands of records can be a long running task, the maximum number
			 * of counted records is limited for performance reasons.
			 *
			 * The SQL statement should conform to the ANSI standard to be
			 * compatible with most relational database systems. This also
			 * includes using double quotes for table and column names.
			 *
			 * @param string SQL statement for counting items
			 * @since 2015.08
			 * @category Developer
			 * @see mshop/customer/manager/group/typo3/search
			 */
			$cfgPathCount = 'mshop/customer/manager/group/typo3/count';

			$results = $this->searchItemsBase( $conn, $search, $cfgPathSearch, $cfgPathCount, $required, $total, $level );

			while( ( $row = $results->fetch() ) !== false ) {
				$map[(string) $row['customer.group.id']] = $this->createItemBase( $row );
			}

			$dbm->release( $conn, $dbname );
		}
		catch( \Exception $e )
		{
			$dbm->release( $conn, $dbname );
			throw $e;
		}

		return $map;
	}


	/**
	 * Creates a new customer item.
	 *
	 * @param array $values List of attributes for customer item
	 * @return \Aimeos\MShop\Customer\Item\Iface New customer item
	 */
	protected function createItemBase( array $values = [] )
	{
		$values['customer.group.siteid'] = $this->getContext()->getLocale()->getSiteId();

		if( array_key_exists( 'tstamp', $values ) ) {
			$values['customer.group.mtime'] = $this->reverse['tstamp']->reverse( $values['tstamp'] );
		}

		if( array_key_exists( 'crdate', $values ) ) {
			$values['customer.group.ctime'] = $this->reverse['crdate']->reverse( $values['crdate'] );
		}

		return new \Aimeos\MShop\Customer\Item\Group\Standard( $values );
	}
}
