<?php

// Adds content to authenticated user account dashboard panel

function storefront_child__woocommerce_account_dashboard() {
	$content_post = get_post( 987 );
	$content = $content_post->post_content;
	echo apply_filters( 'the_content', $content );
}

add_action( 'woocommerce_account_dashboard', 'storefront_child__woocommerce_account_dashboard' );
