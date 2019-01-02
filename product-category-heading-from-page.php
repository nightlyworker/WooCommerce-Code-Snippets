<?php

// Product category heading from page

add_action( 'woocommerce_before_shop_loop', 'storefront_child__woocommerce_before_shop_loop' );

function storefront_child__woocommerce_before_shop_loop() {
	global $wp_query;
	$current_category = $wp_query->get_queried_object()->name;
	if( $current_category != 'Services' ) { return; }
	$args = array(
		'name' => 'services',
		'post_type' => 'page',
		'post_status' => 'publish',
		'numberposts' => 1
	);
	$results = get_posts( $args );
	if( $results ) {
		echo apply_filters('the_content', $results[0]->post_content );
		//print_r( $results[0] );
	}
}
