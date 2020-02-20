<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2020
 */


namespace Aimeos\MW\Session;


require_once __DIR__ . DIRECTORY_SEPARATOR . 'AbstractUserAuthentication';


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;


	protected function setUp() : void
	{
		$mock = new \TYPO3\CMS\Core\Authentication\AbstractUserAuthentication();
		$this->object = new \Aimeos\MW\Session\Typo3( $mock );
	}


	protected function tearDown() : void
	{
		unset( $this->object );
	}


	public function testDel()
	{
		$this->object->set( 'test', '123456789' );
		$this->assertEquals( '123456789', $this->object->get( 'test' ) );

		$result = $this->object->del( 'test' );

		$this->assertInstanceOf( \Aimeos\MW\Session\Iface::class, $result );
		$this->assertEquals( null, $this->object->get( 'test' ) );
	}


	public function testGet()
	{
		$this->assertEquals( null, $this->object->get( 'test' ) );

		$this->object->set( 'test', '123456789' );
		$this->assertEquals( '123456789', $this->object->get( 'test' ) );

		$this->object->set( 'test', ['123456789'] );
		$this->assertEquals( ['123456789'], $this->object->get( 'test' ) );
	}


	public function testPull()
	{
		$this->object->set( 'test', '123456789' );
		$this->assertEquals( '123456789', $this->object->get( 'test' ) );

		$this->assertEquals( '123456789', $this->object->pull( 'test' ) );
		$this->assertEquals( null, $this->object->pull( 'test' ) );
	}


	public function testRemove()
	{
		$this->object->set( 'test', '123456789' );
		$this->assertEquals( '123456789', $this->object->get( 'test' ) );

		$result = $this->object->remove( ['test'] );

		$this->assertInstanceOf( \Aimeos\MW\Session\Iface::class, $result );
		$this->assertEquals( null, $this->object->get( 'test' ) );
	}


	public function testSet()
	{
		$this->object->set( 'test', null );
		$this->assertEquals( null, $this->object->get( 'test' ) );

		$result = $this->object->set( 'test', '234' );

		$this->assertInstanceOf( \Aimeos\MW\Session\Iface::class, $result );
		$this->assertEquals( '234', $this->object->get( 'test' ) );
	}
}
