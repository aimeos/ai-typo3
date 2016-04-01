<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
 */


require_once __DIR__ . DIRECTORY_SEPARATOR . 'MailMessage';


class MW_Mail_Typo3Test extends MW_Unittest_Testcase
{
	private $_object;
	private $_mock;


	protected function setUp()
	{
		$this->_mock = $this->getMock( 'TYPO3\\CMS\\Core\\Mail\\MailMessage' );
		$this->_object = new MW_Mail_Typo3( $this->_mock );
	}


	public function testCreateMessage()
	{
		$result = $this->_object->createMessage( 'ISO-8859-1' );
		$this->assertInstanceOf( 'MW_Mail_Message_Interface', $result );
	}


	public function testSend()
	{
		$this->_object->send( $this->_object->createMessage() );
	}

}
