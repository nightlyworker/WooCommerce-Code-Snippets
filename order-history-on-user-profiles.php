<?php

// Show Order Histories on User Profiles
add_action( 'edit_user_profile', 'storefront_child__edit_user_profile' );

function storefront_child__edit_user_profile( $profileuser ) {
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
}
