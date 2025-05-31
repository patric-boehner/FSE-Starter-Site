<?php
/**
 * Block template for: acf/block-area
 *
 * Dynamically pulls in a "content_area" post based on the selected block area location.
 */

// Get the selected taxonomy term (location) from ACF
$term_id = get_field('block_area_id');
$term = $term_id ? get_term($term_id, 'block_area_location') : null;
$term_slug = $term ? $term->slug : '';

// Dynamic block ID
$block_id = 'wp-block-area-' . $term_id;
if ( isset( $block['anchor'] ) ) {
    $block_id = $block['anchor'];
}

// Classes
$class_name = 'wp-block-area';
if ( $term_slug ) {
    $class_name .= ' wp-block-area-' . $term_slug;
}
if ( !empty( $block['className'] ) ) {
    $class_name .= ' ' . $block['className'];
}

// Show editor-only message if no area is selected
if ( empty( $term_id ) ) {
    if ( is_admin() ) {
        echo '<div class="wp-block-area wp-block-area__missing"><em>Please select a block area to display content.</em></div>';
    }
    return;
}


// Query the content_area post tied to the selected taxonomy term
$query = new WP_Query([
    'post_type'      => 'content_area',
    'posts_per_page' => 1,
    'tax_query'      => [[
        'taxonomy' => 'block_area_location',
        'field'    => 'term_id',
        'terms'    => $term_id,
    ]],
]);


if ( $query->have_posts() ) :

    while ( $query->have_posts() ) :
        $query->the_post();
        echo '<div id="' . esc_attr($block_id) . '" class="' . esc_attr($class_name) . '">';
            the_content();
        echo '</div>';
    endwhile;

    wp_reset_postdata();

elseif (is_admin()) :

    echo '<div class="wp-block-area wp-block-area__empty"><em>No content found for this block area.</em></div>';

endif;
