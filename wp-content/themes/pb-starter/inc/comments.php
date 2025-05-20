<?php
/**
 * WordPress Comments
 *
 * @package fse-stsrter
 **/

 
// Remove comment Feed
add_filter( 'feed_links_show_comments_feed', '__return_false' );


// Remove comments from admin bar
// add_action( 'wp_before_admin_bar_render', 'action_wp_before_admin_bar_render' );
// function action_wp_before_admin_bar_render() {

// 	global $wp_admin_bar;
// 	$wp_admin_bar->remove_menu( 'comments' );

// } 


// Remove page comments
// add_action( 'init', 'pb_disable_post_type_comments' );
// function pb_disable_post_type_comments() {
    
//     remove_post_type_support( 'page', 'comments' );

// }
