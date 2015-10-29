<?php
/*
	Plugin Name: WP Redis
	Plugin URI: http://github.com/alleyinteractive/wp-redis/
	Description: WordPress Object Cache using Redis. Requires phpredis (https://github.com/nicolasff/phpredis).
	Version: 0.1
	Author: Matthew Boynes, Alley Interactive
	Author URI: http://www.alleyinteractive.com/

	Install this file to wp-content/object-cache.php
*/
/*  This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/


# Users with setups where multiple installs share a common wp-config.php or $table_prefix
# can use this to guarantee uniqueness for the keys generated by this object cache
if ( !defined( 'WP_CACHE_KEY_SALT' ) )
	define( 'WP_CACHE_KEY_SALT', '' );

/**
 * Adds data to the cache, if the cache key doesn't already exist.
 *
 * @uses $wp_object_cache Object Cache Class
 * @see WP_Object_Cache::add()
 *
 * @param int|string $key The cache key to use for retrieval later
 * @param mixed $data The data to add to the cache store
 * @param string $group The group to add the cache to
 * @param int $expire When the cache data should be expired
 * @return bool False if cache key and group already exist, true on success
 */
function wp_cache_add( $key, $data, $group = '', $expire = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->add( $key, $data, $group, (int) $expire );
}

/**
 * Closes the cache.
 *
 * This function has ceased to do anything since WordPress 2.5. The
 * functionality was removed along with the rest of the persistent cache. This
 * does not mean that plugins can't implement this function when they need to
 * make sure that the cache is cleaned up after WordPress no longer needs it.
 *
 * @return bool Always returns True
 */
function wp_cache_close() {
	return true;
}

/**
 * Decrement numeric cache item's value
 *
 * @uses $wp_object_cache Object Cache Class
 * @see WP_Object_Cache::decr()
 *
 * @param int|string $key The cache key to increment
 * @param int $offset The amount by which to decrement the item's value. Default is 1.
 * @param string $group The group the key is in.
 * @return false|int False on failure, the item's new value on success.
 */
function wp_cache_decr( $key, $offset = 1, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->decr( $key, $offset, $group );
}

/**
 * Removes the cache contents matching key and group.
 *
 * @uses $wp_object_cache Object Cache Class
 * @see WP_Object_Cache::delete()
 *
 * @param int|string $key What the contents in the cache are called
 * @param string $group Where the cache contents are grouped
 * @return bool True on successful removal, false on failure
 */
function wp_cache_delete($key, $group = '') {
	global $wp_object_cache;

	return $wp_object_cache->delete($key, $group);
}

/**
 * Removes all cache items.
 *
 * @uses $wp_object_cache Object Cache Class
 * @see WP_Object_Cache::flush()
 *
 * @return bool False on failure, true on success
 */
function wp_cache_flush() {
	global $wp_object_cache;

	return $wp_object_cache->flush();
}

/**
 * Retrieves the cache contents from the cache by key and group.
 *
 * @uses $wp_object_cache Object Cache Class
 * @see WP_Object_Cache::get()
 *
 * @param int|string $key What the contents in the cache are called
 * @param string $group Where the cache contents are grouped
 * @param bool $force Whether to force an update of the local cache from the persistent cache (default is false)
 * @param &bool $found Whether key was found in the cache. Disambiguates a return of false, a storable value.
 * @return bool|mixed False on failure to retrieve contents or the cache
 *		contents on success
 */
function wp_cache_get( $key, $group = '', $force = false, &$found = null ) {
	global $wp_object_cache;

	return $wp_object_cache->get( $key, $group, $force, $found );
}

/**
 * Increment numeric cache item's value
 *
 * @uses $wp_object_cache Object Cache Class
 * @see WP_Object_Cache::incr()
 *
 * @param int|string $key The cache key to increment
 * @param int $offset The amount by which to increment the item's value. Default is 1.
 * @param string $group The group the key is in.
 * @return false|int False on failure, the item's new value on success.
 */
