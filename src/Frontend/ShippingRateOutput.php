<?php
namespace Krokedil\Shipping\Frontend;

use Krokedil\Shipping\Interfaces\ShippingRateServiceInterface;

/**
 * Class ShippingRateOutput. Handles the output for extra shipping rate information on the checkout page.
 */
class ShippingRateOutput {
	/**
	 * The shipping rate service instance.
	 *
	 * @var ShippingRateServiceInterface
	 */
	private $shipping_rate_service;

	/**
	 * Class constructor.
	 *
	 * @param ShippingRateServiceInterface $shipping_rate_service The shipping rate service instance.
	 */
	public function __construct( $shipping_rate_service ) {
		$this->shipping_rate_service = $shipping_rate_service;

		add_action( 'woocommerce_after_shipping_rate', array( $this, 'render_description' ), 5 );
	}

	/**
	 * Returns true if the element should be output for the shipping rate.
	 *
	 * @param string $element
	 * @param \WC_Shipping_Rate $shipping_rate
	 */
	public function should_output( $element, $shipping_rate ) {
		// Only if this is the selected shipping rate.
		if ( ! in_array( $shipping_rate->id, WC()->session->get( 'chosen_shipping_methods' ), true ) ) {
			return false;
		}

		return apply_filters( "krokedil_shipping_should_output_$element", $this->shipping_rate_service->should_output( $element ), $shipping_rate );
	}

	/**
	 * Render the shipping rate description.
	 *
	 * @param \WC_Shipping_Rate $shipping_rate The shipping rate instance.
	 *
	 * @return void
	 */
	public function render_description( $shipping_rate ) {
		// Only if this is the selected shipping rate.
		if ( ! $this->should_output( 'description', $shipping_rate ) ) {
			return;
		}

		// Get the description for the shipping rate.
		$description = $this->shipping_rate_service->get_shipping_rate_description( $shipping_rate );

		if ( ! empty( $description ) && 0 === did_action('krokedil_shipping_before_rate_description') ) {
			do_action( 'krokedil_shipping_before_rate_description' );
			echo '<div class="krokedil_shipping_description">' . wp_kses_post( $description ) . '</div>';
			do_action( 'krokedil_shipping_after_rate_description' );
		}
	}
}
