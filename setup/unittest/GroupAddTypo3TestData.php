<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2023
 */


namespace Aimeos\Upscheme\Task;


/**
 * Adds TYPO3 group test data.
 */
class GroupAddTypo3TestData extends GroupAddTestData
{
	/**
	 * Returns the list of task names which this task depends on
	 *
	 * @return string[] List of task names
	 */
	public function after() : array
	{
		return ['Group'];
	}


	/**
	 * Adds group test data
	 */
	public function up()
	{
		$this->info( 'Adding TYPO3 group test data', 'vv' );

		$this->db( 'db-group' )->exec( "DELETE FROM fe_groups WHERE title LIKE 'unitgroup%'" );

		$this->context()->setEditor( 'ai-typo3' );
		$this->process();
	}


	/**
	 * Returns the manager for the current setup task
	 *
	 * @param string $domain Domain name of the manager
	 * @param string $name Specific manager implemenation
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager object
	 */
	protected function getManager( string $domain, string $name = 'Standard' ) : \Aimeos\MShop\Common\Manager\Iface
	{
		if( $domain === 'group' ) {
			return parent::getManager( $domain, 'Typo3' );
		}

		return parent::getManager( $domain );
	}
}
