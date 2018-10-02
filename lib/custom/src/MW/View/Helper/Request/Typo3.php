<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2018
 * @package MW
 * @subpackage View
 */


namespace Aimeos\MW\View\Helper\Request;

use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\ServerRequest;
use Zend\Diactoros\Stream;


/**
 * View helper class for accessing request data from Flow
 *
 * @package MW
 * @subpackage View
 */
class Typo3
	extends \Aimeos\MW\View\Helper\Request\Standard
	implements \Aimeos\MW\View\Helper\Request\Iface
{
	private $ip;
	private $target;


	/**
	 * Initializes the request view helper.
	 *
	 * @param \Aimeos\MW\View\Iface $view View instance with registered view helpers
	 * @param string|null TYPO3 target page ID
	 * @param array $files List of uploaded files like in $_FILES
	 * @param array $query List of uploaded files like in $_GET
	 * @param array $post List of uploaded files like in $_POST
	 * @param array $cookies List of uploaded files like in $_COOKIES
	 * @param array $server List of uploaded files like in $_SERVER
	 */
	public function __construct( \Aimeos\MW\View\Iface $view, $target = null, array $files = [],
		array $query = [], array $post = [], array $cookies = [], array $server = [] )
	{
		$this->target = $target;
		$this->ip = ( isset( $server['REMOTE_ADDR'] ) ? $server['REMOTE_ADDR'] : null );

		$psr7request = $this->createRequest( $files, $query, $post, $cookies, $server );

		parent::__construct( $view, $psr7request );
	}


	/**
	 * Returns the client IP address.
	 *
	 * @return string Client IP address
	 */
	public function getClientAddress()
	{
		return $this->ip;
	}


	/**
	 * Returns the current page or route name
	 *
	 * @return string|null Current page ID
	 */
	public function getTarget()
	{
		return $this->target;
	}


	/**
	 * Creates a PSR-7 compatible request
	 *
	 * @param \TYPO3\Flow\Http\Request $nativeRequest Flow request object
	 * @param array $files List of uploaded files like in $_FILES
	 * @param array $query List of uploaded files like in $_GET
	 * @param array $post List of uploaded files like in $_POST
	 * @param array $cookies List of uploaded files like in $_COOKIES
	 * @param array $server List of uploaded files like in $_SERVER
	 * @return \Psr\Http\Message\ServerRequestInterface PSR-7 request object
	 */
	protected function createRequest( array $files, array $query, array $post, array $cookies, array $server )
	{
		if( !isset( $server['HTTP_HOST'] ) ) {
			$server['HTTP_HOST'] = 'localhost';
		}

		$files = ServerRequestFactory::normalizeFiles( $files );
		$server = ServerRequestFactory::normalizeServer( $server );
		$headers = ServerRequestFactory::marshalHeaders( $server );
		$uri = ServerRequestFactory::marshalUriFromServer( $server, $headers );
		$method = ServerRequestFactory::get('REQUEST_METHOD', $server, 'GET');

		return new ServerRequest( $server, $files, $uri, $method, 'php://input', $headers, $cookies, $query, $post );
	}
}
