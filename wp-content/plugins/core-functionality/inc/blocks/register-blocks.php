<?php
/**
* Register custom blocks
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
 * Register Blocks Blocks
 *
 * @package      CoreFunctionality
 * @author       CultivateWP
 * @since        1.0.0
 * @license      GPL-2.0+
 **/

 /**
 * Load Blocks
 */
add_action( 'init', 'cf_register_blocks', 5 );
function cf_register_blocks() {

	// Check availability of block editor
    if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}

	// adjust location(s) as needed for block.json
  register_block_type( CORE_DIR . 'inc/blocks/toggle' );
  register_block_type( CORE_DIR . 'inc/blocks/toggles' );
  register_block_type( CORE_DIR . 'inc/blocks/icon' );

}


// Remove the ACF InnerBLock Wrppaer
add_filter( 'acf/blocks/wrap_frontend_innerblocks', 'cf_should_wrap_innerblocks', 10, 2 );
function cf_should_wrap_innerblocks( $wrap, $name ) {

    if ( $name == 'cf/toggles-block' ) {
        return true;
    }

    return false;
    
}