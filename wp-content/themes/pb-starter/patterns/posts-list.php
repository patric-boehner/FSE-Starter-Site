<?php
/**
 * Title: List of posts
 * Slug: fse-starter/posts-list
 * Inserter: no
 */
?>
<!-- wp:query {"queryId":1,"query":{"perPage":3,"pages":0,"offset":0,"postType":"post","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[],"format":[]},"className":"alignwide"} -->
<div class="wp-block-query alignwide">
	
	<!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->

		<!-- wp:pattern {"slug":"fse-starter/post-card"} /-->

	<!-- /wp:post-template -->

	<!-- wp:pattern {"slug":"fse-starter/query-pagination"} /-->

</div>
<!-- /wp:query -->