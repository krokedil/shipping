<?php
/**
 * HTML file for the pickup point select box.
 */

defined( 'ABSPATH' ) || exit;

// If there are no pickup points, return.
if ( empty( $pickup_points ) ) {
	return;
}

?>
<div class="krokedil_shipping_pickup_point">
	<select id="krokedil_shipping_pickup_point" name="krokedil_shipping_pickup_point"
		class="krokedil_shipping_pickup_point__select" data-rate-id="<?php esc_attr_e( $rate_id ); ?>">
		<?php foreach ( $pickup_points as $pickup_point ) : ?>
			<option class="krokedil_shipping_pickup_point__option"
				value="<?php echo esc_attr( $pickup_point->get_id() ); ?>" <?php selected( $pickup_point->get_id(), $selected_pickup_point ? $selected_pickup_point->get_id() : $pickup_points[0]->get_id() ); ?>>
				<?php echo esc_html( $pickup_point->get_name() ); ?>
			</option>
		<?php endforeach; ?>
	</select>
</div>
