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

		add_filter( 'woocommerce_shipping_chosen_method', array( __CLASS__, 'maybe_register_shipping_error' ), PHP_INT_MAX, 3 );
		add_action( 'woocommerce_shipping_method_chosen', array( __CLASS__, 'maybe_throw_shipping_error' ), PHP_INT_MAX );
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

			if ( empty( $pickup_point ) ) {
				continue;
			}

			// If the pickup point is set, we can set the selected pickup point to the shipping rate.
			$pickup_points_service->save_selected_pickup_point_to_rate( $rate, $pickup_point );
		}

		return $rates;
	}

	/**
	 * Maybe registers an error if we are attempting to set a new shipping method during the checkout process.
	 * WooCommerce will in some cases reset the shipping selection, instead of throwing an error if shipping options
	 * have changed. In our case its better to throw an error for the customer to see, so they can try again
	 * or select another shipping option.
	 *
	 * @param string $default The shipping method id that would be set as the default method.
	 * @param array  $rates The rates calculated when getting the default shipping method.
	 * @param string $chosen_method The shipping method id that was chosen by the customer.
	 *
	 * @return string
	 */
	public static function maybe_register_shipping_error( $default, $rates, $chosen_method ) {
		// Only do this if we are during the checkout process.
		if ( did_action( 'woocommerce_checkout_process' ) <= 0 ) {
			return $default;
		}

		// Only if the chosen shipping or payment method enables this.
		if ( apply_filters( 'krokedil_shipping_should_verify_shipping', false, $default, $rates, $chosen_method ) ) {
			return $default;
		}

		// This covers for situations where the shipping rate packages may be changed through a hook, which may result in an incorrect shipping method change assessment.
		if ( empty( $chosen_method ) || $default === $chosen_method ) {
			return $default;
		}

		/*
		 * Add a filter to allow people to set if they want to automatically correct shipping discrepancies instead of throwing an error.
		 * Note however that this is not recommended. If you do this, and the shipping method that the customer selected is no longer available,
		 * then unexpected issues might happen. Only do this if you are sure the chosen method actually exists and is available.
		 */
		if ( apply_filters( 'krokedil_shipping_changed_auto_correct', false, $default, $rates, $chosen_method ) ) {
			return $chosen_method;
		}

		// If we are not auto-correcting the shipping method, we return the default, but trigger our action. This is so we can throw the error at a later time.
		if( apply_filters( 'krokedil_shipping_changed_throw_error', true, $default, $rates, $chosen_method ) ) {
			do_action( 'krokedil_shipping_changed_error' );
		}

		return $default;
	}

	/**
	 * Actually throws the error registered previously.
	 * This is moved to happen on a separate action instead, since we need to allow WooCommerce to set a couple sessions.
	 * This prevents customers needing to reload the page.
	 *
	 * @return void
	 * @throws \Exception Exception with the error message.
	 */
	public static function maybe_throw_shipping_error() {
		if ( did_action( 'krokedil_shipping_changed_error' ) <= 0 ) {
			return;
		}

		throw new \Exception( __( 'The shipping methods have been changed during the checkout process. Please verify your selected shipping method and try again.', 'krokedil-shipping' ) );
	}
}
