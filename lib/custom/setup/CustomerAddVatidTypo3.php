<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2021
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds vaid column to fe_users tables.
 */
class CustomerAddVatidTypo3 extends \Aimeos\MW\Setup\Task\Base
{
	private $mysql = array(
		'fe_users' => 'ALTER TABLE "fe_users" ADD "vatid" VARCHAR(32) AFTER "company"',
	);


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function getPostDependencies() : array
	{
		return ['TablesCreateMShop'];
	}


	/**
	 * Executes the task for MySQL databases.
	 */
	public function migrate()
	{
		$this->process( $this->mysql );
	}


	/**
	 * Add column vatid to fe_users tables.
	 *
	 * @param array $stmts Associative array of tables names and lists of SQL statements to execute.
	 */
	protected function process( array $stmts )
	{
		$this->msg( 'Adding "vatid" column to fe_users tables', 0 ); $this->status( '' );

		foreach( $stmts as $table => $stmt )
		{
			$this->msg( sprintf( 'Checking "%1$s" table', $table ), 1 );

			if( $this->schema->tableExists( $table ) === true
				&& $this->schema->columnExists( $table, 'vatid' ) === false )
			{
				$this->execute( $stmt );
				$this->status( 'added' );
			} else {
				$this->status( 'OK' );
			}
		}
	}
}
