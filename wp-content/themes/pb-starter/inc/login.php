<?php
/**
 * Login page updates
 *
 * @package pb-starter
 **/

/**
 * Login Logo URL
 *
 * @param string $url URL.
 */
add_filter( 'login_headerurl', 'fse_login_header_url' );
add_filter( 'login_headertext', '__return_empty_string' );
function fse_login_header_url( $url ) {

	return esc_url( home_url() );

}


/**
 * Login Logo
 */
// add_action( 'login_head', 'fse_login_logo' );
// function fse_login_logo() {

// 	$logo_path   = '/assets/imges/sample-logo.png';
// 	$logo_width  = 212;
// 	$logo_height = 40;

// 	if ( ! file_exists( get_theme_file_path( $logo_path ) ) ) {
// 		return;
// 	}

// 	$logo   = get_theme_file_uri( $logo_path );
// 	$height = floor( $logo_height / $logo_width * 312 );
// 	$styles = sprintf(
// 		'.login h1 a {
// 			background-image: url(%s);
// 			background-size: contain;
// 			background-repeat: no-repeat;
// 			background-position: center center;
// 			display: block;
// 			overflow: hidden;
// 			text-indent: -9999em;
// 			width: 312px;
// 			height: %dpx;
// 		}',
// 		esc_url( $logo ),
// 		$height
// 	);

// 	wp_add_inline_style( 'login', $styles );

// }
