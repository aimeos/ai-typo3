<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2018
 */


namespace Aimeos\MW\View\Helper\Url;


require_once __DIR__ . DIRECTORY_SEPARATOR . 'UriBuilder';


class T3CliTest extends \PHPUnit\Framework\TestCase
{
	private $view;


	protected function setUp()
	{
		$this->view = new \Aimeos\MW\View\Standard();
	}


	protected function tearDown()
	{
		unset( $this->view );
	}


	public function testTransformAbsolute()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->setMethods( array( 'setCreateAbsoluteUri') )->getMock();

		$mock->expects( $this->once() )->method( 'setCreateAbsoluteUri' )
			->with( $this->equalTo( true ) )->will( $this->returnValue( $mock ) );

		$object = new \Aimeos\MW\View\Helper\Url\T3Cli( $this->view, $mock, [] );

		$this->assertEquals( '', $object->transform() );
	}


	public function testTransformChash()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->setMethods( array( 'setUseCacheHash') )->getMock();

		$mock->expects( $this->once() )->method( 'setUseCacheHash' )
			->with( $this->equalTo( false ) )->will( $this->returnValue( $mock ) );

		$object = new \Aimeos\MW\View\Helper\Url\T3Cli( $this->view, $mock, [] );

		$this->assertEquals( '', $object->transform() );
	}
}
