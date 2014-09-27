<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


/**
 * TYPO3 mail stub required for tests.
 */
class T3lib_Mail_Message
{
	/**
	 * @param string $charset
	 */
	public function setCharset( $charset )
	{
	}

	/**
	 * @param string $email
	 * @param string|null $name
	 */
	public function addFrom( $email, $name )
	{
	}

	/**
	 * @param string $email
	 * @param string $name
	 */
	public function addTo( $email, $name = null )
	{
	}

	/**
	 * @param string $email
	 * @param string $name
	 */
	public function addCc( $email, $name = null )
	{
	}

	/**
	 * @param string $email
	 * @param string $name
	 */
	public function addBcc( $email, $name = null )
	{
	}

	/**
	 * @param string $email
	 * @param string $name
	 */
	public function addReplyTo( $email, $name = null )
	{
	}

	/**
	 * @param string $email
	 * @param string $name
	 */
	public function setSender( $email, $name = null )
	{
	}

	/**
	 * @param string $subject
	 */
	public function setSubject( $subject )
	{
	}

	/**
	 * @param string $message
	 */
	public function setBody( $message )
	{
	}

	/**
	 * @param string $message
	 * @param string $mimetype
	 */
	public function addPart( $message, $mimetype )
	{
	}

	public function getHeaders()
	{
		return new Test_HeaderSet();
	}

	public function send()
	{
	}

	public function attach( $part )
	{
	}

	public function embed( $part )
	{
	}
}
