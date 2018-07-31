<?php

// Shortcode for custom post type archives

function storefront_child__archive( $atts ) {

	// Query Posts
	$query = new WP_Query( [ 'post_type' => 'my-custom-post-type' ] );

	// Use Output Buffer
	ob_start();
	$count = 1;

	// Loop Results
	while( $query->have_posts() ) {
		$query->the_post();
		?>

		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="float: left; margin: 0.5em; max-width: 150px;">
		<p style="text-align:center;">
			<a href="<?php the_permalink(); ?>">
				<h4><?php the_title(); ?></h4>
			</a>
		</p>
		</article>

		<?php
		// Optional Row Termination
		if( $count % 4 == 0 ) { echo '<hr style="clear:both;">'; }
		$count ++;
	}

	// Response
	return ob_get_clean();
}

add_shortcode( 'storefront_child__archive', 'storefront_child__archive' );
