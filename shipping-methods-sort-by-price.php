<?php

function storefront_child__woocommerce_package_rates( $rates, $package ) {
	if ( ! $rates )  return;	
	$rate_cost = array();
	foreach( $rates as $rate ) {
		$rate_cost[] = $rate->cost;
	}
	array_multisort( $rate_cost, $rates );	
	return $rates;
}

add_filter( 'woocommerce_package_rates' , 'storefront_child__woocommerce_package_rates', 10, 2 );
