<?php

// Empty cart when adding item

add_filter( 'woocommerce_add_to_cart_validation', 'storefront_child__woocommerce_add_to_cart_validation', 20, 3 );

function storefront_child__woocommerce_add_to_cart_validation( $passed, $product_id, $quantity ) {
	if( ! WC()->cart->is_empty()) {
		WC()->cart->empty_cart();
	}
	return $passed;
}