function wp_cache_incr( $key, $offset = 1, $group = '' ) {
	global $wp_object_cache;

	return $wp_object_cache->incr( $key, $offset, $group );
}

/**
 * Sets up Object Cache Global and assigns it.
 *
 * @global WP_Object_Cache $wp_object_cache WordPress Object Cache
 */
function wp_cache_init() {
	$GLOBALS['wp_object_cache'] = new WP_Object_Cache();
}

/**
 * Replaces the contents of the cache with new data.
 *
 * @uses $wp_object_cache Object Cache Class
 * @see WP_Object_Cache::replace()
 *
 * @param int|string $key What to call the contents in the cache
 * @param mixed $data The contents to store in the cache
 * @param string $group Where to group the cache contents
 * @param int $expire When to expire the cache contents
 * @return bool False if not exists, true if contents were replaced
 */
function wp_cache_replace( $key, $data, $group = '', $expire = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->replace( $key, $data, $group, (int) $expire );
}

/**
 * Saves the data to the cache.
 *
 * @uses $wp_object_cache Object Cache Class
 * @see WP_Object_Cache::set()
 *
 * @param int|string $key What to call the contents in the cache
 * @param mixed $data The contents to store in the cache
 * @param string $group Where to group the cache contents
 * @param int $expire When to expire the cache contents
 * @return bool False on failure, true on success
 */
function wp_cache_set( $key, $data, $group = '', $expire = 0 ) {
	global $wp_object_cache;

	return $wp_object_cache->set( $key, $data, $group, (int) $expire );
}

/**
 * Switch the interal blog id.
 *
 * This changes the blog id used to create keys in blog specific groups.
 *
 * @param int $blog_id Blog ID
 */
function wp_cache_switch_to_blog( $blog_id ) {
	global $wp_object_cache;

	return $wp_object_cache->switch_to_blog( $blog_id );
}

/**
 * Adds a group or set of groups to the list of global groups.
 *
 * @param string|array $groups A group or an array of groups to add
 */
function wp_cache_add_global_groups( $groups ) {
	global $wp_object_cache;

	return $wp_object_cache->add_global_groups( $groups );
}

/**
 * Adds a group or set of groups to the list of non-persistent groups.
 *
 * @param string|array $groups A group or an array of groups to add
 */
function wp_cache_add_non_persistent_groups( $groups ) {
	global $wp_object_cache;

	$wp_object_cache->add_non_persistent_groups( $groups );
}

/**
 * Reset internal cache keys and structures. If the cache backend uses global
 * blog or site IDs as part of its cache keys, this function instructs the
 * backend to reset those keys and perform any cleanup since blog or site IDs
 * have changed since cache init.
 *
 * This function is deprecated. Use wp_cache_switch_to_blog() instead of this
 * function when preparing the cache for a blog switch. For clearing the cache
 * during unit tests, consider using wp_cache_init(). wp_cache_init() is not
 * recommended outside of unit tests as the performance penality for using it is
 * high.
 *
 * @deprecated 3.5.0
 */
function wp_cache_reset() {
	_deprecated_function( __FUNCTION__, '3.5' );

	global $wp_object_cache;

	return $wp_object_cache->reset();
}

/**
 * WordPress Object Cache
 *
 * The WordPress Object Cache is used to save on trips to the database. The
 * Object Cache stores all of the cache data to memory and makes the cache
 * contents available by using a key, which is used to name and later retrieve
 * the cache contents.
 *
 * The Object Cache can be replaced by other caching mechanisms by placing files
 * in the wp-content folder which is looked at in wp-settings. If that file
 * exists, then this file will not be included.
 */
class WP_Object_Cache {

	/**
	 * Holds the cached objects
	 *
	 * @var array
	 * @access private
	 */
	var $cache = array();

	/**
	 * The amount of times the cache data was already stored in the cache.
	 *
	 * @access private
	 * @var int
	 */
	var $cache_hits = 0;

