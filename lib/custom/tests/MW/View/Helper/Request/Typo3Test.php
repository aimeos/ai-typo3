<?php

namespace Aimeos\MW\View\Helper\Request;


/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2017
 */
class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;


	protected function setUp()
	{
		if( !class_exists( '\Zend\Diactoros\ServerRequestFactory' ) ) {
			$this->markTestSkipped( '\Zend\Diactoros\ServerRequestFactory is not available' );
		}

		$view = new \Aimeos\MW\View\Standard();
		$server = array( 'REMOTE_ADDR' => '127.0.0.1' );
		$this->object = new \Aimeos\MW\View\Helper\Request\Typo3( $view, 123, [], [], [], [], $server );
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testTransform()
	{
		$this->assertInstanceOf( '\Aimeos\MW\View\Helper\Request\Typo3', $this->object->transform() );
	}


	public function testGetClientAddress()
	{
		$this->assertEquals( '127.0.0.1', $this->object->getClientAddress() );
	}


	public function testGetTarget()
	{
		$this->assertEquals( 123, $this->object->getTarget() );
	}
}
