<?php

/**
 * Related Posts Strucutre
 *
 * @package    CoreFunctionality
 * @since      2.0.0
 * @copyright  Copyright (c) 2022, Patrick Boehner
 * @license    GPL-2.0+
 */


// If this file is called directly, abort.
//**********************
if( !defined( 'ABSPATH' ) ) exit;


/**
 * Display related posts for a given post.
 *
 * Returns a formatted list of related posts with customizable options.
 *
 * @param array $args {
 *     Optional. Array of arguments for displaying related posts.
 *
 *     @type int|null    $post_id        The ID of the post for which to display related posts. Defaults to the current post.
 *     @type string      $template_part  The template part to use for displaying related posts. Defaults to 'archive'.
 *     @type int|string  $post_per_page  The number of related posts to display per page. Defaults to 3.
 * }
 * @return void
 */
function cf_render_related_posts_list( $args = array() ) {

    $defaults = array(
        'post_id'       => get_the_ID(),
        'template_part' => 'archive',
        'post_per_page' => 3,
    );

    // Parse the default arguments
    $args = wp_parse_args( $args, $defaults );
    
    // Allow developers to filter the entire $args array
    $args = apply_filters( 'cf_render_related_posts_list_args', $args );

	/**
     * If the related posts are disabled, do nothing. 
     *
	 * To set the filter in your theme to disable related posts
	 * add_filter('cf_display_related_posts', '__return_false');
	 */
    if ( ! apply_filters( 'cf_display_related_posts', true ) ) {
        return;
    }

    // Exit early if the post doesn't have a category
    if( ! cf_post_has_multiple_categories( $args['post_id'] ) ) {
        return;
    }

    // Variables
    $post_type         = get_post_type( $args['post_id'] );
    $category          = get_the_category( $args['post_id'] );
    $current_cat       = $category[0]->cat_ID;
    $post_to_exclude   = array( get_the_ID() );
    $post_per_page     = absint( $args['post_per_page'] );

    // Query related posts
    $posts = cf_query_related_posts( $args['post_id'], $current_cat, $post_type, $post_per_page );

    // Exit early if no related posts are found
    if ( !$posts->have_posts() ) {
        return;
    }
    
    // Loop
    if ( $posts->have_posts() ) :


        // Opening Strcutre
        echo sprintf(
            '<section class="related-posts">%s<ul class="post-summery__list">',
            cf_get_related_posts_heading(),
        );

        // Loop
        while ( $posts->have_posts() ) : $posts->the_post();

            // Display related post using the specified template part
            cf_get_related_post_template( $args['template_part'] );

        endwhile;

    endif;

    // Reset
    wp_reset_postdata();

    // Closing Content
    echo '</ul></section>';

}


/**
 * Get related posts based on category and post type.
 *
 * @param int    $post_id The ID of the post.
 * @param int    $category_id The ID of the category.
 * @param string $post_type   The post type.
 *
 * @return WP_Query The query object for related posts.
 */
function cf_query_related_posts( $post_id, $category_id, $post_type, $post_per_page ) {

    return new WP_Query( array(
        'post_type'       => $post_type,
        'posts_per_page'  => $post_per_page,
        'post__not_in'    => array( $post_id ),
        'category__in'    => $category_id,
        'no_found_rows'   => true,
        'update_post_meta_cache' => false,
    ) );
    
}


/**
 * Check if the post in the loop has multiple categories.
 *
 * @param int $post_id The ID of the post.
 *
 * @return bool Whether the post has multiple categories.
 */
function cf_post_has_multiple_categories( $post_id ) {

    $category = wp_get_post_categories( $post_id, array( 'fields' => 'ids' ) );
    $default_category = get_option( 'default_category' );

    return !( count( $category ) <= 1 && $category[0] == $default_category );

}


/**
 * Retrieve the HTML heading for displaying related posts.
 *
 * Checks if the related posts heading is enabled through a filter.
 * To disable the heading, add_filter('cf_display_related_posts_heading', '__return_false');
 *
 * @return string|null The HTML heading for related posts, or null if heading is disabled.
 */
function cf_get_related_posts_heading() {

    // If related posts heading is disabled, do nothing.
	/*
	 * To set the filter in your theme to disable social sharing
	 * add_filter('cf_display_related_posts_heading', '__return_false');
	 */
    if ( ! apply_filters( 'cf_display_related_posts_heading', true ) ) {
        return;
    }

    // Default variables and filter
	$default_heading = __( 'Related Posts', 'core-functionality');
	$section_heading = apply_filters( 'cf_related_posts_title', $default_heading );

    // Fromat the html of the heading
	$related_posts_heading = sprintf(
        '<h2 class="related-posts__heading">%s</h2>',
        esc_html( $section_heading )
	);

	return $related_posts_heading;

}


/**
 * Display the related post using a specified template part.
 *
 * @param string $template_part The template part to use for displaying related posts.
 */
function cf_get_related_post_template( $template_part = 'archive' ) {

    $template_part = apply_filters( 'cf_get_related_post_template_part', $template_part );

    if ( function_exists( 'get_template_part' ) ) {
        get_template_part( 'partials/content/' . $template_part );
    }
}