<?php

/**
 * @license LGPLv3, https://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2024
 * @package Base
 * @subpackage Mail
 */


namespace Aimeos\Base\Mail\Manager;


/**
 * TYPO3 mail manager
 *
 * @package Base
 * @subpackage Mail
 */
class Typo3 implements Iface
{
	private \Closure $closure;
	private \Symfony\Component\Mailer\MailerInterface $mailer;

	/**
	 * Initializes the instance of the class.
	 *
	 * @param \Closure $closure Closure generating TYPO3 mail message objects
	 * @param \Symfony\Component\Mailer\MailerInterface $mailer TYPO3 mailer for sending the messages
	 */
	public function __construct( \Closure $closure, \Symfony\Component\Mailer\MailerInterface $mailer )
	{
		$this->closure = $closure;
		$this->mailer = $mailer;
	}


	/**
	 * Returns the mailer for the given name
	 *
	 * @param string|null $name Key for the mailer
	 * @return \Aimeos\Base\Mail\Iface Mail object
	 */
	public function get( ?string $name = null ) : \Aimeos\Base\Mail\Iface
	{
		return new \Aimeos\Base\Mail\Typo3( $this->closure, $this->mailer );
	}
}
