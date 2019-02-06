<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Removes address and list records without user entry
 */
class CustomerRemoveLostUserDataTypo3 extends \Aimeos\MW\Setup\Task\Base
{
	private $sql = [
		'fe_users_address' => 'DELETE FROM "fe_users_address" WHERE NOT EXISTS ( SELECT "uid" FROM "fe_users" AS u WHERE "parentid"=u."uid" )',
		'fe_users_list' => 'DELETE FROM "fe_users_list" WHERE NOT EXISTS ( SELECT "uid" FROM "fe_users" AS u WHERE "parentid"=u."uid" )',
		'fe_users_property' => 'DELETE FROM "fe_users_property" WHERE NOT EXISTS ( SELECT "uid" FROM "fe_users" AS u WHERE "parentid"=u."uid" )',
	];


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
		return array( 'TablesCreateMShop' );
	}


	/**
	 * Migrate database schema
	 */
	public function migrate()
	{
		$this->msg( 'Remove left over TYPO3 fe_users references', 0, '' );

		foreach( $this->sql as $table => $stmt )
		{
			$this->msg( sprintf( 'Remove unused %1$s records', $table ), 1 );

			if( $this->schema->tableExists( 'fe_users' ) && $this->schema->tableExists( $table ) )
			{
				$this->execute( $stmt );
				$this->status( 'done' );
			}
			else
			{
				$this->status( 'OK' );
			}
		}
	}
}
