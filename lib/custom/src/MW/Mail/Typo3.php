<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014
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
	private $object;


	/**
	 * Initializes the instance of the class.
	 *
	 * @param TYPO3\CMS\Core\Mail\MailMessage $object TYPO3 mail object
	 */
	public function __construct( TYPO3\CMS\Core\Mail\MailMessage $object )
	{
		$this->object = $object;
	}


	/**
	 * Creates a new e-mail message object.
	 *
	 * @param string $charset Default charset of the message
	 * @return MW_Mail_Message_Interface E-mail message object
	 */
	public function createMessage( $charset = 'UTF-8' )
	{
		return new MW_Mail_Message_Typo3( clone $this->object, $charset );
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
		$this->object = clone $this->object;
	}
}
