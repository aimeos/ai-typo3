<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Adds vaid column to fe_users tables.
 */
class MW_Setup_Task_CustomerAddVatidTypo3 extends MW_Setup_Task_Abstract
{
	private $_mysql = array(
		'fe_users' => 'ALTER TABLE "fe_users" ADD "vatid" VARCHAR(32) AFTER "company"',
		'fe_users_address' => 'ALTER TABLE "fe_users_address" ADD "vatid" VARCHAR(32) AFTER "company"',
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
	 * Add column vatid to fe_users tables.
	 *
	 * @param array $stmts Associative array of tables names and lists of SQL statements to execute.
	 */
	protected function _process( array $stmts )
	{
		$this->_msg( 'Adding "vatid" column to fe_users tables', 0 ); $this->_status( '' );

		foreach( $stmts AS $table => $stmt )
		{
			$this->_msg( sprintf( 'Checking "%1$s" table', $table ), 1 );

			if( $this->_schema->tableExists( $table ) === true
				&& $this->_schema->columnExists( $table, 'vatid' ) === false )
			{
				$this->_execute( $stmt );
				$this->_status( 'added' );
			} else {
				$this->_status( 'OK' );
			}
		}
	}
}