<?php

// Shows logged out users a link to log in in place of prices

function storefront_child__formatted_woocommerce_price( $price ) {
	return get_current_user_id()
	  	? $price
	  	: sprintf(
		  	'<a href="%s">Login to view</a>',
		  	get_permalink( get_option('woocommerce_myaccount_page_id') )
		);
}

add_filter( 'formatted_woocommerce_price', 'storefront_child__formatted_woocommerce_price' );
