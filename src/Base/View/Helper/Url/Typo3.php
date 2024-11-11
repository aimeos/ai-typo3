<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2014-2023
 * @package MW
 * @subpackage View
 */


namespace Aimeos\Base\View\Helper\Url;


/**
 * View helper class for building URLs.
 *
 * @package MW
 * @subpackage View
 */
class Typo3
	extends \Aimeos\Base\View\Helper\Url\Base
	implements \Aimeos\Base\View\Helper\Url\Iface
{
	private \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder $uriBuilder;
	private ?string $prefix;
	private array $fixed;


	/**
	 * Initializes the URL view helper.
	 *
	 * @param \Aimeos\Base\View\Iface $view View instance with registered view helpers
	 * @param \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder $uriBuilder TYPO3 URI builder
	 * @param array $fixed Fixed parameters that should be added to each URL
	 */
	public function __construct( \Aimeos\Base\View\Iface $view, \TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder $uriBuilder, array $fixed )
	{
		parent::__construct( $view );

		$this->prefix = $uriBuilder->getArgumentPrefix();
		$this->uriBuilder = clone $uriBuilder;
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
	public function transform( ?string $target = null, ?string $controller = null, ?string $action = null,
		array $params = [], array $trailing = [], array $config = [] ) : string
	{
		$locale = $this->getValue( $params, 'locale' );
		$params['controller'] = $controller !== null ? ucfirst( $controller ) : null;
		$params['action'] = $action;

		if( $this->prefix != '' && (bool) $this->getValue( $config, 'namespace', true ) === true ) {
			$params = [$this->prefix => $params];
		}
		$params += $this->fixed;

		if( ( $eid = $this->getValue( $config, 'eID' ) ) !== null ) {
			$params['eID'] = $eid;
		}

		if( $locale !== null ) {
			$params['L'] = $locale;
		}

		$useCHash = (bool) $this->getValue( $config, 'chash', false );

		$this->uriBuilder->reset()
			->setTargetPageUid( (int) ( $target ?: ( $GLOBALS['TSFE']->id ?? 0 ) ) )
			->setCreateAbsoluteUri( (bool) $this->getValue( $config, 'absoluteUri', false ) )
			->setTargetPageType( (int) $this->getValue( $config, 'type', 0 ) )
			->setNoCache( (bool) $this->getValue( $config, 'nocache', false ) )
			->setFormat( (string) $this->getValue( $config, 'format', '' ) )
			->setArguments( $this->sanitize( $params ) )
			->setSection( join( '/', $trailing ) );

		if( (bool) $this->getValue( $config, 'BE', false ) === true ) {
			return (string) $this->uriBuilder->buildBackendUri();
		}

		$url = (string) $this->uriBuilder->buildFrontendUri();
		return $useCHash ? $url : preg_replace( '/\&cHash=[0-9a-f]{32}/', '', $url );
	}


	/**
	 * Returns the sanitized configuration values.
	 *
	 * @param array $config Associative list of key/value pairs
	 * @param string $key Key of the value to retrieve
	 * @param mixed $default Default value if value for key isn't found
	 * @return mixed Configuration value for the given key or default value
	 */
	protected function getValue( array $config, string $key, $default = null )
	{
		if( isset( $config[$key] ) ) {
			return $config[$key];
		}

		return $default;
	}
}
