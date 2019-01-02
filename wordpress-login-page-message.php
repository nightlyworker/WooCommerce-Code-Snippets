<?php

// WordPress login page message

add_filter( 'login_message', 'storefront_child__login_message' );

function storefront_child__login_message( $message ) {
    if ( empty($message) ){
        return "<h1>Welcome!</h1><br><h2>Demo Username: shop.manager<br><br>Demo Password: shopmanager!</h2>";
    } else {
        return $message;
    }
}
