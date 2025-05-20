<?php
/**
 * WordPress Cleanup
 *
 * @package pb-starter
 **/


 /**
 * Headers class
 */

 add_action( 'wp_headers', 'fse_set_frame_option_header', 99, 1 );
 function fse_set_frame_option_header( $headers ) {

	// Allow omission of this header
	if ( true === apply_filters( 'fse_disable_x_frame_options', false ) ) {
		return $headers;
	}

	// Valid header values are `SAMEORIGIN` (allow iframe on same domain) | `DENY` (do not allow anywhere)
	$header_value               = apply_filters( 'fse_x_frame_options', 'SAMEORIGIN' );
	$headers['X-Frame-Options'] = $header_value;
	return $headers;

}


/*
 * Add custom body classes to the archive pages.
 *
 * @param array $classes The existing body classes.
 * @return array The modified body classes.
 */
add_filter( 'body_class', 'add_archive_style_body_class' );
function add_archive_style_body_class( $classes ) {
	
    if ( is_archive() || is_home() || is_search() ) {
        $classes[] = 'archive';
    }

    return $classes;

}


/**
 * Clean body classes
 *
 * @param array $classes Body classes.
 */
// add_filter( 'body_class', 'fse_clean_body_classes', 20 );
// function fse_clean_body_classes( $classes ) {

// 	$allowed_classes = [
// 		'singular',
// 		'single',
// 		'page',
// 		'archive',
// 		'home',
// 		'search',
// 		'admin-bar',
// 		'logged-in',
// 		'wp-embed-responsive'
// 	];

// 	return array_intersect( $classes, $allowed_classes );

// }




// Remove inline CSS for emoji.
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('admin_print_styles', 'print_emoji_styles');	
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_filter('comment_text_rss', 'wp_staticize_emoji');	
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
// Remove WP emoji DNS prefetch
add_filter('emoji_svg_url', '__return_false');


/**
 * Remove Admin bar logo
 */
add_action( 'wp_before_admin_bar_render', 'fse_remove_admin_wp_logo' );
function fse_remove_admin_wp_logo() {

	global $wp_admin_bar;
	$wp_admin_bar->remove_node('wp-logo');
	
}