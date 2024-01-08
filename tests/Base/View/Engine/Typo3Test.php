<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2017-2024
 */

namespace Aimeos\Base\View\Engine;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	public function testRender()
	{
		if( !class_exists( '\TYPO3\CMS\Fluid\View\StandaloneView' ) ) {
			$this->markTestSkipped( '\TYPO3\CMS\Fluid\View\StandaloneView not available' );
		}

		$view = $this->getMockBuilder( '\TYPO3\CMS\Fluid\View\StandaloneView' )
			->onlyMethods( ['assign', 'assignMultiple', 'render', 'setTemplatePathAndFilename', 'setPartialRootPaths', 'setLayoutRootPaths'] )
			->disableOriginalConstructor()
			->getMock();

		$view->expects( $this->once() )->method( 'setTemplatePathAndFilename' );
		$view->expects( $this->once() )->method( 'assignMultiple' );
		$view->expects( $this->once() )->method( 'assign' );
		$view->expects( $this->once() )->method( 'render' )->will( $this->returnValue( 'test' ) );

		$object = new \Aimeos\Base\View\Engine\Typo3( $view );
		$v = new \Aimeos\Base\View\Standard( [] );

		$this->assertEquals( 'test', $object->render( $v, 'filepath', ['key' => 'value'] ) );
	}
}
