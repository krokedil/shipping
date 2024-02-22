<?php
namespace Krokedil\Shipping;

defined( 'ABSPATH' ) || exit;

/**
 * Class with helper functions for shipping calculations.
 */
class Calculations {
	/**
	 * Get a shipping tax rate from a percentage value.
	 *
	 * @param float $percentage The percentage value.
	 *
	 * @return array
	 */
	public static function get_tax_rate_from_percentage( $percentage ) {
		$tax_rates = \WC_Tax::get_shipping_tax_rates();

		foreach ( $tax_rates as $tax_rate ) {
			if ( $tax_rate['rate'] === $percentage ) {
				return $tax_rate['rate'];
			}
		}

		return array(
			'label'    => __( 'Shipping tax', 'krokedil-shipping' ),
			'rate'     => $percentage,
			'shipping' => 'yes',
			'compound' => 'no',
		);
	}
}
