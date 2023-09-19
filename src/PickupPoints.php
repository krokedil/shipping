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
    #endregion

    #region Setters
    /**
     * Set pickup points.
     *
     * @param array<PickupPoint> $pickup_points Pickup points.
     */
    public function set_pickup_points( $pickup_points ) {
        $this->pickup_points = $pickup_points;
    }

    /**
     * Set WooCommerce shipping rate.
     *
     * @param \WC_Shipping_Rate $rate WooCommerce shipping rate.
     */
    public function set_rate( $rate ) {
        $this->rate = $rate;
    }
    #endregion

    #region Methods
    /**
     * Get pickup points from WooCommerce shipping rate.
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
     */
    public function save_pickup_points_to_rate() {
        $pickup_points = $this->get_pickup_points();
        $pickup_points = $this->array_to_json( $pickup_points );
        $this->rate->add_meta_data( 'krokedil_pickup_points', $pickup_points );
    }
    #endregion
}
