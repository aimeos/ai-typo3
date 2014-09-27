<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2014
 * @copyright Aimeos (aimeos.org), 2014
 */


require_once( __DIR__ . DIRECTORY_SEPARATOR . 'T3Cache.php' );


class MW_Cache_Typo3Test extends MW_Unittest_Testcase
{
	private $_object;
	private $_mock;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		$this->_mock = $this->getMock( 'T3Cache' );
		$this->_object = new MW_Cache_Typo3( array(), $this->_mock );
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
		unset( $this->_mock, $this->_object );
	}


	public function testDelete()
	{
		$this->_mock->expects( $this->once() )->method( 'remove' )->with( $this->equalTo( 'key' ) );
		$this->_object->delete( 'key' );
	}


	public function testDeleteWithSiteId()
	{
		$object = new MW_Cache_Typo3( array( 'siteid' => 1 ), $this->_mock );

		$this->_mock->expects( $this->once() )->method( 'remove' )->with( $this->equalTo( '1-key' ) );
		$object->delete( 'key' );
	}


	public function testDeleteList()
	{
		$this->_mock->expects( $this->exactly( 2 ) )->method( 'remove' )->with( $this->equalTo( 'key' ) );
		$this->_object->deleteList( array( 'key', 'key' ) );
	}


	public function testDeleteListWithSiteId()
	{
		$object = new MW_Cache_Typo3( array( 'siteid' => 1 ), $this->_mock );

		$this->_mock->expects( $this->once() )->method( 'remove' )->with( $this->equalTo( '1-key' ) );
		$object->deleteList( array( 'key' ) );
	}


	public function testDeleteByTags()
	{
		$this->_mock->expects( $this->exactly( 2 ) )->method( 'flushByTag' )->with( $this->equalTo( 'tag' ) );
		$this->_object->deleteByTags( array( 'tag', 'tag' ) );
	}


	public function testDeleteByTagsWithSiteId()
	{
		$object = new MW_Cache_Typo3( array( 'siteid' => 1 ), $this->_mock );

		$this->_mock->expects( $this->once() )->method( 'flushByTag' )->with( $this->equalTo( '1-tag' ) );
		$object->deleteByTags( array( 'tag' ) );
	}


	public function testFlush()
	{
		$this->_mock->expects( $this->once() )->method( 'flush' );
		$this->_object->flush();
	}


	public function testFlushWithSiteId()
	{
		$object = new MW_Cache_Typo3( array( 'siteid' => 1 ), $this->_mock );

		$this->_mock->expects( $this->once() )->method( 'flushByTag' )->with( $this->equalTo( '1-siteid' ) );
		$object->flush();
	}


	public function testGet()
	{
		$this->_mock->expects( $this->once() )->method( 'get' )
			->with( $this->equalTo( 'key' ) )->will( $this->returnValue( 'value' ) );

		$this->assertEquals( 'value', $this->_object->get( 'key', 'default' ) );
	}


	public function testGetWithSiteId()
	{
		$object = new MW_Cache_Typo3( array( 'siteid' => 1 ), $this->_mock );

		$this->_mock->expects( $this->once() )->method( 'get' )->with( $this->equalTo( '1-key' ) );
		$object->get( 'key', 'default' );
	}


	public function testGetList()
	{
		$this->_mock->expects( $this->exactly( 2 ) )->method( 'get' )
			->will( $this->returnValue( 'value' ) );

		$expected = array( 'key1' => 'value', 'key2' => 'value' );
		$this->assertEquals( $expected, $this->_object->getList( array( 'key1', 'key2' ) ) );
	}


	public function testGetListWithSiteId()
	{
		$object = new MW_Cache_Typo3( array( 'siteid' => 1 ), $this->_mock );

		$this->_mock->expects( $this->once() )->method( 'get' )->with( $this->equalTo( '1-key' ) );
		$object->getList( array( 'key' ) );
	}


	public function testGetListByTags()
	{
		$this->_mock->expects( $this->exactly( 2 ) )->method( 'getByTag' )
			->with( $this->equalTo( 'key' ) )->will( $this->returnValue( array( 'key' => 'value' ) ) );

		$this->assertEquals( array( 'key' => 'value' ), $this->_object->getListByTags( array( 'key', 'key' ) ) );
	}


	public function testGetListByTagsWithSiteId()
	{
		$object = new MW_Cache_Typo3( array( 'siteid' => 1 ), $this->_mock );

		$this->_mock->expects( $this->once() )->method( 'getByTag' )
			->with( $this->equalTo( '1-key' ) )->will( $this->returnValue( array( '1-key' => 'value' ) ) );

		$this->assertEquals( array( 'key' => 'value' ), $object->getListByTags( array( 'key' ) ) );
	}


	public function testSet()
	{
		$this->_mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( 'key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( 'tag' ) ), $this->greaterThan( 0 )
			);

		$this->_object->set( 'key', 'value', array( 'tag' ), '2000-01-01 00:00:00' );
	}


	public function testSetWithSiteId()
	{
		$object = new MW_Cache_Typo3( array( 'siteid' => 1 ), $this->_mock );

		$this->_mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( '1-key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( '1-siteid', '1-tag' ) ), $this->equalTo( null )
			);

		$object->set( 'key', 'value', array( 'tag' ), null );
	}


	public function testSetList()
	{
		$this->_mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( 'key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( 'tag' ) ), $this->greaterThan( 0 )
			);

		$expires = array( 'key' => '2000-01-01 00:00:00' );
		$this->_object->setList( array( 'key' => 'value' ), array( 'key' => array( 'tag' ) ), $expires );
	}


	public function testSetListWithSiteId()
	{
		$object = new MW_Cache_Typo3( array( 'siteid' => 1 ), $this->_mock );

		$this->_mock->expects( $this->once() )->method( 'set' )
			->with(
				$this->equalTo( '1-key' ), $this->equalTo( 'value' ),
				$this->equalTo( array( '1-siteid', '1-tag' ) ), $this->equalTo( null )
			);

		$object->setList( array( 'key' => 'value' ), array( 'key' => array( 'tag' ) ), array() );
	}

}
