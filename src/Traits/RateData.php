<?php
namespace Krokedil\Shipping\Traits;

use Krokedil\Shipping\SessionHandler;

trait RateData {
	/**
	 * Ensure the saving of the pickup point data to the shipping rate. Either by forcing the session to update or by updating the shipping rate directly.
	 *
	 * @param \WC_Shipping_Rate    $rate The shipping rate we want to update.
	 * @param array<string, mixed> $data The data to update the rate id with. The key is the meta data id and the value is the data to save.
	 *
	 * @return void
	 */
	private function save_shipping_rate_data( $rate, $data ) {
		$can_set_meta = ( doing_action( 'woocommerce_before_get_rates_for_package' ) || doing_action( 'woocommerce_after_get_rates_for_package' ) || doing_filter( 'woocommerce_package_rates' ) );

		// If before calculate_totals has been triggered but not after, we can just update the meta data for the shipping rate.
		if ( $can_set_meta ) {
			foreach ( $data as $key => $value ) {
				$rate->add_meta_data( $key, $value );
			}
		} else {
			// Otherwise we want to force the shipping rates to update.
			/** @var SessionHandler $session_handler The session handler service from the pickup point service container. */
			$session_handler = $this->container->get( 'session-handler' );

			// Save the data to the session handler.
			$session_handler->set_shipping_rate_data( $rate->get_id(), $data );

			// Force the shipping rates to update.
			$session_handler->update_shipping_rates();
		}
	}
}
