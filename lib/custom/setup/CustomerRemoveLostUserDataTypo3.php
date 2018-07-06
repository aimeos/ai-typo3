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
		'address' => 'DELETE FROM "fe_users_address" WHERE NOT EXISTS ( SELECT "uid" FROM "fe_users" AS u WHERE "parentid"=u."uid" )',
		'list' => 'DELETE FROM "fe_users_list" WHERE NOT EXISTS ( SELECT "uid" FROM "fe_users" AS u WHERE "parentid"=u."uid" )',
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
		$this->msg( 'Remove left over TYPO3 fe_users address records', 0 );

		if( $this->schema->tableExists( 'fe_users' ) && $this->schema->tableExists( 'fe_users_address' ) )
		{
			$this->execute( $this->sql['address'] );
			$this->status( 'done' );
		}
		else
		{
			$this->status( 'OK' );
		}


		$this->msg( 'Remove left over TYPO3 fe_users list records', 0 );

		if( $this->schema->tableExists( 'fe_users' ) && $this->schema->tableExists( 'fe_users_list' ) )
		{
			$this->execute( $this->sql['list'] );
			$this->status( 'done' );
		}
		else
		{
			$this->status( 'OK' );
		}
	}
}
