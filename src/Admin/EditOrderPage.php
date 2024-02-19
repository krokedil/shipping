<?php
namespace Krokedil\Shipping\Admin;

use Krokedil\Shipping\AJAX;
use Krokedil\Shipping\Interfaces\PickupPointServiceInterface;
use Krokedil\Shipping\PickupPoint\PickupPoint;

defined( 'ABSPATH' ) || exit;

/**
 * Class to handle the edit order page in WooCommerce.
 */
class EditOrderPage {
	/**
	 * The pickup point service.
	 *
	 * @var PickupPointServiceInterface
	 */
	private $pickup_point_service;

	/**
	 * Class constructor.
	 *
	 * @param PickupPointServiceInterface $pickup_point_service The pickup point service.
	 *
	 * @return void
	 */
	public function __construct( $pickup_point_service ) {
		$this->pickup_point_service = $pickup_point_service;

		add_action( 'add_meta_boxes', array( $this, 'add_shipping_metabox' ), 10, 2 );

		// Add actions for the metabox outputs.
		add_action( 'ks_metabox_content', array( $this, 'print_selected_pickup_point_info' ), 10, 2 );
		add_action( 'ks_metabox_content', array( $this, 'print_selected_pickup_point_selection' ), 20, 2 );

		$this->init();
	}

	/**
	 * Init the class.
	 *
	 * @return void
	 */
	public function init() {
		/**
		 * The Ajax service from the pickup point service container.
		 *
		 * @var AJAX $registry The Ajax service.
		 */
		$registry = $this->pickup_point_service->get_container()->get( 'ajax' );

		// Register the AJAX request to set the selected pickup point.
		$registry->add_ajax_event( 'ks_pp_update_selected', array( $this, 'update_selected_pickup_point' ) );
	}

	/**
	 * Add the shipping metabox to the edit order page.
	 *
	 * @param string    $post_type The post type to add the metabox to.
	 * @param \WC_Order $order   The WooCommerce order.
	 *
	 * @return void
	 */
	public function add_shipping_metabox( $post_type, $order ) {
		if ( ! $order instanceof \WC_Order || ! in_array( $post_type, array( 'shop_order', 'woocommerce_page_wc-orders' ), true ) ) {
			return;
		}

		// Ensure the order has a shipping lines with a pickup point.
		$shipping_lines = $this->pickup_point_service->get_shipping_lines_from_order( $order );

		if ( ! $shipping_lines ) {
			return;
		}

		add_meta_box(
			'krokedil_shipping',
			__( 'Shipping Information', 'krokedil-shipping' ),
			array( $this, 'render_shipping_metabox' ),
			$post_type,
			'side',
			'high',
			array( 'shipping_lines' => $shipping_lines )
		);
	}

	/**
	 * Render the shipping metabox.
	 *
	 * @param \WC_Order $order The WooCommerce order.
	 * @param array     $args  The metabox arguments.
	 *
	 * @return void
	 */
	public function render_shipping_metabox( $order, $args ) {
		$shipping_lines = $args['args']['shipping_lines'] ?? array();

		if ( ! $order instanceof \WC_Order ) {
			return;
		}

		// Loop each method and render the pickup point information.
		$i     = 0;
		$count = count( $shipping_lines );
		foreach ( $shipping_lines as $shipping_line ) {
			?>
			<div class="ks-metabox__wrapper" data-shipping-line-id="<?php echo esc_attr( $shipping_line->get_id() ); ?>">
				<?php do_action( 'ks_metabox_content', $order, $shipping_line ); ?>
			</div>
			<?php
			if ( $count > 1 && $i !== $count - 1 ) {
				echo '<hr />';
			}

			++$i;
		}
	}

	/**
	 * Print the selected pickup point info.
	 *
	 * @param \WC_Order               $order      The WooCommerce order.
	 * @param \WC_Order_Item_Shipping $shipping_line The shipping line.
	 *
	 * @return void
	 */
	public function print_selected_pickup_point_info( $order, $shipping_line ) {
		$selected = PickupPoint::get_selected_from_order( $order );

		if ( ! $selected instanceof PickupPoint ) {
			return;
		}

		?>
		<div class="ks-metabox__information" data-shipping-line-id="<?php echo esc_html( $shipping_line->get_id() ); ?>">
			<h4><?php echo esc_html( $shipping_line->get_method_title() ); ?></h4>
			<strong>
				<?php esc_html_e( 'Selected pickup point', 'krokedil-shipping' ); ?>
				<a href="#" class="ks-metabox__edit-pp" data-shipping-line-id="<?php echo esc_html( $shipping_line->get_id() ); ?>"><?php esc_html_e( 'Edit', 'woocommerce' ); //phpcs:ignore ?></a>
			</strong>
			<br />
			<?php echo esc_html( $selected->get_name() ); ?>
			<br />
			<small><?php $selected->print_address( true ); ?></small>
		</div>
		<?php
	}

