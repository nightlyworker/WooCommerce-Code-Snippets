<?php

// Add To Cart Redirects To Checkout

function storefront_child__woocommerce_add_to_cart_redirect( $wc_cart_url ) {
	return wc_get_checkout_url();
}

add_filter( 'woocommerce_add_to_cart_redirect', 'storefront_child__woocommerce_add_to_cart_redirect' );
