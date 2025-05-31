<?php

/**
 * Email Template Customization
 *
 * Modifies WordPress emails to use a custom HTML template with branding.
 * Adds banner image, logo, and styling while preserving message content.
 * Skips templating for emails that are already HTML formatted.
 *
 * @package    CoreFunctionality
 * @subpackage Emails
 * @since      2.0.0
 * @author     Patrick Boehner
 * @license    GPL-2.0+
 */


// If this file is called directly, abort.
//**********************
if( !defined( 'ABSPATH' ) ) exit;


add_action('acf/init', 'mycomp_add_email_options_page');
function mycomp_add_email_options_page() {
    if (function_exists('acf_add_options_sub_page')) {
        acf_add_options_sub_page(array(
            'page_title'  => 'Email Settings',
            'menu_title'  => 'Email Settings',
            'parent_slug' => 'options-general.php',
            'menu_slug'   => 'email-settings',
            'capability'  => 'manage_options'
        ));
    }
}



/**
 * Set email content type to HTML
 *
 * @since 2.0.0
 * @return string
 */
add_filter("wp_mail_content_type", "mycomp_set_email_content_type");
function mycomp_set_email_content_type() {
    return "text/html";
}


/**
 * Filter email content to add template
 *
 * @since 2.0.0
 * @param array $args Email arguments including message and headers
 * @return array Modified email arguments
 */
add_filter('wp_mail', 'mycomp_email_filter', 10, 1);
function mycomp_email_filter($args) {
    $message = wp_kses_post($args['message']);
    $message = wpautop($message, false);
    $template = mycomp_email_details();
    $args['message'] = str_replace("[message]", $message, $template);
    
    return $args;
}


/**
 * Generate HTML email template
 * 
 * Creates responsive HTML email template with header images,
 * styled content area, and footer. Uses WordPress options
 * for banner and logo images.
 *
 * Required options:
 * - email_banner_url: URL for header banner image
 * - email_logo_url: URL for company logo
 *
 * @since 2.0.0
 * @return string HTML template with [message] placeholder
 */
function mycomp_email_details() {
    // Configuration
    $max_width = '900px';
    
    // Styles
    $styles = [
        'body' => 'margin:0;padding:0;background:#FAFAFA;',
        'wrapper' => 'max-width:' . $max_width . ';margin:0 auto;background:#FAFAFA;padding:15px;',
        'table' => 'width:100%;background:#FFFFFF;border-collapse:collapse;',
        'cell' => 'padding:20px;',
        'banner' => 'display:block;width:100%;height:auto;max-width:' . $max_width . ';margin-bottom:20px;',
        'logo' => 'height:20px;display:block;',
        'logo_text' => 'display:block;text-decoration:none;color:#000;font-family:Arial,sans-serif;font-size:20px;',
        'content' => 'padding:20px;font-family:Arial,sans-serif;font-size:15px;line-height:1.5;',
        'content_box' => 'border-top:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;padding:20px 0;',
        'footer' => 'padding:20px;color:#888888;font-family:Arial,sans-serif;font-size:13px;'
    ];

    // Required WordPress data
    $blog_name = get_bloginfo('name');
    $blog_url = get_bloginfo('url');
    
    // Get paths from options
    $banner_id = get_option('options_email_banner_url');
    $logo_id = get_option('options_email_logo_url');

    $banner_image = wp_get_attachment_url($banner_id);
    $logo_image = wp_get_attachment_url($logo_id);
    
    // Error handling & exit early
    if (empty($blog_name) || empty($blog_url)) {
        error_log('Email template error: Required WordPress settings missing');
        return '[message]';
    }
    
    // Initialize
    $info = '';
    
    // Body
    $info .= '<!DOCTYPE html>';
    $info .= '<html lang="en">';
    $info .= '<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"></head>';
    $info .= '<body style="' . esc_attr($styles['body']) . '">';
    
    $info .= '<div style="' . esc_attr($styles['wrapper']) . '">';
    $info .= '<table role="presentation" border="0" cellpadding="0" cellspacing="0" style="' . esc_attr($styles['table']) . '">';
    
    // Header
    $info .= '<tr><td style="' . esc_attr($styles['cell']) . '">';
    if (!empty($banner_image)) {
        $info .= '<img src="' . esc_url($banner_image) . '" alt="Banner" style="' . esc_attr($styles['banner']) . '">';
    }
    
    if (!empty($logo_image)) {
        $info .= '<a href="' . esc_url($blog_url) . '" style="display:block;text-decoration:none;">';
        $info .= '<img src="' . esc_url($logo_image) . '" alt="' . esc_attr($blog_name) . '" style="' . esc_attr($styles['logo']) . '">';
        $info .= '</a>';
    } else {
        $info .= '<a href="' . esc_url($blog_url) . '" style="' . esc_attr($styles['logo_text']) . '">';
        $info .= esc_html($blog_name);
        $info .= '</a>';
    }
    $info .= '</td></tr>';
    
    // Content
    $info .= '<tr><td style="' . esc_attr($styles['content']) . '">';
    $info .= '<div style="' . esc_attr($styles['content_box']) . '">';
    $info .= '[message]';
    $info .= '</div>';
    $info .= '</td></tr>';
    
    // Footer
    $info .= '<tr><td style="' . esc_attr($styles['footer']) . '">';
    $info .= '&copy; ' . date("Y") . ' ' . esc_html($blog_name) . '. All Rights Reserved';
    $info .= '</td></tr>';
    
    $info .= '</table>';
    $info .= '</div>';
    $info .= '</body></html>';
    
    return $info;
}