	/**
	 * Print the selected pickup point selection.
	 *
	 * @param \WC_Order               $order      The WooCommerce order.
	 * @param \WC_Order_Item_Shipping $shipping_line The shipping line.
	 *
	 * @return void
	 */
	public function print_selected_pickup_point_selection( $order, $shipping_line ) {
		$selected      = PickupPoint::get_selected_from_order( $order );
		$pickup_points = PickupPoint::get_from_order( $order );

		if ( ! $selected instanceof PickupPoint || ! $pickup_points ) {
			return;
		}

		?>
		<div class="ks-metabox__change-pp" data-shipping-line-id="<?php echo esc_html( $shipping_line->get_id() ); ?>">
			<select name="ks-metabox__selected-pp" id="ks-metabox__selected-pp-<?php echo esc_html( $shipping_line->get_id() ); ?>">
				<?php foreach ( $pickup_points as $pickup_point ) : ?>
				<option
					value="<?php echo esc_attr( $pickup_point->get_id() ); ?>"
					<?php selected( $selected->get_id(), $pickup_point->get_id() ); ?>
				>
					<?php echo esc_html( $pickup_point->get_name() ); ?>
				</option>
				<?php endforeach; ?>
			</select>
			<button type="button" class="button button-primary ks-metabox__change-pp-button" data-shipping-line-id="<?php echo esc_html( $shipping_line->get_id() ); ?>">
				<?php esc_html_e( 'Change', 'krokedil-shipping' ); ?>
			</button>
		</div>
		<?php
	}

	/**
	 * Update the selected pickup point ajax call handler.
	 *
	 * @return void
	 */
	public function update_selected_pickup_point() {
		// Check the admin referer.
		check_ajax_referer( 'ks_pp_update_selected', 'nonce' );

		// Get the posted shipping line id, pickup point id and order id.
		$shipping_line_id = filter_input( INPUT_POST, 'shippingLineId', FILTER_SANITIZE_STRING );
		$pickup_point_id  = filter_input( INPUT_POST, 'pickupPointId', FILTER_SANITIZE_STRING );
		$order_id         = filter_input( INPUT_POST, 'orderId', FILTER_SANITIZE_STRING );

		// Get the order.
		$order = wc_get_order( $order_id );

		if ( ! $order instanceof \WC_Order ) {
			wp_send_json_error( array( 'message' => __( 'Invalid order id', 'krokedil-shipping' ) ) );
		}

		// Get the shipping line.
		$shipping_line = new \WC_Order_Item_Shipping( $shipping_line_id );

		if ( ! $shipping_line instanceof \WC_Order_Item_Shipping ) {
			wp_send_json_error( array( 'message' => __( 'Invalid shipping line id', 'krokedil-shipping' ) ) );
		}

		// Get the pickup points.
		$pickup_points = PickupPoint::get_from_order( $order );

		if ( ! $pickup_points ) {
			wp_send_json_error( array( 'message' => __( 'No pickup points found', 'krokedil-shipping' ) ) );
		}

		// Get the selected pickup point.
		$selected_pickup_point = null;

		foreach ( $pickup_points as $pickup_point ) {
			if ( strval( $pickup_point->get_id() ) === strval( $pickup_point_id ) ) {
				$selected_pickup_point = $pickup_point;
				break;
			}
		}

		if ( ! $selected_pickup_point ) {
			wp_send_json_error( array( 'message' => __( 'Invalid pickup point id', 'krokedil-shipping' ) ) );
		}

		// Update the shipping line.
		$shipping_line->update_meta_data( 'krokedil_selected_pickup_point', wp_json_encode( $selected_pickup_point ) );
		$shipping_line->update_meta_data( 'krokedil_selected_pickup_point_id', $selected_pickup_point->get_id() );

		if ( ! $shipping_line->save() ) {
			wp_send_json_error( array( 'message' => __( 'Could not save shipping line', 'krokedil-shipping' ) ) );
		}

		ob_start();
		$this->print_selected_pickup_point_info( $selected_pickup_point, $shipping_line );
		$shipping_info = ob_get_clean();

		wp_send_json_success(
			array(
				'message'   => __( 'Pickup point updated', 'krokedil-shipping' ),
				'fragments' => array(
					'.ks-metabox__information' => $shipping_info,
				),
			)
		);
	}
}
