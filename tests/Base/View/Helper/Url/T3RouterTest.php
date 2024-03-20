<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2024
 */


namespace Aimeos\Base\View\Helper\Url;


class T3RouterTest extends \PHPUnit\Framework\TestCase
{
	private $view;


	protected function setUp() : void
	{
		if( !interface_exists( '\TYPO3\CMS\Core\Routing\RouterInterface' ) ) {
			$this->markTestSkipped( 'TYPO3 Router not available' );
		}

		$this->view = new \Aimeos\Base\View\Standard();
	}


	protected function tearDown() : void
	{
		unset( $this->view );
	}


	public function testTransform()
	{
		$mock = $this->getMockBuilder( 'TYPO3\CMS\Core\Routing\RouterInterface' )
			->onlyMethods( array( 'generateUri', 'matchRequest' ) )->getMock();

		$stub = $this->getMockBuilder( 'Psr\Http\Message\UriInterface' )->getMock();

		$mock->expects( $this->once() )->method( 'generateUri' )->willReturn( $stub );

		$object = new \Aimeos\Base\View\Helper\Url\T3Router( $this->view, $mock, [] );

		$this->assertEquals( '', $object->transform() );
	}
}
