<?php

namespace Aimeos\MShop\Common\Manager\Group;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2017
 */
class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object = null;
	private $editor = '';


	protected function setUp()
	{
		$context = \TestHelper::getContext();
		$this->editor = $context->getEditor();

		$this->object = new \Aimeos\MShop\Customer\Manager\Group\Typo3( $context );
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testCleanup()
	{
		$this->object->cleanup( array( -1 ) );
	}


	public function testSaveItem()
	{
		$item = new \Aimeos\MShop\Customer\Item\Group\Standard();

		$this->setExpectedException( '\\Aimeos\\MShop\\Customer\\Exception' );
		$this->object->saveItem( $item );
	}


	public function testDeleteItem()
	{
		$this->setExpectedException( '\\Aimeos\\MShop\\Customer\\Exception' );
		$this->object->deleteItem( -1 );
	}


	public function testSearchItem()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.group.label', 'Unit test group' ) );
		$search->setSlice( 0, 1 );

		$total = 0;
		$results = $this->object->searchItems( $search, [], $total );

		$this->assertEquals( 1, count( $results ) );
		$this->assertEquals( 1, $total );
	}

}
