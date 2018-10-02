<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2014
 * @copyright Aimeos (aimeos.org), 2014-2018
 */


namespace Aimeos\MW\Cache;


require_once __DIR__ . DIRECTORY_SEPARATOR . 'T3Cache';


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp()
	{
		$this->mock = $this->getMockBuilder( 'TYPO3\\CMS\\Core\\Cache\\Frontend\\T3Cache' )->getMock();
		$this->object = new \Aimeos\MW\Cache\Typo3( [], $this->mock );
	}


	protected function tearDown()
	{
		unset( $this->mock, $this->object );
	}


	public function testDelete()
	{
		$this->mock->expects( $this->once() )->method( 'remove' )->with( $this->equalTo( 'key' ) );
		$this->object->delete( 'key' );
	}


	public function testDeleteWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'remove' )->with( $this->equalTo( '1-key' ) );
		$object->delete( 'key' );
	}


	public function testDeleteMultiple()
	{
		$this->mock->expects( $this->exactly( 2 ) )->method( 'remove' )->with( $this->equalTo( 'key' ) );
		$this->object->deleteMultiple( array( 'key', 'key' ) );
	}


	public function testDeleteMultipleWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'remove' )->with( $this->equalTo( '1-key' ) );
		$object->deleteMultiple( array( 'key' ) );
	}


	public function testDeleteByTags()
	{
		$this->mock->expects( $this->exactly( 2 ) )->method( 'flushByTag' )->with( $this->equalTo( 'tag' ) );
		$this->object->deleteByTags( array( 'tag', 'tag' ) );
	}


	public function testDeleteByTagsWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'flushByTag' )->with( $this->equalTo( '1-tag' ) );
		$object->deleteByTags( array( 'tag' ) );
	}


	public function testClear()
	{
		$this->mock->expects( $this->once() )->method( 'flush' );
		$this->object->clear();
	}


	public function testClearWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'flushByTag' )->with( $this->equalTo( '1-siteid' ) );
		$object->clear();
	}


	public function testGet()
	{
		$this->mock->expects( $this->once() )->method( 'get' )
			->with( $this->equalTo( 'key' ) )->will( $this->returnValue( 'value' ) );

		$this->assertEquals( 'value', $this->object->get( 'key', 'default' ) );
	}


	public function testGetWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'get' )->with( $this->equalTo( '1-key' ) );
		$object->get( 'key', 'default' );
	}


	public function testGetMultiple()
	{
		$this->mock->expects( $this->exactly( 2 ) )->method( 'get' )
			->will( $this->returnValue( 'value' ) );

		$expected = array( 'key1' => 'value', 'key2' => 'value' );
		$this->assertEquals( $expected, $this->object->getMultiple( array( 'key1', 'key2' ) ) );
	}


	public function testGetMultipleWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'get' )->with( $this->equalTo( '1-key' ) );
		$object->getMultiple( array( 'key' ) );
	}


	public function testGetMultipleByTags()
	{
		$this->mock->expects( $this->exactly( 2 ) )->method( 'getByTag' )
			->with( $this->equalTo( 'key' ) )->will( $this->returnValue( array( 'key' => 'value' ) ) );

		$this->assertEquals( array( 'key' => 'value' ), $this->object->getMultipleByTags( array( 'key', 'key' ) ) );
	}


	public function testGetMultipleByTagsWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'getByTag' )
			->with( $this->equalTo( '1-key' ) )->will( $this->returnValue( array( '1-key' => 'value' ) ) );

		$this->assertEquals( array( 'key' => 'value' ), $object->getMultipleByTags( array( 'key' ) ) );
	}


	public function testSet()
	{
		$this->mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( 'key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( 'tag' ) ), $this->greaterThan( 0 )
			);

		$this->object->set( 'key', 'value', '2100-01-01 00:00:00', array( 'tag' ) );
	}


	public function testSetWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( '1-key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( '1-siteid', '1-tag' ) ), $this->equalTo( null )
			);

		$object->set( 'key', 'value', null, array( 'tag' ) );
	}


	public function testSetMultiple()
	{
		$this->mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( 'key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( 'tag' ) ), $this->greaterThan( 0 )
			);

		$expires = array( 'key' => '2100-01-01 00:00:00' );
		$this->object->setMultiple( array( 'key' => 'value' ), $expires, array( 'key' => array( 'tag' ) ) );
	}


	public function testSetMultipleWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( '1-key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( '1-siteid', '1-tag' ) ), $this->equalTo( null )
			);

		$object->setMultiple( array( 'key' => 'value' ), null, array( 'key' => array( 'tag' ) ) );
	}

}
