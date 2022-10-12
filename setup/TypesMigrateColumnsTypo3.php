<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018-2022
 */


namespace Aimeos\Upscheme\Task;


/**
 * Adds the new type columns
 */
class TypesMigrateColumnsTypo3 extends TypesMigrateColumns
{
	private $tables = [
		'db-customer' => ['fe_users_list', 'fe_users_property'],
	];

	private $constraints = [
		'db-customer' => ['fe_users_list' => 'unq_mcusli_sid_dm_rid_tid_pid', 'fe_users_property' => 'unq_mcuspr_sid_tid_lid_value'],
	];

	private $migrations = [
		'db-customer' => [
			'fe_users_list' => 'UPDATE "fe_users_list" SET "type" = ( SELECT "code" FROM "fe_users_list_type" AS t WHERE t."id" = "typeid" AND t."domain" = "domain" ) WHERE "type" = \'\'',
			'fe_users_property' => 'UPDATE "fe_users_property" SET "type" = ( SELECT "code" FROM "fe_users_property_type" AS t WHERE t."id" = "typeid" AND t."domain" = "domain" ) WHERE "type" = \'\'',
		],
	];


	/**
	 * Executes the task
	 */
	public function up()
	{
		$db = $this->db( 'db-customer' );

		if( !$db->hasTable( 'fe_users' ) ) {
			return;
		}

		$this->info( 'Migrate typeid to type for Laravel', 'vv' );
		$this->info( 'Add new type columns for Laravel', 'vv' );

		foreach( $this->tables as $rname => $list ) {
			$this->addColumn( $rname, $list );
		}

		$this->info( 'Drop old unique indexes for Laravel', 'vv' );

		foreach( $this->constraints as $rname => $list ) {
			$this->dropIndex( $rname, $list );
		}

		$this->info( 'Migrate typeid to type for Laravel', 'vv' );

		foreach( $this->migrations as $rname => $list ) {
			$this->migrateData( $rname, $list );
		}
	}
}