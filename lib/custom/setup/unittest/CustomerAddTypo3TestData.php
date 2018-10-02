<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds TYPO3 customer test data.
 */
class CustomerAddTypo3TestData extends \Aimeos\MW\Setup\Task\CustomerAddTestData
{
	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies()
	{
		return array( 'TablesAddTypo3TestData' );
	}


	/**
	 * Adds test data
	 */
	public function migrate()
	{
		\Aimeos\MW\Common\Base::checkClass( '\\Aimeos\\MShop\\Context\\Item\\Iface', $this->additional );

		$this->msg( 'Adding TYPO3 customer test data', 0 );
		$this->additional->setEditor( 'ai-typo3:unittest' );

		$parentIds = [];
		$ds = DIRECTORY_SEPARATOR;
		$path = __DIR__ . $ds . 'data' . $ds . 'customer.php';

		if( ( $testdata = include( $path ) ) == false ){
			throw new \Aimeos\MShop\Exception( sprintf( 'No file "%1$s" found for customer domain', $path ) );
		}


		$customerManager = \Aimeos\MShop\Customer\Manager\Factory::createManager( $this->additional, 'Typo3' );
		$customerAddressManager = $customerManager->getSubManager( 'address', 'Typo3' );

		foreach( $customerManager->searchItems( $customerManager->createSearch() ) as $id => $item ) {
			$parentIds[ 'customer/' . $item->getCode() ] = $id;
		}

		$this->conn->begin();

		$this->addCustomerAddressData( $testdata, $customerAddressManager, $parentIds );

		$this->conn->commit();


		$this->status( 'done' );
	}
}
