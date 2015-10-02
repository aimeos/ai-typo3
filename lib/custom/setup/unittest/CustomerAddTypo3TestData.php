<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


/**
 * Adds TYPO3 customer test data.
 */
class MW_Setup_Task_CustomerAddTypo3TestData extends MW_Setup_Task_CustomerAddTestData
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
	 * Adds customer TYPO3 test data.
	 */
	protected function process()
	{
		$iface = 'MShop_Context_Item_Interface';
		if( !( $this->additional instanceof $iface ) ) {
			throw new MW_Setup_Exception( sprintf( 'Additionally provided object is not of type "%1$s"', $iface ) );
		}

		$this->msg( 'Adding TYPO3 customer test data', 0 );
		$this->additional->setEditor( 'ai-typo3:unittest' );

		$parentIds = array();
		$ds = DIRECTORY_SEPARATOR;
		$path = dirname( __FILE__ ) . $ds . 'data' . $ds . 'customer.php';

		if( ( $testdata = include( $path ) ) == false ){
			throw new MShop_Exception( sprintf( 'No file "%1$s" found for customer domain', $path ) );
		}


		$customerManager = MShop_Customer_Manager_Factory::createManager( $this->additional, 'Typo3' );
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
