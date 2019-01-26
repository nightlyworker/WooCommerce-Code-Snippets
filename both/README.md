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

## Author

* **Coded Commerce, LLC** - *Initial work* - [Coded-Commerce-LLC](https://github.com/Coded-Commerce-LLC)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
