<?php

/**
 * @license LGPLv3, http://www.gnu.org/copyleft/lgpl.html
 * @copyright Aimeos (aimeos.org), 2015-2022
 * @package MAdmin
 * @subpackage Cache
 */


namespace Aimeos\MAdmin\Cache\Proxy;


/**
 * Cache proxy for creating the TYPO3 cache object on demand.
 *
 * @package MAdmin
 * @subpackage Cache
 */
class Typo3
	extends \Aimeos\MAdmin\Cache\Proxy\Standard
	implements \Aimeos\Base\Cache\Iface
{
	private $object;
	private $context;
	private $cache;


	/**
	 * Initializes the cache controller.
	 *
	 * @param \Aimeos\MShop\ContextIface $context MShop context object
	 * @param \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache Flow cache object
	 */
	public function __construct( \Aimeos\MShop\ContextIface $context, \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache )
	{
		$this->context = $context;
		$this->cache = $cache;
	}


	/**
	 * Returns the cache object or creates a new one if it doesn't exist yet.
	 *
	 * @return \Aimeos\Base\Cache\Iface Cache object
	 */
	protected function object() : \Aimeos\Base\Cache\Iface
	{
		if( !isset( $this->object ) )
		{
			$siteid = $this->context->locale()->getSiteItem()->getId();
			$conf = array( 'siteid' => $this->context->config()->get( 'madmin/cache/prefix' ) . $siteid );
			$this->object = \Aimeos\Base\Cache\Factory::create( 'Typo3', $conf, $this->cache );
		}

		return $this->object;
	}
}