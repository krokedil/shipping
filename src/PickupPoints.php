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
		$hidden_order_itemmeta[] = 'krokedil_pickup_points';
		$hidden_order_itemmeta[] = 'krokedil_selected_pickup_point';

		return $hidden_order_itemmeta;
	}

	/**
	 * A list of all the WooCommerce packages for the current request.
	 *
	 * @var array
	 */
	private $packages = null;

	/** {@inheritDoc} */
	public function save_pickup_points_to_rate( $rate, $pickup_points ) {
		$pickup_points_json = $this->to_json( $pickup_points );

		$data = array(
			'krokedil_pickup_points' => $pickup_points_json,
		);

		$this->save_shipping_rate_data( $rate, $data );
	}

	/** {@inheritDoc} */
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

	/** {@inheritDoc} */
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

	/** {@inheritDoc} */
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

	/** {@inheritDoc} */
	public function save_selected_pickup_point_to_rate( $rate, $pickup_point ) {
		$pickup_point_json = $this->to_json( $pickup_point );

		$data = array(
			'krokedil_selected_pickup_point' => $pickup_point_json,
		);

		$this->save_shipping_rate_data( $rate, $data );
	}

	/** {@inheritDoc} */
	public function get_selected_pickup_point_from_rate( $rate ) {
		$meta_data = $rate->get_meta_data();
		if ( ! array_key_exists( 'krokedil_selected_pickup_point', $meta_data ) ) {
			return false;
		}

		$pickup_point_array = $this->json_to_array( $meta_data['krokedil_selected_pickup_point'] );

		return new PickupPoint( $pickup_point_array );
	}

	/** {@inheritDoc} */
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

	/** {@inheritDoc} */
	public function get_container() {
		return $this->container;
	}
}
