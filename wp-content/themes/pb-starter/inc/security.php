<?php
/**
 * WordPress Security
 *
 * @package pb-starter
 **/

/**
 * Remove generator meta tags.
 *
 * @see https://developer.wordpress.org/reference/functions/the_generator/
 */
add_filter( 'the_generator', '__return_false' );


/**
 * Disable XML RPC.
 *
 * @see https://developer.wordpress.org/reference/hooks/xmlrpc_enabled/
 */
add_filter( 'xmlrpc_enabled', '__return_false' );
