<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


require_once dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'MailMessage';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'Test_HeaderSet.php';


class MW_Mail_Message_Typo3Test extends MW_Unittest_Testcase
{
	private $_object;
	private $_mock;


	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 *
	 * @access protected
	 */
	protected function setUp()
	{
		$this->_mock = $this->getMock( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' );
		$this->_object = new MW_Mail_Message_Typo3( $this->_mock, 'UTF-8' );
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
		$this->_mock->expects( $this->once() )->method( 'addFrom' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->addFrom( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testAddTo()
	{
		$this->_mock->expects( $this->once() )->method( 'addTo' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->addTo( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testAddCc()
	{
		$this->_mock->expects( $this->once() )->method( 'addCc' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->addCc( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testAddBcc()
	{
		$this->_mock->expects( $this->once() )->method( 'addBcc' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->addBcc( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testAddReplyTo()
	{
		$this->_mock->expects( $this->once() )->method( 'addReplyTo' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->addReplyTo( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testAddHeader()
	{
		$headersMock = $this->getMock( 'Test_HeaderSet' );

		$this->_mock->expects( $this->once() )->method( 'getHeaders' )
			->will( $this->returnValue( $headersMock ) );

		$headersMock->expects( $this->once() )->method( 'addTextHeader' )
			->with( $this->stringContains( 'test' ), $this->stringContains( 'value' ) );

		$result = $this->_object->addHeader( 'test', 'value' );
		$this->assertSame( $this->_object, $result );
	}


	public function testSetSender()
	{
		$this->_mock->expects( $this->once() )->method( 'setSender' )
			->with( $this->stringContains( 'a@b' ), $this->stringContains( 'test' ) );

		$result = $this->_object->setSender( 'a@b', 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testSetSubject()
	{
		$this->_mock->expects( $this->once() )->method( 'setSubject' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->_object->setSubject( 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testSetBody()
	{
		$this->_mock->expects( $this->once() )->method( 'setBody' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->_object->setBody( 'test' );
		$this->assertSame( $this->_object, $result );
	}


	public function testSetBodyHtml()
	{
		$this->_mock->expects( $this->once() )->method( 'addPart' )
			->with( $this->stringContains( 'test' ) );

		$result = $this->_object->setBodyHtml( 'test' );
		$this->assertSame( $this->_object, $result );
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
		$this->assertInstanceOf( 'TYPO3\\CMS\\Core\\Mail\\MailMessage', $this->_object->getObject() );
	}
}
