<?php

/**
 * @license LGPLv3, http://www.gnu.org/copyleft/lgpl.html
 * @copyright Aimeos (aimeos.org), 2015-2021
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
	implements \Aimeos\MW\Cache\Iface
{
	private $object;
	private $context;
	private $cache;


	/**
	 * Initializes the cache controller.
	 *
	 * @param \Aimeos\MShop\Context\Item\Iface $context MShop context object
	 * @param \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache Flow cache object
	 */
	public function __construct( \Aimeos\MShop\Context\Item\Iface $context, \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache )
	{
		$this->context = $context;
		$this->cache = $cache;
	}


	/**
	 * Returns the cache object or creates a new one if it doesn't exist yet.
	 *
	 * @return \Aimeos\MW\Cache\Iface Cache object
	 */
	protected function getObject() : \Aimeos\MW\Cache\Iface
	{
		if( !isset( $this->object ) )
		{
			$siteid = $this->context->getLocale()->getSiteItem()->getId() . $this->retrievePageType();
			$conf = array( 'siteid' => $this->context->getConfig()->get( 'madmin/cache/prefix' ) . $siteid );
			$this->object = \Aimeos\MW\Cache\Factory::create( 'Typo3', $conf, $this->cache );
		}

		return $this->object;
	}


	/**
	 * Retrieve the page type.
	 *
	 * @return string The page type, if available.
	 */
	protected function retrievePageType() : string
	{
		// Try to access it from the Aimeos middleware.
		if( method_exists( \Aimeos\Aimeos\Middleware\PageRoutingHandler::class, 'getRoutingPageArguments' ) ) {
			$arguments = \Aimeos\Aimeos\Middleware\PageRoutingHandler::getRoutingPageArguments();
			if( $arguments !== null ) {
				return '-' . (int) $arguments->getPageType();
			}
		}

		// Fallback to the globals.
		if( isset( $GLOBALS['TYPO3_REQUEST'] ) === true
			&& $GLOBALS['TYPO3_REQUEST'] instanceof \Psr\Http\Message\ServerRequestInterface
			&& $GLOBALS['TYPO3_REQUEST']->getAttribute('routing') !== null
		) {
			return '-' . (int) $GLOBALS['TYPO3_REQUEST']->getAttribute( 'routing' )->getPageType();
		}

		// Unable to retrieve the page type.
		return '';
	}
}
