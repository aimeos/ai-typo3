<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018
 */


namespace Aimeos\MW\Setup\Task;


/**
 * Adds customer property test data.
 */
class CustomerPropertyAddTypo3TestData
	extends \Aimeos\MW\Setup\Task\CustomerAddPropertyTestData
{

	/**
	 * Returns the list of task names which this task depends on.
	 *
	 * @return string[] List of task names
	 */
	public function getPreDependencies()
	{
		return array( 'TablesAddTypo3TestData', 'CustomerAddTypo3TestData', 'LocaleAddTestData' );
	}


	/**
	 * Adds customer test data.
	 */
	public function migrate()
	{
		\Aimeos\MW\Common\Base::checkClass( '\\Aimeos\\MShop\\Context\\Item\\Iface', $this->additional );

		$this->msg( 'Adding customer property TYPO3 test data', 0 );
		$this->additional->setEditor( 'ai-typo3:unittest' );

		$ds = DIRECTORY_SEPARATOR;
		$path = __DIR__ . $ds . 'data' . $ds . 'customer-property.php';

		if( ( $testdata = include( $path ) ) == false ) {
			throw new \Aimeos\MShop\Exception( sprintf( 'No file "%1$s" found for customer domain', $path ) );
		}

		$this->addCustomerPropertyData( $testdata, 'Typo3' );

		$this->status( 'done' );
	}
}