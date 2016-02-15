<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2016
 */


namespace Aimeos\MW\View\Helper\Response;


class Typo3Test extends \PHPUnit_Framework_TestCase
{
	private $object;


	protected function setUp()
	{
		if( !class_exists( '\Zend\Diactoros\Response' ) ) {
			$this->markTestSkipped( '\Zend\Diactoros\Response is not available' );
		}

		$view = new \Aimeos\MW\View\Standard();
		$this->object = new \Aimeos\MW\View\Helper\Response\Typo3( $view );
	}


	protected function tearDown()
	{
		unset( $this->object );
	}


	public function testTransform()
	{
		$this->assertInstanceOf( '\Aimeos\MW\View\Helper\Response\Typo3', $this->object->transform() );
	}
}
