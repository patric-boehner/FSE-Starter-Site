<?php
/**
* Register block categories
*
* @package    CoreFunctionality
* @since      2.0.0
* @copyright  Copyright (c) 2019, Patrick Boehner
* @license    GPL-2.0+
*
* @link https://www.billerickson.net/building-acf-blocks-with-block-json/
*/

//* Block Acess
//**********************
if( !defined( 'ABSPATH' ) ) exit;


/**
 * Block categories
 *
 * @since 1.0.0
 */
add_filter( 'block_categories_all', 'cf_block_categories' );
function cf_block_categories( $categories ) {

	// Check to see if we already have a content category
	$include = true;
	foreach( $categories as $category ) {
		if( 'content' === $category['slug'] ) {
			$include = false;
		}
	}

	if( $include ) {
		$categories = array_merge(
			$categories,
			[
				[
					'slug'  => 'content',
					'title' => __( 'Content', 'core-functionality' ),
				]
			]
		);
	}

	return $categories;

}