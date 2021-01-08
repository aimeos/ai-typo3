<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2014-2021
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds FOS user customer test data.
 */
class CustomerAddTypo3TestData extends \Aimeos\MW\Setup\Task\CustomerAddTestData
{
	/**
	 * Returns the list of task names which this task depends on
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies() : array
	{
		return ['TablesAddTypo3TestData', 'MShopSetLocale'];
	}


	/**
	 * Returns the list of task names which depends on this task.
	 *
	 * @return string[] List of task names
	 */
	public function getPostDependencies() : array
	{
		return ['CustomerAddTestData'];
	}


	/**
	 * Adds customer test data
	 */
	public function migrate()
	{
		\Aimeos\MW\Common\Base::checkClass( \Aimeos\MShop\Context\Item\Iface::class, $this->additional );

		$this->msg( 'Adding TYPO3 customer test data', 0 );

		$dbm = $this->additional->getDatabaseManager();
		$conn = $dbm->acquire( 'db-customer' );
		$conn->create( 'DELETE FROM "fe_users" WHERE "email" LIKE \'test%@example.com\'' )->execute()->finish();
		$dbm->release( $conn, 'db-customer' );

		$manager = $this->getManager( 'customer' )->getSubManager( 'group' );
		$search = $manager->filter();
		$search->setConditions( $search->compare( '==', 'customer.group.code', 'unitgroup' ) );
		$manager->delete( $manager->search( $search )->toArray() );

		$this->additional->setEditor( 'ai-typo3:lib/custom' );
		$this->process( __DIR__ . DIRECTORY_SEPARATOR . 'data' . DIRECTORY_SEPARATOR . 'customer.php' );

		$this->status( 'done' );
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
			return \Aimeos\MShop\Customer\Manager\Factory::create( $this->additional, 'Typo3' );
		}

		return parent::getManager( $domain );
	}
}
