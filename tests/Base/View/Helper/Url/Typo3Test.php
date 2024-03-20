<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2024
 */


namespace Aimeos\Base\View\Helper\Url;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $view;


	protected function setUp() : void
	{
		if( !class_exists( '\TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder' ) ) {
			$this->markTestSkipped( 'TYPO3 UriBuilder not available' );
		}

		$this->view = new \Aimeos\Base\View\Standard();
	}


	protected function tearDown() : void
	{
		unset( $this->view );
	}


	public function testTransform()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->onlyMethods( ['buildFrontendUri'] )->getMock();

		$mock->expects( $this->once() )->method( 'buildFrontendUri' );

		$fixed = ['site' => 'unittest'];
		$object = new \Aimeos\Base\View\Helper\Url\Typo3( $this->view, $mock, $fixed );

		$this->assertEquals( '', $object->transform() );
	}


	public function testTransformAbsolute()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->onlyMethods( ['setCreateAbsoluteUri', 'buildFrontendUri'] )->getMock();

		$mock->expects( $this->once() )->method( 'setCreateAbsoluteUri' )
			->with( $this->equalTo( true ) )->willReturn( $mock );

		$mock->expects( $this->once() )->method( 'buildFrontendUri' )->willReturn( '' );

		$object = new \Aimeos\Base\View\Helper\Url\Typo3( $this->view, $mock, [] );

		$config = ['absoluteUri' => 1];
		$this->assertEquals( '', $object->transform( null, null, null, [], [], $config ) );
	}


	public function testTransformNocache()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->onlyMethods( ['setNoCache', 'buildFrontendUri'] )->getMock();

		$mock->expects( $this->once() )->method( 'setNoCache' )
			->with( $this->equalTo( true ) )->willReturn( $mock );

		$mock->expects( $this->once() )->method( 'buildFrontendUri' )->willReturn( '' );

		$object = new \Aimeos\Base\View\Helper\Url\Typo3( $this->view, $mock, [] );

		$config = ['nocache' => 1];
		$this->assertEquals( '', $object->transform( null, null, null, [], [], $config ) );
	}


	public function testTransformType()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->onlyMethods( ['setTargetPageType', 'buildFrontendUri'] )->getMock();

		$mock->expects( $this->once() )->method( 'setTargetPageType' )
			->with( $this->equalTo( 123 ) )->willReturn( $mock );

		$mock->expects( $this->once() )->method( 'buildFrontendUri' )->willReturn( '' );

		$object = new \Aimeos\Base\View\Helper\Url\Typo3( $this->view, $mock, [] );

		$config = ['type' => 123];
		$this->assertEquals( '', $object->transform( null, null, null, [], [], $config ) );
	}


	public function testTransformFormat()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->onlyMethods( ['setFormat', 'buildFrontendUri'] )->getMock();

		$mock->expects( $this->once() )->method( 'setFormat' )
			->with( $this->equalTo( 'xml' ) )->willReturn( $mock );

		$mock->expects( $this->once() )->method( 'buildFrontendUri' )->willReturn( '' );

		$object = new \Aimeos\Base\View\Helper\Url\Typo3( $this->view, $mock, [] );

		$config = ['format' => 'xml'];
		$this->assertEquals( '', $object->transform( null, null, null, [], [], $config ) );
	}


	public function testTransformEID()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->onlyMethods( ['setArguments', 'buildFrontendUri'] )->getMock();

		$param = ['eID' => 123, 'controller' => '', 'action' => null];

		$mock->expects( $this->once() )->method( 'setArguments' )
			->with( $this->equalTo( $param ) )->willReturn( $mock );

		$mock->expects( $this->once() )->method( 'buildFrontendUri' )->willReturn( '' );

		$object = new \Aimeos\Base\View\Helper\Url\Typo3( $this->view, $mock, [] );

		$config = ['eID' => 123];
		$this->assertEquals( '', $object->transform( null, null, null, [], [], $config ) );
	}


	public function testTransformLocale()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->onlyMethods( ['setArguments', 'buildFrontendUri'] )->getMock();

		$param = ['L' => 'de', 'controller' => '', 'action' => null, 'locale' => 'de'];

		$mock->expects( $this->once() )->method( 'setArguments' )
			->with( $this->equalTo( $param ) )->willReturn( $mock );

		$mock->expects( $this->once() )->method( 'buildFrontendUri' )->willReturn( '' );

		$object = new \Aimeos\Base\View\Helper\Url\Typo3( $this->view, $mock, [] );

		$params = ['locale' => 'de'];
		$this->assertEquals( '', $object->transform( null, null, null, $params ) );
	}


	public function testTransformBackend()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
		->onlyMethods( ['buildBackendUri'] )->getMock();

		$mock->expects( $this->once() )->method( 'buildBackendUri' );

		$object = new \Aimeos\Base\View\Helper\Url\Typo3( $this->view, $mock, ['site' => 'unittest'] );

		$params = ['test' => 'my/value'];
		$this->assertEquals( '', $object->transform( null, null, null, $params, [], ['BE' => 1] ) );
	}


	public function testTransformParams()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->onlyMethods( ['buildFrontendUri'] )->getMock();

		$mock->expects( $this->once() )->method( 'buildFrontendUri' );

		$object = new \Aimeos\Base\View\Helper\Url\Typo3( $this->view, $mock, ['site' => 'unittest'] );

		$params = ['test' => 'my/value'];
		$this->assertEquals( '', $object->transform( null, null, null, $params ) );
	}


	public function testTransformNoNamespace()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->onlyMethods( ['buildFrontendUri', 'getArgumentPrefix'] )->getMock();

		$mock->expects( $this->once() )->method( 'buildFrontendUri' );
		$mock->expects( $this->once() )->method( 'getArgumentPrefix' )->willReturn( 'ai' );

		$object = new \Aimeos\Base\View\Helper\Url\Typo3( $this->view, $mock, ['site' => 'unittest'] );

		$params = ['test' => 'my/value'];
		$config = ['namespace' => false];
		$this->assertEquals( '', $object->transform( null, null, null, $params, [], $config ) );
	}


	public function testTransformUnchangedOriginalUriBuilder()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Extbase\\Mvc\\Web\\Routing\\UriBuilder' )
			->onlyMethods( ['reset', 'buildFrontendUri'] )->getMock();

		$mock->expects( $this->once() )->method( 'reset' )->willReturn( $mock );
		$mock->expects( $this->once() )->method( 'buildFrontendUri' )->willReturn( '' );

		$object = new \Aimeos\Base\View\Helper\Url\Typo3( $this->view, $mock, [] );

		$mock->expects( $this->never() )->method( 'reset' );
		$this->assertEquals( '', $object->transform( null, null, null, [], [], [] ) );
	}
}
