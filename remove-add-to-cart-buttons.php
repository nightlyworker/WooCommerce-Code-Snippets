<?php

add_action( 'init', 'storefront_child__init' );

function storefront_child__init() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
	//remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}

add_filter( 'woocommerce_is_purchasable', '__return_false' );
