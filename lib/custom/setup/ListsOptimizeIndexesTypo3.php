<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2013
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


/**
 * Optmizes the unique constraints of list tables and their indexes.
 */
class MW_Setup_Task_ListsOptimizeIndexesTypo3 extends MW_Setup_Task_Abstract
{
	private $_mysql = array(
		'add' => array(
			'fe_users_list' => array(
				'unq_t3feuli_sid_dm_rid_tid_pid' => 'ALTER TABLE "fe_users_list" ADD CONSTRAINT "unq_t3feuli_sid_dm_rid_tid_pid" UNIQUE ("siteid", "domain", "refid", "typeid", "parentid")',
			),
		),
		'delete' => array(
			'fe_users_list' => array(
				'unq_t3feuli_sid_pid_dm_rid_tid' => 'ALTER TABLE "fe_users_list" DROP INDEX "unq_t3feuli_sid_pid_dm_rid_tid"',
			),
		),
		'indexes' => array(
			'fe_users_list' => array(
				'idx_t3feuli_sid_rid_dom_tid' => 'ALTER TABLE "fe_users_list" DROP INDEX "idx_t3feuli_sid_rid_dom_tid"',
				'idx_t3feuli_pid_sid_rid' => 'ALTER TABLE "fe_users_list" DROP INDEX "idx_t3feuli_pid_sid_rid"',
			),
		),
	);


	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return array List of task names
	 */
	public function getPreDependencies()
	{
		return array();
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function getPostDependencies()
	{
		return array();
	}


	/**
	 * Executes the task for MySQL databases.
	 */
	protected function _mysql()
	{
		$this->_process( $this->_mysql );
	}


	/**
	 * Renames all order tables if they exist.
	 *
	 * @param array $stmts Associative array of tables names and lists of SQL statements to execute.
	 */
	protected function _process( array $stmts )
	{
		$this->_msg( 'Optimize list indexes in TYPO3 extension', 0 );
		$this->_status( '' );

		$this->_addConstraints( $stmts['add'] );
		$this->_deleteConstraints( $stmts['delete'] );
		$this->_dropIndexes( $stmts['indexes'] );
	}


	/**
	 * Adds the new constraints to the tables.
	 *
	 * @param array $stmts Associative list of table names and list of statements
	 */
	protected function _addConstraints( array $stmts )
	{
		foreach( $stmts as $table => $stmtList )
		{
			foreach ( $stmtList as $name => $stmt )
			{
				$this->_msg( sprintf( 'Adding constraint "%1$s": ', $name ), 1 );

				if( $this->_schema->tableExists( $table ) === true
						&& $this->_schema->constraintExists( $table, $name ) === false
				) {
					$this->_execute( $stmt );
					$this->_status( 'done' );
				} else {
					$this->_status( 'OK' );
				}
			}
		}
	}


	/**
	 * Deletes existing constraints from the tables.
	 *
	 * @param array $stmts Associative list of table names and list of statements
	 */
	protected function _deleteConstraints( array $stmts )
	{
		foreach( $stmts as $table => $stmtList )
		{
			foreach ( $stmtList as $name => $stmt )
			{
				$this->_msg( sprintf( 'Deleting constraint "%1$s": ', $name ), 1 );

				if( $this->_schema->tableExists( $table ) === true
					&& $this->_schema->constraintExists( $table, $name ) === true
				) {
					$this->_execute( $stmt );
					$this->_status( 'done' );
				} else {
					$this->_status( 'OK' );
				}
			}
		}
	}


	/**
	 * Drops existing indexes from the tables.
	 *
	 * @param array $stmts Associative list of table names and list of statements
	 */
	protected function _dropIndexes( array $stmts )
	{
		foreach( $stmts as $table => $stmtList )
		{
			foreach ( $stmtList as $name => $stmt )
			{
				$this->_msg( sprintf( 'Dropping index "%1$s": ', $name ), 1 );

				if( $this->_schema->tableExists( $table ) === true
					&& $this->_schema->indexExists( $table, $name ) === true
				) {
					$this->_execute( $stmt );
					$this->_status( 'done' );
				} else {
					$this->_status( 'OK' );
				}
			}
		}
	}
}
