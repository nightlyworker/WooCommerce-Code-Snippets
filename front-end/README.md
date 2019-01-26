# WooCommerce Code Snippets - Front End

Contains code snippets useful for WooCommerce shops on the visitor side of the site.

## Usage

These code snippets are intended for use with the [Code Snippets](https://wordpress.org/plugins/code-snippets/) plugin for WordPress.

### Add SKU to product search

```
// Credits to: https://iconicwp.com/blog/add-product-sku-woocommerce-search/
add_filter( 'posts_join', function( $join, $query ) {
	if ( ! $query->is_main_query() || is_admin() || ! is_search() || ! is_woocommerce() ) {
		return $join;
	}
	global $wpdb;
	$join .= " LEFT JOIN {$wpdb->postmeta} iconic_post_meta ON {$wpdb->posts}.ID = iconic_post_meta.post_id ";
	return $join;
}, 10, 2 );
add_filter( 'posts_where', function( $where, $query ) {
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
}, 10, 2 );

```

## Author

* **Coded Commerce, LLC** - *Initial work* - [Coded-Commerce-LLC](https://github.com/Coded-Commerce-LLC)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
