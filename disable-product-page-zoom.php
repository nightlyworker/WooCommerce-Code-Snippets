<?php

// Disable product page zoom

add_action( 'after_setup_theme', 'storefront_child__after_setup_theme', 99 );

function storefront_child__after_setup_theme() { 
	remove_theme_support( 'wc-product-gallery-zoom' );
	//remove_theme_support( 'wc-product-gallery-lightbox' );
	//remove_theme_support( 'wc-product-gallery-slider' );
}
