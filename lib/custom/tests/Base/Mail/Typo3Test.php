<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2022
 */


namespace Aimeos\Base\Mail;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		if( !class_exists( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' ) ) {
			$this->markTestSkipped( 'Class TYPO3\\CMS\\Core\\Mail\\MailMessage not found' );
		}

		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' )
			->disableOriginalConstructor()
			->getMock();

		$this->object = new \Aimeos\Base\Mail\Typo3( function() use ( $mock ) { return $mock; } );
		$this->mock = $mock;
	}


	public function testCreate()
	{
		$result = $this->object->create( 'ISO-8859-1' );
		$this->assertInstanceOf( '\\Aimeos\\Base\\Mail\\Message\\Iface', $result );
	}


	public function testSend()
	{
		$this->mock->expects( $this->once() )->method( 'send' );

		$this->object->send( $this->object->create() );
	}

}
