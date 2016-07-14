<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2014
 * @copyright Aimeos (aimeos.org), 2014
 */


namespace Aimeos\MW\Cache;


require_once __DIR__ . DIRECTORY_SEPARATOR . 'T3Cache';


class Typo3Test extends \PHPUnit_Framework_TestCase
{
	private $object;
	private $mock;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		$this->mock = $this->getMockBuilder( 'TYPO3\\CMS\\Core\\Cache\\Frontend\\T3Cache' )->getMock();
		$this->object = new \Aimeos\MW\Cache\Typo3( array(), $this->mock );
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
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


	public function testDeleteList()
	{
		$this->mock->expects( $this->exactly( 2 ) )->method( 'remove' )->with( $this->equalTo( 'key' ) );
		$this->object->deleteList( array( 'key', 'key' ) );
	}


	public function testDeleteListWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'remove' )->with( $this->equalTo( '1-key' ) );
		$object->deleteList( array( 'key' ) );
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


	public function testFlush()
	{
		$this->mock->expects( $this->once() )->method( 'flush' );
		$this->object->flush();
	}


	public function testFlushWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'flushByTag' )->with( $this->equalTo( '1-siteid' ) );
		$object->flush();
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


	public function testGetList()
	{
		$this->mock->expects( $this->exactly( 2 ) )->method( 'get' )
			->will( $this->returnValue( 'value' ) );

		$expected = array( 'key1' => 'value', 'key2' => 'value' );
		$this->assertEquals( $expected, $this->object->getList( array( 'key1', 'key2' ) ) );
	}


	public function testGetListWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'get' )->with( $this->equalTo( '1-key' ) );
		$object->getList( array( 'key' ) );
	}


	public function testGetListByTags()
	{
		$this->mock->expects( $this->exactly( 2 ) )->method( 'getByTag' )
			->with( $this->equalTo( 'key' ) )->will( $this->returnValue( array( 'key' => 'value' ) ) );

		$this->assertEquals( array( 'key' => 'value' ), $this->object->getListByTags( array( 'key', 'key' ) ) );
	}


	public function testGetListByTagsWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'getByTag' )
			->with( $this->equalTo( '1-key' ) )->will( $this->returnValue( array( '1-key' => 'value' ) ) );

		$this->assertEquals( array( 'key' => 'value' ), $object->getListByTags( array( 'key' ) ) );
	}


	public function testSet()
	{
		$this->mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( 'key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( 'tag' ) ), $this->greaterThan( 0 )
			);

		$this->object->set( 'key', 'value', array( 'tag' ), '2000-01-01 00:00:00' );
	}


	public function testSetWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( '1-key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( '1-siteid', '1-tag' ) ), $this->equalTo( null )
			);

		$object->set( 'key', 'value', array( 'tag' ), null );
	}


	public function testSetList()
	{
		$this->mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( 'key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( 'tag' ) ), $this->greaterThan( 0 )
			);

		$expires = array( 'key' => '2000-01-01 00:00:00' );
		$this->object->setList( array( 'key' => 'value' ), array( 'key' => array( 'tag' ) ), $expires );
	}


	public function testSetListWithSiteId()
	{
		$object = new \Aimeos\MW\Cache\Typo3( array( 'siteid' => 1 ), $this->mock );

		$this->mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( '1-key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( '1-siteid', '1-tag' ) ), $this->equalTo( null )
			);

		$object->setList( array( 'key' => 'value' ), array( 'key' => array( 'tag' ) ), array() );
	}

}
