<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2013
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @package MW
 * @subpackage Mail
 */


/**
 * TYPO3 implementation for creating and sending e-mails.
 *
 * @package MW
 * @subpackage Mail
 */
class MW_Mail_Typo3 implements MW_Mail_Interface
{
	private $_object;


	/**
	 * Initializes the instance of the class.
	 *
	 * @param t3lib_mail_Message $object TYPO3 mail object
	 */
	public function __construct( t3lib_mail_Message $object )
	{
		$this->_object = $object;
	}


	/**
	 * Creates a new e-mail message object.
	 *
	 * @param string $charset Default charset of the message
	 * @return MW_Mail_Message_Interface E-mail message object
	 */
	public function createMessage( $charset = 'UTF-8' )
	{
		return new MW_Mail_Message_Typo3( clone $this->_object, $charset );
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @param MW_Mail_Message_Interface $message E-mail message object
	 */
	public function send( MW_Mail_Message_Interface $message )
	{
		$message->getObject()->send();
	}


	/**
	 * Clones the internal objects.
	 */
	public function __clone()
	{
		$this->_object = clone $this->_object;
	}
}
