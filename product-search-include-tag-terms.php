<?php

// Extends product search widget or Storefront theme product search to include tags
// or any other taxonomies you should modify here

function storefront_child__search_by_product_tag( $posts, $query = false ) {

	// Only for searches
	if( ! is_search() || ! is_main_query() || ! $query ) {
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

add_filter( 'the_posts', 'storefront_child__search_by_product_tag', 10, 2 );
