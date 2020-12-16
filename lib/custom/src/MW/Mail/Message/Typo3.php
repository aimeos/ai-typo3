<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2020
 * @package MW
 * @subpackage Mail
 */


namespace Aimeos\MW\Mail\Message;


/**
 * Zend implementation for creating e-mails.
 *
 * @package MW
 * @subpackage Mail
 */
class Typo3 implements \Aimeos\MW\Mail\Message\Iface
{
	private $charset;
	private $object;


	/**
	 * Initializes the message instance.
	 *
	 * @param \TYPO3\CMS\Core\Mail\MailMessage $object TYPO3 mail object
	 * @param string $charset Default charset of the message
	 */
	public function __construct( \TYPO3\CMS\Core\Mail\MailMessage $object, string $charset )
	{
		$this->charset = $charset;
		$this->object = $object;
	}


	/**
	 * Adds a source e-mail address of the message.
	 *
	 * @param string $email Source e-mail address
	 * @param string|null $name Name of the user sending the e-mail or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addFrom( string $email, string $name = null ) : Iface
	{
		$class = '\Symfony\Component\Mime\Email';

		if( class_exists( $class ) && $this->object instanceof $class ) {
			$this->object->addFrom( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
		} else {
			$this->object->addFrom( $email, $name );
		}

		return $this;
	}


	/**
	 * Adds a destination e-mail address of the target user mailbox.
	 *
	 * @param string $email Destination address of the target mailbox
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addTo( string $email, string $name = null ) : Iface
	{
		$class = '\Symfony\Component\Mime\Email';

		if( class_exists( $class ) && $this->object instanceof $class ) {
			$this->object->addTo( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
		} else {
			$this->object->addTo( $email, $name );
		}

		return $this;
	}


	/**
	 * Adds a destination e-mail address for a copy of the message.
	 *
	 * @param string $email Destination address for a copy
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addCc( string $email, string $name = null ) : Iface
	{
		$class = '\Symfony\Component\Mime\Email';

		if( class_exists( $class ) && $this->object instanceof $class ) {
			$this->object->addCc( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
		} else {
			$this->object->addCc( $email, $name );
		}

		return $this;
	}


	/**
	 * Adds a destination e-mail address for a hidden copy of the message.
	 *
	 * @param string $email Destination address for a hidden copy
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addBcc( string $email, string $name = null ) : Iface
	{
		$class = '\Symfony\Component\Mime\Email';

		if( class_exists( $class ) && $this->object instanceof $class ) {
			$this->object->addBcc( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
		} else {
			$this->object->addBcc( $email, $name );
		}

		return $this;
	}


	/**
	 * Adds the return e-mail address for the message.
	 *
	 * @param string $email E-mail address which should receive all replies
	 * @param string|null $name Name of the user which should receive all replies or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addReplyTo( string $email, string $name = null ) : Iface
	{
		$class = '\Symfony\Component\Mime\Email';

		if( class_exists( $class ) && $this->object instanceof $class ) {
			$this->object->addReplyTo( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
		} else {
			$this->object->addReplyTo( $email, $name );
		}

		return $this;
	}


	/**
	 * Adds a custom header to the message.
	 *
	 * @param string $name Name of the custom e-mail header
	 * @param string $value Text content of the custom e-mail header
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addHeader( string $name, string $value ) : Iface
	{
		$class = '\Symfony\Component\Mime\Email';

		if( class_exists( $class ) && $this->object instanceof $class ) {
			$this->object->getHeaders()->add( new \Symfony\Component\Mime\Header\UnstructuredHeader( $name, $value ) );
		} else {
			$this->object->getHeaders()->addTextHeader( $name, $value );
		}

		return $this;
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function send() : Iface
	{
		$this->object->send();
		return $this;
	}


	/**
	 * Sets the e-mail address and name of the sender of the message (higher precedence than "From").
	 *
	 * @param string $email Source e-mail address
	 * @param string|null $name Name of the user who sent the message or null for no name
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function setSender( string $email, string $name = null ) : Iface
	{
		$class = '\Symfony\Component\Mime\Email';

		if( class_exists( $class ) && $this->object instanceof $class ) {
			$this->object->setSender( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
		} else {
			$this->object->setSender( $email, $name );
		}

		return $this;
	}


	/**
	 * Sets the subject of the message.
	 *
	 * @param string $subject Subject of the message
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function setSubject( string $subject ) : Iface
	{
		$class = '\Symfony\Component\Mime\Email';

		if( class_exists( $class ) && $this->object instanceof $class ) {
			$this->object->setSubject( $subject );
		} else {
			$this->object->setSubject( $subject );
		}

		return $this;
	}


	/**
	 * Sets the text body of the message.
	 *
	 * @param string $message Text body of the message
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function setBody( string $message ) : Iface
	{
		$class = '\Symfony\Component\Mime\Email';

		if( class_exists( $class ) && $this->object instanceof $class ) {
			$this->object->text( $message, $this->charset );
		} elseif( class_exists( '\Swift_Mailer' ) ) {
			$this->object->setBody( $message );
		}

		return $this;
	}


	/**
	 * Sets the HTML body of the message.
	 *
	 * @param string $message HTML body of the message
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function setBodyHtml( string $message ) : Iface
	{
		$class = '\Symfony\Component\Mime\Email';

		if( class_exists( $class ) && $this->object instanceof $class ) {
			$this->object->html( $message, $this->charset );
		} elseif( class_exists( '\Swift_Mailer' ) ) {
			$this->object->addPart( $message, 'text/html' );
		}

		return $this;
	}


	/**
	 * Adds an attachment to the message.
	 *
	 * @param string $data Binary or string
	 * @param string $mimetype Mime type of the attachment (e.g. "text/plain", "application/octet-stream", etc.)
	 * @param string|null $filename Name of the attached file (or null if inline disposition is used)
	 * @param string $disposition Type of the disposition ("attachment" or "inline")
	 * @return \Aimeos\MW\Mail\Message\Iface Message object
	 */
	public function addAttachment( string $data, string $mimetype, string $filename, string $disposition = 'attachment' ) : Iface
	{
		$class = '\Symfony\Component\Mime\Email';

		if( class_exists( $class ) && $this->object instanceof $class )
		{
			$this->object->attach( $data, $filename, $mimetype );
			return $this;
		}

		if( class_exists( '\Swift_Attachment' ) )
		{
			$part = \Swift_Attachment::newInstance( $data, $filename, $mimetype );
			$part->setDisposition( $disposition );
			$this->object->attach( $part );
			return $this;
		}

		throw new \RuntimeException( 'Symfony mailer or Swiftmailer package missing' );
	}


