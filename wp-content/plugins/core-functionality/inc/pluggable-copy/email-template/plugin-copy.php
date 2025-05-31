<?php

/**
 * Email Template
 * 
 * Replaces standard wordpress emails
 *
 * @package    CoreFunctionality
 * @since      2.0.0
 * @copyright  Copyright (c) 2024, Patrick Boehner
 * @license    GPL-2.0+
 * 
 * @link https://www.smashingmagazine.com/2011/10/create-perfect-emails-wordpress-website/
 */


// If this file is called directly, abort.
//**********************
if( !defined( 'ABSPATH' ) ) exit;


add_filter ("wp_mail_content_type", "my_awesome_mail_content_type");
function my_awesome_mail_content_type() {
    return "text/html";
}


add_filter( 'wp_mail', 'mycomp_email_filter',10 ,1 );
function mycomp_email_filter($args) {

	$template = mycomp_email_details();

	$args['message'] = str_replace("[message]",$args['message'],$template);

	return $args;

}


function mycomp_email_details() {

    // Get the blog name and URL
    $blog_name = get_bloginfo('name');
    $blog_url = get_bloginfo('url');

    //
    $info .= '<div style="background:#FAFAFA;padding:15px;text-align:center;">';
    $info .= '<table border="0" cellpadding="0" cellspacing="0" style="background:#FFFFFF;margin:0px;text-align:left;width:100%;"><tbody>';
    $info .= '<tr><td style="border:none;padding:0px;" align="center" valign="top">';

    // Header
    $info .= '<tr><td style="border:none;padding:20px;" align="left" valign="top">';
    $info .= '<img src="https://starter-theme-development.local/wp-content/themes/BE-Starter-master/assets/img/email-banner.jpg" style="display:block;padding-bottom:20px;width:100%;height:auto;max-width:1200px;"><a id="site_url_target_1" href="'.$blog_url.'" target="_blank" rel="noopener noreferrer"><img src="https://starter-theme-development.local/wp-content/themes/BE-Starter-master/assets/img/logo.jpg" alt=" '.$blog_name.' " title=" '.$blog_name.' " style="display:inline;max-height:20px;padding-bottom:0;"></a>';
    $info .= '</td></tr>';

    // Body
    $info .= '<tr> <td align="left" valign="top" style="background:#FFFFFF;border:none;font-family:Arial,sans-serif;font-size:15px;line-height:23px;padding:0px 20px 0px 20px;text-align:left;">';
    $info .= '<div style="text-align:left;padding:20px 0px 20px 0px;border-bottom:1px solid #DDDDDD;border-top:1px solid #DDDDDD;">';
    $info .= '[message]';
    $info .= '</div>';
    $info .= '</td></tr>';

    // Footer
    $info .= '<tr><td valign="top" style="border:none;color:#888888;font-family:Arial,sans-serif;font-size:13px;line-height:22px;padding:20px;text-align:left;">';
    $info .= '<p style="margin:0px;padding:0px;">';
    $info .= '&copy; '.date("Y").' ' .$blog_name. '. All Rights Reserved';
    $info .= '</p>';
    $info .= '</td></tr>';

    //
    $info .= '</td></tr>';
    $info .= '</tbody></table>';
    $info .= '</div>';

    return $info;

}
