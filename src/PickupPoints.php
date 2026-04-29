<?php
namespace Krokedil\Shipping;

use Krokedil\Shipping\AJAX;
use Krokedil\Shipping\Assets;
use Krokedil\Shipping\Frontend\PickupPointSelect;
use Krokedil\Shipping\Interfaces\PickupPointServiceInterface;
use Krokedil\Shipping\PickupPoint\PickupPoint;
use Krokedil\Shipping\Traits\ArrayFormat;
use Krokedil\Shipping\Traits\JsonFormat;
use Krokedil\Shipping\Traits\RateData;
use Krokedil\Shipping\Container\Container;

/**
 * Class PickupPoints
 *
 * Handles the pickup points service and any interaction with WooCommerce that is required for the package to work properly.
 * Offloading this from the plugins that implement it to a service class.
 */
class PickupPoints implements PickupPointServiceInterface {
	use JsonFormat;
	use ArrayFormat;
	use RateData;

	/**
	 * The container instance.
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * Class constructor.
	 *
	 * @param bool $add_select_box Whether or not to add the pickup point select box to the checkout page.
	 * @return void
	 */
	public function __construct( $add_select_box = false ) {
		$this->init( $add_select_box );
	}

	/**
	 * Initialize the class instance.
	 *
	 * @param bool $add_select_box Whether or not to add the pickup point select box to the checkout page.
	 * @return void
	 */
	public function init( $add_select_box ) {
		// Register actions and filters required by the package.
		add_filter( 'woocommerce_hidden_order_itemmeta', array( $this, 'add_hidden_order_itemmeta' ) );

		// Setup the container with the dependent services.
		$this->container = Container::get_instance();

		$this->container->add( 'pickup-points', $this );
		$this->container->add( 'session-handler', new SessionHandler() );
		$this->container->add( 'ajax', new AJAX() );
		$this->container->add( 'assets', new Assets() );

		// If the select box should be added to the checkout page, add the service to the container.
		if ( $add_select_box ) {
			$this->container->add( 'pickup_point_select', new PickupPointSelect( $this ) );
		}
	}

