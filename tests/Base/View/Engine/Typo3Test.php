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
		if( !class_exists( '\TYPO3\CMS\Extbase\Object\ObjectManagerInterface' ) ) {
			$this->markTestSkipped( 'TYPO3 ObjectManager not available' );
		}

		$mock = $this->getMockBuilder( '\TYPO3\CMS\Extbase\Object\ObjectManagerInterface' )
			->onlyMethods( array( 'get' ) )
			->disableOriginalConstructor()
			->getMock();

		$config = $this->getMockBuilder( '\TYPO3\CMS\Extbase\Configuration\ConfigurationManager' )
			->onlyMethods( array( 'getConfiguration' ) )
			->disableOriginalConstructor()
			->getMock();

		$view = $this->getMockBuilder( 'T3View' )
			->onlyMethods( array( 'assign', 'assignMultiple', 'render', 'setTemplatePathAndFilename', 'setPartialRootPaths', 'setLayoutRootPaths' ) )
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

		$v = new \Aimeos\Base\View\Standard( [] );
		$object = new \Aimeos\Base\View\Engine\Typo3( $mock );

		$this->assertEquals( 'test', $object->render( $v, 'filepath', array( 'key' => 'value' ) ) );
	}
}



class T3View
{
	public function setTemplatePathAndFilename( $filepath )
	{
	}

	public function setPartialRootPaths( array $partialRootPaths )
	{
	}

	public function setLayoutRootPaths( array $setLayoutRootPaths )
	{
	}

	public function assignMultiple( array $values )
	{
	}

	public function assign( $key, $value )
	{
	}

	public function render()
	{
	}
}
