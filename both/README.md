# WooCommerce Code Snippets - Front And Back End

## Background

Contains code snippets useful for WooCommerce shops on both the visitor side of the site and the administrative side. For specific contexts, see [project main page](https://github.com/Coded-Commerce-LLC/WooCommerce-Code-Snippets).

These code snippets are intended for use with the [Code Snippets](https://wordpress.org/plugins/code-snippets/) plugin for WordPress.

### Copy Woo emails for a specific customer to an address based on user meta `billing_email_cc`
```
add_filter( 'woocommerce_email_headers', function( $headers, $email_id, $order ) {
	$cc_email = get_user_meta( $order->get_user_id(), 'billing_email_cc', true );
	if( empty( $cc_email ) ) { return $headers; }
	$headers .= 'Cc: ' . utf8_decode( $cc_email ) . '\r\n';
    return $headers;
}, 10, 3 );
```

### Disable password reset admin emails
```
add_filter( 'send_password_change_email', '__return_false' );
```

### Stop user enumerations for PCI scanner compliance
```
// Credits: https://plugins.trac.wordpress.org/browser/stop-user-enumeration/trunk/frontend/class-frontend.php
add_action( 'plugins_loaded', function() {
	if( ! is_user_logged_in() && isset( $_REQUEST['author'] ) ) {
		if( preg_match( '/\\d/', $_REQUEST['author'] ) > 0 ) {
			wp_die(
				esc_html__( 'forbidden - number in author name not allowed = ', 'stop-user-enumeration' )
				. esc_html( $_REQUEST['author'] )
			);
		}
	}
} );
add_action( 'rest_authentication_errors', function( $access ) {
	if(
		preg_match( '/users/', $_SERVER['REQUEST_URI'] ) !== 0
		|| isset( $_REQUEST['rest_route'] ) && preg_match( '/users/', $_REQUEST['rest_route'] ) !== 0
	) {
		if( ! is_user_logged_in() ) {
			return new WP_Error(
				'rest_cannot_access',
				esc_html__( 'Only authenticated users can access the User endpoint REST API.', 'stop-user-enumeration' ),
				array( 'status' => rest_authorization_required_code() )
			);
		}
	}
	return $access;
} );
```

## Author

* **Coded Commerce, LLC** - *Initial work* - [Coded-Commerce-LLC](https://github.com/Coded-Commerce-LLC)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
