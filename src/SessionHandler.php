<?php
namespace Krokedil\Shipping;

use Krokedil\Shipping\Container\Container;

/**
 * Class SessionHandler
 *
 * Handles the updating and retrieval of session data from WooCommerce.
 * Enables us to store the data to shipping rates without having to do it during the cart calculation process.
 */
class SessionHandler {
	/**
	 * The update data to be set to shipping rates when they are calculated by WooCommerce.
	 * The key for the first array is the shipping rate id. Then the meta data as key value pairs in the nested array.
	 *
	 * @var array<string, array<string, mixed>>
	 */
	private $shipping_rate_data = array();

	/**
	 * The pickup points service to use for getting the pickup points.
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * Class constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->container = Container::get_instance();
		add_filter( 'woocommerce_package_rates', array( $this, 'package_rates_handler' ), 10, 1 );
		add_filter( 'woocommerce_package_rates', array( $this, 'set_selected_pickup_point_from_session' ), 20, 1 );
	}

	/**
	 * Get the shipping rate from the WooCommerce session from the rate id.
	 *
	 * @param string $rate_id The shipping rate id to get.
	 *
	 * @return \WC_Shipping_Rate|null
	 */
	public function get_shipping_rate( $rate_id ) {
		$packages = WC()->shipping()->get_packages();

		// Find the package that contains the shipping rate.
		foreach ( $packages as $package_key => $package ) {
			foreach ( $package['rates'] as $rate_key => $rate ) {
				if ( $rate->get_id() === $rate_id ) {
					return $rate;
				}
			}
		}

		return null;
	}

	/**
	 * Update the shipping rates.
	 *
	 * Forces a recalculation of the shipping rates, so we can update the rates with the data we want.
	 *
	 * @return void
	 */
	public function update_shipping_rates() {
		// Get all the shipping packages from the WooCommerce session.
		$packages = WC()->shipping()->get_packages();
		// Loop the packages to unset the session and then recalculate the shipping rates.
		foreach ( $packages as $package_key => $package ) {
			$this->preserve_old_meta_data( $package );

			// Unset the shipping rates from the session.
			WC()->session->__unset( 'shipping_for_package_' . $package_key );

			// Recalculate the shipping rates.
			WC()->shipping()->calculate_shipping_for_package( $package );

		}

		// Reset the stored data.
		$this->shipping_rate_data = array();
	}

	/**
	 * Sets the data to be updated to the shipping rate when its calculated.
	 *
	 * @param string               $rate_id The shipping rate id to update.
	 * @param array<string, mixed> $data The data to update the rate id with.
	 *
	 * @return void
	 */
	public function set_shipping_rate_data( $rate_id, $data ) {
		$this->shipping_rate_data[ $rate_id ] = $data;
	}

	/**
	 * Retrieve the data we want to set to the shipping rate with the matching id.
	 *
	 * @param string $rate_id The shipping rate id to get the data for.
	 * @return array<string, mixed> The data to set to the shipping rate.
	 */
	public function get_shipping_rate_data( $rate_id ) {
		return $this->shipping_rate_data[ $rate_id ] ?? array();
	}

	/**
	 * Update the shipping rates with the data set in the session handler.
	 *
	 * @param \WC_Shipping_Rate[] $rates The shipping rates to update.
	 *
	 * @return \WC_Shipping_Rate[] The updated shipping rates.
	 */
	public function package_rates_handler( $rates ) {
		// If the shipping rate data is empty, return the rates as is. Since we don't need to do any extra checks.
		if ( empty( $this->shipping_rate_data ) ) {
			return $rates;
		}

		// Loop the rates to update the once we have data to set for.
		foreach ( $rates as $rate ) {
			$data_array = $this->shipping_rate_data[ $rate->get_id() ] ?? null;
			// If we have data to set for the rate, set it.
			if ( ! empty( $data_array ) ) {
				foreach ( $data_array as $key => $value ) {
					$rate->add_meta_data( $key, $value );
				}
			}
		}

		return $rates;
	}

	/**
	 * Preserve the old meta data from the shipping rates.
	 *
	 * @param array<string, mixed> $package The shipping package to preserve the meta data for.
	 *
	 * @return void
	 */
	public function preserve_old_meta_data( $package ) {
		/**
		 * Loop the shipping rates to get the meta data and store it in the session handler.
		 *
		 * @var \WC_Shipping_Rate $rate
		 */
		foreach ( $package['rates'] as $rate_key => $rate ) {
			$rate_meta   = $rate->get_meta_data();
			$stored_meta = $this->get_shipping_rate_data( $rate->get_id() );

			foreach ( $stored_meta as $key => $value ) {
				$rate_meta[ $key ] = $value;
			}

			$this->shipping_rate_data[ $rate->get_id() ] = $rate_meta;
		}
	}

	/**
	 * Set the selected pickup point from the session after shipping has been calculated.
	 *
	 * @param \WC_Shipping_Rate[] $rates The shipping rates to set the selected pickup point for.
	 *
	 * @return \WC_Shipping_Rate[] The updated shipping rates with the selected pickup point set.
	 */
	public function set_selected_pickup_point_from_session( $rates ) {
		$session_pickup_point_id = WC()->session->get( 'krokedil_selected_pickup_point_id' );
		if ( ! $session_pickup_point_id ) {
			return $rates;
		}

		$pickup_points_service = $this->container->get( 'pickup-points' );
		foreach ( $rates as $rate ) {
			$pickup_point = $pickup_points_service->get_pickup_point_from_rate_by_id( $rate, $session_pickup_point_id );

			if(empty($pickup_point)) {
				continue;
			}

			// If the pickup point is set, we can set the selected pickup point to the shipping rate.
			$pickup_points_service->save_selected_pickup_point_to_rate( $rate, $pickup_point );
		}

		return $rates;
	}
}
