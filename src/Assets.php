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
		$this->assets_path = plugin_dir_url( __FILE__ ) . '../assets/';

		add_action( 'init', array( $this, 'register_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Register scripts.
	 */
	public function register_assets() {
		// Register the Klarna Payments library script.
		wp_register_script( 'ks_pp', $this->assets_path . 'js/pickup-point-select.js', array( 'jquery', 'selectWoo' ), '2.0.0', true );
		wp_register_style( 'ks_pp', $this->assets_path . 'css/pickup-point-select.css', array( 'select2' ), '2.0.0' );
	}

	/**
	 * Enqueue scripts.
	 */
	public function enqueue_assets() {
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
}
