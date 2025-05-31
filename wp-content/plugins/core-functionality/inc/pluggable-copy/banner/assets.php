<?php
/**
* Sitewide Banner Assets
*
* @package    CoreFunctionality
* @since      2.0.0
* @copyright  Copyright (c) 2019, Patrick Boehner
* @license    GPL-2.0+
*/

//* Block Acess
//**********************
if( !defined( 'ABSPATH' ) ) exit;


// Enqueue Scripts and Styles.
add_action( 'wp_enqueue_scripts', 'cf_enqueue_banner_scripts_styles' );
function cf_enqueue_banner_scripts_styles() {

  // Setup page if has top banner.
  if ( function_exists( 'cf_output_banner' ) ) {

    if ( cf_is_banner_active() == true && pb_is_landing_page() !== true ) {

      wp_register_style(
        'banner-style',
        CORE_URL . 'inc/pluggable/banner/style.min.css',
        false,
        cf_version_id()
      );
  
      if( cf_is_dismissable_banner_active() == true ) {
  
        wp_enqueue_script(
          'banner-script',
          CORE_URL . 'inc/pluggable/banner/script.min.js',
          array(),
          cf_version_id(),
          true
        );
    
        wp_script_add_data(
          'banner-script',
          'defer',
          true
        );
    
        // Load Customizer Banner varaibles    
        wp_localize_script(
          'banner-script',
          'cookie_banner',
          cf_get_banner_cookie_settings()
        );
  
      }
  
    }

  }

}