<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 * @copyright Metaways Infosystems GmbH, 2014
 * @copyright Aimeos (aimeos.org), 2014-2023
 * @package MW
 * @subpackage Cache
 */


namespace Aimeos\Base\Cache;


/**
 * TYPO3 caching implementation.
 *
 * @package MW
 * @subpackage Cache
 */
class Typo3
	extends \Aimeos\Base\Cache\Base
	implements \Aimeos\Base\Cache\Iface
{
	private $object;
	private $prefix;


	/**
	 * Initializes the object instance.
	 *
	 * @param array $config List of configuration values
	 * @param \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache TYPO3 cache object
	 * @deprecated 2022.01 Remove $config parameter and siteid prefix
	 */
	public function __construct( array $config, \TYPO3\CMS\Core\Cache\Frontend\FrontendInterface $cache )
	{
		$this->prefix = ( isset( $config['siteid'] ) ? $config['siteid'] . '-' : '' );
		$this->object = $cache;
	}


	/**
	 * Removes all expired cache entries.
	 *
	 * @inheritDoc
	 *
	 * @return bool True on success and false on failure
	 */
	public function cleanup() : bool
	{
		$this->object->collectGarbage();
		return true;
	}


	/**
	 * Removes all entries for the current site from the cache.
	 *
	 * @inheritDoc
	 *
	 * @return bool True on success and false on failure
	 */
	public function clear() : bool
	{
		if( $this->prefix ) {
			$this->object->flushByTag( $this->prefix . 'siteid' );
		} else {
			$this->object->flush();
		}

		return true;
	}


	/**
	 * Removes the cache entry identified by the given key.
	 *
	 * @inheritDoc
	 *
	 * @param string $key Key string that identifies the single cache entry
	 * @return bool True if the item was successfully removed. False if there was an error
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function delete( string $key ) : bool
	{
		$this->object->remove( $this->prefix . $key );
		return true;
	}


	/**
	 * Removes the cache entries identified by the given keys.
	 *
	 * @inheritDoc
	 *
	 * @param iterable $keys List of key strings that identify the cache entries that should be removed
	 * @return bool True if the items were successfully removed. False if there was an error.
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function deleteMultiple( iterable $keys ) : bool
	{
		foreach( $keys as $key ) {
			$this->object->remove( $this->prefix . $key );
		}

		return true;
	}


	/**
	 * Removes the cache entries identified by the given tags.
	 *
	 * @inheritDoc
	 *
	 * @param iterable $tags List of tag strings that are associated to one or
	 *  more cache entries that should be removed
	 * @return bool True if the items were successfully removed. False if there was an error.
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function deleteByTags( iterable $tags ) : bool
	{
		foreach( $tags as $tag ) {
			$this->object->flushByTag( $this->prefix . $tag );
		}

		return true;
	}


	/**
	 * Returns the value of the requested cache key.
	 *
	 * @inheritDoc
	 *
	 * @param string $key Path to the requested value like product/id/123
	 * @param mixed $default Value returned if requested key isn't found
	 * @return mixed Value associated to the requested key. If no value for the
	 *	key is found in the cache, the given default value is returned
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function get( string $key, $default = null )
	{
		if( ( $entry = $this->object->get( $this->prefix . $key ) ) !== false ) {
			return $entry;
		}

		return $default;
	}


	/**
	 * Returns the cached values for the given cache keys.
	 *
	 * @inheritDoc
	 *
	 * @param iterable $keys List of key strings for the requested cache entries
	 * @param mixed $default Default value to return for keys that do not exist
	 * @return iterable A list of key => value pairs. Cache keys that do not exist or are stale will have $default as value.
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function getMultiple( iterable $keys, $default = null ) : iterable
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
	 * Determines whether an item is present in the cache.
	 *
	 * @inheritDoc
	 *
	 * @param string $key The cache item key
	 * @return bool True if cache entry is available, false if not
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function has( string $key ) : bool
	{
		return $this->object->has( $this->prefix . $key );
	}


	/**
	 * Sets the value for the given key in the cache.
	 *
	 * @inheritDoc
	 *
	 * @param string $key Key string for the given value like product/id/123
	 * @param mixed $value Value string that should be stored for the given key
	 * @param \DateInterval|int|string|null $expires Date interval object,
	 *  date/time string in "YYYY-MM-DD HH:mm:ss" format or as integer TTL value
	 *  when the cache entry will expiry
	 * @param iterable $tags List of tag strings that should be assoicated to the cache entry
	 * @return bool True on success and false on failure.
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function set( string $key, $value, $expires = null, iterable $tags = [] ) : bool
	{
		if( $expires instanceof \DateInterval ) {
			$expires = date_create()->add( $expires )->getTimestamp() - time();
		} elseif( is_string( $expires ) ) {
			$expires = date_create( $expires )->getTimestamp() - time();
		}

		$tagList = ( $this->prefix ? array( $this->prefix . 'siteid' ) : [] );

		foreach( $tags as $tag ) {
			$tagList[] = $this->prefix . $tag;
		}

		$this->object->set( $this->prefix . $key, $value, $tagList, $expires );
		return true;
	}


	/**
	 * Adds or overwrites the given key/value pairs in the cache, which is much
	 * more efficient than setting them one by one using the set() method.
	 *
	 * @inheritDoc
	 *
	 * @param iterable $pairs Associative list of key/value pairs. Both must be a string
	 * @param \DateInterval|int|string|null $expires Date interval object,
	 *  date/time string in "YYYY-MM-DD HH:mm:ss" format or as integer TTL value
	 *  when the cache entry will expiry
	 * @param iterable $tags List of tags that should be associated to the cache entries
	 * @return bool True on success and false on failure.
	 * @throws \Psr\SimpleCache\InvalidArgumentException
	 */
	public function setMultiple( iterable $pairs, $expires = null, iterable $tags = [] ) : bool
	{
		foreach( $pairs as $key => $value ) {
			$this->set( $key, $value, $expires, $tags );
		}

		return true;
	}
}
