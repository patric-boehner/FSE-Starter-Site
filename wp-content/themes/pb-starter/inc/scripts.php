<?php
/**
 * Enqueue scripts and styles.
 *
 * @package pb-starter
 **/


/**
 * Enqueue scripts and styles.
 */
add_action( 'wp_enqueue_scripts', 'fse_starter_enqueue_stylesheet' );
function fse_starter_enqueue_stylesheet() {

	wp_enqueue_style( 
		'frontend-style',
		THEME_URL . 'assets/css/frontend.min.css',
		array(),
		cache_version_id() 
	);

}


/**
 * Gutenberg scripts and styles
 */
add_action( 'enqueue_block_editor_assets', 'fse_block_editor_scripts' );
function fse_block_editor_scripts() {

	wp_enqueue_style( 
		'frontend-style',
		THEME_URL . 'assets/css/editor.min.css',
		array(),
		cache_version_id() 
	);

	wp_enqueue_script( 
		'theme-editor', 
		THEME_URL . 'assets/js/editor.min.js', 
		array( 'wp-blocks', 'wp-dom' ), 
		cache_version_id(),
		true 
	);

}


/**
 * Block Style Loader for Core and Custom Blocks
 *
 * This setup automatically registers and enqueues CSS styles for both core and custom blocks.
 * - Scans /assets/css/blocks/core/ and /assets/css/blocks/custom/ for .css files.
 * - Loads each file as a block style on the frontend via wp_enqueue_block_style().
 * - Ensures the same styles are enqueued in the block editor for visual consistency.
 *
 * Folder structure expected:
 * assets/
 * └── css/
 *     └── blocks/
 *         ├── core/
 *         │   ├── button.css       → applies to core/button block
 *         │   └── image.css        → applies to core/image block
 *         └── custom/
 *             ├── fancy-cta.css    → applies to custom/fancy-cta block
 *             └── product.css      → applies to custom/product block
 */

add_action( 'init', 'fse_register_all_block_styles' );
function fse_register_all_block_styles() {
	$theme_version = wp_get_theme()->get( 'Version' );

	// Load core block styles
	fse_register_block_styles_from_dir(
		'core',
		get_stylesheet_directory() . '/assets/css/blocks/core/',
		get_stylesheet_directory_uri() . '/assets/css/blocks/core/',
		$theme_version
	);

	// Load custom block styles
	fse_register_block_styles_from_dir(
		'custom',
		get_stylesheet_directory() . '/assets/css/blocks/custom/',
		get_stylesheet_directory_uri() . '/assets/css/blocks/custom/',
		$theme_version
	);
}

/**
 * Registers and enqueues block styles for all CSS files in the given directory.
 *
 * @param string $namespace Block namespace (e.g. 'core' or 'custom').
 * @param string $dir       Absolute path to the CSS directory.
 * @param string $uri       URI to the CSS directory.
 * @param string $version   Theme version string.
 */
function fse_register_block_styles_from_dir( $namespace, $dir, $uri, $version ) {
	foreach ( glob( $dir . '*.css' ) as $file_path ) {
		$filename   = basename( $file_path );
		$block_slug = basename( $file_path, '.min.css' ); // Adjust if not using minified files
		$block_name = $namespace . '/' . $block_slug;
		$handle     = $namespace . '-' . $block_slug;

		wp_register_style(
			$handle,
			$uri . $filename,
			array(),
			$version . '.' . filemtime( $file_path )
		);

		wp_enqueue_block_style( $block_name, array(
			'handle' => $handle,
			'src'    => $uri . $filename,
			'path'   => $file_path,
			'ver'    => $version . '.' . filemtime( $file_path ),
		) );
	}
}

/**
 * Ensures block styles are enqueued in the editor.
 */
add_action( 'enqueue_block_editor_assets', 'fse_enqueue_editor_styles_for_registered_blocks' );
function fse_enqueue_editor_styles_for_registered_blocks() {
	global $wp_styles;

	if ( ! empty( $wp_styles->registered ) ) {
		foreach ( $wp_styles->registered as $handle => $style ) {
			if (
				str_starts_with( $handle, 'core-' ) ||
				str_starts_with( $handle, 'custom-' )
			) {
				wp_enqueue_style( $handle );
			}
		}
	}
}
