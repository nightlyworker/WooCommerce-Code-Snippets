<?php

// Hide front page title

add_filter( 'post_class', 'storefront_child__post_class' );

function storefront_child__post_class( $classes ) {
	if( is_front_page() ) {
		$classes[] = 'hidetitle';
	}
	return $classes;
}

