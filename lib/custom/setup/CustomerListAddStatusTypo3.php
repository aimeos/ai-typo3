<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Adds status column to list table.
 */
class MW_Setup_Task_CustomerListAddStatusTypo3 extends MW_Setup_Task_Abstract
{
	private $_mysql = array(
		'fe_users_list' => array (
			'ALTER TABLE "fe_users_list" ADD "status" SMALLINT NOT NULL DEFAULT 0 AFTER "pos"',
			'ALTER TABLE "fe_users_list" DROP INDEX "idx_t3feuli_sid_start_end"',
		)
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
	 * @return string[] List of task names
	 */
	public function getPostDependencies()
	{
		return array('TablesCreateTypo3');
	}


	/**
	 * Executes the task for MySQL databases.
	 */
	protected function _mysql()
	{
		$this->_process( $this->_mysql );
	}


	/**
	 * Add column status to fe_users_list table.
	 *
	 * @param array $stmts Associative array of tables names and lists of SQL statements to execute.
	 */
	protected function _process( array $stmts )
	{
		$this->_msg( 'Adding status column to fe_users_list table', 0 );
		$this->_status( '' );
		$table = 'fe_users_list';

		$this->_msg( sprintf( 'Checking table "%1$s": ', $table ), 1 );

		if( $this->_schema->tableExists( $table ) === true
			&& $this->_schema->columnExists( $table, 'status' ) === false )
		{
			$this->_executeList( $stmts[$table] );
			$this->_status( 'added' );
		}
		else
		{
			$this->_status( 'OK' );
		}
	}
}