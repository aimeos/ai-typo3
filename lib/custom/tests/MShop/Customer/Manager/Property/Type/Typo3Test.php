<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2018-2022
 */


namespace Aimeos\MShop\Customer\Manager\Property\Type;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $editor = '';


	protected function setUp() : void
	{
		$context = \TestHelper::context();
		$this->editor = $context->editor();

		$manager = \Aimeos\MShop\Customer\Manager\Factory::create( $context, 'Typo3' );
		$this->object = $manager->getSubManager( 'property', 'Typo3' )->getSubManager( 'type', 'Typo3' );
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
		$this->assertInstanceOf( '\\Aimeos\\MShop\\Common\\Item\\Type\\Iface', $this->object->create() );
	}


	public function testGetResourceType()
	{
		$result = $this->object->getResourceType();

		$this->assertContains( 'customer/property/type', $result );
	}


	public function testGetSearchAttributes()
	{
		foreach( $this->object->getSearchAttributes() as $attribute ) {
			$this->assertInstanceOf( '\\Aimeos\\MW\\Criteria\\Attribute\\Iface', $attribute );
		}
	}


	public function testGetItem()
	{
		$search = $this->object->filter();
		$conditions = array(
			$search->compare( '==', 'customer.property.type.code', 'newsletter' ),
			$search->compare( '==', 'customer.property.type.editor', $this->editor )
		);
		$search->setConditions( $search->and( $conditions ) );

		if( ( $item = $this->object->search( $search )->first() ) === null ) {
			throw new \RuntimeException( 'No property type item found.' );
		}

		$actual = $this->object->get( $item->getId() );

		$this->assertEquals( $item, $actual );
	}


	public function testSaveUpdateDeleteItem()
	{
		$search = $this->object->filter();
		$search->setConditions( $search->compare( '==', 'customer.property.type.editor', $this->editor ) );

		if( ( $item = $this->object->search( $search )->first() ) === null ) {
			throw new \RuntimeException( 'No type item found' );
		}

		$item->setId( null );
		$item->setCode( 'unitTestSave' );
		$resultSaved = $this->object->save( $item );
		$itemSaved = $this->object->get( $item->getId() );

		$itemExp = clone $itemSaved;
		$itemExp->setCode( 'unitTestSave2' );
		$resultUpd = $this->object->save( $itemExp );
		$itemUpd = $this->object->get( $itemExp->getId() );

		$this->object->delete( $itemSaved->getId() );


		$this->assertTrue( $item->getId() !== null );
		$this->assertEquals( $item->getId(), $itemSaved->getId() );
		$this->assertEquals( $item->getSiteId(), $itemSaved->getSiteId() );
		$this->assertEquals( $item->getCode(), $itemSaved->getCode() );
		$this->assertEquals( $item->getDomain(), $itemSaved->getDomain() );
		$this->assertEquals( $item->getLabel(), $itemSaved->getLabel() );
		$this->assertEquals( $item->getStatus(), $itemSaved->getStatus() );

		$this->assertEquals( $this->editor, $itemSaved->editor() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemSaved->getTimeModified() );

		$this->assertEquals( $itemExp->getId(), $itemUpd->getId() );
		$this->assertEquals( $itemExp->getSiteId(), $itemUpd->getSiteId() );
		$this->assertEquals( $itemExp->getCode(), $itemUpd->getCode() );
		$this->assertEquals( $itemExp->getDomain(), $itemUpd->getDomain() );
		$this->assertEquals( $itemExp->getLabel(), $itemUpd->getLabel() );
		$this->assertEquals( $itemExp->getStatus(), $itemUpd->getStatus() );

		$this->assertEquals( $this->editor, $itemUpd->editor() );
		$this->assertEquals( $itemExp->getTimeCreated(), $itemUpd->getTimeCreated() );
		$this->assertRegExp( '/\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}/', $itemUpd->getTimeModified() );

		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultSaved );
		$this->assertInstanceOf( \Aimeos\MShop\Common\Item\Iface::class, $resultUpd );

		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->get( $itemSaved->getId() );
	}


	public function testSearchItems()
	{
		$total = 0;
		$search = $this->object->filter();

		$expr = [];
		$expr[] = $search->compare( '!=', 'customer.property.type.id', null );
		$expr[] = $search->compare( '!=', 'customer.property.type.siteid', null );
		$expr[] = $search->compare( '==', 'customer.property.type.domain', 'customer' );
		$expr[] = $search->compare( '==', 'customer.property.type.code', 'newsletter' );
		$expr[] = $search->compare( '>', 'customer.property.type.label', '' );
		$expr[] = $search->compare( '>=', 'customer.property.type.position', 0 );
		$expr[] = $search->compare( '==', 'customer.property.type.status', 1 );
		$expr[] = $search->compare( '>=', 'customer.property.type.mtime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '>=', 'customer.property.type.ctime', '1970-01-01 00:00:00' );
		$expr[] = $search->compare( '==', 'customer.property.type.editor', $this->editor );

		$search->setConditions( $search->and( $expr ) );
		$results = $this->object->search( $search, [], $total );
		$this->assertEquals( 1, count( $results ) );


		$search = $this->object->filter();
		$conditions = array(
			$search->compare( '=~', 'customer.property.type.code', 'newsletter' ),
			$search->compare( '==', 'customer.property.type.editor', $this->editor )
		);
		$search->setConditions( $search->and( $conditions ) );
		$search->slice( 0, 1 );
		$items = $this->object->search( $search, [], $total );

		$this->assertEquals( 1, count( $items ) );
		$this->assertEquals( 1, $total );

		foreach( $items as $itemId => $item ) {
			$this->assertEquals( $itemId, $item->getId() );
		}
	}


	public function testGetSubManager()
	{
		$this->expectException( '\\Aimeos\\MShop\\Exception' );
		$this->object->getSubManager( 'unknown' );
	}
}
