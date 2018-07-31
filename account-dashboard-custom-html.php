<?php

// Authenticated user account dashboard panel

function storefront_child__woocommerce_account_dashboard() {
	echo '
	  <h2>Custom Section</h2>
	';
}

add_action( 'woocommerce_account_dashboard', 'storefront_child__woocommerce_account_dashboard' );
