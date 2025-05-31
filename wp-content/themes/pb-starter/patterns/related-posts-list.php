<?php
/**
 * Title: List of Related Posts
 * Slug: fse-starter/related-posts-list
 * Inserter: no
 */
?>
<!-- wp:group {"metadata":{"name":"Related Posts"},"align":"full","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull">

	<!-- wp:query {"queryId":1,"query":{"order":"desc","orderBy":"date","postType":"posts","perPage":3,"offset":0,"inherit":false},"namespace":"related-posts","align":"wide"} -->
	<div class="wp-block-query alignwide">

		<!-- wp:heading -->
		<h2 class="wp-block-heading"><?php echo esc_html__( 'Related Posts', 'pb-starter' ) ?></h2>
		<!-- /wp:heading -->

		<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->

			<!-- wp:post-featured-image {"aspectRatio":"16/9"} /-->
			<!-- wp:post-title {"level":3,"isLink":true} /-->
			 
		<!-- /wp:post-template -->

	</div>
	<!-- /wp:query -->

</div>
<!-- /wp:group -->