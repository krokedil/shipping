<?php
namespace Krokedil\Shipping;

defined( 'ABSPATH' ) || exit;

/**
 * Assets class for Klarna Express Checkout
 *
 * @package Krokedil\Shipping
 */
class Assets {
	/**
	 * The path to the assets directory.
	 *
	 * @var string
	 */
	private $assets_path;

	/**
	 * Assets constructor.
	 */
	public function __construct() {
		$this->assets_path = plugin_dir_url( __FILE__ ) . '/assets/';

		add_action( 'init', array( $this, 'register_assets' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_assets' ) );
	}

	/**
	 * Register scripts.
	 */
	public function register_assets() {
		// Register the ks_pp scripts and style.
		wp_register_script( 'ks_pp', $this->assets_path . 'js/pickup-point-select.js', array( 'jquery', 'selectWoo' ), '2.0.0', true );
		wp_register_style( 'ks_pp', $this->assets_path . 'css/pickup-point-select.css', array( 'select2' ), '2.0.0' );

		// Register the ks_edit_order scripts and style.
		wp_register_script( 'ks_edit_order', $this->assets_path . 'js/edit-order.js', array( 'jquery', 'selectWoo' ), '2.0.0', true );
		wp_register_style( 'ks_edit_order', $this->assets_path . 'css/edit-order.css', array(), '2.0.0' );
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_assets() {
		if ( ! is_checkout() ) {
			return;
		}

		$params = array(
			'ajax' => array(
				'setPickupPoint' => array(
					'action' => 'ks_pp_set_selected_pickup_point',
					'nonce'  => wp_create_nonce( 'ks_pp_set_selected_pickup_point' ),
					'url'    => \WC_AJAX::get_endpoint( 'ks_pp_set_selected_pickup_point' ),
				),
			),
		);

		wp_localize_script( 'ks_pp', 'ks_pp_params', $params );
		wp_enqueue_script( 'ks_pp' );
		wp_enqueue_style( 'ks_pp' );
	}

	/**
	 * Enqueue admin assets.
	 *
	 * @param string $hook The current admin page.
	 *
	 * @return void
	 *
	 * @codeCoverageIgnore
 	 * No tests made yet.
	 */
	public function enqueue_admin_assets( $hook ) {

		$screen    = get_current_screen();
		$screen_id = $screen ? $screen->id : '';

		if ( ! in_array( $hook, array( 'shop_order', 'woocommerce_page_wc-orders' ), true ) && ! in_array( $screen_id, array( 'shop_order' ), true ) ) {
			return;
		}

		$params = array(
			'ajax' => array(
				'updateSelectedPickupPoint' => array(
					'action' => 'ks_pp_update_selected',
					'nonce'  => wp_create_nonce( 'ks_pp_update_selected' ),
					'url'    => \WC_AJAX::get_endpoint( 'ks_pp_update_selected' ),
				),
				'refreshShippingMethods'    => array(
					'action' => 'ks_pp_refresh_shipping_methods',
					'nonce'  => wp_create_nonce( 'ks_refresh_shipping_methods' ),
					'url'    => \WC_AJAX::get_endpoint( 'ks_refresh_shipping_methods' ),
				),
			),
		);

		wp_localize_script( 'ks_edit_order', 'ks_edit_order_params', $params );
		wp_enqueue_script( 'ks_edit_order' );
		wp_enqueue_style( 'ks_edit_order' );
	}
}
