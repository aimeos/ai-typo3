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
	private $cache;
	private $object;


	/**
	 * Initializes the cache controller.
	 *
	 * @param \Aimeos\MShop\ContextIface $context MShop context object
	 * @param \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache TYPO3 cache object
	 */
	public function __construct( \Aimeos\MShop\ContextIface $context, \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache )
	{
		parent::__construct( $this->context );

		$this->cache = $cache;
	}


	/**
	 * Returns the cache object or creates a new one if it doesn't exist yet.
	 *
	 * @return \Aimeos\Base\Cache\Iface Cache object
	 */
	protected function object() : \Aimeos\Base\Cache\Iface
	{
		if( !isset( $this->object ) ) {
			$this->object = \Aimeos\Base\Cache\Factory::create( 'Typo3', $this->cache );
		}

		return $this->object;
	}
}
