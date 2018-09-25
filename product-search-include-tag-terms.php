<?php

// Filter the main query priority 10 with 2 arguments
add_filter( 'the_posts', 'storefront_child__search_by_product_tag', 10, 2 );

function storefront_child__search_by_product_tag( $posts, $query = false ) {
  	global $post_type;
    $is_product = isset( $post_type ) && is_array( $post_type )
        ? false === in_array( 'product', $post_type ) : false;

	// Only for searches of products
	if( ! is_search() || ! is_main_query() || ! $query || ! $is_product ) {
		return $posts;
	}

	// Product tags search
	$args = [
	  'post_type' => 'product',
	  'posts_per_page' => 5,
	  'product_tag' => get_search_query(),
	  'post__not_in' => wp_list_pluck( $posts, 'ID' ),
	];
	$results = get_posts( $args );

	// Store any new results
	if( $results ) {
		$posts = array_merge( $posts, $results );
		$query->posts = $posts;
		$query->found_posts = sizeof( $posts );
	}

	// Pass results
	return $posts;
}
