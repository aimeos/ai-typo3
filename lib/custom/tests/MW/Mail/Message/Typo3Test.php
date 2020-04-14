<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2020
 */


namespace Aimeos\MW\Mail\Message;


class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		$this->mock = $this->getMockBuilder( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' )->getMock();
		$this->object = new \Aimeos\MW\Mail\Message\Typo3( $this->mock, 'UTF-8' );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock );
	}


	public function testAddFrom()
	{
		$this->mock->expects( $this->once() )->method( 'addFrom' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->addFrom( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testAddTo()
	{
		$this->mock->expects( $this->once() )->method( 'addTo' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->addTo( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testAddCc()
	{
		$this->mock->expects( $this->once() )->method( 'addCc' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->addCc( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testAddBcc()
	{
		$this->mock->expects( $this->once() )->method( 'addBcc' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->addBcc( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testAddReplyTo()
	{
		$this->mock->expects( $this->once() )->method( 'addReplyTo' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->addReplyTo( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testAddHeader()
	{
		$result = $this->object->addHeader( 'test', 'value' );
//		$this->assertSame( $this->object, $result );
	}


	public function testSend()
	{
		$this->mock->expects( $this->once() )->method( 'send' );
		$this->assertSame( $this->object, $this->object->send() );
	}


	public function testSetSender()
	{
		$this->mock->expects( $this->once() )->method( 'setSender' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->object->setSender( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testSetSubject()
	{
		$this->mock->expects( $this->once() )->method( 'setSubject' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->setSubject( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testSetBody()
	{
		$this->mock->expects( $this->once() )->method( 'text' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->setBody( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testSetBodyHtml()
	{
		$this->mock->expects( $this->once() )->method( 'html' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->setBodyHtml( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testAddAttachment()
	{
		$this->markTestIncomplete( 'Swift_Attachment::newInstance() is not testable' );
	}


	public function testEmbedAttachment()
	{
		$this->markTestIncomplete( 'Swift_EmbeddedFile::newInstance() is not testable' );
	}


	public function testGetObject()
	{
		$this->assertInstanceOf( 'TYPO3\\CMS\\Core\\Mail\\MailMessage', $this->object->getObject() );
	}
}
