<?php
namespace Krokedil\Shipping\Admin;

use Krokedil\Shipping\AJAX;
use Krokedil\Shipping\Interfaces\PickupPointServiceInterface;
use Krokedil\Shipping\PickupPoint\PickupPoint;

defined( 'ABSPATH' ) || exit;

/**
 * Class to handle the edit order page in WooCommerce.
 *
 * @codeCoverageIgnore
 * No tests made yet.
 */
class EditOrderPage {
	/**
	 * The metabox title.
	 *
	 * @var string
	 */
	private $metabox_title;

	/**
	 * The pickup point service.
	 *
	 * @var PickupPointServiceInterface
	 */
	private $pickup_point_service;

	/**
	 * Can change pickup point.
	 *
	 * @var bool
	 */
	private $can_change_pickup_point;

	/**
	 * Class constructor.
	 *
	 * @param PickupPointServiceInterface $pickup_point_service The pickup point service.
	 *
	 * @return void
	 */
	public function __construct( $pickup_point_service ) {
		$this->pickup_point_service    = $pickup_point_service;
		$this->metabox_title           = __( 'Shipping Information', 'krokedil-shipping' );
		$this->can_change_pickup_point = true;

		$this->init();
	}

	/**
	 * Set the title for the metabox on the edit order page.
	 *
	 * @param string $title The metabox title.
	 *
	 * @return self
	 */
	public function set_metabox_title( $title ) {
		$this->metabox_title = $title ?? $this->metabox_title;
		return $this;
	}

	/**
	 * Set if the pickup point can be changed.
	 *
	 * @param bool $can_change_pickup_point If the pickup point can be changed.
	 *
	 * @return self
	 */
	public function set_can_change_pickup_point( $can_change_pickup_point ) {
		$this->can_change_pickup_point = $can_change_pickup_point;
		return $this;
	}

	/**
	 * Init the class.
	 *
	 * @return void
	 */
	public function init() {
		add_action( 'add_meta_boxes', array( $this, 'add_shipping_metabox' ), 10, 2 );

		// Add actions for the metabox outputs.
		add_action( 'ks_metabox_content', array( $this, 'print_selected_pickup_point_info' ), 10, 2 );
		add_action( 'ks_metabox_content', array( $this, 'print_selected_pickup_point_selection' ), 20, 2 );

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
	 * @param string            $post_type The post type to add the metabox to.
	 * @param \WP_Post|\WC_Order $post_or_order_object      The WordPress post or WooCommerce order, depending on HPOS is active or not.
	 *
	 * @return void
	 */
	public function add_shipping_metabox( $post_type, $post_or_order_object ) {

		$order = ( $post_or_order_object instanceof \WP_Post ) ? wc_get_order( $post_or_order_object->ID ) : $post_or_order_object;

		if ( ! $order instanceof \WC_Order ) {
			return;
		}

		// Ensure the order has a shipping lines with a pickup point.
		$shipping_lines = $this->pickup_point_service->get_shipping_lines_from_order( $order );

		// Possibility for plugins to display metabox even if shipping has no pickup points.
		$shipping_lines = apply_filters( 'krokedil_shipping_metabox_shipping_lines', $shipping_lines, $order );

		if ( ! $shipping_lines ) {
			return;
		}

		add_meta_box(
			'krokedil_shipping',
			$this->metabox_title,
			array( $this, 'render_shipping_metabox' ),
			$post_type,
			'side',
			'core',
			array( 'shipping_lines' => $shipping_lines )
		);
	}

	/**
	 * Render the shipping metabox.
	 *
	 * @param \WP_Post|\WC_Order $post_or_order_object      The WordPress post or WooCommerce order, depending on HPOS is active or not.
	 * @param array             $args  The metabox arguments.
	 *
	 * @return void
	 */
	public function render_shipping_metabox( $post_or_order_object, $args ) {

		$order = ( $post_or_order_object instanceof \WP_Post ) ? wc_get_order( $post_or_order_object->ID ) : $post_or_order_object;

		if ( ! $order instanceof \WC_Order ) {
			return;
		}

		$shipping_lines = $args['args']['shipping_lines'] ?? array();

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
		do_action( 'ks_before_print_selected_pickup_point_info', $order, $shipping_line );
		?>
		<div class="ks-metabox__information" data-shipping-line-id="<?php echo esc_html( $shipping_line->get_id() ); ?>">
			<strong>
				<?php esc_html_e( 'Selected pickup point', 'krokedil-shipping' ); ?>
				<?php if ( $this->can_change_pickup_point ) : ?>
					<a href="#" class="ks-metabox__edit-pp" data-shipping-line-id="<?php echo esc_html( $shipping_line->get_id() ); ?>"><?php esc_html_e( 'Edit', 'woocommerce' ); //phpcs:ignore ?></a>
				<?php endif; ?>
			</strong>
			<br />
			<?php echo esc_html( $selected->get_name() ); ?>
			<br />
			<small><?php $selected->print_address( true ); ?></small>
		</div>
		<?php
	}

	/**
	 * Print the Select pickup point dropdown.
	 *
	 * @param \WC_Order               $order      The WooCommerce order.
	 * @param \WC_Order_Item_Shipping $shipping_line The shipping line.
	 *
	 * @return void
	 */
	public function print_selected_pickup_point_selection( $order, $shipping_line ) {
		$selected      = PickupPoint::get_selected_from_order( $order );
		$pickup_points = PickupPoint::get_from_order( $order );

		if ( ! $selected instanceof PickupPoint || ! $pickup_points || ! $this->can_change_pickup_point ) {
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

		// Get the order again since it now have been updated with the new pickup point.
		$order = wc_get_order( $order_id );

		ob_start();
		$this->print_selected_pickup_point_info( $order, $shipping_line );
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
