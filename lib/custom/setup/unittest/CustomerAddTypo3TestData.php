<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2021
 */


namespace Aimeos\Upscheme\Task;


/**
 * Adds FOS user customer test data.
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
		return ['Customer', 'Text', 'ProductAddTestData'];
	}


	/**
	 * Adds customer test data
	 */
	public function up()
	{
		$this->info( 'Adding TYPO3 customer test data', 'v' );

		$this->db( 'db-customer' )->exec( "DELETE FROM fe_users WHERE email LIKE 'test%@example.com'" );

		$this->context()->setEditor( 'ai-typo3:lib/custom' );
		$this->process();
	}


	/**
	 * Returns the manager for the current setup task
	 *
	 * @param string $domain Domain name of the manager
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager object
	 */
	protected function getManager( string $domain ) : \Aimeos\MShop\Common\Manager\Iface
	{
		if( $domain === 'customer' ) {
			return \Aimeos\MShop\Customer\Manager\Factory::create( $this->context(), 'Typo3' );
		}

		return parent::getManager( $domain );
	}
}
