<?php

// Sets `X-Frame-Options` header for PCI compliance scanners

function storefront_child__send_headers() {
  header( 'X-Frame-Options: SAMEORIGIN' );
}

add_action( 'send_headers', 'storefront_child__send_headers' );