	/**
	 * Amount of times the cache did not have the request in cache
	 *
	 * @var int
	 * @access public
	 */
	var $cache_misses = 0;

	/**
	 * List of global groups
	 *
	 * @var array
	 * @access protected
	 */
	var $global_groups = array();

	/**
	 * List of non-persistent groups
	 *
	 * @var array
	 * @access protected
	 */
	var $non_persistent_groups = array();

	/**
	 * The blog prefix to prepend to keys in non-global groups.
	 *
	 * @var int
	 * @access private
	 */
	var $blog_prefix;

	/**
	 * Adds data to the cache if it doesn't already exist.
	 *
	 * @uses WP_Object_Cache::_exists Checks to see if the cache already has data.
	 * @uses WP_Object_Cache::set Sets the data after the checking the cache
	 *		contents existence.
	 *
	 * @param int|string $key What to call the contents in the cache
	 * @param mixed $data The contents to store in the cache
	 * @param string $group Where to group the cache contents
	 * @param int $expire When to expire the cache contents
	 * @return bool False if cache key and group already exist, true on success
	 */
	function add( $key, $data, $group = 'default', $expire = 0 ) {
		if ( function_exists( 'wp_suspend_cache_addition' ) && wp_suspend_cache_addition() )
			return false;

		if ( $this->_exists( $this->_key( $key, $group ) ) )
			return false;

		return $this->set( $key, $data, $group, (int) $expire );
	}

	/**
	 * Sets the list of global groups.
	 *
	 * @param array $groups List of groups that are global.
	 */
	function add_global_groups( $groups ) {
		$groups = (array) $groups;

		$groups = array_fill_keys( $groups, true );
		$this->global_groups = array_merge( $this->global_groups, $groups );
	}

	/**
	 * Sets the list of non-persistent groups.
	 *
	 * @param array $groups List of groups that are non-persistent.
	 */
	function add_non_persistent_groups( $groups ) {
		$groups = (array) $groups;

		$groups = array_fill_keys( $groups, true );
		$this->non_persistent_groups = array_merge( $this->non_persistent_groups, $groups );
	}

	/**
	 * Decrement numeric cache item's value
	 *
	 * @param int|string $key The cache key to increment
	 * @param int $offset The amount by which to decrement the item's value. Default is 1.
	 * @param string $group The group the key is in.
	 * @return false|int False on failure, the item's new value on success.
	 */
	function decr( $key, $offset = 1, $group = 'default' ) {
		$id = $this->_key( $key, $group );

		$offset = (int) $offset;

		// The key needs to exist in order to be decremented
		if ( ! $this->_exists( $id ) ) {
			return false;
		}

		# If this isn't a persistant group, we have to sort this out ourselves, grumble grumble
		if ( ! $this->_should_persist( $group ) ) {
			if ( empty( $this->cache[ $id ] ) || ! is_numeric( $this->cache[ $id ] ) ) {
				$this->cache[ $id ] = 0;
			} else {
				$this->cache[ $id ] -= $offset;

				if ( $this->cache[ $id ] < 0 ) {
					$this->cache[ $id ] = 0;
				}
			}
			return $this->cache[ $id ];
		}

		if ( $offset > 1 ) {
			$result = $this->redis->decrBy( $id, $offset );
		} else {
			$result = $this->redis->decr( $id );
		}

		if ( $result < 0 ) {
			$result = 0;
			$this->redis->set( $id, $result );
		}

		if ( is_int( $result ) ) {
			$this->cache[ $id ] = $result;
		}

		return $result;
	}

