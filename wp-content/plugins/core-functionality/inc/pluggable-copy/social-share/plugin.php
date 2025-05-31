<?php

/**
 * Social Sharing Functions
 *
 * This file contains functions for generating social media sharing links and buttons.
 *
 *
* @package    CoreFunctionality
* @since      2.0.0
* @copyright  Copyright (c) 2022, Patrick Boehner
* @license    GPL-2.0+
 *
 */


//* Block Acess
//**********************
if( !defined( 'ABSPATH' ) ) exit;


// Define constants for social media URLs
define('FACEBOOK_URL', 'https://www.facebook.com/sharer/sharer.php?u=%s&t=%s');
define('TWITTER_URL', 'https://twitter.com/intent/tweet?&url=%s&text=%s&via=%s');
define('PINTEREST_URL', 'https://pinterest.com/pin/create/button/?url=%s&media=%s&nbsp;&description=%s');
define('LINKEDIN_URL', 'https://www.linkedin.com/shareArticle?min=true&url=%s&title=%s&source=%s');
define('POCKET_URL', 'https://getpocket.com/save?url=%s&title=%s');
define('EMAIL_URL', 'mailto:?subject=%s&body=%s');


/**
 * Render Social Share Links
 *
 * Generates and outputs the HTML for social media sharing links.
 *
 * @return string HTML code for social media sharing links.
 */
function cf_render_social_share_links() {

	/**
     * If share options are disabled, do nothing.
     * 
	 * To set the filter in your theme to disable social sharing
	 * add_filter('cf_display_sharing_links', '__return_false');
	 */
    if ( ! apply_filters( 'cf_display_sharing_links', true ) ) {
        return;
    }

	// Default social sharing options
    $default_sharing_options = array(
        'facebook',
        'twitter',
        'pinterest',
        'linkedin',
        'pocket',
        'email',
    );

    // Allow users to customize social sharing options
    $sharing_options = apply_filters( 'cf_social_sharing_options', $default_sharing_options );

	// Reusable variables
    $url = esc_url_raw( get_permalink() );
    $title = urlencode( esc_attr( strip_tags( get_the_title() ) ) );
    $name = urlencode( get_bloginfo('name') );

	// Construct social media sharing URLs
    $share_urls = array(
        'facebook' => cf_construct_social_url( 'facebook', $url, $title ),
        'twitter'   => cf_construct_social_url( 'twitter', $url, $title ),
        'pinterest' => cf_construct_social_url( 'pinterest', $url, $title ),
        'linkedin' => cf_construct_social_url( 'linkedin', $url, $title, $name ),
        'pocket' => cf_construct_social_url( 'pocket', $url, $title ),
        'email' => cf_construct_social_url( 'email', $url, $title ),
    );

    $share_links = '';

	// Generate HTML for each social media link
    foreach ( $sharing_options as $option ) {

        if ( ! empty( $option ) ) {
            $class = esc_attr( $option );
            $name = esc_html( ucfirst( $option ) );
            $share_link = $share_urls[ $option ];
            $icon = cf_get_sharing_button_icon( $class );
            $link_text = cf_get_sharing_button_text( $name );

            $share_item = sprintf(
                '<li class="share-links__item">%s</li>',
                cf_get_sharing_button_link( $share_link, $class, $icon, $link_text )
            );

            $share_links .= $share_item;
        }

    }

	// Generate the HTML for the entire social medial linl strucutre
    $output = sprintf(
        '<div class="share-links">%s<ul class="share-links__list">%s</ul></div>',
        cf_get_sharing_heading(),
        $share_links
    );

    echo $output;
	
}


/**
 * Construct Social Media URL
 *
 * Generates the social media sharing URL based on the specified option.
 *
 * @param string $option Social media option (e.g., 'facebook', 'twitter').
 * @param string $url    The URL to share.
 * @param string $title  The title of the content being shared.
 * @param string $name   The name associated with the content (used for LinkedIn).
 *
 * @return string Social media sharing URL.
 */
function cf_construct_social_url( $option, $url, $title = '', $name = '' ) {

    switch ($option) {
        case 'facebook':
            return sprintf( FACEBOOK_URL, esc_url_raw( $url ), esc_attr( $title ) );
        case 'twitter':
            return sprintf( TWITTER_URL, esc_url_raw( $url ), esc_attr( $title ), esc_attr( cf_get_sharing_twitter_handle() ) );
        case 'pinterest':
            return sprintf( PINTEREST_URL, esc_url_raw( $url ), esc_url_raw( cf_get_sharing_featured_image() ), esc_attr( $title ) );
        case 'linkedin':
            return sprintf( LINKEDIN_URL, esc_url_raw( $url ), esc_attr( $title ), esc_attr( $name ));
        case 'pocket':
            return sprintf( POCKET_URL, esc_url_raw( $url ), esc_attr( $title ) );
        case 'email':
            return sprintf( EMAIL_URL, esc_attr( cf_get_social_share_email_subject() ), esc_attr( cf_get_social_share_email_content() ) );
        default:
            return ''; // Handle unknown options
    }

}


/**
 * Get Social Sharing Heading
 *
 * Generates the heading for the social media sharing section.
 *
 * @return string HTML code for the social sharing heading.
 */
function cf_get_sharing_heading() {
	
	/*
     * If share heading is disabled, do nothing.
     * 
	 * To set the filter in your theme to disable social sharing
	 * add_filter('cf_display_sharing_heading', '__return_false');
	 */
    if ( ! apply_filters( 'cf_display_sharing_heading', true ) ) {
        return;
    }

	// Default variables and filter
	$default_heading = __( 'Share this Post', 'core-functionality' );
	$section_heading = apply_filters( 'cf_sharing_heading_text', $default_heading );

	// Fromat the html of the heading
	$social_share_heading = sprintf(
		'<h2 class="share-links__heading">%s</h2>',
		esc_html( $section_heading )
	);

	return $social_share_heading;

}


