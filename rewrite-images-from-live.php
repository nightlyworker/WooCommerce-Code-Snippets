<?php

// Rewrites all Media Library images to pull from production.
function storefront_child__rewrite() {
	$production = 'https://codedcommerce.com';
	add_rewrite_rule( '^/wp-content/uploads/(.*)?', $production . '/wp-content/uploads/$matches[1]', 'top' );
}

add_action( 'init', 'storefront_child__rewrite' );
