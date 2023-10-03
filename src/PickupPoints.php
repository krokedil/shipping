<?php
namespace Krokedil\Shipping;

use Krokedil\Shipping\Interfaces\PickupPointServiceInterface;
use Krokedil\Shipping\PickupPoint\PickupPoint;
use Krokedil\Shipping\Traits\ArrayFormat;
use Krokedil\Shipping\Traits\JsonFormat;

/**
 * Class PickupPoints
 *
 * Handles the pickup points service and any integraction with WooCommerce that is required for the package to work properly.
 * Offloading this from the plugins that implement it to a service class.
 */
class PickupPoints implements PickupPointServiceInterface {
	use JsonFormat;
	use ArrayFormat;

	public function __construct() {
		// Add the order line metadata for pickup points to the list of hidden meta data.
		add_filter( 'woocommerce_hidden_order_itemmeta', array( $this, 'add_hidden_order_itemmeta' ) );
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

		$rate->add_meta_data( 'krokedil_pickup_points', $pickup_points_json );
	}

	/** {@inheritDoc} */
	public function get_pickup_points_from_rate( $rate ) {
		$meta_data = $rate->get_meta_data();
		if ( ! array_key_exists( 'krokedil_pickup_points', $meta_data ) ) {
			return;
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
			function ($pickup_point_in_array) use ($pickup_point) {
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
		$rate->add_meta_data( 'krokedil_selected_pickup_point', $pickup_point_json );
	}

	/** {@inheritDoc} */
	public function get_selected_pickup_point_from_rate( $rate ) {
		$meta_data = $rate->get_meta_data();
		if ( ! array_key_exists( 'krokedil_selected_pickup_point', $meta_data ) ) {
			return;
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
}
