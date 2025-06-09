<?php
namespace Krokedil\Shipping\Interfaces;

use Krokedil\Shipping\Container\Container;

/**
 * Interface for the ShippingRateService.
 */
interface ShippingRateServiceInterface {
	/**
	 * Retrieve the container that holds all the registered services for the pickup point service.
	 *
	 * @return Container
	 */
	public function get_container();

	/**
	 * Returns if the element should be output or not on the frontend.
	 *
	 * @param string $element The field to check.
	 *
	 * @return bool
	 */
	public function should_output( $element );

	/**
	 * Save the description for a shipping rate.
	 *
	 * @param \WC_Shipping_Rate $rate The shipping rate to save the description for.
	 * @param string $description The description to save.
	 */
	public function save_shipping_rate_description( $rate, $description );

	/**
	 * Get the description for a shipping rate.
	 *
	 * @param \WC_Shipping_Rate $rate The shipping rate to get the description for.
	 *
	 * @return string
	 */
	public function get_shipping_rate_description( $rate );
}
