<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2021
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Creates all required TYPO3 tables.
 */
class TablesAddTypo3TestData extends TablesCreateMShop
{
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
	 * Creates the TYPO3 test tables
	 */
	public function migrate()
	{
		$this->msg( 'Creating TYPO3 test tables', 0, '' );

		$ds = DIRECTORY_SEPARATOR;

		$this->setupSchema( ['db-customer' => 'schema' . $ds . 'customer.php'] );
	}
}