	/**
	 * Add the order line metadata for pickup points to the list of hidden meta data.
	 *
	 * @param array $hidden_order_itemmeta The list of hidden meta data.
	 * @return array
	 */
	public function add_hidden_order_itemmeta( $hidden_order_itemmeta ) {
		// If the query parameter "debug" is set, return early.
		if ( isset( $_GET['debug'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			return $hidden_order_itemmeta;
		}

		$hidden_order_itemmeta[] = 'krokedil_pickup_points';
		$hidden_order_itemmeta[] = 'krokedil_selected_pickup_point';
		$hidden_order_itemmeta[] = 'krokedil_selected_pickup_point_id';

		return $hidden_order_itemmeta;
	}

	/**
	 * A list of all the WooCommerce packages for the current request.
	 *
	 * @var array
	 */
	private $packages = null;

	/**
	 * Save the pickup points for a specific rate.
	 *
	 * @param \WC_Shipping_Rate  $rate The WooCommerce shipping rate to save the pickup points to.
	 * @param array<PickupPoint> $pickup_points The pickup points to save.
	 *
	 * @return void
	 */
	public function save_pickup_points_to_rate( $rate, $pickup_points ) {
		$pickup_points_json = $this->to_json( $pickup_points );
		$data               = array( 'krokedil_pickup_points' => $pickup_points_json );
		$rate->add_meta_data( 'krokedil_pickup_points', $pickup_points_json );

		$selected_pickup_point = $this->get_selected_pickup_point_from_rate( $rate );

		// Does the rate have any selected pickup points? If not set the first one as the selected pickup point.
		if ( ! $selected_pickup_point && ! empty( $pickup_points ) ) {
			$pickup_point_json                         = $this->to_json( $pickup_points[0] );
			$data['krokedil_selected_pickup_point']    = $pickup_point_json;
			$data['krokedil_selected_pickup_point_id'] = $pickup_points[0]->get_id();
		} elseif ( $selected_pickup_point ) {
			$data['krokedil_selected_pickup_point_id'] = $selected_pickup_point->get_id();
			$data['krokedil_selected_pickup_point']    = $this->to_json( $selected_pickup_point );

		}

		$this->save_shipping_rate_data( $rate, $data );
	}

	/**
	 * Get the pickup points for a specific rate.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to get the pickup points from.
	 *
	 * @return array<PickupPoint>
	 */
	public function get_pickup_points_from_rate( $rate ) {
		$meta_data = $rate->get_meta_data();
		if ( ! array_key_exists( 'krokedil_pickup_points', $meta_data ) ) {
			return array();
		}

		$pickup_points_array = $this->json_to_array( $meta_data['krokedil_pickup_points'] );

		$pickup_points = array();

		foreach ( $pickup_points_array as $pickup_point_array ) {
			$pickup_points[] = new PickupPoint( $pickup_point_array );
		}

		return $pickup_points;
	}

	/**
	 * Add a pickup point to the rate.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to add the pickup point to.
	 * @param PickupPoint       $pickup_point The pickup point to add.
	 *
	 * @return void
	 */
	public function add_pickup_point_to_rate( $rate, $pickup_point ) {
		$pickup_points = $this->get_pickup_points_from_rate( $rate );

		if ( ! $pickup_points ) {
			$pickup_points = array();
		}

		// Ensure that the pickup point is not already in the array.
		foreach ( $pickup_points as $pickup_point_in_array ) {
			if ( $pickup_point_in_array->get_id() === $pickup_point->get_id() ) {
				return;
			}
		}

		$pickup_points[] = $pickup_point;

		$this->save_pickup_points_to_rate( $rate, $pickup_points );
	}

	/**
	 * Remove a pickup point from the rate.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to remove the pickup point from.
	 * @param PickupPoint       $pickup_point The pickup point to remove.
	 *
	 * @return void
	 */
	public function remove_pickup_point_from_rate( $rate, $pickup_point ) {
		$pickup_points = $this->get_pickup_points_from_rate( $rate );

		if ( ! $pickup_points ) {
			return;
		}

		$pickup_points = array_filter(
			$pickup_points,
			function ( $pickup_point_in_array ) use ( $pickup_point ) {
				return $pickup_point_in_array->get_id() !== $pickup_point->get_id();
			}
		);

		// Reset the array keys.
		$pickup_points = array_values( $pickup_points );

		$this->save_pickup_points_to_rate( $rate, $pickup_points );
	}

	/**
	 * Save the selected pickup point for a specific rate.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to save the selected pickup point to.
	 * @param PickupPoint       $pickup_point The pickup point to save.
	 *
	 * @return void
	 */
	public function save_selected_pickup_point_to_rate( $rate, $pickup_point ) {
		$pickup_point_json = $this->to_json( $pickup_point );

		$data = array(
			'krokedil_selected_pickup_point'    => $pickup_point_json,
			'krokedil_selected_pickup_point_id' => $pickup_point->get_id(),
		);

		$this->save_selected_pickup_point_to_session( $pickup_point );
		$this->save_shipping_rate_data( $rate, $data );
	}

	/**
	 * Save the selected pickup point for a specific rate.
	 *
	 * @param PickupPoint $pickup_point The pickup point to save.
	 *
	 * @return void
	 */
	public function save_selected_pickup_point_to_session( $pickup_point ) {
		$pickup_point_json = $this->to_json( $pickup_point );

		$data = array(
			'krokedil_selected_pickup_point'    => $pickup_point_json,
			'krokedil_selected_pickup_point_id' => $pickup_point->get_id(),
		);

		// Save the data to the session 'krokedil_selected_pickup_point' and 'krokedil_selected_pickup_point_id'.
		WC()->session->set( 'krokedil_selected_pickup_point', $data['krokedil_selected_pickup_point'] );
		WC()->session->set( 'krokedil_selected_pickup_point_id', $data['krokedil_selected_pickup_point_id'] );
	}

	/**
	 * Get the selected pickup point for a specific rate. If no pickup point is selected, returns false.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to get the selected pickup point from.
	 *
	 * @return PickupPoint|bool
	 */
	public function get_selected_pickup_point_from_rate( $rate ) {
		// Try to get the selected pickup point id from the session if it exists.
		$session_pickup_point_id = WC()->session->get( 'krokedil_selected_pickup_point_id' );

		// See if the rate still has the pickup point for the sessions selected id.
		if ( $session_pickup_point_id ) {
			$session_pickup_point = $this->get_pickup_point_from_rate_by_id( $rate, $session_pickup_point_id );

			// Return the pickup point if it exists in the rate.
			if ( $session_pickup_point ) {
				return $session_pickup_point;
			}
		}

		$meta_data = $rate->get_meta_data();
		if ( ! array_key_exists( 'krokedil_selected_pickup_point', $meta_data ) ) {
			return false;
		}

		$pickup_point_array = $this->json_to_array( $meta_data['krokedil_selected_pickup_point'] );

		return new PickupPoint( $pickup_point_array );
	}

	/**
	 * Get the selected pickup point from the session for a rate.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to get the selected pickup point from.
	 *
	 * @return PickupPoint|bool
	 */
	public function get_selected_pickup_point_from_rate_session( $rate ) {
		// Try to get the selected pickup point id from the session if it exists.
		$session_pickup_point_id = WC()->session->get( 'krokedil_selected_pickup_point_id' );

		// See if the rate still has the pickup point for the sessions selected id.
		if ( empty( $session_pickup_point_id ) ) {
			return false;
		}

		$session_pickup_point = $this->get_pickup_point_from_rate_by_id( $rate, $session_pickup_point_id );

		// Return the pickup point if it exists in the rate.
		if ( empty( $session_pickup_point ) ) {
			return false;
		}

		return $session_pickup_point;
	}

	/**
	 * Get the selected pickup point from the session.
	 *
	 * @return PickupPoint|bool
	 */
	public function get_selected_pickup_point_from_session() {
		// Try to get the selected pickup point from the session.
		$session_pickup_point = WC()->session->get( 'krokedil_selected_pickup_point' );

		// See if the rate still has the pickup point for the sessions selected id.
		if ( empty( $session_pickup_point ) ) {
			return false;
		}

		$pickup_point_array = $this->json_to_array( $session_pickup_point['krokedil_selected_pickup_point'] );

		return new PickupPoint( $pickup_point_array );
	}

	/**
	 * Get a pickup point from a rate by id.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to get the pickup point from.
	 * @param string            $id The id of the pickup point to get.
	 *
	 * @return PickupPoint|null
	 */
	public function get_pickup_point_from_rate_by_id( $rate, $id ) {
		$pickup_points = $this->get_pickup_points_from_rate( $rate );

		if ( ! $pickup_points ) {
			return;
		}

		foreach ( $pickup_points as $pickup_point ) {
			if ( $pickup_point->get_id() === $id ) {
				return $pickup_point;
			}
		}
	}

	/**
	 * Retrieve the container that holds all the registered services for the pickup point service.
	 *
	 * @return Container
	 */
	public function get_container() {
		return $this->container;
	}

	/**
	 * Return any pickup point shipping methods from a WooCommerce order.
	 *
	 * @param \WC_Order $order The WooCommerce order.
	 *
	 * @return array|bool
	 */
	public function get_shipping_lines_from_order( $order ) {
		$shipping_methods = $order->get_shipping_methods();

		if ( ! $shipping_methods ) {
			return false;
		}

		$pickup_point_shipping_methods = array_filter(
			$shipping_methods,
			function ( $shipping_method ) {
				$pickup_points = $shipping_method->get_meta( 'krokedil_pickup_points' );
				$selected      = $shipping_method->get_meta( 'krokedil_selected_pickup_point' );

				return $pickup_points || $selected;
			}
		);

		return empty( $pickup_point_shipping_methods ) ? false : $pickup_point_shipping_methods;
	}
}
