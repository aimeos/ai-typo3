<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Renames the "refid" column to "parentid"
 */
class CustomerChangeAddressRefidParentidTypo3 extends \Aimeos\MW\Setup\Task\Base
{
	private $mysql = array(
		'refid' => array(
			'ALTER TABLE "fe_users_address" CHANGE "refid" "parentid" INTEGER NOT NULL',
			'ALTER TABLE "fe_users_address" DROP INDEX "idx_mcusad_refid", ADD INDEX "idx_mcusad_pid" ("parentid")',
		),
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
		$table = 'fe_users_address';
		$this->msg( sprintf( 'Rename "refid" to "parentid" in table "%1$s"', $table ), 0 ); $this->status( '' );

		foreach( $this->mysql as $column => $stmts )
		{
			$this->msg( sprintf( 'Checking column "%1$s"', $column ), 1 );

			if( $this->schema->tableExists( $table )
				&& $this->schema->columnExists( $table, $column ) === true
			) {
				$this->executeList( $stmts );
				$this->status( 'done' );
			} else {
				$this->status( 'OK' );
			}
		}
	}
}
