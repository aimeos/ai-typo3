<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2013
 * @copyright Aimeos (aimeos.org), 2014-2023
 * @package Base
 * @subpackage Mail
 */


namespace Aimeos\Base\Mail;


/**
 * TYPO3 implementation for creating and sending e-mails.
 *
 * @package Base
 * @subpackage Mail
 */
class Typo3 implements \Aimeos\Base\Mail\Iface
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
	 * @return \Aimeos\Base\Mail\Message\Iface E-mail message object
	 */
	public function create( string $charset = 'UTF-8' ) : \Aimeos\Base\Mail\Message\Iface
	{
		$closure = $this->closure;
		return new \Aimeos\Base\Mail\Message\Typo3( $closure(), $charset );
	}


	/**
	 * Sends the e-mail message to the mail server.
	 *
	 * @param \Aimeos\Base\Mail\Message\Iface $message E-mail message object
	 */
	public function send( \Aimeos\Base\Mail\Message\Iface $message ) : Iface
	{
		$message->object()->send();
		return $this;
	}
}
