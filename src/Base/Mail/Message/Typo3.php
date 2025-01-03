<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2025
 * @package Base
 * @subpackage Mail
 */


namespace Aimeos\Base\Mail\Message;


/**
 * TYPO3 implementation for creating e-mails.
 *
 * @package Base
 * @subpackage Mail
 */
class Typo3 implements \Aimeos\Base\Mail\Message\Iface
{
	private \TYPO3\CMS\Core\Mail\MailMessage $object;
	private string $charset;


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
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function from( string $email, ?string $name = null ) : Iface
	{
		if( $email )
		{
			$class = '\Symfony\Component\Mime\Email';

			if( class_exists( $class ) && $this->object instanceof $class ) {
				$this->object->addFrom( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
			} else {
				$this->object->addFrom( $email, $name );
			}
		}

		return $this;
	}


	/**
	 * Adds a destination e-mail address of the target user mailbox.
	 *
	 * @param string $email Destination address of the target mailbox
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function to( string $email, ?string $name = null ) : Iface
	{
		if( $email )
		{
			$class = '\Symfony\Component\Mime\Email';

			if( class_exists( $class ) && $this->object instanceof $class ) {
				$this->object->addTo( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
			} else {
				$this->object->addTo( $email, $name );
			}
		}

		return $this;
	}


	/**
	 * Adds a destination e-mail address for a copy of the message.
	 *
	 * @param string $email Destination address for a copy
	 * @param string|null $name Name of the user owning the target mailbox or null for no name
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function cc( string $email, ?string $name = null ) : Iface
	{
		if( $email )
		{
			$class = '\Symfony\Component\Mime\Email';

			if( class_exists( $class ) && $this->object instanceof $class ) {
				$this->object->addCc( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
			} else {
				$this->object->addCc( $email, $name );
			}
		}

		return $this;
	}


	/**
	 * Adds a destination e-mail address for a hidden copy of the message.
	 *
	 * @param array|string $email Destination address for a hidden copy
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function bcc( $email ) : Iface
	{
		if( !empty( $email ) )
		{
			$class = '\Symfony\Component\Mime\Email';

			foreach( (array) $email as $addr )
			{
				if( class_exists( $class ) && $this->object instanceof $class ) {
					$this->object->addBcc( new \Symfony\Component\Mime\Address( $addr ) );
				} else {
					$this->object->addBcc( $addr );
				}
			}
		}

		return $this;
	}


	/**
	 * Adds the return e-mail address for the message.
	 *
	 * @param string $email E-mail address which should receive all replies
	 * @param string|null $name Name of the user which should receive all replies or null for no name
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function replyTo( string $email, ?string $name = null ) : Iface
	{
		if( $email )
		{
			$class = '\Symfony\Component\Mime\Email';

			if( class_exists( $class ) && $this->object instanceof $class ) {
				$this->object->addReplyTo( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
			} else {
				$this->object->addReplyTo( $email, $name );
			}
		}

		return $this;
	}


	/**
	 * Adds a custom header to the message.
	 *
	 * @param string $name Name of the custom e-mail header
	 * @param string $value Text content of the custom e-mail header
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function header( string $name, string $value ) : Iface
	{
		if( $name )
		{
			$class = '\Symfony\Component\Mime\Email';

			if( class_exists( $class ) && $this->object instanceof $class ) {
				$this->object->getHeaders()->add( new \Symfony\Component\Mime\Header\UnstructuredHeader( $name, $value ) );
			} else {
				$this->object->getHeaders()->addTextHeader( $name, $value );
			}
		}

		return $this;
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
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
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function sender( string $email, ?string $name = null ) : Iface
	{
		if( $email )
		{
			$class = '\Symfony\Component\Mime\Email';

			if( class_exists( $class ) && $this->object instanceof $class ) {
				$this->object->setSender( new \Symfony\Component\Mime\Address( $email, (string) $name ) );
			} else {
				$this->object->setSender( $email, $name );
			}
		}

		return $this;
	}


	/**
	 * Sets the subject of the message.
	 *
	 * @param string $subject Subject of the message
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function subject( string $subject ) : Iface
	{
		if( $subject )
		{
			$class = '\Symfony\Component\Mime\Email';

			if( class_exists( $class ) && $this->object instanceof $class ) {
				$this->object->setSubject( $subject );
			} else {
				$this->object->setSubject( $subject );
			}
		}

		return $this;
	}


	/**
	 * Sets the text body of the message.
	 *
	 * @param string $message Text body of the message
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function text( string $message ) : Iface
	{
		if( $message )
		{
			$class = '\Symfony\Component\Mime\Email';

			if( class_exists( $class ) && $this->object instanceof $class ) {
				$this->object->text( $message, $this->charset );
			} elseif( class_exists( '\Swift_Mailer' ) ) {
				$this->object->setBody( $message );
			}
		}

		return $this;
	}


	/**
	 * Sets the HTML body of the message.
	 *
	 * @param string $message HTML body of the message
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function html( string $message ) : Iface
	{
		if( $message )
		{
			$class = '\Symfony\Component\Mime\Email';

			if( class_exists( $class ) && $this->object instanceof $class ) {
				$this->object->html( $message, $this->charset );
			} elseif( class_exists( '\Swift_Mailer' ) ) {
				$this->object->addPart( $message, 'text/html' );
			}
		}

		return $this;
	}


	/**
	 * Adds an attachment to the message.
	 *
	 * @param string|null $data Binary or string @author nose
	 * @param string|null $filename Name of the attached file (or null if inline disposition is used)
	 * @param string|null $mimetype Mime type of the attachment (e.g. "text/plain", "application/octet-stream", etc.)
	 * @param string $disposition Type of the disposition ("attachment" or "inline")
	 * @return \Aimeos\Base\Mail\Message\Iface Message object
	 */
	public function attach( ?string $data, ?string $filename = null, ?string $mimetype = null, string $disposition = 'attachment' ) : Iface
	{
		if( $data )
		{
			$class = '\Symfony\Component\Mime\Email';
			$mimetype = $mimetype ?: (new \finfo( FILEINFO_MIME_TYPE ))->buffer( $data );
			$filename = $filename ?: md5( $data );

			if( class_exists( $class ) && $this->object instanceof $class )
			{
				$this->object->attach( $data, $filename, $mimetype );
			}
			elseif( class_exists( '\Swift_Attachment' ) )
			{
				$part = \Swift_Attachment::newInstance( $data, $filename, $mimetype );
				$part->setDisposition( $disposition );
				$this->object->attach( $part );
			}
			else
			{
				throw new \RuntimeException( 'Symfony mailer or Swiftmailer package missing' );
			}
		}

		return $this;
	}


	/**
	 * Embeds an attachment into the message and returns its reference.
	 *
	 * @param string|null $data Binary or string
	 * @param string|null $filename Name of the attached file
	 * @param string|null $mimetype Mime type of the attachment (e.g. "text/plain", "application/octet-stream", etc.)
	 * @return string Content ID for referencing the attachment in the HTML body
	 */
	public function embed( ?string $data, ?string $filename = null, ?string $mimetype = null ) : string
	{
		if( $data )
		{
			$class = '\Symfony\Component\Mime\Email';
			$mimetype = $mimetype ?: (new \finfo( FILEINFO_MIME_TYPE ))->buffer( $data );
			$filename = $filename ?: md5( $data );

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
			else
			{
				throw new \RuntimeException( 'Symfony mailer or Swiftmailer package missing' );
			}
		}

		return '';
	}


	/**
	 * Returns the internal TYPO3 mail message object.
	 *
	 * @return \TYPO3\CMS\Core\Mail\MailMessage TYPO3 mail message object
	 */
	public function object() : \TYPO3\CMS\Core\Mail\MailMessage
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
