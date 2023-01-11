<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2021-2023
 */


namespace Aimeos\Upscheme\Task;


/**
 * Migrates country column values in fe_users table.
 */
class FEUsersMigrateCountryTypo3 extends Base
{
	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function before() : array
	{
		return ['Customer'];
	}


	/**
	 * Migrates country column values in fe_users table.
	 */
	public function up()
	{
		$db = $this->db( 'db-customer' );

		if( !$db->hasTable( ['fe_users', 'static_countries'] ) || !$db->hasColumn( 'fe_users', 'static_info_country' ) ) {
			return;
		}

		$this->info( 'Migrating "static_info_country" column in "fe_users" table', 'vv' );

		$db->exec( '
			UPDATE fe_users SET static_info_country = (
				SELECT cn_iso_2 FROM static_countries WHERE cn_iso_3 = static_info_country
			) WHERE LENGTH(static_info_country) = 3
		' );
	}
}