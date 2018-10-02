<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2018
 * @package MW
 * @subpackage Mail
 */


namespace Aimeos\MW\Mail;


/**
 * TYPO3 implementation for creating and sending e-mails.
 *
 * @package MW
 * @subpackage Mail
 */
class Typo3 implements \Aimeos\MW\Mail\Iface
{
	private $closure;

	/**
	 * Initializes the instance of the class.
	 *
	 * @param \Closure $closure Closure generating TYPO3 mail message objects
	 */
	public function __construct( \Closure $closure )
	{
		$this->closure = $closure;
	}


	/**
	 * Creates a new e-mail message object.
	 *
	 * @param string $charset Default charset of the message
	 * @return \Aimeos\MW\Mail\Message\Iface E-mail message object
	 */
	public function createMessage( $charset = 'UTF-8' )
	{
		$closure = $this->closure;
		return new \Aimeos\MW\Mail\Message\Typo3( $closure(), $charset );
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @param \Aimeos\MW\Mail\Message\Iface $message E-mail message object
	 */
	public function send( \Aimeos\MW\Mail\Message\Iface $message )
	{
		$message->getObject()->send();
	}
}
