<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


/**
 * TYPO3 mail stub required for tests.
 */
class T3lib_Mail_Message
{
	public function setCharset( $charset )
	{
	}

	public function addFrom( $email, $name )
	{
	}

	public function addTo( $email, $name = null )
	{
	}

	public function addCc( $email, $name = null )
	{
	}

	public function addBcc( $email, $name = null )
	{
	}

	public function addReplyTo( $email, $name = null )
	{
	}

	public function setSender( $email, $name = null )
	{
	}

	public function setSubject( $subject )
	{
	}

	public function setBody( $message )
	{
	}

	public function addPart( $message, $mimetype )
	{
	}

	public function getHeaders()
	{
	}

	public function send()
	{
	}
}
