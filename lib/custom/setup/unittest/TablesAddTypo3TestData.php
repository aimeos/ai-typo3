<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds default records to tables.
 */
class TablesAddTypo3TestData extends \Aimeos\MW\Setup\Task\Base
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return array List of task names
	 */
	public function getPreDependencies()
	{
		return ['TablesCreateMShop'];
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function getPostDependencies()
	{
		return [];
	}


	/**
	 * Adds fe_user test data.
	 */
	public function migrate()
	{
		$this->msg('Setting up Aimeos TYPO3 test tables', 0);
		$this->status('');

		$filename = __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'mysql.sql';

		$this->msg( sprintf( 'Adding records from "%1$s"', basename( $filename ) ), 1 );

		if( ( $content = file_get_contents( $filename ) ) === false ) {
			throw new \Aimeos\MW\Setup\Exception( sprintf( 'Unable to get content from file "%1$s"', $filename ) );
		}

		$this->execute( $content );
		$this->status( 'done' );
	}
}