<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2014
 * @copyright Aimeos (aimeos.org), 2014-2018
 * @package MW
 * @subpackage Cache
 */


namespace Aimeos\MW\Cache;


/**
 * TYPO3 caching implementation.
 *
 * @package MW
 * @subpackage Cache
 */
class Typo3
	extends \Aimeos\MW\Cache\Base
	implements \Aimeos\MW\Cache\Iface
{
	private $object;
	private $prefix;


	/**
	 * Initializes the object instance.
	 *
	 * @param array $config List of configuration values
	 * @param \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache TYPO3 cache object
	 */
	public function __construct( array $config, \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache )
	{
		$this->prefix = ( isset( $config['siteid'] ) ? $config['siteid'] . '-' : '' );
		$this->object = $cache;
	}


	/**
	 * Removes the cache entry identified by the given key.
	 *
	 * @inheritDoc
	 *
	 * @param string $key Key string that identifies the single cache entry
	 */
	public function delete( $key )
	{
		$this->object->remove( $this->prefix . $key );
	}


	/**
	 * Removes the cache entries identified by the given keys.
	 *
	 * @inheritDoc
	 *
	 * @param \Traversable|array $keys List of key strings that identify the cache entries
	 * 	that should be removed
	 */
	public function deleteMultiple( $keys )
	{
		foreach( $keys as $key ) {
			$this->object->remove( $this->prefix . $key );
		}
	}


	/**
	 * Removes the cache entries identified by the given tags.
	 *
	 * @inheritDoc
	 *
	 * @param string[] $tags List of tag strings that are associated to one or more
	 * 	cache entries that should be removed
	 */
	public function deleteByTags( array $tags )
	{
		foreach( $tags as $tag ) {
			$this->object->flushByTag( $this->prefix . $tag );
		}
	}


	/**
	 * Removes all entries for the current site from the cache.
	 *
	 * @inheritDoc
	 */
	public function clear()
	{
		if( $this->prefix ) {
			$this->object->flushByTag( $this->prefix . 'siteid' );
		} else {
			$this->object->flush();
		}
	}


	/**
	 * Returns the value of the requested cache key.
	 *
	 * @inheritDoc
	 *
	 * @param string $name Path to the requested value like tree/node/classname
	 * @param string $default Value returned if requested key isn't found
	 * @return mixed Value associated to the requested key
	 */
	public function get( $name, $default = null )
	{
		if( ( $entry = $this->object->get( $this->prefix . $name ) ) !== false ) {
			return $entry;
		}

		return $default;
	}


	/**
	 * Returns the cached values for the given cache keys.
	 *
	 * @inheritDoc
	 *
	 * @param \Traversable|array $keys List of key strings for the requested cache entries
	 * @param mixed $default Default value to return for keys that do not exist
	 * @return array Associative list of key/value pairs for the requested cache
	 * 	entries. If a cache entry doesn't exist, neither its key nor a value
	 * 	will be in the result list
	 */
	public function getMultiple( $keys, $default = null )
	{
		$result = [];

		foreach( $keys as $key )
		{
			if( ( $entry = $this->object->get( $this->prefix . $key ) ) !== false ) {
				$result[$key] = $entry;
			} else {
				$result[$key] = $default;
			}
		}

		return $result;
	}


	/**
	 * Returns the cached keys and values associated to the given tags.
	 *
	 * @inheritDoc
	 *
	 * @param string[] $tags List of tag strings associated to the requested cache entries
	 * @return array Associative list of key/value pairs for the requested cache
	 * 	entries. If a tag isn't associated to any cache entry, nothing is returned
	 * 	for that tag
	 */
	public function getMultipleByTags( array $tags )
	{
		$result = [];
		$len = strlen( $this->prefix );

		foreach( $tags as $tag )
		{
			foreach( $this->object->getByTag( $this->prefix . $tag ) as $key => $value )
			{
				if( strncmp( $key, $this->prefix, $len ) === 0 ) {
					$result[ substr( $key, $len ) ] = $value;
				} else {
					$result[$key] = $value;
				}

			}
		}

		return $result;
	}


	/**
	 * Sets the value for the given key in the cache.
	 *
	 * @inheritDoc
	 *
	 * @param string $key Key string for the given value like product/id/123
	 * @param mixed $value Value string that should be stored for the given key
	 * @param int|string|null $expires Date/time string in "YYYY-MM-DD HH:mm:ss"
	 * 	format or as TTL value when the cache entry expires
	 * @param array $tags List of tag strings that should be assoicated to the
	 * 	given value in the cache
	 */
	public function set( $key, $value, $expires = null, array $tags = [] )
	{
		if( is_string( $expires ) ) {
			$expires = date_create( $expires )->getTimestamp() - time();
		}

		$tagList = ( $this->prefix ? array( $this->prefix . 'siteid' ) : [] );

		foreach( $tags as $tag ) {
			$tagList[] = $this->prefix . $tag;
		}

		$this->object->set( $this->prefix . $key, $value, $tagList, $expires );
	}


	/**
	 * Adds or overwrites the given key/value pairs in the cache, which is much
	 * more efficient than setting them one by one using the set() method.
	 *
	 * @inheritDoc
	 *
	 * @param \Traversable|array $pairs Associative list of key/value pairs. Both must be
	 * 	a string
	 * @param array|int|string|null $expires Associative list of keys and datetime
	 *  string or integer TTL pairs.
	 * @param array $tags Associative list of key/tag or key/tags pairs that
	 *  should be associated to the values identified by their key. The value
	 *  associated to the key can either be a tag string or an array of tag strings
	 */
	public function setMultiple( $pairs, $expires = null, array $tags = [] )
	{
		foreach( $pairs as $key => $value )
		{
			$tagList = ( isset( $tags[$key] ) ? (array) $tags[$key] : [] );
			$keyExpire = ( isset( $expires[$key] ) ? $expires[$key] : $expires );

			$this->set( $key, $value, $keyExpire, $tagList );
		}
	}
}
