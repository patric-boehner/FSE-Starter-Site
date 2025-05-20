<?php
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @package pb-starter
 **/


/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 *
 * @since 0.8.0
 *
 * @return void
 */

add_action( 'after_setup_theme', 'fse_starter_setup' );	
function fse_starter_setup() {

    /**
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_theme_textdomain( 'pb-starter', THEME_PATH . 'languages' );

    // Enqueue editor stylesheet.
    // add_editor_style( THEME_PATH . 'style.css' );

    // Remove core block patterns.
    remove_theme_support( 'core-block-patterns' );

    // Disable the loading of remote patterns from the Dotorg pattern directory.
    add_filter( 'should_load_remote_block_patterns', '__return_false' );

}