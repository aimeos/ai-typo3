<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2024
 * @package MShop
 * @subpackage Group
 */


namespace Aimeos\MShop\Group\Manager;


/**
 * TYPO3 implementation of the group class
 *
 * @package MShop
 * @subpackage Group
 */
class Typo3
	extends \Aimeos\MShop\Group\Manager\Standard
{
	private array $searchConfig = array(
		'group.id' => array(
			'code' => 'group.id',
			'internalcode' => 'mgro."uid"',
			'label' => 'Group ID',
			'type' => 'int',
		),
		'group.code' => array(
			'code' => 'group.code',
			'internalcode' => 'mgro."title"',
			'label' => 'Group code',
			'type' => 'string',
		),
		'group.label' => array(
			'code' => 'group.label',
			'internalcode' => 'mgro."description"',
			'label' => 'Group label',
			'type' => 'string',
		),
		'group.ctime'=> array(
			'code' => 'group.ctime',
			'internalcode' => 'mgro."crdate"',
			'label' => 'Group creation time',
			'type' => 'datetime',
		),
		'group.mtime'=> array(
			'code' => 'group.mtime',
			'internalcode' => 'mgro."tstamp"',
			'label' => 'Group modification time',
			'type' => 'datetime',
		),
		'group.editor'=> array(
			'code' => 'group.editor',
			'internalcode' => '',
			'label' => 'Group editor',
			'type' => 'string',
		),
	);

	private array $plugins = [];
	private array $reverse = [];
	private int $pid;


	/**
	 * Initializes the group manager object
	 *
	 * @param \Aimeos\MShop\ContextIface $context Context object with required objects
	 */
	public function __construct( \Aimeos\MShop\ContextIface $context )
	{
		parent::__construct( $context );

		$plugin = new \Aimeos\Base\Criteria\Plugin\T3Datetime();
		$this->plugins['ctime'] = $this->reverse['crdate'] = $plugin;
		$this->plugins['mtime'] = $this->reverse['tstamp'] = $plugin;

		/** mshop/manager/typo3/pid-default
		 * Page ID the group records are assigned to
		 *
		 * In TYPO3, you can assign fe_group records to different sysfolders based
		 * on their page ID. These sysfolders can be use for user authorization and
		 * therefore, you need to assign the correct page ID to groups
		 * created or modified by the Aimeos admin backend.
		 *
		 * @param int TYPO3 page ID
		 * @since 2018.10
		 * @see mshop/customer/manager/typo3/pid-default
		 */
		$this->pid = (int) $context->config()->get( 'mshop/customer/manager/typo3/pid-default', 0 );
		$this->pid = (int) $context->config()->get( 'mshop/group/manager/typo3/pid-default', $this->pid );
	}


	/**
	 * Removes old entries from the database
	 *
	 * @param integer[] $siteids List of IDs for sites whose entries should be deleted
	 * @return \Aimeos\MShop\Common\Manager\Iface Same object for fluent interface
	 */
	public function clear( iterable $siteids ) : \Aimeos\MShop\Common\Manager\Iface
	{
		$path = 'mshop/group/manager/submanagers';

		foreach( $this->context()->config()->get( $path, [] ) as $domain ) {
			$this->object()->getSubManager( $domain )->clear( $siteids );
		}

		return $this;
	}


	/**
	 * Removes multiple items.
	 *
	 * @param \Aimeos\MShop\Common\Item\Iface[]|string[] $itemIds List of item objects or IDs of the items
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager object for chaining method calls
	 */
	public function delete( $itemIds ) : \Aimeos\MShop\Common\Manager\Iface
	{
		/** mshop/group/manager/typo3/delete/mysql
		 * Deletes the items matched by the given IDs from the database
		 *
		 * @see mshop/group/manager/typo3/delete/ansi
		 */

		/** mshop/group/manager/typo3/delete/ansi
		 * Deletes the items matched by the given IDs from the database
		 *
		 * Removes the records specified by the given IDs from the group
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
		 * @see mshop/group/manager/typo3/insert/ansi
		 * @see mshop/group/manager/typo3/update/ansi
		 * @see mshop/group/manager/typo3/newid/ansi
		 * @see mshop/group/manager/typo3/search/ansi
		 * @see mshop/group/manager/typo3/count/ansi
		 */
		$path = 'mshop/group/manager/typo3/delete';

		return $this->deleteItemsBase( $itemIds, $path, false, 'uid' );
	}


	/**
	 * Returns the attributes that can be used for searching
	 *
	 * @param bool $withsub Return attributes of sub-managers too if true
	 * @return array List of attribute items implementing \Aimeos\Base\Criteria\Attribute\Iface
	 */
	public function getSearchAttributes( bool $withsub = true ) : array
	{
		$path = 'mshop/group/manager/submanagers';

		return $this->getSearchAttributesBase( $this->searchConfig, $path, [], $withsub );
	}


	/**
	 * Returns a new manager for group extensions
	 *
	 * @param string $manager Name of the sub manager type in lower case
	 * @param string|null $name Name of the implementation, will be from configuration (or Default) if null
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager for different extensions
	 */
	public function getSubManager( string $manager, string $name = null ) : \Aimeos\MShop\Common\Manager\Iface
	{
		return $this->getSubManagerBase( 'group/group', $manager, ( $name === null ? 'Typo3' : $name ) );
	}


	/**
	 * Inserts a new or updates an existing group item
	 *
	 * @param \Aimeos\MShop\Group\Item\Iface $item Group item
	 * @param boolean $fetch True if the new ID should be returned in the item
	 * @return \Aimeos\MShop\Group\Item\Iface $item Updated item including the generated ID
	 */
	protected function saveItem( \Aimeos\MShop\Group\Item\Iface $item, bool $fetch = true ) : \Aimeos\MShop\Group\Item\Iface
	{
		if( !$item->isModified() ) {
			return $item;
		}

		$context = $this->context();
		$conn = $context->db( $this->getResourceName() );

			$id = $item->getId();
			$columns = $this->object()->getSaveAttributes();

			if( $id === null )
			{
				/** mshop/group/manager/typo3/insert/mysql
				 * Inserts a new group record into the database table
				 *
				 * @see mshop/group/manager/typo3/insert/ansi
				 */

				/** mshop/group/manager/typo3/insert/ansi
				 * Inserts a new group record into the database table
				 *
				 * Items with no ID yet (i.e. the ID is NULL) will be created in
				 * the database and the newly created ID retrieved afterwards
				 * using the "newid" SQL statement.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the group item to the statement before
				 * they are sent to the database server. The number of question
				 * marks must be the same as the number of columns listed in the
				 * INSERT statement. The order of the columns must correspond to
				 * the order in the save() method, so the correct values are
				 * bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for inserting records
				 * @since 2015.08
				 * @category Developer
				 * @see mshop/group/manager/typo3/update/ansi
				 * @see mshop/group/manager/typo3/newid/ansi
				 * @see mshop/group/manager/typo3/delete/ansi
				 * @see mshop/group/manager/typo3/search/ansi
				 * @see mshop/group/manager/typo3/count/ansi
				 */
				$path = 'mshop/group/manager/typo3/insert';
				$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ) );
			}
			else
			{
				/** mshop/group/manager/typo3/update/mysql
				 * Updates an existing group record in the database
				 *
				 * @see mshop/group/manager/typo3/update/ansi
				 */

				/** mshop/group/manager/typo3/update/ansi
				 * Updates an existing group record in the database
				 *
				 * Items which already have an ID (i.e. the ID is not NULL) will
				 * be updated in the database.
				 *
				 * The SQL statement must be a string suitable for being used as
				 * prepared statement. It must include question marks for binding
				 * the values from the group item to the statement before
				 * they are sent to the database server. The order of the columns
				 * must correspond to the order in the save() method, so the
				 * correct values are bound to the columns.
				 *
				 * The SQL statement should conform to the ANSI standard to be
				 * compatible with most relational database systems. This also
				 * includes using double quotes for table and column names.
				 *
				 * @param string SQL statement for updating records
				 * @since 2015.08
				 * @category Developer
				 * @see mshop/group/manager/typo3/insert/ansi
				 * @see mshop/group/manager/typo3/newid/ansi
				 * @see mshop/group/manager/typo3/delete/ansi
				 * @see mshop/group/manager/typo3/search/ansi
				 * @see mshop/group/manager/typo3/count/ansi
				 */
				$path = 'mshop/group/manager/typo3/update';
				$sql = $this->addSqlColumns( array_keys( $columns ), $this->getSqlConfig( $path ), false );
			}

			$idx = 1;
			$stmt = $this->getCachedStatement( $conn, $path, $sql );

			foreach( $columns as $name => $entry ) {
				$stmt->bind( $idx++, $item->get( $name ), \Aimeos\Base\Criteria\SQL::type( $entry->getType() ) );
			}

			$stmt->bind( $idx++, $this->pid, \Aimeos\Base\DB\Statement\Base::PARAM_INT );
			$stmt->bind( $idx++, $item->getCode() );
			$stmt->bind( $idx++, $item->getLabel() );
			$stmt->bind( $idx++, time(), \Aimeos\Base\DB\Statement\Base::PARAM_INT ); // mtime

			if( $id !== null ) {
				$stmt->bind( $idx++, $id, \Aimeos\Base\DB\Statement\Base::PARAM_INT );
				$item->setId( $id );
			} else {
				$stmt->bind( $idx++, time(), \Aimeos\Base\DB\Statement\Base::PARAM_INT ); // ctime
			}

			$stmt->execute()->finish();

			if( $id === null && $fetch === true )
			{
				/** mshop/group/manager/typo3/newid/mysql
				 * Retrieves the ID generated by the database when inserting a new record
				 *
				 * @see mshop/group/manager/typo3/newid/ansi
				 */

				/** mshop/group/manager/typo3/newid/ansi
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
				 * @see mshop/group/manager/typo3/insert/ansi
				 * @see mshop/group/manager/typo3/update/ansi
				 * @see mshop/group/manager/typo3/delete/ansi
				 * @see mshop/group/manager/typo3/search/ansi
				 * @see mshop/group/manager/typo3/count/ansi
				 */
				$path = 'mshop/group/manager/typo3/newid';
				$item->setId( $this->newId( $conn, $path ) );
			}

		return $item;
	}


	/**
	 * Returns the item objects matched by the given search criteria.
	 *
	 * @param \Aimeos\Base\Criteria\Iface $search Search criteria object
	 * @param array $ref List of domain items that should be fetched too
	 * @param int|null &$total Number of items that are available in total
	 * @return \Aimeos\Map List of items implementing \Aimeos\MShop\Group\Item\Iface
	 * @throws \Aimeos\MShop\Exception If retrieving items failed
	 */
	public function search( \Aimeos\Base\Criteria\Iface $search, array $ref = [], int &$total = null ) : \Aimeos\Map
	{
		$map = [];
		$context = $this->context();
		$conn = $context->db( $this->getResourceName() );

			$required = array( 'group' );
			$level = \Aimeos\MShop\Locale\Manager\Base::SITE_ALL;

			/** mshop/group/manager/typo3/search
			 * Retrieves the records matched by the given criteria in the database
			 *
			 * Fetches the records matched by the given criteria from the group
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
			 * @see mshop/group/manager/typo3/count
			 */
			$cfgPathSearch = 'mshop/group/manager/typo3/search';

			/** mshop/group/manager/typo3/count
			 * Counts the number of records matched by the given criteria in the database
			 *
			 * Counts all records matched by the given criteria from the group
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
			 * @see mshop/group/manager/typo3/search
			 */
			$cfgPathCount = 'mshop/group/manager/typo3/count';

			$results = $this->searchItemsBase( $conn, $search, $cfgPathSearch, $cfgPathCount, $required, $total, $level );

			while( ( $row = $results->fetch() ) !== null ) {
				$map[(string) $row['group.id']] = $this->createItemBase( $row );
			}

		return map( $map );
	}


	/**
	 * Creates a new group item.
	 *
	 * @param array $values List of attributes for group item
	 * @return \Aimeos\MShop\Group\Item\Iface New group item
	 */
	protected function createItemBase( array $values = [] ) : \Aimeos\MShop\Group\Item\Iface
	{
		$values['group.siteid'] = $this->context()->locale()->getSiteId();

		if( array_key_exists( 'group.mtime', $values ) ) {
			$values['group.mtime'] = $this->reverse['tstamp']->reverse( $values['group.mtime'] );
		}

		if( array_key_exists( 'group.ctime', $values ) ) {
			$values['group.ctime'] = $this->reverse['crdate']->reverse( $values['group.ctime'] );
		}

		return new \Aimeos\MShop\Group\Item\Standard( $values );
	}
}