	/**
	 * Remove the contents of the cache key in the group
	 *
	 * If the cache key does not exist in the group and $force parameter is set
	 * to false, then nothing will happen. The $force parameter is set to false
	 * by default.
	 *
	 * @param int|string $key What the contents in the cache are called
	 * @param string $group Where the cache contents are grouped
	 * @param bool $force Optional. Whether to force the unsetting of the cache
	 *		key in the group
	 * @return bool False if the contents weren't deleted and true on success
	 */
	function delete( $key, $group = 'default', $force = false ) {
		$id = $this->_key( $key, $group );

		if ( ! $force && ! $this->_exists( $id ) )
			return false;

		if ( $this->_should_persist( $group ) ) {
			$result = $this->redis->delete( $id );
			if ( 1 != $result ) {
				return false;
			}
		}

		unset( $this->cache[ $id ] );
		return true;
	}

	/**
	 * Clears the object cache of all data.
	 *
	 * By default, this will flush the session cache as well as Redis, but we
	 * can leave the redis cache intact if we want. This is helpful when, for
	 * instance, you're running a batch process and want to clear the session
	 * store to reduce the memory footprint, but you don't want to have to
	 * re-fetch all the values from the database.
	 *
	 * @param  bool $redis Should we flush redis as well as the session cache?
	 * @return bool Always returns true
	 */
	function flush( $redis = true ) {
		$this->cache = array();
		if ( $redis ) {
			$this->redis->flushAll();
		}

		return true;
	}

	/**
	 * Retrieves the cache contents, if it exists
	 *
	 * The contents will be first attempted to be retrieved by searching by the
	 * key in the cache group. If the cache is hit (success) then the contents
	 * are returned.
	 *
	 * On failure, the number of cache misses will be incremented.
	 *
	 * @param int|string $key What the contents in the cache are called
	 * @param string $group Where the cache contents are grouped
	 * @param string $force Whether to force a refetch rather than relying on the local cache (default is false)
	 * @return bool|mixed False on failure to retrieve contents or the cache
	 *		contents on success
	 */
	function get( $key, $group = 'default', $force = false, &$found = null ) {
		$id = $this->_key( $key, $group );

		if ( $this->_exists( $id ) ) {
			$found = true;
			$this->cache_hits += 1;

			if ( $this->_should_persist( $group ) && ( $force || ( ! isset( $this->cache[ $id ] ) && ! array_key_exists( $id, $this->cache ) ) ) ) {
				$this->cache[ $id ] = $this->redis->get( $id );
				if ( ! is_numeric( $this->cache[ $id ] ) ) {
					$this->cache[ $id ] = unserialize( $this->cache[ $id ] );
				}
			}

			if ( is_object( $this->cache[ $id ] ) )
				return clone $this->cache[ $id ];
			else
				return $this->cache[ $id ];
		}

		$found = false;
		$this->cache_misses += 1;
		return false;
	}

	/**
	 * Increment numeric cache item's value
	 *
	 * @param int|string $key The cache key to increment
	 * @param int $offset The amount by which to increment the item's value. Default is 1.
	 * @param string $group The group the key is in.
	 * @return false|int False on failure, the item's new value on success.
	 */
	function incr( $key, $offset = 1, $group = 'default' ) {
		$id = $this->_key( $key, $group );

		$offset = (int) $offset;

		// The key needs to exist in order to be incremented
		if ( ! $this->_exists( $id ) ) {
			return false;
		}

		# If this isn't a persistant group, we have to sort this out ourselves, grumble grumble
		if ( ! $this->_should_persist( $group ) ) {
			if ( empty( $this->cache[ $id ] ) || ! is_numeric( $this->cache[ $id ] ) ) {
				$this->cache[ $id ] = 0;
			} else {
				$this->cache[ $id ] += $offset;

				if ( $this->cache[ $id ] < 0 ) {
					$this->cache[ $id ] = 0;
				}
			}
			return $this->cache[ $id ];
		}

		if ( $offset > 1 ) {
			$result = $this->redis->incrBy( $id, $offset );
		} else {
			$result = $this->redis->incr( $id );
		}

		if ( is_int( $result ) ) {
			$this->cache[ $id ] = $result;
		}

		return $result;
	}

