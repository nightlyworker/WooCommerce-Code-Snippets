<?php

// Remove payment gateways by product

add_filter( 'woocommerce_available_payment_gateways', 'storefront_child__woocommerce_available_payment_gateways' );
 
function storefront_child__woocommerce_available_payment_gateways( $gateways ) {
	global $woocommerce;
	$cart_items = $woocommerce->cart->get_cart();
	foreach( $cart_items as $cart_item ) {
		if( $cart_item['product_id'] == 639 ) {
			unset( $gateways['amazon'] );
			unset( $gateways['cheque'] );
			unset( $gateways['paypal'] );
			unset( $gateways['stripe'] );
		}
	}
	return $gateways;
}
