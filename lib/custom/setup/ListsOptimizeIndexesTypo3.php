<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Optmizes the unique constraints of list tables and their indexes.
 */
class ListsOptimizeIndexesTypo3 extends \Aimeos\MW\Setup\Task\Base
{
	private $mysql = array(
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
	protected function mysql()
	{
		$this->process( $this->mysql );
	}


	/**
	 * Renames all order tables if they exist.
	 *
	 * @param array $stmts Associative array of tables names and lists of SQL statements to execute.
	 */
	protected function process( array $stmts )
	{
		$this->msg( 'Optimize list indexes in TYPO3 extension', 0 );
		$this->status( '' );

		$this->addConstraints( $stmts['add'] );
		$this->deleteConstraints( $stmts['delete'] );
		$this->dropIndexes( $stmts['indexes'] );
	}


	/**
	 * Adds the new constraints to the tables.
	 *
	 * @param array $stmts Associative list of table names and list of statements
	 */
	protected function addConstraints( array $stmts )
	{
		foreach( $stmts as $table => $stmtList )
		{
			foreach ( $stmtList as $name => $stmt )
			{
				$this->msg( sprintf( 'Adding constraint "%1$s": ', $name ), 1 );

				if( $this->schema->tableExists( $table ) === true
						&& $this->schema->constraintExists( $table, $name ) === false
				) {
					$this->execute( $stmt );
					$this->status( 'done' );
				} else {
					$this->status( 'OK' );
				}
			}
		}
	}


	/**
	 * Deletes existing constraints from the tables.
	 *
	 * @param array $stmts Associative list of table names and list of statements
	 */
	protected function deleteConstraints( array $stmts )
	{
		foreach( $stmts as $table => $stmtList )
		{
			foreach ( $stmtList as $name => $stmt )
			{
				$this->msg( sprintf( 'Deleting constraint "%1$s": ', $name ), 1 );

				if( $this->schema->tableExists( $table ) === true
					&& $this->schema->constraintExists( $table, $name ) === true
				) {
					$this->execute( $stmt );
					$this->status( 'done' );
				} else {
					$this->status( 'OK' );
				}
			}
		}
	}


	/**
	 * Drops existing indexes from the tables.
	 *
	 * @param array $stmts Associative list of table names and list of statements
	 */
	protected function dropIndexes( array $stmts )
	{
		foreach( $stmts as $table => $stmtList )
		{
			foreach ( $stmtList as $name => $stmt )
			{
				$this->msg( sprintf( 'Dropping index "%1$s": ', $name ), 1 );

				if( $this->schema->tableExists( $table ) === true
					&& $this->schema->indexExists( $table, $name ) === true
				) {
					$this->execute( $stmt );
					$this->status( 'done' );
				} else {
					$this->status( 'OK' );
				}
			}
		}
	}
}
