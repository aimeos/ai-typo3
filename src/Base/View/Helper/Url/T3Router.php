<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2020-2022
 * @package MW
 * @subpackage View
 */


namespace Aimeos\Base\View\Helper\Url;

use TYPO3\CMS\Core\Routing\RouterInterface;


/**
 * View helper class for building URLs using the page router.
 *
 * @package MW
 * @subpackage View
 */
class T3Router
	extends \Aimeos\Base\View\Helper\Url\Base
	implements \Aimeos\Base\View\Helper\Url\Iface
{
	private $router;
	private $fixed;


	/**
	 * Initializes the URL view helper.
	 *
	 * @param \Aimeos\Base\View\Iface $view View instance with registered view helpers
	 * @param \TYPO3\CMS\Core\Routing\RouterInterface $router TYPO3 page router
	 * @param array $fixed Fixed parameters that should be added to each URL
	 */
	public function __construct( \Aimeos\Base\View\Iface $view, \TYPO3\CMS\Core\Routing\RouterInterface $router, array $fixed )
	{
		parent::__construct( $view );

		$this->router = clone $router;
		$this->fixed = $fixed;
	}


	/**
	 * Returns the URL assembled from the given arguments.
	 *
	 * @param string|null $target Route or page which should be the target of the link (if any)
	 * @param string|null $controller Name of the controller which should be part of the link (if any)
	 * @param string|null $action Name of the action which should be part of the link (if any)
	 * @param array $params Associative list of parameters that should be part of the URL
	 * @param array $trailing Trailing URL parts that are not relevant to identify the resource (for pretty URLs)
	 * @param array $config Additional configuration parameter per URL
	 * @return string Complete URL that can be used in the template
	 */
	public function transform( string $target = null, string $controller = null, string $action = null,
		array $params = [], array $trailing = [], array $config = [] ) : string
	{
		$params['controller'] = $controller !== null ? ucfirst( $controller ) : null;
		$params['action'] = $action;

		if( $params['locale'] ?? null ) {
			$params['L'] = $params['locale'];
		}

		$abs = !empty( $config['absoluteUri'] ) ? RouterInterface::ABSOLUTE_URL : RouterInterface::ABSOLUTE_PATH;

		return (string) $this->router->generateUri( $target, ['ai' => $params] + $this->fixed, join( '/', $trailing ), $abs );
	}
}
