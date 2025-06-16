<?php
namespace Krokedil\Shipping\Blocks\PickupPoints;

use Automattic\WooCommerce\Blocks\Integrations\IntegrationInterface;

defined( 'ABSPATH' ) || exit;

/**
 * Class PickupPointsBlock
 */
class PickupPointsBlock implements IntegrationInterface {
	/**
	 * Whether or not to add the select box to the checkout page.
	 *
	 * @var bool
	 */
	private $add_select_box;

	/**
	 * Class constructor.
	 *
	 * @param bool $add_select_box Whether or not to add the select box to the checkout page.
	 *
	 * @return void
	 */
	public function __construct( $add_select_box = false ) {
		$this->add_select_box = $add_select_box;
		add_action( 'woocommerce_blocks_loaded', array( $this, 'register_callbacks' ) );
	}

	/**
	 * Register the block callbacks.
	 *
	 * @return void
	 */
	public function register_callbacks() {
		// Register the callback for the update API.
		woocommerce_store_api_register_update_callback(
			array(
				'namespace' => 'krokedil-pickup-point',
				'callback'  => function ( $data ) {
					$this->block_callback( $data );
				},
			)
		);
	}

	/**
	 * Callback for the block update API.
	 *
	 * @param array $data The data to update.
	 *
	 * @return void
	 */
	public function block_callback( $data ) {
		error_log( 'Block data updated: ' . var_export( $data, true ) );
	}
	/**
	 * Returns an array of script handles to enqueue in the editor context.
	 *
	 * @return string[]
	 */
	public function get_editor_script_handles() {
		return array( 'krokedil-pickup-points-block' );
	}

	/**
	 * The name of the integration.
	 *
	 * @return string
	 */
	public function get_name() {
		return 'krokedil-pickup-points';
	}

	/**
	 * An array of key, value pairs of data made available to the block on the client side.
	 *
	 * @return array
	 */
	public function get_script_data() {
		return array(
			'addSelectBox' => $this->add_select_box,
		);
	}

	/**
	 * Returns an array of script handles to enqueue in the frontend context.
	 *
	 * @return string[]
	 */
	public function get_script_handles() {
		return array( 'krokedil-pickup-points-block' );
	}

	/**
	 * When called invokes any initialization/setup for the integration.
	 */
	public function initialize() {
		$build_path = dirname( __DIR__, 2 );

		$js_file     = plugin_dir_url( $build_path ) . 'blocks/build/pickuppoints.js';
		$assets_file = $build_path . '/build/pickuppoints.asset.php';

		// Ensure the assets file exists.
		if ( ! file_exists( $assets_file ) ) {
			return;
		}

		$assets = require $assets_file;

		wp_register_script(
			'krokedil-pickup-points-block',
			$js_file,
			$assets['dependencies'],
			$assets['version'],
			true
		);
	}

	/**
	 * Register the block to be available for checkout block.
	 *
	 * @param bool $add_select_box Whether or not to add the select box to the checkout page.
	 *
	 * @return void
	 */
	public static function register_block( $add_select_box = false ) {
		add_action(
			'woocommerce_blocks_checkout_block_registration',
			function ( $integration_registry ) use ( $add_select_box ) {
				$integration_registry->register( new PickupPointsBlock( $add_select_box ) );
			}
		);
	}
}
