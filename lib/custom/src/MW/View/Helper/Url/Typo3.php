<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2012
 * @copyright Aimeos (aimeos.org), 2014
 * @package MW
 * @subpackage View
 */


/**
 * View helper class for building URLs.
 *
 * @package MW
 * @subpackage View
 */
class MW_View_Helper_Url_Typo3
	extends MW_View_Helper_Abstract
	implements MW_View_Helper_Interface
{
	private $_uriBuilder;


	/**
	 * Initializes the URL view helper.
	 *
	 * @param MW_View_Interface $view View instance with registered view helpers
	 * @param Tx_Extbase_MVC_Web_Routing_UriBuilder $uriBuilder TYPO3 URI builder
	 */
	public function __construct( MW_View_Interface $view, Tx_Extbase_MVC_Web_Routing_UriBuilder $uriBuilder )
	{
		parent::__construct( $view );

		$this->_uriBuilder = $uriBuilder;
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
		$additional = array();
		if( isset( $config['eID'] ) ) {
			$additional['eID'] = $config['eID'];
		}

		$values = $this->_getValues( $config );

		$this->_uriBuilder
			->reset()
			->setTargetPageUid( $target )
			->setSection( join( '/', $trailing ) )
			->setCreateAbsoluteUri( $values['absoluteUri'] )
			->setTargetPageType( $values['type'] )
			->setUseCacheHash( $values['chash'] )
			->setNoCache( $values['nocache'] )
			->setFormat( $values['format'] )
			->setArguments( $additional );

		// Slashes in URL parameters confuses the router
		foreach( $params as $key => $value ) {
			$params[$key] = str_replace( '/', '', $value );
		}

		return $this->_uriBuilder->uriFor( $action, $params, ucfirst( $controller ) );
	}


	/**
	 * Returns the sanitized configuration values.
	 *
	 * @param array $config Associative list of key/value pairs
	 * @return array Associative list of sanitized key/value pairs
	 */
	protected function _getValues( array $config )
	{
		$values = array(
			'absoluteUri' => false,
			'nocache' => false,
			'chash' => true,
			'format' => '',
			'type' => 0,
		);

		if( isset( $config['absoluteUri'] ) ) {
			$values['absoluteUri'] = (bool) $config['absoluteUri'];
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