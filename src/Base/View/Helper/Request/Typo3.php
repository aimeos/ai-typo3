<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Aimeos (aimeos.org), 2015-2023
 * @package MW
 * @subpackage View
 */


namespace Aimeos\Base\View\Helper\Request;


/**
 * View helper class for accessing request data from Flow
 *
 * @package MW
 * @subpackage View
 */
class Typo3
	extends \Aimeos\Base\View\Helper\Request\Standard
	implements \Aimeos\Base\View\Helper\Request\Iface
{
	private ?string $target;
	private ?string $ip;


	/**
	 * Initializes the request view helper.
	 *
	 * @param \Aimeos\Base\View\Iface $view View instance with registered view helpers
	 * @param string|null TYPO3 target page ID
	 * @param array $files List of uploaded files like in $_FILES
	 * @param array $query List of uploaded files like in $_GET
	 * @param array $post List of uploaded files like in $_POST
	 * @param array $cookies List of uploaded files like in $_COOKIES
	 * @param array $server List of uploaded files like in $_SERVER
	 */
	public function __construct( \Aimeos\Base\View\Iface $view, ?string $target = null, array $files = [],
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
	public function getClientAddress() : string
	{
		return $this->ip;
	}


	/**
	 * Returns the current page or route name
	 *
	 * @return string|null Current page ID
	 */
	public function getTarget() : ?string
	{
		return $this->target;
	}


	/**
	 * Creates a PSR-7 compatible request
	 *
	 * @param array $files List of uploaded files like in $_FILES
	 * @param array $query List of uploaded files like in $_GET
	 * @param array $post List of uploaded files like in $_POST
	 * @param array $cookies List of uploaded files like in $_COOKIES
	 * @param array $server List of uploaded files like in $_SERVER
	 * @return \Psr\Http\Message\ServerRequestInterface PSR-7 request object
	 */
	protected function createRequest( array $files, array $query, array $post, array $cookies, array $server ) : \Psr\Http\Message\ServerRequestInterface
	{
		if( !isset( $server['HTTP_HOST'] ) ) {
			$server['HTTP_HOST'] = 'localhost';
		}

		$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();

		$creator = new \Nyholm\Psr7Server\ServerRequestCreator(
			$psr17Factory, // ServerRequestFactory
			$psr17Factory, // UriFactory
			$psr17Factory, // UploadedFileFactory
			$psr17Factory  // StreamFactory
		);

		return $creator->fromGlobals();
	}
}
