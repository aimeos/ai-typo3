<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 */


namespace Aimeos\MW\View\Helper\Url;


class T3CliTest extends \PHPUnit_Framework_TestCase
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


	public function testTransform()
	{
		$fixed = array( 'site' => 'unittest' );
		$object = new \Aimeos\MW\View\Helper\Url\T3Cli( $this->view, 'index.php', '', $fixed );

		$url = $object->transform( 1, 'catalog', 'detail', array(), array(), array() );
		$this->assertEquals( 'index.php?id=1&site=unittest&controller=catalog&action=detail', $url );
	}


	public function testTransformAbsolute()
	{
		$config = array( 'absoluteUri' => 1 );
		$fixed = array( 'site' => 'unittest' );
		$object = new \Aimeos\MW\View\Helper\Url\T3Cli( $this->view, 'http://localhost/index.php', '', $fixed );

		$url = $object->transform( 1, null, null, array(), array(), $config );
		$this->assertEquals( 'http://localhost/index.php?id=1&site=unittest', $url );
	}


	public function testTransformNocache()
	{
		$object = new \Aimeos\MW\View\Helper\Url\T3Cli( $this->view, 'index.php', 'ai', array() );

		$url = $object->transform( 1, null, null, array(), array(), array( 'nocache' => 1 ) );
		$this->assertEquals( 'index.php?id=1&no_cache=1', $url );
	}


	public function testTransformNamespace()
	{
		$object = new \Aimeos\MW\View\Helper\Url\T3Cli( $this->view, 'index.php', 'ai', array() );

		$url = $object->transform( 1, 'catalog', 'detail', array( 'key' => 'value' ), array(), array() );
		$this->assertEquals( 'index.php?id=1&ai%5Bcontroller%5D=catalog&ai%5Baction%5D=detail&ai%5Bkey%5D=value', $url );
	}


	public function testTransformType()
	{
		$object = new \Aimeos\MW\View\Helper\Url\T3Cli( $this->view, 'index.php', 'ai', array() );

		$url = $object->transform( 1, null, null, array(), array(), array( 'type' => 123 ) );
		$this->assertEquals( 'index.php?id=1&type=123', $url );
	}


	public function testTransformEID()
	{
		$object = new \Aimeos\MW\View\Helper\Url\T3Cli( $this->view, 'index.php', 'ai', array() );

		$url = $object->transform( 1, null, null, array(), array(), array( 'eID' => 10 ) );
		$this->assertEquals( 'index.php?id=1&eID=10', $url );
	}
}
