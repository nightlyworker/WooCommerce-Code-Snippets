<?php

// Prints before the My Account log in and sign up forms

function storefront_child__woocommerce_before_customer_login_form() {
	echo '
	  <h4>Please log in or register an account to continue.</h4><br />
	';
}

add_action( 'woocommerce_before_customer_login_form', 'storefront_child__woocommerce_before_customer_login_form' );
