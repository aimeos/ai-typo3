<?php

/**
 * @license LGPLv3, http://www.aimeos.com/en/license
 * @copyright Aimeos (aimeos.org), 2014-2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Removes locale constraints from feusers_* tables.
 */
class CustomerDropLocaleConstraintsTypo3 extends \Aimeos\MW\Setup\Task\Base
{
	private $mysql = array(
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
		return [];
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
	public function migrate()
	{
		$this->process( $this->mysql );
	}


	/**
	 * Drops local constraints.
	 *
	 * @param array $stmts List of SQL statements to execute for adding columns
	 */
	protected function process( array $stmts )
	{
		$this->msg( 'Removing locale constraints from customer tables', 0 );
		$this->status( '' );

		$schema = $this->getSchema( 'db-customer' );

		foreach( $stmts as $table => $list )
		{
			if( $schema->tableExists( $table ) === true )
			{
				foreach( $list as $constraint => $stmt )
				{
					$this->msg( sprintf( 'Removing "%1$s" from "%2$s"', $constraint, $table ), 1 );

					if( $schema->constraintExists( $table, $constraint ) !== false )
					{
						$this->execute( $stmt, 'db-customer' );
						$this->status( 'done' );
					} else {
						$this->status( 'OK' );
					}
				}
			}
		}
	}
}