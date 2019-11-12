<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2019
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Updates the charset and collations
 */
class TablesUpdateCharsetCollationTypo3 extends \Aimeos\MW\Setup\Task\TablesUpdateCharsetCollation
{
	private $tables = [
		'db-customer' => [
			'fe_users' => 'code', 'fe_users_address' => 'email',
			'fe_users_list_type' => 'code', 'fe_users_list' => 'refid',
			'fe_users_property_type' => 'code', 'fe_users_property' => 'value',
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
		$this->msg( 'Update charset and collation for TYPO3 tables', 0 );
		$this->status( '' );

		foreach( $this->tables as $rname => $list ) {
			$this->checkTables( $list, $rname );
		}
	}
}
