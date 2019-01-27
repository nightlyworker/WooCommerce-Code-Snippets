# WooCommerce Code Snippets - Front End Usage

## Background

Contains code snippets useful for WooCommerce shops on the visitor side of the site. For other contexts, see [project main page](https://github.com/Coded-Commerce-LLC/WooCommerce-Code-Snippets).

These code snippets are intended for use with the [Code Snippets](https://wordpress.org/plugins/code-snippets/) plugin for WordPress.

## Storefront or Theme Based

### Enables shortcode execution in widgets
```
add_filter( 'widget_text', 'do_shortcode' );
```

### Storefront customize footer links
```
add_action( 'init', function() {
	remove_action( 'storefront_footer', 'storefront_credit', 20 );
}, 10 );
```

### Disable product page zoom
```
add_action( 'after_setup_theme', function() { 
	remove_theme_support( 'wc-product-gallery-zoom' );
	remove_theme_support( 'wc-product-gallery-lightbox' );
	remove_theme_support( 'wc-product-gallery-slider' );
}, 99 );
```

### Disable front page title
```
add_filter( 'post_class', function( $classes ) {
	if( is_front_page() ) {
		$classes[] = 'hidetitle';
	}
	return $classes;
} );
```

### Sets `X-Frame-Options` header for PCI compliance scanners
```
add_action( 'send_headers',function() {
	header( 'X-Frame-Options: SAMEORIGIN' );
} );
```

### Elementor adds shortcode for hooking in templates `do_shortcode( '[INSERT_ELEMENTOR id="226"]' );`
```
namespace Elementor;
add_shortcode( 'INSERT_ELEMENTOR', 'Elementor\wts_insert_elementor' );
function wts_insert_elementor( $atts ) {
	if( ! class_exists( 'Elementor\Plugin' ) ) {
		return '';
	}
	if( ! isset( $atts['id'] ) || empty( $atts['id'] ) ) {
		return '';
	}
	$post_id = $atts['id'];
	$response = Plugin::instance()->frontend->get_builder_content_for_display( $post_id );
	return $response;
}
```

## JetPack Plugin

### User registrations to JetPack
```
add_action( 'user_register', function( $user_id ) {
    if( empty( $_POST['email'] ) ) { return; }
	if( ! class_exists( 'Jetpack_Subscriptions' ) ) { return; }
	$response = Jetpack_Subscriptions::subscribe( $_POST['email'], 0, false );
}, 10, 1 );
```

### JetPack custom sign up form
```
add_shortcode( 'storefront_child__follow', function( $atts ) {
	$redirect = isset( $atts['redirect'] ) ? intval( $atts['redirect'] ) : '';
	ob_start();
?>
<form method="POST" action="/wp-json/jetpack/follow/<?php echo $redirect; ?>">
<input type="email" name="email" placeholder="Enter your email address" required="required" />
<input type="submit" value="Download the Presentation (PDF)" />
</form>
<?php
	return ob_get_clean();
} );

// ReST API Set-up
add_action( 'rest_api_init', function() {
	register_rest_route(
		'jetpack', '/follow/(?P<redirect>\d+)', array(
			'methods' => WP_REST_Server::ALLMETHODS,
			'callback' => 'storefront_child__jetpack_follow_submit',
		)
	);
} );
function storefront_child__jetpack_follow_submit( $atts ) {
	$redirect = isset( $atts['redirect'] ) ? wp_get_attachment_url( intval( $atts['redirect'] ) ) : '/';
	$email = isset( $_REQUEST['email'] ) ? $_REQUEST['email'] : '';
	if( ! $email ) {
		return json_encode( 'Error: Invalid email address.' );
	}
	if( ! class_exists( 'Jetpack_Subscriptions' ) ) {
		return json_encode( 'Error: JetPack is unavailable.' );
	}
	$response = Jetpack_Subscriptions::subscribe( $email, 0, false );
	//return json_encode( $response );
	wp_redirect( $redirect );
	exit;
}
```

## Adding WooCommerce Features

### Add my-account custom sidebar link
```
add_filter( 'woocommerce_account_menu_items', function( $items ) {
	return array_merge( [ 'survey' => 'Free Project Consult' ], $items );
} );
```

### Add-to-cart redirection to checkout
```
add_filter( 'woocommerce_add_to_cart_redirect', function( $wc_cart_url ) {
	return wc_get_checkout_url();
} );
```

### Sort shipping methods by price
```
add_filter( 'woocommerce_package_rates' , function( $rates, $package ) {
	if( ! $rates ) { return; }
	$rate_cost = array();
	foreach( $rates as $rate ) {
		$rate_cost[] = $rate->cost;
	}
	array_multisort( $rate_cost, $rates );
	return $rates;
}, 10, 2 );
```

### Empty cart when adding a second item
```
add_filter( 'woocommerce_add_to_cart_validation', function( $passed, $product_id, $quantity ) {
	if( ! WC()->cart->is_empty()) {
		WC()->cart->empty_cart();
	}
	return $passed;
}, 20, 3 );
```

### Add variable product options to product archives
```
// Credits to: https://iconicwp.com/blog/show-variations-shop-page-woocommerce/
add_action( 'init', function() {
    remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
    add_action( 'woocommerce_after_shop_loop_item', function() {
		global $product;
		if ( ! $product->is_type( 'variable' ) ) {
			woocommerce_template_loop_add_to_cart();
			return;
		}
		remove_action( 'woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20 );
		add_action( 'woocommerce_single_variation', function() {
			global $product; 
			?>
			<div class="woocommerce-variation-add-to-cart variations_button">
				<button type="submit" class="single_add_to_cart_button button"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
				<input type="hidden" name="add-to-cart" value="<?php echo absint( $product->get_id() ); ?>" />
				<input type="hidden" name="product_id" value="<?php echo absint( $product->get_id() ); ?>" />
				<input type="hidden" name="variation_id" class="variation_id" value="0" />
			</div>
			<?php
		}, 20 );
		woocommerce_template_single_add_to_cart();
	}, 10 );
}, 10 );
```

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

### Add tag terms and categories to product search
```
add_filter( 'the_posts', function( $posts, $query = false ) {
	if( ! is_search() ) { return $posts; }
	$args = [
		'post_type' => 'product',
		'posts_per_page' => 200,
		'product_tag' => get_search_query(),
		'post__not_in' => wp_list_pluck( $posts, 'ID' ),
	];
	$results = get_posts( $args );
	if( $results ) {
		$posts = array_merge( $posts, $results );
		$query->found_posts = sizeof( $posts );
	}
	$args = [
		'post_type' => 'product',
		'posts_per_page' => 200,
		'product_cat' => get_search_query(),
		'post__not_in' => wp_list_pluck( $posts, 'ID' ),
	];
	$results = get_posts( $args );
	if( $results ) {
		$posts = array_merge( $posts, $results );
		$query->found_posts = sizeof( $posts );
	}
	return $posts;
}, 10, 2 );
```

## Removing WooCommerce Features

### Disable added-to-cart message
```
add_filter( 'wc_add_to_cart_message_html', '__return_false' );
```

### Disable add-to-cart buttons and ability to checkout
```
add_action( 'init', function() {
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
} );
add_filter( 'woocommerce_is_purchasable', '__return_false' );
```

### Disable products archive sort options
```
add_filter( "woocommerce_catalog_orderby", function( $orderby ) {
	//unset( $orderby["price"] );
	//unset( $orderby["price-desc"] );
	unset( $orderby["rating"] );
	return $orderby;
}, 20 );
```

### Disable payment gateways by product
```
add_filter( 'woocommerce_available_payment_gateways', function( $gateways ) {
	global $woocommerce;
	$cart_items = $woocommerce->cart->get_cart();
	foreach( $cart_items as $cart_item ) {
		if( $cart_item['product_id'] == 639 ) {
			unset( $gateways['amazon'] );
			unset( $gateways['cheque'] );
			unset( $gateways['paypal'] );
			unset( $gateways['stripe'] );
		}
	}
	return $gateways;
} );
```

## Author

* **Coded Commerce, LLC** - *Initial work* - [Coded-Commerce-LLC](https://github.com/Coded-Commerce-LLC)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
