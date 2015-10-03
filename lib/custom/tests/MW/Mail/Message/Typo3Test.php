<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


require_once dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'MailMessage';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Test_HeaderSet.php';


class MW_Mail_Message_Typo3Test extends PHPUnit_Framework_TestCase
{
	private $object;
	private $mock;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		$this->mock = $this->getMock( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' );
		$this->object = new MW_Mail_Message_Typo3( $this->mock, 'UTF-8' );
	}

	/**
	 * Tears down the fixture, for example, closes a network connection.
	 * This method is called after a test is executed.
	 *
	 * @access protected
	 */
	protected function tearDown()
	{
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
		$headersMock = $this->getMock( 'Test_HeaderSet' );

		$this->mock->expects( $this->once() )->method( 'getHeaders' )
			->will( $this->returnValue( $headersMock ) );

		$headersMock->expects( $this->once() )->method( 'addTextHeader' )
			->with( $this->stringContains( 'test' ), $this->stringContains( 'value' ) );

		$result = $this->object->addHeader( 'test', 'value' );
		$this->assertSame( $this->object, $result );
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
		$this->mock->expects( $this->once() )->method( 'setBody' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->object->setBody( 'test' );
		$this->assertSame( $this->object, $result );
	}


	public function testSetBodyHtml()
	{
		$this->mock->expects( $this->once() )->method( 'addPart' )
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
