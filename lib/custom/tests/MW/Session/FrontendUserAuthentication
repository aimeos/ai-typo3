<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


namespace TYPO3\CMS\Frontend\Authentication;


class FrontendUserAuthentication
{
	private $_session = array();

	/**
	 * @param string $type
	 * @param string $key
	*/
	public function getKey( $type , $key )
	{
		if ( isset($this->_session[$key]) ) {
			return $this->_session[$key];
		}
	}

	/**
	 * @param string $type
	 * @param string $key
	 */
	public function setKey( $type , $key , $data )
	{
		$this->_session[$key] = $data;
	}

	public function storeSessionData()
	{
	}
}
