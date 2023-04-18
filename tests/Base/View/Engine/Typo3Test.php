<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2023
 */

namespace Aimeos\Base\View\Engine;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	public function testRender()
	{
		if( !class_exists( '\TYPO3\CMS\Extbase\Configuration\ConfigurationManager' ) ) {
			$this->markTestSkipped( 'TYPO3 ConfigurationManager not available' );
		}

		$config = $this->getMockBuilder( '\TYPO3\CMS\Extbase\Configuration\ConfigurationManager' )
			->onlyMethods( ['getConfiguration'] )
			->disableOriginalConstructor()
			->getMock();

		$view = $this->getMockBuilder( '\TYPO3\CMS\Fluid\View\StandaloneView' )
			->onlyMethods( ['assign', 'assignMultiple', 'render', 'setTemplatePathAndFilename', 'setPartialRootPaths', 'setLayoutRootPaths'] )
			->disableOriginalConstructor()
			->getMock();

		$view->expects( $this->once() )->method( 'setTemplatePathAndFilename' );
		$view->expects( $this->once() )->method( 'assignMultiple' );
		$view->expects( $this->once() )->method( 'assign' );
		$view->expects( $this->once() )->method( 'setPartialRootPaths' );
		$view->expects( $this->once() )->method( 'setLayoutRootPaths' );
		$view->expects( $this->once() )->method( 'render' )->will( $this->returnValue( 'test' ) );

		$conf = ['view' => ['partialRootPaths' => '', 'layoutRootPaths' => '']];
		$object = new \Aimeos\Base\View\Engine\Typo3( $view, $conf );
		$v = new \Aimeos\Base\View\Standard( [] );

		$this->assertEquals( 'test', $object->render( $v, 'filepath', ['key' => 'value'] ) );
	}
}
