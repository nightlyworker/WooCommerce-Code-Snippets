<?php

// Remove WooCommerce status dashboard widget

add_action( 'wp_user_dashboard_setup', 'storefront_child__wp_dashboard_setup', 20 );
add_action( 'wp_dashboard_setup', 'storefront_child__wp_dashboard_setup', 20 );

function storefront_child__wp_dashboard_setup() {
	remove_meta_box( 'woocommerce_dashboard_status', 'dashboard', 'normal' );
}

