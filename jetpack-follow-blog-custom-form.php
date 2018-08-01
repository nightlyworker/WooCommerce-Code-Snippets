<?php

/**
* Handles Custom Forms For Blog Follow And Redirect
* Redirects subscribers to the media library item you put as ID
* Could also be used as a page ID with `get_permalink()` instead
* Shortcode usage: [storefront_child__follow redirect="ID"]
*/

// Shortcode That Prints Form
function storefront_child__jetpack_follow_form( $atts ) {
	$redirect = isset( $atts['redirect'] ) ? intval( $atts['redirect'] ) : '';
	ob_start();
?>
<form method="POST" action="/wp-json/jetpack/follow/<?php echo $redirect; ?>">
<input type="email" name="email" placeholder="Enter your email address" required="required" />
<input type="submit" value="Download the Presentation (PDF)" />
</form>
<?php
	return ob_get_clean();
}
add_shortcode( 'storefront_child__follow', 'storefront_child__jetpack_follow_form' );

// ReST API Set-up
function storefront_child__jetpack_follow_init() {
	register_rest_route(
		'jetpack', '/follow/(?P<redirect>\d+)', array(
			'methods' => WP_REST_Server::ALLMETHODS,
			'callback' => 'storefront_child__jetpack_follow_submit',
		)
	);
}
add_action( 'rest_api_init', 'storefront_child__jetpack_follow_init' );

// ReST API Submit
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
