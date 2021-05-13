<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2021
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds siteid column to fe_users table.
 */
class FEUsersMigrateCountryTypo3 extends \Aimeos\MW\Setup\Task\Base
{
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
	 * Add column siteid to fe_users table.
	 *
	 */
	public function migrate()
	{
		$this->msg( sprintf( 'Migrating "%1$s" column in "%2$s" table', 'static_info_country', 'fe_users' ), 0 );

		$schema = $this->getSchema( 'db-customer' );

		if( $schema->tableExists( 'fe_users' ) === true && $schema->tableExists( 'static_countries' ) === true
			&& $schema->columnExists( 'fe_users', 'static_info_country' ) === true )
		{
			$stmt = 'UPDATE fe_users SET static_info_country = (
				SELECT cn_iso_2 FROM static_countries WHERE cn_iso_3 = static_info_country
			) WHERE LENGTH(static_info_country) = 3';

			$this->execute( $stmt, 'db-customer' );
			$this->status( 'done' );
		}
		else
		{
			$this->status( 'OK' );
		}
	}
}
