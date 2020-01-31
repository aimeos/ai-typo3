<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019-2020
 */


namespace Aimeos\MW\Setup\Task;


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


	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies() : array
	{
		return ['TablesMigrateSiteid'];
	}


	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
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
		$this->msg( 'Update TYPO3 "siteid" columns', 0, '' );

		$this->process( $this->resources );
	}
}
