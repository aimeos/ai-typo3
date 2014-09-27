<?php

/**
 * @license LGPLv3, http://opensource.org/licenses/LGPL-3.0
 */


interface FrontendInterface
{
}


class T3Cache implements FrontendInterface
{
	public function flush()
	{
	}

	public function flushByTag( $tag )
	{
	}

	public function get( $key )
	{
	}

	public function getByTag( $tag )
	{
	}

	public function remove( $key )
	{
	}

	public function set( $key, $value, array $tags, $expire )
	{
	}
}
