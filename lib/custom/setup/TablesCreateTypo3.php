<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Creates all required tables.
 */
class MW_Setup_Task_TablesCreateTypo3 extends MW_Setup_Task_TablesCreateMShop
{
	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function getPostDependencies()
	{
		return array( 'MShopAddTypeData' );
	}
	
	
	/**
	 * Executes the task for MySQL databases.
	 */
	protected function _mysql()
	{
		$this->_msg( 'Creating Arcavias TYPO3 tables', 0 );
		$this->_status( '' );

		$ds = DIRECTORY_SEPARATOR;

		$files = array(
			'db-customer' => __DIR__ . $ds . 'default' . $ds . 'schema' . $ds . 'mysql' . $ds . 'customer.sql',
		);

		$this->_setup( $files );
	}
}