/**
 * Get Social Sharing Button Text
 *
 * Generates the text for the social media sharing button.
 *
 * @param string $service_name The name of the social media service.
 * @return string HTML code for the social sharing button text.
 */
function cf_get_sharing_button_text( $service_name ) {

    $default_style = 'icon-text';
    $style = apply_filters( 'cf_sharing_button_style', $default_style );

	// Text defaults
    $screen_reader_share_text = esc_html__( 'Share on', 'core-functionality' );
    $screen_reader_warning_text = esc_html__( 'Opens in new window', 'core-functionality' );

	// Determine the text based on the style
	$text = ( $style == 'icon' ) ? $screen_reader_share_text . ' ' . $service_name : $screen_reader_share_text;

	// Text formating
    if ( $style == 'icon' ) {
        $formatted_text = sprintf(
            '<span class="screen-reader-text">%s (%s)</span>',
            $text,
            $screen_reader_warning_text
        );
    } else {
        $formatted_text = sprintf(
            '<span class="screen-reader-text">%s&#32;</span>%s <span class="screen-reader-text">(%s)</span>',
            $text,
            $service_name,
            $screen_reader_warning_text
        );
    }

    $link_text = sprintf(
        '<span class="share-links__name">%s</span>',
        $formatted_text
    );

    return $link_text;

}



/**
 * Get Sharing Button Link
 *
 * Generates the HTML code for the social media sharing button link.
 *
 * @param string $share_url      The URL to be shared.
 * @param string $service_class  The CSS class for the social media service.
 * @param string $icon           The SVG icon for the social media service.
 * @param string $text           The text content for the button.
 *
 * @return string HTML code for the sharing button link.
 */
function cf_get_sharing_button_link( $share_url, $service_class, $icon, $text ) {

    // Find the style from the provided filter
	$style = apply_filters( 'cf_sharing_button_style', 'icon-text' );

    $style_class = 'style-' . $style;

    $link = sprintf(
        '<a href="%s" class="share-links__link %s %s" target="_blank" rel="noopener noreferrer nofollow">%s %s</a>',
        $share_url,
        $service_class,
        $style_class,
        $icon,
        $text
    );

    return $link;

}


/**
 * Get Sharing Button Icon
 *
 * Generates the SVG icon for the social media sharing button.
 *
 * @param string $share_name The name of the social media service.
 * @return string SVG code for the sharing button icon.
 */
function cf_get_sharing_button_icon( $share_name ) {

    $svg = '';

    if ( function_exists( 'be_icon' ) ) {

		// Find the style from the provided filter
        $style = apply_filters( 'cf_sharing_button_style', 'icon-text' );

        if ( $style !== 'text' ) {
            $svg = be_icon( array( 'icon' => $share_name ) );
        }
    }

    return $svg;

}


/**
 * Get Sharing Featured Image
 *
 * Retrieves the featured image of a post or returns the theme logo.
 *
 * @return string URL of the featured image or default logo.
 */
function cf_get_sharing_featured_image() {

	// Default image as logo
	$logo_img = esc_url( get_stylesheet_directory_uri() . '/assets/images/logo.png' );
	$featured_image = esc_url( get_the_post_thumbnail_url( get_the_ID(), 'large' ) );

	$image = ( $featured_image )? $featured_image : $logo_img;

	return $image;

}


/**
 * Get Sharing Twitter Handle
 *
 * Retrieves the Twitter handle for social media sharing.
 *
 * @return string Twitter handle.
 */
function cf_get_sharing_twitter_handle() {

    $custom_twitter_handle = '';
    $author_twitter = esc_html( get_the_author_meta( 'twitter' ) );
    $twitter_handle = apply_filters( 'cf_sharing_twitter_handle', $custom_twitter_handle );

    $twitter_handle = ( !empty( $twitter_handle ) )? $twitter_handle : $author_twitter;

    if ( !empty( $twitter_handle ) ) {
        $twitter_handle = '@' . urlencode( $twitter_handle );
    }

    return $twitter_handle;

}


/**
 * Get Social Share Email Subject
 *
 * Generates the email subject for social media sharing via email.
 *
 * @return string Email subject.
 */
function cf_get_social_share_email_subject() {

    $post_name = urlencode( get_bloginfo('name') );
    $email_subject_default = esc_html__( 'Shared Article:', 'core-functionality' );
    $email_subject = apply_filters( 'cf_sharing_email_subject', $email_subject_default );

    if ( !empty( $email_subject ) ) {
        $subject = urlencode( $email_subject ) . '&nbsp;' . $post_name;
    } else {
        $subject = urlencode( $post_name );
    }

    return $subject;

}


/**
 * Get Social Share Email Content
 *
 * Generates the email content for social media sharing via email.
 *
 * @return string Email body content.
 */
function cf_get_social_share_email_content() {

    $post_url = esc_url_raw( get_permalink() );
    $email_body_default = esc_html__( 'I want to share this article with you. Here is the link to the article:', 'core-functionality' );
    $email_body = apply_filters( 'cf_share_email_body', $email_body_default );

    if ( !empty( $email_body ) ) {
        $body = urlencode( $email_body ) . '&nbsp;' .  $post_url;
    } else {
        $body = $post_url;
    }

    return $body;

}
