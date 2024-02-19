<?php
namespace Krokedil\Shipping\Interfaces;

use Krokedil\Shipping\PickupPoint\PickupPoint;
use Krokedil\Shipping\Container\Container;

/**
 * Interface PickupPointServiceInterface
 */
interface PickupPointServiceInterface {
	/**
	 * Retrieve the container that holds all the registered services for the pickup point service.
	 *
	 * @return Container
	 */
	public function get_container();

	/**
	 * Save the pickup points for a specific rate.
	 *
	 * @param \WC_Shipping_Rate  $rate The WooCommerce shipping rate to save the pickup points to.
	 * @param array<PickupPoint> $pickup_points The pickup points to save.
	 *
	 * @return void
	 */
	public function save_pickup_points_to_rate( $rate, $pickup_points );

	/**
	 * Get the pickup points for a specific rate.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to get the pickup points from.
	 *
	 * @return array<PickupPoint>
	 */
	public function get_pickup_points_from_rate( $rate );

	/**
	 * Get a pickup point from a rate by id.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to get the pickup point from.
	 * @param string            $id The id of the pickup point to get.
	 *
	 * @return PickupPoint|null
	 */
	public function get_pickup_point_from_rate_by_id( $rate, $id );

	/**
	 * Add a pickup point to the rate.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to add the pickup point to.
	 * @param PickupPoint       $pickup_point The pickup point to add.
	 *
	 * @return void
	 */
	public function add_pickup_point_to_rate( $rate, $pickup_point );

	/**
	 * Remove a pickup point from the rate.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to remove the pickup point from.
	 * @param PickupPoint       $pickup_point The pickup point to remove.
	 *
	 * @return void
	 */
	public function remove_pickup_point_from_rate( $rate, $pickup_point );

	/**
	 * Save the selected pickup point for a specific rate.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to save the selected pickup point to.
	 * @param PickupPoint       $pickup_point The pickup point to save.
	 *
	 * @return void
	 */
	public function save_selected_pickup_point_to_rate( $rate, $pickup_point );

	/**
	 * Get the selected pickup point for a specific rate. If no pickup point is selected, returns false.
	 *
	 * @param \WC_Shipping_Rate $rate The WooCommerce shipping rate to get the selected pickup point from.
	 *
	 * @return PickupPoint|bool
	 */
	public function get_selected_pickup_point_from_rate( $rate );

	/**
	 * Return any pickup point shipping methods from a WooCommerce order.
	 *
	 * @param \WC_Order $order The WooCommerce order.
	 *
	 * @return bool|\WC_Order_Item_Shipping[]
	 */
	public function get_shipping_lines_from_order( $order );
}
