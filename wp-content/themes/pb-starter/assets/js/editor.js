/**
 * Unregister the Gutenberg blocks, style and variations that are not going to be used on the website
 */
wp.domReady(() => {
    
    // Button styles (skip 'default' - can't unregister default styles)
    wp.blocks.unregisterBlockStyle('core/button', 'fill');
    wp.blocks.unregisterBlockStyle('core/button', 'outline');
    
    // Separator styles  
    wp.blocks.unregisterBlockStyle('core/separator', 'wide');
    wp.blocks.unregisterBlockStyle('core/separator', 'dots');
    
    // Quote styles
    wp.blocks.unregisterBlockStyle('core/quote', 'large');
    wp.blocks.unregisterBlockStyle('core/quote', 'plain');
    
    // Image styles
    wp.blocks.unregisterBlockStyle('core/image', 'rounded');
    
    // Social Links styles
    wp.blocks.unregisterBlockStyle('core/social-links', 'logos-only');
    wp.blocks.unregisterBlockStyle('core/social-links', 'pill-shape');

    // Register new block stlyes
    wp.blocks.registerBlockStyle('core/button', {
        name: 'primary',
        label: 'Primary',
        isDefault: true,
    });
    wp.blocks.registerBlockStyle('core/button', {
        name: 'secondary',
        label: 'Secondary',
    });

    wp.blocks.registerBlockStyle('core/list', {
        name: 'default',
        label: 'Default',
        isDefault: true,
    });

    wp.blocks.registerBlockStyle('core/list', {
        name: 'no-bullets',
        label: 'No Bullets',
    });

    wp.blocks.registerBlockStyle('core/list', {
        name: 'checkmarks',
        label: 'Checkmarks',
    });

    wp.blocks.registerBlockStyle('core/list', {
        name: 'arrows',
        label: 'Arrows',
    });
    
});