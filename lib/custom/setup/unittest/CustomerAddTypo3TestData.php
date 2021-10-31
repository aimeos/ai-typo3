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
		return ['TablesAddTypo3TestData', 'ProductAddTestData'];
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function before() : array
	{
		return ['CustomerAddTestData'];
	}


	/**
	 * Adds customer test data
	 */
	public function up()
	{
		$this->info( 'Adding TYPO3 customer test data', 'v' );

		$this->db( 'db-customer' )->exec( 'DELETE FROM fe_users WHERE email LIKE \'test%@example.com\'' );

		$manager = $this->getManager( 'customer' )->getSubManager( 'group' );
		$search = $manager->filter();
		$search->setConditions( $search->compare( '==', 'customer.group.code', 'unitgroup' ) );
		$manager->delete( $manager->search( $search )->toArray() );

		$this->context()->setEditor( 'ai-typo3:lib/custom' );
		$this->process( __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'customer.php' );
	}


	/**
	 * Returns the manager for the current setup task
	 *
	 * @param string $domain Domain name of the manager
	 * @return \Aimeos\MShop\Common\Manager\Iface Manager object
	 */
	protected function getManager( $domain )
	{
		if( $domain === 'customer' ) {
			return \Aimeos\MShop\Customer\Manager\Factory::create( $this->context(), 'Typo3' );
		}

		return parent::getManager( $domain );
	}
}
