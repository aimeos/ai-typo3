<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2023
 */


namespace Aimeos\MAdmin\Cache\Manager;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $context;
	private $stub;


	protected function setUp() : void
	{
		$context = \TestHelper::context();
		$this->stub = $this->getMockBuilder( \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface::class )->getMock();

		$this->object = new \Aimeos\MAdmin\Cache\Manager\Typo3( $context );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->stub );
	}


	public function testSetCache()
	{
		$this->assertInstanceOf( \Aimeos\MAdmin\Cache\Manager\Iface::class, $this->object->setCache( $this->stub ) );
	}


	public function testGetCache()
	{
		$this->object->setCache( $this->stub );
		$this->assertInstanceOf( \Aimeos\Base\Cache\Iface::class, $this->object->getCache() );
	}
}
