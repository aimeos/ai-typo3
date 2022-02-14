<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2022
 */


namespace Aimeos\Base\Session;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		if( !class_exists( '\TYPO3\CMS\Core\Authentication\AbstractUserAuthentication' ) ) {
			$this->markTestSkipped( 'TYPO3 AbstractUserAuthentication not available' );
		}

		$this->mock = $this->getMockBuilder( '\TYPO3\CMS\Core\Authentication\AbstractUserAuthentication' )
			->setMethods( ['getSessionData', 'setAndSaveSessionData'] )
			->disableOriginalConstructor()
			->getMockForAbstractClass();

		$this->object = new \Aimeos\Base\Session\Typo3( $this->mock );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock );
	}


	public function testDel()
	{
		$this->mock->expects( $this->once() )->method( 'setAndSaveSessionData' );

		$result = $this->object->del( 'test' );

		$this->assertInstanceOf( \Aimeos\Base\Session\Iface::class, $result );
	}


	public function testGet()
	{
		$this->mock->expects( $this->once() )->method( 'getSessionData' )->will( $this->returnValue( '123456789' ) );

		$this->assertEquals( '123456789', $this->object->get( 'test' ) );
	}


	public function testPull()
	{
		$this->mock->expects( $this->once() )->method( 'setAndSaveSessionData' );
		$this->mock->expects( $this->once() )->method( 'getSessionData' )->will( $this->returnValue( '123456789' ) );

		$this->assertEquals( '123456789', $this->object->pull( 'test' ) );
	}


	public function testRemove()
	{
		$this->mock->expects( $this->once() )->method( 'setAndSaveSessionData' );

		$result = $this->object->remove( ['test'] );

		$this->assertInstanceOf( \Aimeos\Base\Session\Iface::class, $result );
	}


	public function testSet()
	{
		$this->mock->expects( $this->once() )->method( 'setAndSaveSessionData' );

		$result = $this->object->set( 'test', '234' );

		$this->assertInstanceOf( \Aimeos\Base\Session\Iface::class, $result );
	}
}
