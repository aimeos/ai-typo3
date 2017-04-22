<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2014-2017
 * @package MW
 * @subpackage View
 */


namespace Aimeos\MW\View\Helper\Url;


use TYPO3\CMS\Core\Utility\ArrayUtility;


/**
 * View helper class for building URLs.
 *
 * @package MW
 * @subpackage View
 */
class Typo3
	extends \Aimeos\MW\View\Helper\Url\Base
	implements \Aimeos\MW\View\Helper\Url\Iface
{
	private $uriBuilder;
	private $prefix;
	private $fixed;


	/**
	 * Initializes the URL view helper.
	 *
	 * @param \Aimeos\MW\View\Iface $view View instance with registered view helpers
	 * @param \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder $uriBuilder TYPO3 URI builder
	 * @param array $fixed Fixed parameters that should be added to each URL
	 */
	public function __construct( \Aimeos\MW\View\Iface $view, \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder $uriBuilder, array $fixed )
	{
		parent::__construct( $view );

		$this->prefix = $uriBuilder->getArgumentPrefix();
		$this->uriBuilder = $uriBuilder;
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
	public function transform( $target = null, $controller = null, $action = null, array $params = [], array $trailing = [], array $config = [] )
	{
		$arguments = $this->fixed;
		$arguments['controller'] = ucfirst( $controller );
		$arguments['action'] = $action;

		$values = $this->getValues( $config );

		if( isset( $config['eID'] ) )
		{
			// set required config
			$values['type'] = 0;
			$values['chash'] = false;

			// handle parameters
			$arguments = $arguments + $params;

			$params = [];
			$params['eID'] = $config['eID'];

			if( isset( $config['format'] ) ) {
				$params['format'] = $config['format'];
			}

			$params = $params + $arguments;
		}
		else
		{
			if( $this->prefix != '' )
			{
				if( $values['namespace'] === true ) {
					$params = array( $this->prefix => $arguments + $params );
				} else {
					$params = $params + array( $this->prefix => $arguments );
				}
			}
		}

		$params = $this->sanitize( $params );

		$this->uriBuilder
			->reset()
			->setTargetPageUid( $target )
			->setSection( join( '/', $trailing ) )
			->setCreateAbsoluteUri( $values['absoluteUri'] )
			->setTargetPageType( $values['type'] )
			->setUseCacheHash( $values['chash'] )
			->setNoCache( $values['nocache'] )
			->setFormat( $values['format'] )
			->setArguments( $params );

		if( isset( $config['BE'] ) && $config['BE'] == true ) {
			return $this->uriBuilder->buildBackendUri();
		}

		return $this->uriBuilder->buildFrontendUri();
	}


	/**
	 * Returns the sanitized configuration values.
	 *
	 * @param array $config Associative list of key/value pairs
	 * @return array Associative list of sanitized key/value pairs
	 */
	protected function getValues( array $config )
	{
		$values = array(
			'plugin' => null,
			'extension' => null,
			'absoluteUri' => false,
			'namespace' => true,
			'nocache' => false,
			'chash' => false,
			'format' => '',
			'type' => 0,
		);

		if( isset( $config['plugin'] ) ) {
			$values['plugin'] = (string) $config['plugin'];
		}

		if( isset( $config['extension'] ) ) {
			$values['extension'] = (string) $config['extension'];
		}

		if( isset( $config['absoluteUri'] ) ) {
			$values['absoluteUri'] = (bool) $config['absoluteUri'];
		}

		if( isset( $config['namespace'] ) ) {
			$values['namespace'] = (bool) $config['namespace'];
		}

		if( isset( $config['nocache'] ) ) {
			$values['nocache'] = (bool) $config['nocache'];
		}

		if( isset( $config['chash'] ) ) {
			$values['chash'] = (bool) $config['chash'];
		}

		if( isset( $config['type'] ) ) {
			$values['type'] = (int) $config['type'];
		}

		if( isset( $config['format'] ) ) {
			$values['format'] = (string) $config['format'];
		}

		return $values;
	}
}