	/**
	 * Replace the contents in the cache, if contents already exist
	 * @see WP_Object_Cache::set()
	 *
	 * @param int|string $key What to call the contents in the cache
	 * @param mixed $data The contents to store in the cache
	 * @param string $group Where to group the cache contents
	 * @param int $expire When to expire the cache contents
	 * @return bool False if not exists, true if contents were replaced
	 */
	function replace( $key, $data, $group = 'default', $expire = 0 ) {
		if ( ! $this->_exists( $this->_key( $key, $group ) ) )
			return false;

		return $this->set( $key, $data, $group, (int) $expire );
	}

	/**
	 * Reset keys
	 *
	 * @deprecated 3.5.0
	 */
	function reset() {
		_deprecated_function( __FUNCTION__, '3.5', 'switch_to_blog()' );
	}

	/**
	 * Sets the data contents into the cache
	 *
	 * The cache contents is grouped by the $group parameter followed by the
	 * $key. This allows for duplicate ids in unique groups. Therefore, naming of
	 * the group should be used with care and should follow normal function
	 * naming guidelines outside of core WordPress usage.
	 *
	 * The $expire parameter is not used, because the cache will automatically
	 * expire for each time a page is accessed and PHP finishes. The method is
	 * more for cache plugins which use files.
	 *
	 * @param int|string $key What to call the contents in the cache
	 * @param mixed $data The contents to store in the cache
	 * @param string $group Where to group the cache contents
	 * @param int $expire TTL for the data, in seconds
	 * @return bool Always returns true
	 */
	function set( $key, $data, $group = 'default', $expire = 0 ) {
		$id = $this->_key( $key, $group );

		if ( is_object( $data ) )
			$data = clone $data;

		$this->cache[ $id ] = $data;

		if ( $this->_should_persist( $group ) ) {
			# If this is an integer, store it as such. Otherwise, serialize it.
			if ( ! is_numeric( $data ) || intval( $data ) != $data ) {
				$data = serialize( $data );
			}

			if ( empty( $expire ) ) {
				$this->redis->set( $id, $data );
			} else {
				$this->redis->setex( $id, $expire, $data );
			}
		}

		return true;
	}

	/**
	 * Echoes the stats of the caching.
	 *
	 * Gives the cache hits, and cache misses. Also prints every cached group,
	 * key and the data.
	 */
	function stats() {
		echo "<p>";
		echo "<strong>Cache Hits:</strong> {$this->cache_hits}<br />";
		echo "<strong>Cache Misses:</strong> {$this->cache_misses}<br />";
		echo "</p>";
		echo '<ul>';
		foreach ( $this->cache as $group => $cache ) {
			echo "<li><strong>Group:</strong> $group - ( " . number_format( strlen( serialize( $cache ) ) / 1024, 2 ) . 'k )</li>';
		}
		echo '</ul>';
	}

	/**
	 * Switch the interal blog id.
	 *
	 * This changes the blog id used to create keys in blog specific groups.
	 *
	 * @param int $blog_id Blog ID
	 */
	function switch_to_blog( $blog_id ) {
		$blog_id = (int) $blog_id;
		$this->blog_prefix = $this->multisite ? $blog_id . ':' : '';
	}

	/**
	 * Utility function to determine whether a key exists in the cache.
	 *
	 * @access protected
	 */
	protected function _exists( $id ) {
		if ( isset( $this->cache[ $id ] ) || array_key_exists( $id, $this->cache ) ) {
			return true;
		} else {
			return $this->redis->exists( $id );
		}
	}

	/**
	 * Utility function to generate the redis key for a given key and group.
	 *
	 * @param  string $key   The cache key.
	 * @param  string $group The cache group.
	 * @return string        A properly prefixed redis cache key.
	 */
	protected function _key( $key, $group = 'default' ) {
		if ( empty( $group ) ) {
			$group = 'default';
		}

		if ( ! empty( $this->global_groups[ $group ] ) ) {
			$prefix = $this->global_prefix;
		} else {
			$prefix = $this->blog_prefix;
		}

		return preg_replace( '/\s+/', '', WP_CACHE_KEY_SALT . "$prefix$group:$key" );
	}

