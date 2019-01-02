<?php

// My account custom sidebar link

add_filter( 'woocommerce_account_menu_items', 'storefront_child__woocommerce_account_menu_items' );

function storefront_child__woocommerce_account_menu_items( $items ) {
	return array_merge( [ 'survey' => 'Free Project Consult' ], $items );
}

