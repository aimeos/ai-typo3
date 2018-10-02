<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2011
 * @copyright Aimeos (aimeos.org), 2014-2018
 * @package MW
 * @subpackage Session
 */


namespace Aimeos\MW\Session;


/**
 * Managing session data using the TYPO3 session
 *
 * @package MW
 * @subpackage Session
 */
class Typo3 implements \Aimeos\MW\Session\Iface
{
	private $user;


	/**
	 * Initializes the Typo3 session object.
	 *
	 * @param \TYPO3\CMS\Core\Authentication\AbstractUserAuthentication $user Typo3 user object (FE or BE)
	 */
	public function __construct( \TYPO3\CMS\Core\Authentication\AbstractUserAuthentication $user )
	{
		$this->user = $user;
	}


	/**
	 * Returns the value of the requested session key.
	 *
	 * If the returned value wasn't a string, it's decoded from its serialized
	 * representation.
	 *
	 * @param string $name Key of the requested value in the session
	 * @param mixed $default Value returned if requested key isn't found
	 * @return mixed Value associated to the requested key
	 */
	public function get( $name, $default = null )
	{
		if( ( $value = $this->user->getSessionData( $name ) ) !== null ) {
			return $value;
		}

		return $default;
	}


	/**
	 * Sets the value for the specified key.
	 *
	 * If the value isn't a string, it's encoded into a serialized representation
	 * and decoded again when using the get() method.
	 *
	 * @param string $name Key to the value which should be stored in the session
	 * @param mixed $value Value that should be associated with the given key
	 * @return void
	 */
	public function set( $name, $value )
	{
		$this->user->setAndSaveSessionData( $name, $value );
	}
}
