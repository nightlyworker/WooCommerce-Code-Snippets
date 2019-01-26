<?php

// Add SKU to product search

// Credits to: https://iconicwp.com/blog/add-product-sku-woocommerce-search/

add_filter( 'posts_join', 'iconic_product_search_join', 10, 2 );
add_filter( 'posts_where', 'iconic_product_search_where', 10, 2 );

function iconic_product_search_join( $join, $query ) {
	if ( ! $query->is_main_query() || is_admin() || ! is_search() || ! is_woocommerce() ) {
		return $join;
	}
	global $wpdb;
	$join .= " LEFT JOIN {$wpdb->postmeta} iconic_post_meta ON {$wpdb->posts}.ID = iconic_post_meta.post_id ";
	return $join;
}

function iconic_product_search_where( $where, $query ) {
	if ( ! $query->is_main_query() || is_admin() || ! is_search() || ! is_woocommerce() ) {
		return $where;
	}
	global $wpdb;
	$where = preg_replace(
		"/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
		"( {$wpdb->posts}.post_title LIKE $1 ) OR ( iconic_post_meta.meta_key = '_sku' AND iconic_post_meta.meta_value LIKE $1 )",
		$where
	);
	return $where;
}
