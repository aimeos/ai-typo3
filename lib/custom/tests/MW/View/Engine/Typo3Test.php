<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2018
 */

namespace Aimeos\MW\View\Engine;


require_once __DIR__ . DIRECTORY_SEPARATOR . 'T3Object';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'T3View';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'T3Configuration';


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		$this->mock = $this->getMockBuilder( '\TYPO3\CMS\Extbase\Object\ObjectManagerInterface' )
			->setMethods( array( 'get' ) )
			->disableOriginalConstructor()
			->getMock();

		$configuration = $this->getMockBuilder( '\TYPO3\CMS\Extbase\Configuration\ConfigurationManager' )
			->setMethods( array( 'getConfiguration' ) )
			->disableOriginalConstructor()
			->getMock();
		$configuration->expects( $this->once() )->method( 'getConfiguration' );
		$this->mock->expects( $this->at(0) )->method( 'get' )
			->will( $this->returnValue( $configuration) );

		$this->object = new \Aimeos\MW\View\Engine\Typo3( $this->mock );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock );
	}


	public function testRender()
	{
		$v = new \Aimeos\MW\View\Standard( [] );

		$view = $this->getMockBuilder( 'TYPO3\\CMS\\Fluid\\View\\T3View' )
			->setMethods( array( 'assign', 'assignMultiple', 'render', 'setTemplatePathAndFilename', 'setPartialRootPaths', 'setLayoutRootPaths' ) )
			->disableOriginalConstructor()
			->getMock();

		$view->expects( $this->once() )->method( 'setTemplatePathAndFilename' );
		$view->expects( $this->once() )->method( 'assignMultiple' );
		$view->expects( $this->once() )->method( 'assign' );
		$view->expects( $this->once() )->method( 'setPartialRootPaths' );
		$view->expects( $this->once() )->method( 'setLayoutRootPaths' );
		$view->expects( $this->once() )->method( 'render' )
			->will( $this->returnValue( 'test' ) );

		$this->mock->expects( $this->at(0) )->method( 'get' )
			->will( $this->returnValue( $view) );

		$result = $this->object->render( $v, 'filepath', array( 'key' => 'value' ) );
		$this->assertEquals( 'test', $result );
	}
}
