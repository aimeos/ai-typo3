<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds the new type columns
 */
class TypesMigrateColumnsTypo3 extends \Aimeos\MW\Setup\Task\TypesMigrateColumns
{
	private $tables = [
		'db-customer' => ['fe_users_list', 'fe_users_property'],
	];

	private $constraints = [
		'db-customer' => ['fe_users_list' => 'unq_t3feuli_sid_dm_rid_tid_pid', 'fe_users_property' => 'unq_t3feupr_sid_tid_lid_value'],
	];

	private $migrations = [
		'db-customer' => [
			'fe_users_list' => 'UPDATE "fe_users_list" SET "type" = ( SELECT "code" FROM "fe_users_list_type" AS t WHERE t."id" = "typeid" AND t."domain" = "domain" LIMIT 1 ) WHERE "type" = \'\'',
			'fe_users_property' => 'UPDATE "fe_users_property" SET "type" = ( SELECT "code" FROM "fe_users_property_type" AS t WHERE t."id" = "typeid" AND t."domain" = "domain" LIMIT 1 ) WHERE "type" = \'\'',
		],
	];


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function getPostDependencies() : array
	{
		return ['TablesCreateMShop'];
	}


	/**
	 * Executes the task
	 */
	public function migrate()
	{
		$this->msg( sprintf( 'Add new type columns for TYPO3' ), 0 );
		$this->status( '' );

		foreach( $this->tables as $rname => $list ) {
			$this->addColumn( $rname, $list );
		}

		$this->msg( sprintf( 'Drop old unique indexes for TYPO3' ), 0 );
		$this->status( '' );

		foreach( $this->constraints as $rname => $list ) {
			$this->dropIndex( $rname, $list );
		}

		$this->msg( sprintf( 'Migrate typeid to type for TYPO3' ), 0 );
		$this->status( '' );

		foreach( $this->migrations as $rname => $list ) {
			$this->migrateData( $rname, $list );
		}
	}
}
