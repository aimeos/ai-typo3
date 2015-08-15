<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


class MShop_Common_Manager_Group_Typo3Test extends PHPUnit_Framework_TestCase
{
	private $_object = null;
	private $_editor = '';


	protected function setUp()
	{
		$context = TestHelper::getContext();
		$this->_editor = $context->getEditor();

		$this->_object = new MShop_Customer_Manager_Group_Typo3( $context );
	}


	protected function tearDown()
	{
		unset( $this->_object );
	}


	public function testCleanup()
	{
		$this->_object->cleanup( array( -1 ) );
	}


	public function testSaveItem()
	{
		$item = new MShop_Customer_Item_Group_Default();

		$this->setExpectedException( 'MShop_Customer_Exception' );
		$this->_object->saveItem( $item );
	}


	public function testDeleteItem()
	{
		$this->setExpectedException( 'MShop_Customer_Exception' );
		$this->_object->deleteItem( -1 );
	}


	public function testSearchItem()
	{
		$search = $this->_object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.group.label', 'Unit test group' ) );
		$search->setSlice( 0, 1 );

		$total = 0;
		$results = $this->_object->searchItems( $search, array(), $total );

		$this->assertEquals( 1, count( $results ) );
		$this->assertEquals( 1, $total );
	}

}
