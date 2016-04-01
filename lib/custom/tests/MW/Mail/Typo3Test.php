<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


namespace Aimeos\MW\Mail;


require_once __DIR__ . DIRECTORY_SEPARATOR . 'MailMessage';


class Typo3Test extends \PHPUnit_Framework_TestCase
{
	private $object;
	private $mock;


	protected function setUp()
	{
		$this->mock = $this->getMock( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' );
		$this->object = new \Aimeos\MW\Mail\Typo3( $this->mock );
	}


	public function testCreateMessage()
	{
		$result = $this->object->createMessage( 'ISO-8859-1' );
		$this->assertInstanceOf( '\\Aimeos\\MW\\Mail\\Message\\Iface', $result );
	}


	public function testSend()
	{
		$this->object->send( $this->object->createMessage() );
	}

}
