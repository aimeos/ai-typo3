<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2016
 */


namespace Aimeos\MW\Mail;


require_once __DIR__ . DIRECTORY_SEPARATOR . 'MailMessage';


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp()
	{
		$mock = $this->getMockBuilder( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' )->getMock();
		$this->object = new \Aimeos\MW\Mail\Typo3( function() use ( $mock ) { return $mock; } );
		$this->mock = $mock;
	}


	public function testCreateMessage()
	{
		$result = $this->object->createMessage( 'ISO-8859-1' );
		$this->assertInstanceOf( '\\Aimeos\\MW\\Mail\\Message\\Iface', $result );
	}


	public function testSend()
	{
		$this->mock->expects( $this->once() )->method( 'send' );

		$this->object->send( $this->object->createMessage() );
	}

}
