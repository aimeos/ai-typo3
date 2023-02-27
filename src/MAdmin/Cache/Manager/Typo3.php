<?php

/**
 * @license LGPLv3, http://www.gnu.org/copyleft/lgpl.html
 * @copyright Aimeos (aimeos.org), 2015-2023
 * @package MAdmin
 * @subpackage Cache
 */


namespace Aimeos\MAdmin\Cache\Manager;


/**
 * Cache manager for the TYPO3 cache object.
 *
 * @package MAdmin
 * @subpackage Cache
 */
class Typo3 extends \Aimeos\MAdmin\Cache\Manager\Standard
{
	private \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache;
	private \Aimeos\Base\Cache\Iface $object;


	/**
	 * Sets the cache controller object.
	 *
	 * @param \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache TYPO3 cache object
	 * @return \Aimeos\MAdmin\Cache\Manager\Iface Same object for fluid interface
	 */
	public function setCache( \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache ) : Iface
	{
		$this->cache = $cache;
		return $this;
	}


	/**
	 * Returns the cache object or creates a new one if it doesn't exist yet.
	 *
	 * @return \Aimeos\Base\Cache\Iface Cache object
	 */
	public function getCache() : \Aimeos\Base\Cache\Iface
	{
		if( !isset( $this->object ) ) {
			$this->object = \Aimeos\Base\Cache\Factory::create( 'Typo3', $this->cache );
		}

		return $this->object;
	}
}
