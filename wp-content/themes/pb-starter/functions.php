<?php
/**
 * This file adds functions to the FSE Starter Theme WordPress theme.
 *
 * @package FSE Starter Theme
 * @author  Patrick Boehner
 * @license GNU General Public License v3
 * @link    https://example.com/
 * 
 * Resources:
 * @link https://gutenberg.10up.com
 *
 * Inspiration:
 * @link https://github.com/10up/wp-scaffold/blob/trunk/themes/10up-block-theme
 * @link https://github.com/WebDevStudios/wds-bt
 */


 // Global constants
define( 'THEME_HANDLE', sanitize_title_with_dashes( wp_get_theme()->get( 'Name' ) ) );
define( 'THEME_VERSION', wp_get_theme()->get( 'Version' ) );
define( 'THEME_PATH', get_template_directory() . '/' );
define( 'THEME_URL', get_template_directory_uri() . '/' );
define( 'THEME_INC', THEME_PATH . 'inc/' );


// Cache Busting
function cache_version_id() {

	if ( WP_DEBUG ) {
		return time();
	} else {
		return THEME_VERSION;
	}

}


// Functionality
require_once THEME_INC . 'setup.php';
require_once THEME_INC . 'scripts.php';
require_once THEME_INC . 'wordpress-cleanup.php';
require_once THEME_INC . 'template-tags.php';
// require_once THEME_INC . 'comments.php';
require_once THEME_INC . 'login.php';
// require_once THEME_INC . 'gravityforms.php';
// require_once THEME_INC . 'acf.php';