<?php

// Customize the storefront theme footer

function storefront_child__remove_footer_credit () {
	remove_action( 'storefront_footer', 'storefront_credit', 20 );
	add_action( 'storefront_footer', 'storefront_child__custom_footer_credit', 20 );
} 

function storefront_child__custom_footer_credit() {
	?>
	<div class="site-info">
		&copy; <?php echo get_bloginfo( 'name' ) . ' ' . get_the_date( 'Y' ); ?><br />
		<a href="#" onclick="window.open('<?php echo get_permalink( get_option( 'wp_page_for_privacy_policy' ) ); ?>', 'privacy', 'menubar=0,resizable=1,width=768,height=600'); return false;">Privacy Policy</a> •
		<a href="#" onclick="window.open('<?php echo get_permalink( get_option( 'woocommerce_terms_page_id' ) ); ?>', 'terms', 'menubar=0,resizable=1,width=768,height=600'); return false;">Terms &amp; Conditions</a>
	</div>
	<?php
}

add_action( 'init', 'storefront_child__remove_footer_credit', 10 );
