<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019-2022
 */


namespace Aimeos\Upscheme\Task;


/**
 * Updates site ID columns
 */
class TablesMigrateSiteidTypo3 extends TablesMigrateSiteid
{
	private $resources = [
		'db-customer' => [
			'fe_users_list_type', 'fe_users_property_type',
			'fe_users_property', 'fe_users_list', 'fe_users_address', 'fe_users',
		],
	];


	public function before() : array
	{
		return ['Customer'];
	}


	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function after() : array
	{
		return ['TablesMigrateSiteid'];
	}


	/**
	 * Executes the task
	 */
	public function up()
	{
		$db = $this->db( 'db-locale' );

		if( !$db->hasTable( 'mshop_locale_site' ) || $db->hasColumn( 'mshop_locale_site', 'siteid' ) ) {
			return;
		}

		$this->info( 'Update fe_users "siteid" columns', 'vv' );

		$this->process( $this->resources );

		$db = $this->db( 'db-customer' );

		if( $db->hasColumn( 'fe_users', 'siteid' ) ) {
			$db->exec( 'UPDATE fe_users SET siteid=\'\' WHERE siteid IS NULL' );
		}
	}
}
