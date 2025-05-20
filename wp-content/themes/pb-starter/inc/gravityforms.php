<?php
/**
 * GravityForms
 *
 * @package fse-stsrter
 **/


 // Remove required message
 add_filter( 'gform_required_legend', '__return_empty_string' );