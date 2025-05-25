<?php
/**
 * Replace JS based skip links
 *
 * @package pb-starter
 **/

add_action( 'wp_enqueue_scripts', 'fse_remove_skip_link_script', 20 );
function fse_remove_skip_link_script() {

    wp_dequeue_script( 'wp-block-template-skip-link' );
    wp_deregister_script( 'wp-block-template-skip-link' );

}


/**
 * Adds skip links for accessibility before the header.
 *
 * This function determines which skip links are needed based on the presence
 * of certain templates. It then calls the function to render these links.
 */
add_action( 'wp_body_open', 'fse_output_skip_link', 1 );
function fse_output_skip_link() {

    $template = get_page_template_slug();

	// Determine which skip links are needed.
	$links = [];

	$links['main-content'] = esc_html__( 'Skip to main content', 'pb-starter' );

    if ( $template !== 'blank' ) {
        $links['footer'] = esc_html__( 'Skip to footer', 'pb-starter' );
	}

    // Render the skip links HTML
    if( function_exists( 'fse_render_skip_links' ) ) {
        fse_render_skip_links( $links );
    }
    
}


/**
 * Renders the skip links HTML.
 *
 * This function takes an array of links and outputs them as a list of
 * skip links for accessibility purposes.
 *
 * @param array $links Array of skip links to render. The keys are the IDs
 *              of the target elements, and the values are the link texts.
 */
function fse_render_skip_links( $links ) {

    ?>
    <div class="skip-links">

        <?php foreach ( $links as $key => $value ) : ?>

            <a class="skip-link screen-reader-text" href="<?= esc_url( '#' . $key ); ?>"><?= esc_html( $value ); ?></a>

        <?php endforeach; ?>

        </div>
    <?php

}


/**
 * Adds an ID to the header for skip links.
 *
 * This function modifies the header block to include an ID attribute
 * for accessibility purposes, allowing skip links to target it.
 */
add_filter( 'render_block_core/template-part', 'fse_add_footer_id_for_skiplink', 10, 2 );
function fse_add_footer_id_for_skiplink( $block_content, $block ) {

    // Check if this is a template part block and if it's the footer
    if (isset($block['attrs']['slug']) && $block['attrs']['slug'] === 'footer') {

         $block_content = str_replace(
            '<footer',
            '<footer id="footer"',
            $block_content
        );
    
    }

    return $block_content;

}



