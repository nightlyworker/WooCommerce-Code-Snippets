<?php

// Copy Woo emails for a specific customer to an address
// Use plugin "User Meta Manager" to populate the user meta field `billing_email_cc` accordingly

add_filter( 'woocommerce_email_headers', 'storefront_child__woocommerce_email_headers', 10, 3 );

function storefront_child__woocommerce_email_headers( $headers, $email_id, $order ) {

	// Only for "Completed Order" email notification
	/*
	if( 'customer_completed_order' !== $email_id ) {
		return $header;
	}
	*/

	// Get the custom email from user meta data  (with the correct User ID)
	$cc_email = get_user_meta( $order->get_user_id(), 'billing_email_cc', true );

	// Exit if no Cc is set
	if( empty( $cc_email ) ) { 
		return $headers;
	}

	// Add Cc to headers
	$headers .= 'Cc: ' . utf8_decode( $cc_email ) . '\r\n';
    return $headers;
}
