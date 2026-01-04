<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2026
 */


namespace Aimeos\Upscheme\Task;


/**
 * Adds TYPO3 customer test data.
 */
class CustomerAddTypo3TestData extends CustomerAddTestData
{
	/**
	 * Returns the list of task names which this task depends on
	 *
	 * @return string[] List of task names
	 */
	public function after() : array
	{
		return ['Customer', 'Text', 'GroupAddTestData', 'ProductAddTestData'];
	}


	/**
	 * Adds customer test data
	 */
	public function up()
	{
		$this->info( 'Adding TYPO3 customer test data', 'vv' );

		$this->db( 'db-customer' )->exec( "DELETE FROM fe_users WHERE email LIKE 'test%@example.com'" );

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
		if( $domain === 'customer' ) {
			return parent::getManager( $domain, 'Typo3' );
		}

		return parent::getManager( $domain );
	}
}
