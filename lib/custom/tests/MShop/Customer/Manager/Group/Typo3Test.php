<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2020
 */


namespace Aimeos\MShop\Common\Manager\Group;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object = null;
	private $editor = '';


	protected function setUp() : void
	{
		$context = \TestHelper::getContext();
		$this->editor = $context->getEditor();

		$this->object = new \Aimeos\MShop\Customer\Manager\Group\Typo3( $context );
	}


	protected function tearDown() : void
	{
		unset( $this->object );
	}


	public function testClear()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->clear( array( -1 ) ) );
	}


	public function testCreateItem()
	{
		$item = $this->object->createItem();
		$this->assertInstanceOf( \Aimeos\MShop\Customer\Item\Group\Iface::class, $item );
	}


	public function testCreateSearch()
	{
		$this->assertInstanceOf( \Aimeos\MW\Criteria\Iface::class, $this->object->createSearch() );
	}


	public function testDeleteItems()
	{
		$this->assertInstanceOf( \Aimeos\MShop\Common\Manager\Iface::class, $this->object->deleteItems( [-1] ) );
	}


	public function testGetResourceType()
	{
		$this->assertContains( 'customer/group', $this->object->getResourceType() );
	}


	public function testGetSearchAttributes()
	{
		foreach( $this->object->getSearchAttributes() as $attribute ) {
			$this->assertInstanceOf( \Aimeos\MW\Criteria\Attribute\Iface::class, $attribute );
		}
	}


	public function testFindItem()
	{
		$item = $this->object->findItem( 'unitgroup' );

		$this->assertEquals( 'unitgroup', $item->getCode() );
	}


	public function testGetItem()
	{
		$item = $this->object->findItem( 'unitgroup' );

		$this->assertEquals( $item, $this->object->getItem( $item->getId() ) );
	}


	public function testSaveUpdateDeleteItem()
	{
		$item = $this->object->createItem();
		$item->setCode( 'unittest-group' );

		$resultSaved = $this->object->saveItem( $item );
		$itemSaved = $this->object->getItem( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setCode( 'unittest-group-2' );

		$resultUpd = $this->object->saveItem( $itemExp );
		$itemUpd = $this->object->getItem( $itemExp->getId() );

		$this->object->deleteItem( $itemSaved->getId() );


		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getCode(), $itemSaved->getCode() );
		$this->assertEquals( $item->getLabel(), $itemSaved->getLabel() );

		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getCode(), $itemUpd->getCode() );
		$this->assertEquals( $itemExp->getLabel(), $itemUpd->getLabel() );

		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultSaved );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultUpd );

		$this->expectException( \Aimeos\MShop\Exception::class );
		$this->object->getItem( $itemSaved->getId() );
	}


	public function testSearchItem()
	{
		$search = $this->object->createSearch();
		$search->setConditions( $search->compare( '==', 'customer.group.label', 'Unitgroup' ) );
		$search->setSlice( 0, 1 );

		$total = 0;
		$results = $this->object->searchItems( $search, [], $total );

		$this->assertEquals( 1, count( $results ) );
		$this->assertEquals( 1, $total );
	}

}