	/**
	 * Embeds an attachment into the message and returns its reference.
	 *
	 * @param string $data Binary or string
	 * @param string $mimetype Mime type of the attachment (e.g. "text/plain", "application/octet-stream", etc.)
	 * @param string|null $filename Name of the attached file
	 * @return string Content ID for referencing the attachment in the HTML body
	 */
	public function embedAttachment( string $data, string $mimetype, string $filename ) : string
	{
		$class = '\Symfony\Component\Mime\Email';

		if( !$filename ) {
			$filename = md5( $data );
		}

		if( class_exists( $class ) && $this->object instanceof $class )
		{
			$this->object->embed( $data, $filename, $mimetype );
			return 'cid:' . $filename;
		}
		elseif( class_exists( '\Swift_EmbeddedFile' ) )
		{
			$part = \Swift_EmbeddedFile::newInstance( $data, $filename, $mimetype );
			return $this->object->embed( $part );
		}

		throw new \RuntimeException( 'Symfony mailer or Swiftmailer package missing' );
	}


	/**
	 * Returns the internal TYPO3 mail message object.
	 *
	 * @return TYPO3\CMS\Core\Mail\MailMessage TYPO3 mail message object
	 */
	public function getObject() : \TYPO3\CMS\Core\Mail\MailMessage
	{
		return $this->object;
	}


	/**
	 * Clones the internal objects.
	 */
	public function __clone()
	{
		$this->object = clone $this->object;
	}
}
