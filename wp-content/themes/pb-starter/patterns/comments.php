<?php
/**
 * Title: Comments section and form
 * Slug: fse-starter/comments
 * Inserter: no
 */
?>

<!-- wp:group {"tagName":"section","metadata":{"name":"Comments"},"className":"entry-comments","layout":{"type":"constrained"}} -->
<section class="wp-block-group entry-comments">
	<!-- wp:comments {"className":"wp-block-comments-query-loop"} -->
	<div class="wp-block-comments wp-block-comments-query-loop">
		<!-- wp:heading -->
		<h2><?php echo esc_html__( 'Comments', 'pb-starter' ); ?></h2>
		<!-- /wp:heading -->
		<!-- wp:comments-title {"level":3} /-->
		<!-- wp:group -->
		<div class="wp-block-group">
			<!-- wp:comment-template -->
			<!-- wp:group {"tagName":"article","layout":{"type":"default"}} -->
			<article class="wp-block-group">
				<!-- wp:group {"tagName":"header","layout":{"type":"flex","flexWrap":"nowrap"}} -->
				<header class="wp-block-group">
					<!-- wp:avatar {"size":48} /-->
					<!-- wp:group {"layout":{"type":"default"}} -->
					<div class="wp-block-group">
						<!-- wp:comment-author-name /-->
						<!-- wp:group {"layout":{"type":"flex"}} -->
						<div class="wp-block-group">
							<!-- wp:comment-date /-->
							<!-- wp:comment-edit-link /-->
						</div>
						<!-- /wp:group -->
					</div>
					<!-- /wp:group -->
				</header>
				<!-- /wp:group -->
				<!-- wp:comment-content /-->
				<!-- wp:comment-reply-link /-->
			</article>
			<!-- /wp:group -->
			<!-- /wp:comment-template -->
		</div>
		<!-- /wp:group -->
		<!-- wp:comments-pagination -->
		<!-- wp:comments-pagination-previous /-->
		<!-- wp:comments-pagination-numbers /-->
		<!-- wp:comments-pagination-next /-->
		<!-- /wp:comments-pagination -->
		<!-- wp:post-comments-form /-->
	</div>
	<!-- /wp:comments -->
</section>
<!-- /wp:group -->


