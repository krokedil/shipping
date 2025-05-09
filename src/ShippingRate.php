<?php
namespace Krokedil\Shipping;

use Krokedil\Shipping\Interfaces\ShippingRateServiceInterface;
use Krokedil\Shipping\Container\Container;
use Krokedil\Shipping\Traits\RateData;
use Krokedil\Shipping\Frontend\ShippingRateOutput;

/**
 * Class to handle shipping rates and extensions to them for WooCommerce.
 */
class ShippingRate implements ShippingRateServiceInterface {
	use RateData;

	/**
	 * The arguments for the class.
	 *
	 * @var array
	 */
	private $args = array(
		'show_description' => true,
	);

	/**
	 * The container instance.
	 *
	 * @var Container
	 */
	private $container;

	/**
	 * Class constructor.
	 *
	 * @param array $args Arguments to initialize the class with.
	 *
	 * @return void
	 */
	public function __construct( $args = array() ) {
		$this->args = array_merge( $this->args, $args );
		$this->init();
	}

	/**
	 * Initialize the class instance.
	 *
	 * @return void
	 */
	public function init() {
		// Register actions and filters required by the package.
		add_filter( 'woocommerce_hidden_order_itemmeta', array( $this, 'add_hidden_order_itemmeta' ) );

		// Setup the container with the dependent services.
		$this->container = Container::get_instance();
		$this->container->add( 'session-handler', new SessionHandler() );
		$this->container->add( 'shipping-rate-output', new ShippingRateOutput( $this ) );
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

		$hidden_order_itemmeta[] = 'krokedil_description';

		return $hidden_order_itemmeta;
	}

	/**
	 * @inheritDoc
	 */
	public function get_container() {
		return $this->container;
	}

	/**
	 * @inheritDoc
	 */
	public function get_shipping_rate_description( $rate ) {
		$meta_data = $rate->get_meta_data();
		if ( ! array_key_exists( 'krokedil_description', $meta_data ) ) {
			return '';
		}

		return $meta_data['krokedil_description'];
	}

	/**
	 * @inheritDoc
	 */
	public function save_shipping_rate_description( $rate, $description ) {
		// If the description is empty, return.
		if ( empty( $description ) ) {
			return;
		}

		$this->save_shipping_rate_data( $rate, array( 'krokedil_description' => $description ) );
	}

	/**
	 * @inheritDoc
	 */
	public function should_output( $element ) {
		return $this->args[ "show_{$element}" ];
	}
}
