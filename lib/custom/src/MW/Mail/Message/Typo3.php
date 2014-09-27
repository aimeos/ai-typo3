<?php

/**
 * @copyright Copyright (c) Metaways Infosystems GmbH, 2013
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @package MW
 * @subpackage Mail
 */


/**
 * Zend implementation for creating e-mails.
 *
 * @package MW
 * @subpackage Mail
 */
class MW_Mail_Message_Typo3 implements MW_Mail_Message_Interface
{
	private $_object;


	/**
	 * Initializes the message instance.
	 *
	 * @param t3lib_mail_Message $object TYPO3 mail object
	 * @param string $charset Default charset of the message
	 */
	public function __construct( t3lib_mail_Message $object, $charset )
	{
		$object->setCharset( $charset );

		$this->_object = $object;
	}


	/**
	 * Adds a source e-mail address of the message.
	 *
	 * @param string $email Source e-mail address
	 * @param string|null $name Name of the user sending the e-mail or null for no name
	 * @return MW_Mail_Message_Interface Message object
	 */
	public function addFrom( $email, $name = null )
	{
		$this->_object->addFrom( $email, $name );
		return $this;
	}


	/**
	 * Adds a destination e-mail address of the target user mailbox.
	 *
	 * @param string $email Destination address of the target mailbox
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return MW_Mail_Message_Interface Message object
	 */
	public function addTo( $email, $name = null )
	{
		$this->_object->addTo( $email, $name );
		return $this;
	}


	/**
	 * Adds a destination e-mail address for a copy of the message.
	 *
	 * @param string $email Destination address for a copy
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return MW_Mail_Message_Interface Message object
	 */
	public function addCc( $email, $name = null )
	{
		$this->_object->addCc( $email, $name );
		return $this;
	}


	/**
	 * Adds a destination e-mail address for a hidden copy of the message.
	 *
	 * @param string $email Destination address for a hidden copy
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return MW_Mail_Message_Interface Message object
	 */
	public function addBcc( $email, $name = null )
	{
		$this->_object->addBcc( $email, $name );
		return $this;
	}


	/**
	 * Adds the return e-mail address for the message.
	 *
	 * @param string $email E-mail address which should receive all replies
	 * @param string|null $name Name of the user which should receive all replies or null for no name
	 * @return MW_Mail_Message_Interface Message object
	 */
	public function addReplyTo( $email, $name = null )
	{
		$this->_object->addReplyTo( $email, $name );
		return $this;
	}


	/**
	 * Adds a custom header to the message.
	 *
	 * @param string $name Name of the custom e-mail header
	 * @param string $value Text content of the custom e-mail header
	 * @return MW_Mail_Message_Interface Message object
	 */
	public function addHeader( $name, $value )
	{
		$hs = $this->_object->getHeaders();
		$hs->addTextHeader( $name, $value );
		return $this;
	}


	/**
	 * Sets the e-mail address and name of the sender of the message (higher precedence than "From").
	 *
	 * @param string $email Source e-mail address
	 * @param string|null $name Name of the user who sent the message or null for no name
	 * @return MW_Mail_Message_Interface Message object
	 */
	public function setSender( $email, $name = null )
	{
		$this->_object->setSender( $email, $name );
		return $this;
	}


	/**
	 * Sets the subject of the message.
	 *
	 * @param string $subject Subject of the message
	 * @return MW_Mail_Message_Interface Message object
	 */
	public function setSubject( $subject )
	{
		$this->_object->setSubject( $subject );
		return $this;
	}


	/**
	 * Sets the text body of the message.
	 *
	 * @param string $message Text body of the message
	 * @return MW_Mail_Message_Interface Message object
	 */
	public function setBody( $message )
	{
		$this->_object->setBody( $message );
		return $this;
	}


	/**
	 * Sets the HTML body of the message.
	 *
	 * @param string $message HTML body of the message
	 * @return MW_Mail_Message_Interface Message object
	 */
	public function setBodyHtml( $message )
	{
		$this->_object->addPart( $message, 'text/html' );
		return $this;
	}


	/**
	 * Adds an attachment to the message.
	 *
	 * @param string $data Binary or string
	 * @param string $mimetype Mime type of the attachment (e.g. "text/plain", "application/octet-stream", etc.)
	 * @param string|null $filename Name of the attached file (or null if inline disposition is used)
	 * @param string $disposition Type of the disposition ("attachment" or "inline")
	 * @return MW_Mail_Message_Interface Message object
	 */
	public function addAttachment( $data, $mimetype, $filename, $disposition = 'attachment' )
	{
		$part = Swift_Attachment::newInstance( $data, $filename, $mimetype );
		$part->setDisposition( $disposition );

		$this->_object->attach( $part );
		return $this;
	}


	/**
	 * Embeds an attachment into the message and returns its reference.
	 *
	 * @param string $data Binary or string
	 * @param string $mimetype Mime type of the attachment (e.g. "text/plain", "application/octet-stream", etc.)
	 * @param string|null $filename Name of the attached file
	 * @return string Content ID for referencing the attachment in the HTML body
	 */
	public function embedAttachment( $data, $mimetype, $filename )
	{
		$part = Swift_EmbeddedFile::newInstance( $data, $mimetype, $filename );

		return $this->_object->embed( $part );
	}


	/**
	 * Returns the internal Zend mail object.
	 *
	 * @return Zend_Mail Zend mail object
	 */
	public function getObject()
	{
		return $this->_object;
	}


	/**
	 * Clones the internal objects.
	 */
	public function __clone()
	{
		$this->_object = clone $this->_object;
	}
}