	/**
	 * Does this group use persistent storage?
	 *
	 * @param  string $group Cache group.
	 * @return bool        true if the group is persistent, false if not.
	 */
	protected function _should_persist( $group ) {
		return empty( $this->non_persistent_groups[ $group ] );
	}

	/**
	 * Sets up object properties; PHP 5 style constructor
	 *
	 * @return null|WP_Object_Cache If cache is disabled, returns null.
	 */
	function __construct() {
		global $blog_id, $redis_server, $table_prefix;

		$this->multisite = is_multisite();
		$this->blog_prefix =  $this->multisite ? $blog_id . ':' : '';

		if ( empty( $redis_server ) ) {
			# Attempt to automatically load Pantheon's Redis config from the env.
			if ( isset( $_SERVER['CACHE_HOST'] ) ) {
				$redis_server = array( 'host' => $_SERVER['CACHE_HOST'],
				                       'port' => $_SERVER['CACHE_PORT'],
				                       'auth' => $_SERVER['CACHE_PASSWORD'] );
			}
			else {
				$redis_server = array( 'host' => '127.0.0.1', 'port' => 6379 );
			}
		}

		$this->redis = new WP_Redis();
		$this->redis->connect( $redis_server['host'], $redis_server['port'], 1, NULL, 100 ); # 1s timeout, 100ms delay between reconnections
		if ( ! empty( $redis_server['auth'] ) ) {
			$this->redis->auth( $redis_server['auth'] );
		}

		$this->global_prefix = '';
		if ( function_exists( 'is_multisite' ) ) {
			$this->global_prefix = ( is_multisite() || defined( 'CUSTOM_USER_TABLE' ) && defined( 'CUSTOM_USER_META_TABLE' ) ) ? '' : $table_prefix;
		}

		/**
		 * @todo This should be moved to the PHP4 style constructor, PHP5
		 * already calls __destruct()
		 */
		register_shutdown_function( array( $this, '__destruct' ) );
	}

	/**
	 * Will save the object cache before object is completely destroyed.
	 *
	 * Called upon object destruction, which should be when PHP ends.
	 *
	 * @return bool True value. Won't be used by PHP
	 */
	function __destruct() {
		return true;
	}
}

if ( class_exists( 'Redis' ) ) {
	class WP_Redis extends Redis {

	}
} else {
	class WP_Redis {

		public function __call( $name, $arguments ) {
			global $wp_object_cache;
			switch ( $name ) {
				case 'incr':
				case 'incrBy':
					if ( ! isset( $wp_object_cache->cache[ $arguments[0] ] ) ) {
						return false;
					}
					$val = $wp_object_cache->cache[ $arguments[0] ];
					$offset = isset( $arguments[1] ) && 'incrBy' === $name ? $arguments[1] : 1;
					$val = $val + $offset;
					return $val;
				case 'decrBy':
				case 'decr':
					if ( ! isset( $wp_object_cache->cache[ $arguments[0] ] ) ) {
						return false;
					}
					$val = $wp_object_cache->cache[ $arguments[0] ];
					$offset = isset( $arguments[1] ) && 'decrBy' === $name ? $arguments[1] : 1;
					$val = $val - $offset;
					return $val;
				case 'delete':
					return 1;
				case 'exists':
					return false;
			}
		}

		public function __construct() {
			add_action( 'admin_notices', array( $this, 'wp_action_admin_notices_warn_missing_redis' ) );
		}

		public function wp_action_admin_notices_warn_missing_redis() {
			if ( ! current_user_can( 'manage_options' ) ) {
				return;
			}
			echo '<div class="message error"><p>Alert! PHPRedis module is unavailable, which is required by WP Redis object cache.</p></div>';
		}

	}
}
