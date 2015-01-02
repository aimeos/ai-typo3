<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015
 */


namespace TYPO3\CMS\Extbase\Mvc\Web\Routing;

class UriBuilder
{
	/**
	 * @param string|null $action
	 * @param string $controller
	 */
	public function uriFor( $action, array $params, $controller, $extension, $plugin )
	{
		return '';
	}

	public function reset()
	{
		return $this;
	}

	/**
	 * @param string|null $target
	 */
	public function setTargetPageUid( $target )
	{
		return $this;
	}

	/**
	 * @param integer $pageType
	 */
	public function setTargetPageType( $pageType )
	{
		return $this;
	}

	/**
	 * @param boolean $absoluteUri
	 */
	public function setCreateAbsoluteUri( $absoluteUri )
	{
		return $this;
	}

	public function setArguments( $additional )
	{
		return $this;
	}

	/**
	 * @param boolean $chash
	 */
	public function setUseCacheHash( $chash )
	{
		return $this;
	}

	/**
	 * @param boolean $nocache
	 */
	public function setNoCache( $nocache )
	{
		return $this;
	}

	public function setFormat( $format )
	{
		return $this;
	}

	public function setSection( $trailing )
	{
		return $this;
	}
}
