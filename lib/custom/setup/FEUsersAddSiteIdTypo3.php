<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds siteid column to fe_users table.
 */
class FEUsersAddSiteIdTypo3 extends \Aimeos\MW\Setup\Task\Base
{
	private $migrate = array(
		'mysql' => array (
			'ALTER TABLE "fe_users" ADD "siteid" INTEGER NULL'
		),
	);


	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return array List of task names
	 */
	public function getPreDependencies()
	{
		return [];
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
	 * Add column siteid to fe_users table.
	 *
	 * @param array $stmts Associative array of tables names and lists of SQL statements to execute.
	 */
	public function migrate()
	{
		$table = 'fe_users';
		$column = 'siteid';

		$this->msg( sprintf( 'Adding "%1$s" column to "%2$s" table', $column, $table ), 0 );

		$schema = $this->getSchema( 'db-customer' );

		if( isset( $this->migrate[$schema->getName()] )
			&& $schema->tableExists( $table ) === true
			&& $schema->columnExists( $table, $column ) === false )
		{
			foreach ( $this->migrate[$schema->getName()] as $stmt )
			{
				$this->execute( $stmt );
			}
			$this->status( 'done' );
		}
		else
		{
			$this->status( 'OK' );
		}
	}
}
