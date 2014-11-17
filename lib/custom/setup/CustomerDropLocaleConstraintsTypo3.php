<?php

/**
 * @license LGPLv3, http://www.arcavias.com/en/license
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Removes locale constraints from feusers_* tables.
 */
class MW_Setup_Task_CustomerDropLocaleConstraintsTypo3 extends MW_Setup_Task_Abstract
{
	private $_mysql = array(
		'fe_users_list_type' => array(
			'fk_t3feulity_siteid' => 'ALTER TABLE "fe_users_list_type" DROP FOREIGN KEY "fk_t3feulity_siteid"',
		),
		'fe_users_list' => array(
			'fk_t3feuli_siteid' => 'ALTER TABLE "fe_users_list" DROP FOREIGN KEY "fk_t3feuli_siteid"',
		),
		'fe_users_address' => array(
			'fk_t3feuad_siteid' => 'ALTER TABLE "fe_users_address" DROP FOREIGN KEY "fk_t3feuad_siteid"',
			'fk_t3feuad_langid' => 'ALTER TABLE "fe_users_address" DROP FOREIGN KEY "fk_t3feuad_langid"',
		),
	);




	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
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
		return array( 'TablesCreateTypo3' );
	}


	/**
	 * Executes the task for MySQL databases.
	 */
	protected function _mysql()
	{
		$this->_process( $this->_mysql );
	}


	/**
	 * Drops local constraints.
	 *
	 * @param array $stmts List of SQL statements to execute for adding columns
	 */
	protected function _process( array $stmts )
	{
		$this->_msg( 'Removing locale constraints from customer tables', 0 );
		$this->_status( '' );

		$schema = $this->_getSchema( 'db-customer' );

		foreach( $stmts as $table => $list )
		{
			if( $schema->tableExists( $table ) === true )
			{
				foreach( $list as $constraint => $stmt )
				{
					$this->_msg( sprintf( 'Removing "%1$s" from "%2$s"', $constraint, $table ), 1 );

					if( $schema->constraintExists( $table, $constraint ) !== false )
					{
						$this->_execute( $stmt, 'db-customer' );
						$this->_status( 'done' );
					} else {
						$this->_status( 'OK' );
					}
				}
			}
		}
	}
}