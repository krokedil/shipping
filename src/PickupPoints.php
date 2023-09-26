<?php
/**
 * Pickup points class that contains all the pickup points registered on a shipping rate from WooCommerce.
 *
 * @package Krokedil/Shipping
 */

namespace Krokedil\Shipping;

use Krokedil\Shipping\PickupPoint\PickupPoint;
use Krokedil\Shipping\Traits\ArrayFormat;
use Krokedil\Shipping\Traits\JsonFormat;

/**
 * Class PickupPoints.
 * Automatically gets pickup points from a WooCommerce shipping rate if the metadata for it exists.
 * And has functionality to add and remove pickup points from the shipping rate.
 *
 * @since 1.0.0
 */
class PickupPoints {
	use ArrayFormat;
	use JsonFormat;

    #region Properties
    /**
     * Pickup points.
     *
     * @var array<PickupPoint>
     */
    private $pickup_points = array();

	/**
	 * Selected pickup point id.
	 *
	 * @var PickupPoint
	 */
	private $selected_pickup_point;

	/**
	 * WooCommerce shipping rate.
	 *
	 * @var \WC_Shipping_Rate
	 */
    private $rate;
    #endregion

    /**
     * PickupPoints constructor. Automatically gets pickup points from a WooCommerce shipping rate if the metadata for it exists.
     * Can be passed null to create an empty PickupPoints object, that can then be manually populated.
     *
     * @param \WC_Shipping_Rate|null $rate WooCommerce shipping rate.
     *
     * @since 1.0.0
     *
     * @return void
     *

     */
	public function __construct( $rate = null ) {
        if( $rate === null ) {
            return;
        }

		$this->set_rate( $rate );
		$this->set_pickup_points_from_rate();
	}

    #region Getters
    /**
     * Get pickup points.
     *
     * @return array<PickupPoint>
     */
    public function get_pickup_points() {
        return $this->pickup_points;
    }

    /**
     * Get WooCommerce shipping rate.
     *
     * @return \WC_Shipping_Rate
     */
    public function get_rate() {
        return $this->rate;
    }

	/**
	 * Get the selected pickup point.
	 *
	 * @return PickupPoint
	 */
	public function get_selected_pickup_point() {
		return $this->selected_pickup_point;
	}

	/**
	 * Returns the pickup point from the array of pickup points based on the ID passed.
	 *
	 * @param string $id The ID of the pickup point to get.
	 *
	 * @return PickupPoint|null
	 */
	public function get_pickup_point_by_id( $id ) {
		$pickup_points = $this->get_pickup_points();
		foreach ( $pickup_points as $pickup_point ) {
			if ( $pickup_point->get_id() === $id ) {
				return $pickup_point;
			}
		}
		return null;
	}
	#endregion

    #region Setters
    /**
     * Set pickup points.
     *
     * @param array<PickupPoint> $pickup_points Pickup points.
     * @return void
     */
    public function set_pickup_points( $pickup_points ) {
        $this->pickup_points = $pickup_points;
    }

    /**
     * Set WooCommerce shipping rate.
     *
     * @param \WC_Shipping_Rate $rate WooCommerce shipping rate.
     * @return void
     */
    public function set_rate( $rate ) {
        $this->rate = $rate;
    }

	/**
	 * Set the selected pickup point. Pass the ID of the pickup point that has been selected by the customer.
	 *
	 * @param string|PickupPoint $selected_pickup_point
	 */
	public function set_selected_pickup_point( $selected_pickup_point ) {
		// If the pickup point is a string, try to get the pickup point by id from the array of pickup points.
		if ( is_string( $selected_pickup_point ) ) {
			$selected_pickup_point = $this->get_pickup_point_by_id( $selected_pickup_point );
		}

		$this->selected_pickup_point = $selected_pickup_point;
		$this->save_selected_pickup_point_to_rate();
	}
    #endregion

    #region Methods
    /**
     * Get pickup points from WooCommerce shipping rate.
     * @return void
     */
	public function set_pickup_points_from_rate() {
		$meta_data = $this->rate->get_meta_data();
		if ( ! array_key_exists( 'krokedil_pickup_points', $meta_data ) ) {
			return;
		}

		$pickup_points = $this->json_to_array( $meta_data['krokedil_pickup_points'] );
		// Ensure its not an empty array
		if ( empty( $pickup_points ) ) {
			return;
		}

        // Loop through the pickup points and create a new PickupPoint object for each.
        foreach ( $pickup_points as $pickup_point ) {
            $this->pickup_points[] = new PickupPoint( $pickup_point );
        }
	}

    /**
     * Add pickup point to WooCommerce shipping rate.
     *
     * @param PickupPoint $pickup_point Pickup point.
     * @return void
     */
	public function add_pickup_point( PickupPoint $pickup_point ) {
        $pickup_points = $this->get_pickup_points();
        $pickup_points[] = $pickup_point;
        $this->set_pickup_points( $pickup_points );
        $this->save_pickup_points_to_rate();
	}

    /**
     * Remove pickup point from WooCommerce shipping rate.
     *
     * @param PickupPoint $pickup_point Pickup point.
     * @return void
     */
	public function remove_pickup_point( PickupPoint $pickup_point ) {
		$pickup_points = $this->get_pickup_points();
		$pickup_points = array_filter( $pickup_points, function ($p) use ($pickup_point) {
			return $p->get_id() !== $pickup_point->get_id();
		} );
		$this->set_pickup_points( $pickup_points );
		$this->save_pickup_points_to_rate();
	}

    /**
     * Save pickup points to WooCommerce shipping rate as a json string.
     *
     * @return void
     */
    public function save_pickup_points_to_rate() {
        $pickup_points = $this->get_pickup_points();
		$pickup_points = $this->to_json( $pickup_points );
        $this->rate->add_meta_data( 'krokedil_pickup_points', $pickup_points );
    }

	/**
	 * Saves the selected pickup point to the shipping rate.
	 *
	 * @return void
	 */
	public function save_selected_pickup_point_to_rate() {
		$selected_pickup_point = $this->get_selected_pickup_point();
		$selected_pickup_point = $this->to_json( $selected_pickup_point );
		$this->rate->add_meta_data( 'krokedil_selected_pickup_point', $selected_pickup_point );
	}
    #endregion
}
