<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2026
 */


namespace Aimeos\Base\Mail\Message;


#[\PHPUnit\Framework\Attributes\AllowMockObjectsWithoutExpectations]
class Typo3Test extends \PHPUnit\Framework\TestCase
{
	private $object;
	private $mock;


	protected function setUp() : void
	{
		if( !class_exists( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' ) ) {
			$this->markTestSkipped( 'Class TYPO3\\CMS\\Core\\Mail\\MailMessage not found' );
		}

		$this->mock = $this->getMockBuilder( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' )
			->disableOriginalConstructor()
			->getMock();

		$this->object = new \Aimeos\Base\Mail\Message\Typo3( $this->mock, 'UTF-8' );
	}


	protected function tearDown() : void
	{
		unset( $this->object, $this->mock );
	}


	public function testFrom()
	{
		$this->mock->expects( $this->once() )->method( 'addFrom' );

		$result = $this->object->from( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testTo()
	{
		$this->mock->expects( $this->once() )->method( 'addTo' );

		$result = $this->object->to( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testCc()
	{
		$this->mock->expects( $this->once() )->method( 'addCc' );

		$result = $this->object->cc( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testBcc()
	{
		$this->mock->expects( $this->once() )->method( 'addBcc' );

		$result = $this->object->bcc( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testReplyTo()
	{
		$this->mock->expects( $this->once() )->method( 'addReplyTo' );

		$result = $this->object->replyTo( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testSend()
	{
		$this->mock->expects( $this->once() )->method( 'send' );
		$this->assertSame( $this->object, $this->object->send() );
	}


	public function testSender()
	{
		$this->mock->expects( $this->once() )->method( 'setSender' );

		$result = $this->object->sender( 'a@b', 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testSubject()
	{
		$this->mock->expects( $this->once() )->method( 'setSubject' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->subject( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testText()
	{
		$this->mock->expects( $this->once() )->method( 'text' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->text( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testHtml()
	{
		$this->mock->expects( $this->once() )->method( 'html' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->html( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testAttach()
	{
		$this->mock->expects( $this->once() )->method( 'attach' );

		$result = $this->object->attach( 'test', 'test.txt', 'text/plain' );
		$this->assertSame( $this->object, $result );
	}


	public function testEmbed()
	{
		$this->mock->expects( $this->once() )->method( 'embed' );

		$result = $this->object->embed( 'test', 'test.txt', 'text/plain' );
		$this->assertEquals( 'cid:test.txt', $result );
	}


	public function testObject()
	{
		$this->assertInstanceOf( 'TYPO3\\CMS\\Core\\Mail\\MailMessage', $this->object->object() );
	}
}
