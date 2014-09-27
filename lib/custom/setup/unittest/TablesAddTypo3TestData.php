<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Adds default records to tables.
 */
class MW_Setup_Task_TablesAddTypo3TestData extends MW_Setup_Task_Abstract
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return array List of task names
	 */
	public function getPreDependencies()
	{
		return array();
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return array List of task names
	 */
	public function getPostDependencies()
	{
		return array();
	}


	/**
	 * Executes the task for MySQL databases.
	 */
	protected function _mysql()
	{
		$this->_msg('Setting up Arcavias TYPO3 test data', 0);
		$this->_status('');

		$file = dirname( realpath( __FILE__ ) ) . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'mysql.sql';
		$this->_process( $file );
	}


	/**
	 * Insert records from file containing the SQL records.
	 *
	 * @param string $filename Name of the file
	 */
	protected function _process( $filename )
	{
		$this->_msg(sprintf('Adding records from "%1$s"', basename($filename)), 1);

		if( ( $content = file_get_contents( $filename ) ) === false ) {
			throw new MW_Setup_Exception( sprintf( 'Unable to get content from file "%1$s"', $filename ) );
		}

		$this->_execute( $content );
		$this->_status( 'done' );
	}

}