<?php

// User Registrations Get Added To JetPack

function storefront_child__user_register( $user_id ) {
    if( empty( $_POST['email'] ) ) { return; }
	if( ! class_exists( 'Jetpack_Subscriptions' ) ) { return; }
	$response = Jetpack_Subscriptions::subscribe( $_POST['email'], 0, false );
}

add_action( 'user_register', 'storefront_child__user_register', 10, 1 );
