# WooCommerce Code Snippets - Back End

## Background

Contains code snippets useful for WooCommerce shops on the administrator side of the site. For other contexts, see [project main page](https://github.com/Coded-Commerce-LLC/WooCommerce-Code-Snippets).

These code snippets are intended for use with the [Code Snippets](https://wordpress.org/plugins/code-snippets/) plugin for WordPress.

### Disable WooCommerce status dashboard widget
```
add_action( 'wp_user_dashboard_setup', 'storefront_child__wp_dashboard_setup', 20 );
add_action( 'wp_dashboard_setup', 'storefront_child__wp_dashboard_setup', 20 );
function storefront_child__wp_dashboard_setup() {
	remove_meta_box( 'woocommerce_dashboard_status', 'dashboard', 'normal' );
}
```

### Disable connect-to-WooCommerce.com notice
```
add_filter( 'woocommerce_helper_suppress_admin_notices', '__return_true' );
```

### Enable Code Snippets and Appearance section access for Editors
```
add_filter( 'code_snippets_role', function( $value ) { return 'editor'; } );
add_filter( 'code_snippets_cap', function( $value ) { return 'edit_published_pages'; } );
add_action( 'init', function() {
	$role_object = get_role( 'editor' );
	$role_object->add_cap( 'edit_theme_options' );
} );
```

### Show Order Histories on User Profiles
```
add_action( 'edit_user_profile', function( $profileuser ) {
	if( ! current_user_can( 'administrator' ) ) { return; }
	$orderhistory = get_posts( [
		'numberposts' => -1,
		'meta_key' => '_customer_user',
		'meta_value' => $profileuser->ID,
		'post_type' => wc_get_order_types(),
		'post_status' => array_keys( wc_get_order_statuses() ),
	] );
	?>
	<table class="form-table">
		<tr>
			<th>Order History</th>
			<td>
				<?php
				foreach( $orderhistory as $post ) {
					$order = wc_get_order( $post->ID );
					echo sprintf(
						'<div>Order <a href="post.php?post=%d&action=edit">%s</a> (%s)</div>',
						$post->ID, $order->get_order_number(), $order->get_status()
					);
				}
				?>
			</td>
		</tr>
	</table>
	<?php
} );
```

### Login page custom logo and message
```
add_action( 'login_enqueue_scripts', function() {
	?>
	<style type="text/css">
		#login h1 a, .login h1 a {
			background-image: url( 'https://acceleratedstore.com/wp-content/uploads/2018/12/accelerated-store-logo.png' );
			height: 85px;
			width: 350px;
			background-size: 350px 85px;
			background-repeat: no-repeat;
		}
	</style>
	<?php
} );
add_filter( 'login_headerurl', function() {
	return home_url();
} );
add_filter( 'login_headertitle', function() {
	return 'Accelerated Store Demo';
} );
add_filter( 'login_message', function( $message ) {
	if( empty( $message ) ) {
		return '<h1>Welcome!</h1>';
	} else {
		return $message;
	}
} );

```

## Author

* **Coded Commerce, LLC** - *Initial work* - [Coded-Commerce-LLC](https://github.com/Coded-Commerce-LLC)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
