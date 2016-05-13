<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2016
 * @package MW
 * @subpackage View
 */


namespace Aimeos\MW\View\Helper\Url;


/**
 * TYPO3 view helper class for building URLs on the command line
 *
 * @package MW
 * @subpackage View
 */
class T3Cli
	extends \Aimeos\MW\View\Helper\Url\Base
	implements \Aimeos\MW\View\Helper\Url\Iface
{
	private $baseurl;
	private $prefix;
	private $fixed;


	/**
	 * Initializes the URL view helper.
	 *
	 * @param \Aimeos\MW\View\Iface $view View instance with registered view helpers
	 * @param string $baseurl Base URL, e.g. http://localhost/index.php
	 * @param string $prefix Argument prefix, e.g. "ai" for "ai[key]=value"
	 * @param array $fixed Fixed parameters that should be added to each URL
	 */
	public function __construct( \Aimeos\MW\View\Iface $view, $baseurl, $prefix, array $fixed )
	{
		\Aimeos\MW\View\Helper\Base::__construct( $view );

		$this->baseurl = $baseurl;
		$this->prefix = $prefix;
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
	public function transform( $target = null, $controller = null, $action = null, array $params = array(), array $trailing = array(), array $config = array() )
	{
		$arguments = $this->fixed;
		$arguments['controller'] = $controller;
		$arguments['action'] = $action;

		if( $this->prefix )
		{
			if( isset( $config['namespace'] ) && $config['namespace'] == false ) {
				$params = $params + array( $this->prefix => $arguments );
			} else {
				$params = array( $this->prefix => array_merge( $arguments, $params ) );
			}
		}
		else
		{
			$params = array_merge( $params, $arguments );
		}

		$params = array_merge( $params, $this->getValues( $config ) );
		$params = $this->sanitize( $params );

		return $this->baseurl . '?id=' . $target . '&' . http_build_query( $params );
	}


	/**
	 * Returns the sanitized configuration values.
	 *
	 * @param array $config Associative list of key/value pairs
	 * @return array Associative list of sanitized key/value pairs
	 */
	protected function getValues( array $config )
	{
		$values = array();

		if( isset( $config['plugin'] ) ) {
			$values['plugin'] = (string) $config['plugin'];
		}

		if( isset( $config['extension'] ) ) {
			$values['extension'] = (string) $config['extension'];
		}

		if( isset( $config['nocache'] ) ) {
			$values['no_cache'] = (bool) $config['nocache'];
		}

		if( isset( $config['type'] ) ) {
			$values['type'] = (int) $config['type'];
		}

		if( isset( $config['eID'] ) ) {
			$values['eID'] = $config['eID'];
		}

		return $values;
	}
}
