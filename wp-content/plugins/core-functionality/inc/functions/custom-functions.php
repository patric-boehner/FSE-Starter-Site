<?php

/**
 * Custom functions
 *
 * @author      Patrick Boehner
 * @link        http://www.patrickboehner.com
 * @package     Core Functionality
 * @copyright   Copyright (c) 2012, Patrick Boehner
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */


//* Block Acess
//**********************
if( !defined( 'ABSPATH' ) ) exit;


/**
 * Check if current site is a local development site
 *
 * @since 1.2.0
 * @return boolean
 */
function cf_is_local_dev_site() {

	$url_strings = array( 'localdev', 'localhost', '.dev', '.local' );
	$is_local_site = false;

	foreach( $url_strings as $string ) {
		// Add a check for the returned value from strpos()
		if( strpos( home_url(), $string ) !== false ) {
			$is_local_site = true;
		}	
	}

	// Use the constant WP_ENVIRONMENT_TYPE instead of wp_get_environment_type() which is not available in older WordPress versions
	if( defined( 'WP_ENVIRONMENT_TYPE' ) && WP_ENVIRONMENT_TYPE === 'local' ) { 
		$is_local_site = true;
	}

	// return $is_local_site;
	return $is_local_site;

}


/**
 * Check if current site is a development staging site
 *
 * @since 1.2.0
 * @return boolean
 */
function cf_is_development_staging_site() {

	$url_strings = array( 'wpclientstaging.com' );
	$is_development_staging_site = false;

	foreach( $url_strings as $string ) {
		// Add a check for the returned value from strpos()
		if( strpos( home_url(), $string ) !== false ) { 
			$is_development_staging_site = true;
		}	
	}

	// Use the constant WP_ENVIRONMENT_TYPE instead of wp_get_environment_type() which is not available in older WordPress versions
	if( defined( 'WP_ENVIRONMENT_TYPE' ) && WP_ENVIRONMENT_TYPE === 'development' ) { 
		$is_development_staging_site = true;
	}
	
	return $is_development_staging_site;

}


/**
 * Check if current site is a staging site
 *
 * @since 1.2.0
 * @return boolean
 */
function cf_is_staging_site() {

	$url_strings = array( 'staging.', '.flywheelsites.com', '.wpengine.com', '.kinsta.cloud' );
	$is_staging_site = false;

	foreach( $url_strings as $string ) {
		// Add a check for the returned value from strpos()
		if( strpos( home_url(), $string ) !== false ) { 
			$is_staging_site = true;
		}
	}

	// Use the constant WP_ENVIRONMENT_TYPE instead of wp_get_environment_type() which is not available in older WordPress versions
	if( defined( 'WP_ENVIRONMENT_TYPE' ) && WP_ENVIRONMENT_TYPE === 'staging' ) { 
		$is_staging_site = true;
	}
	
	return $is_staging_site;

}