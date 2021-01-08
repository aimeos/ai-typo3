<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2021
 */

namespace Aimeos\MW\View\Engine;


require_once __DIR__ . DIRECTORY_SEPARATOR . 'T3Object';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'T3View';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'T3Configuration';


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	public function testRender()
	{
		$mock = $this->getMockBuilder( '\TYPO3\CMS\Extbase\Object\ObjectManagerInterface' )
			->setMethods( array( 'get' ) )
			->disableOriginalConstructor()
			->getMock();

		$config = $this->getMockBuilder( '\TYPO3\CMS\Extbase\Configuration\ConfigurationManager' )
			->setMethods( array( 'getConfiguration' ) )
			->disableOriginalConstructor()
			->getMock();

		$view = $this->getMockBuilder( 'TYPO3\\CMS\\Fluid\\View\\T3View' )
			->setMethods( array( 'assign', 'assignMultiple', 'render', 'setTemplatePathAndFilename', 'setPartialRootPaths', 'setLayoutRootPaths' ) )
			->disableOriginalConstructor()
			->getMock();

		$conf = ['view' => ['partialRootPaths' => '', 'layoutRootPaths' => '']];
		$config->expects( $this->once() )->method( 'getConfiguration' )->will( $this->returnValue( $conf ) );
		$mock->expects( $this->exactly( 2 ) )->method( 'get' )->will( $this->onConsecutiveCalls( $config, $view ) );

		$view->expects( $this->once() )->method( 'setTemplatePathAndFilename' );
		$view->expects( $this->once() )->method( 'assignMultiple' );
		$view->expects( $this->once() )->method( 'assign' );
		$view->expects( $this->once() )->method( 'setPartialRootPaths' );
		$view->expects( $this->once() )->method( 'setLayoutRootPaths' );
		$view->expects( $this->once() )->method( 'render' )->will( $this->returnValue( 'test' ) );

		$v = new \Aimeos\MW\View\Standard( [] );
		$object = new \Aimeos\MW\View\Engine\Typo3( $mock );

		$this->assertEquals( 'test', $object->render( $v, 'filepath', array( 'key' => 'value' ) ) );
	}
}
