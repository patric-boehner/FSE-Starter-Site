<?php
/**
 * Title: Footer
 * Slug: fse-starter/footer-default
 * Categories: footer
 * Block Types: core/template-part/footer
 */
?>
<!-- wp:group {"metadata":{"name":"Site Footer"},"align":"full","className":"footer-base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull footer-base">

<!-- wp:group {"align":"wide","layout":{"type":"flex","allowOrientation":false,"justifyContent":"space-between"}} -->
	<div class="wp-block-group alignwide">

		<!-- wp:paragraph {"className":"copyright"} -->
		<p class="copyright"><?php echo esc_html( get_fse_copyyright() ); ?></p>
		<!-- /wp:paragraph -->
		<!-- wp:navigation {"ref":13,"overlayMenu":"never"} /-->
		 
	</div>
	<!-- /wp:group -->

</div>
<!-- /wp:group -->