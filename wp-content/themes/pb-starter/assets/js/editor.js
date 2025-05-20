/**
 * Unregister the Gutenberg blocks, style and variations that are not going to be used on the website
 */
wp.domReady(() => {

	// List of the Gutenberg blocks that would be unregistered
	const unusedBlocks = [
		'core/classic',
		'core/code',
		'core/verse',
		'core/preformatted',
		'core/pullquote',
		'core/calendar',
		'core/archives',
        'core/latest-comments', 
        'core/missing',
		'core/tag-cloud',
		'core/post-author',
		'core/legacy-widget',
		'core/latest-posts',
		'core/more',
		'core/nextpage',
		'core/spacer',
		'core/categories',
		'core/page-list',
		'core/rss',
	];

	const embedBlockVariations = wp.blocks.getBlockVariations('core/embed');
	const keepEmbeds = [
		'twitter',
        'vimeo',
		'youtube',
		'bluesky',
	];

	for (let i = 0; i < unusedBlocks.length; i++) {
		wp.blocks.unregisterBlockType(unusedBlocks[i]);
	}

	for (let i = 0; i < embedBlockVariations.length; i++) {
		if (!keepEmbeds.includes(embedBlockVariations[i].name)) {
			wp.blocks.unregisterBlockVariation(
				'core/embed',
				embedBlockVariations[i].name
			);
		}
	}


	wp.blocks.unregisterBlockStyle(
		'core/button',
		[ 'default', 'fill', 'outline' ]
	);


	wp.blocks.unregisterBlockStyle(
		'core/separator',
		[ 'default', 'wide', 'dots' ]
	);

	wp.blocks.unregisterBlockStyle(
		'core/quote',
		[ 'default', 'large', 'plain' ]
	);

	wp.blocks.unregisterBlockStyle(
		'core/image',
		[ 'default', 'rounded' ]
	);

	wp.blocks.unregisterBlockStyle(
		'core/social-links',
		[ 'default', 'logos-only', 'pill-shape' ]
	);

});