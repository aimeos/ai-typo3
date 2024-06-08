<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2024
 */


namespace Aimeos\Base\Mail\Manager;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $mock;


	protected function setUp() : void
	{
		if( !class_exists( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' ) ) {
			$this->markTestSkipped( 'Class TYPO3\\CMS\\Core\\Mail\\MailMessage not found' );
		}

		$this->mock = $this->getMockBuilder( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' )
			->disableOriginalConstructor()
			->getMock();
	}


	public function testGet()
	{
		$object = new \Aimeos\Base\Mail\Manager\Typo3( fn() => $this->mock );
		$this->assertInstanceOf( \Aimeos\Base\Mail\Iface::class, $object->get( '' ) );
	}
}
