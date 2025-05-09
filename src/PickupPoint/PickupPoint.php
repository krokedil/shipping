<?php
namespace Krokedil\Shipping\PickupPoint;

use Krokedil\Shipping\PickupPoint\Address;
use Krokedil\Shipping\PickupPoint\Coordinates;
use Krokedil\Shipping\PickupPoint\OpenHours;
use Krokedil\Shipping\PickupPoint\EstimatedTimeOfArrival;
use Krokedil\Shipping\Traits\ArrayFormat;
use Krokedil\Shipping\Traits\JsonFormat;

/**
 * Contains the data for a pickup point.
 *
 * @since 1.0.0
 */
class PickupPoint {
	use JsonFormat;
	use ArrayFormat;

	/**
	 * ID of the pickup point or reference needed for the shipping plugin.
	 *
	 * @var string
	 */
	public $id;

	/**
	 * Name to display with the pickup point.
	 *
	 * @var string
	 */
	public $name;

	/**
	 * Description of the pickup point to be displayed.
	 *
	 * @var string
	 */
	public $description;

	/**
	 * Address of the pickup point.
	 *
	 * @var Address
	 */
	public $address;

	/**
	 * Coordinates of the pickup point.
	 *
	 * @var Coordinates
	 */
	public $coordinates;

	/**
	 * Opening hours of the pickup point.
	 *
	 * @var array<OpenHours>
	 */
	public $open_hours = array();

	/**
	 * Estimated time of arrival of the pickup point.
	 *
	 * @var EstimatedTimeOfArrival
	 */
	public $eta;

	/**
	 * Meta data for the pickup point to enable plugins to add additional data they might need.
	 *
	 * @var array;
	 */
	public $meta_data = array();

	/**
	 * PickupPoint constructor. Can be passed a array or a json string to automatically set the properties.
	 * If a string is passed it will be json decoded, if a array is passed it will be set directly.
	 *
	 * @param array|string $pickup_point Pickup point data as a array.
	 *
	 * @since 1.0.0
	 *
	 * @example $pickup_point = new PickupPoint( $pickup_point );
	 * @example $pickup_point = new PickupPoint( array( 'id' => '123', 'name' => 'My pickup point', ... ) );
	 *
	 * @return void
	 */
	public function __construct( $pickup_point = array() ) {
		// If the pickup point is a string, json decode it.
		if ( is_string( $pickup_point ) ) {
			$pickup_point = $this->json_to_array( $pickup_point );
		}

		$this->set_from_array( $pickup_point );
	}

	/**
	 * Get the ID.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get the name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->name;
	}

	/**
	 * Get the description.
	 *
	 * @return string
	 */
	public function get_description() {
		return $this->description;
	}

	/**
	 * Get the address.
	 *
	 * @return Address
	 */
	public function get_address() {
		return $this->address;
	}

	/**
	 * Get the coordinates.
	 *
	 * @return Coordinates
	 */
	public function get_coordinates() {
		return $this->coordinates;
	}

	/**
	 * Get the opening hours.
	 *
	 * @return array<OpenHours>
	 */
	public function get_open_hours() {
		return $this->open_hours;
	}

	/**
	 * Get the estimated time of arrival.
	 *
	 * @return EstimatedTimeOfArrival
	 */
	public function get_eta() {
		return $this->eta;
	}

	/**
	 * Set the ID.
	 *
	 * @param string|null $id ID.
	 */
	public function set_id( $id ) {
		$this->id = $id ?? '';

		return $this;
	}

	/**
	 * Set the name.
	 *
	 * @param string|null $name Name.
	 */
	public function set_name( $name ) {
		$this->name = $name ?? '';

		return $this;
	}

	/**
	 * Set the description.
	 *
	 * @param string|null $description Description.
	 */
	public function set_description( $description ) {
		$this->description = $description ?? '';

		return $this;
	}

	/**
	 * Set the address.
	 *
	 * @param string $street   Street.
	 * @param string $city     City.
	 * @param string $postcode Postcode.
	 * @param string $country  Country.
	 */
	public function set_address( $street, $city, $postcode, $country ) {
		$this->address = new Address( $street, $city, $postcode, $country );

		return $this;
	}

	/**
	 * Set the coordinates.
	 *
	 * @param float|string|null $latitude  Latitude.
	 * @param float|string|null $longitude Longitude.
	 */
	public function set_coordinates( $latitude, $longitude ) {
		$this->coordinates = new Coordinates( $latitude, $longitude );

		return $this;
	}

	/**
	 * Set the opening hours.
	 *
	 * @param array $open_hours Opening hours.
	 */
	public function set_open_hours( $open_hours ) {
		$this->open_hours = array();
		foreach ( $open_hours as $open_hour ) {
			$this->open_hours[] = new OpenHours( $open_hour['day'], $open_hour['open'], $open_hour['close'] );
		}

		return $this;
	}

	/**
	 * Set a single opening hour for a specific day.
	 *
	 * @param string $day Day.
	 * @param string $open Open.
	 * @param string $close Close.
	 */
	public function set_open_hour( $day, $open, $close ) {
		$this->open_hours[] = new OpenHours( $day, $open, $close );

		return $this;
	}

	/**
	 * Set the estimated time of arrival.
	 *
	 * @param string|null $utc UTC.
	 * @param string|null $local Local time.
	 */
	public function set_eta( $utc = '', $local = '' ) {
		$this->eta = new EstimatedTimeOfArrival( $utc, $local );

		return $this;
	}

	/**
	 * Add meta data to the pickup point.
	 *
	 * @param string $key  The meta key to store the value under.
	 * @param mixed  $value The meta value to store.
	 */
	public function add_meta_data( $key, $value ) {
		$this->meta_data[ $key ] = $value;
	}

	/**
	 * Get the meta data.
	 *
	 * @param string $key The meta key to get the value for.
	 * @return mixed|false
	 */
	public function get_meta_data( $key ) {
		return $this->meta_data[ $key ] ?? false;
	}

	/**
	 * Set the pickup point from an array.
	 *
	 * @param array $pickup_point Pickup point data as a array.
	 */
	public function set_from_array( $pickup_point = array() ) {
		$this->set_id( $pickup_point['id'] ?? '' );
		$this->set_name( $pickup_point['name'] ?? '' );
		$this->set_description( $pickup_point['description'] ?? '' );

		$address = $pickup_point['address'] ?? array();
		$this->set_address(
			$address['street'] ?? '',
			$address['city'] ?? '',
			$address['postcode'] ?? '',
			$address['country'] ?? ''
		);

		$coordinates = $pickup_point['coordinates'] ?? array();
		$this->set_coordinates(
			$coordinates['latitude'] ?? '',
			$coordinates['longitude'] ?? ''
		);

		$this->set_open_hours( $pickup_point['open_hours'] ?? array() );

		$eta = $pickup_point['eta'] ?? array();
		$this->set_eta(
			$eta['utc'] ?? '',
			$eta['local'] ?? ''
		);

		$meta_data = $pickup_point['meta_data'] ?? array();
		foreach ( $meta_data as $key => $value ) {
			$this->add_meta_data( $key, $value );
		}
	}

	/**
	 * Print the address as a formatted HTML output.
	 *
	 * @param bool $no_title Whether to print the title or not.
	 * @return void
	 * @codeCoverageIgnore
 	 * No tests made yet.
	 */
	public function print_address( $no_title = false ) {
		if ( ! $this->address ) {
			return;
		}

		?>
		<?php if ( ! $no_title ) : ?>
		<strong><?php esc_html_e( 'Address', 'krokedil-shipping' ); ?></strong>
		<br />
		<?php endif; ?>
		<?php
		echo wp_kses_post(
			WC()->countries->get_formatted_address(
				array(
					'address_1' => $this->address->get_street(),
					'postcode'  => $this->address->get_postcode(),
					'city'      => $this->address->get_city(),
					'country'   => $this->address->get_country(),
				)
			)
		);
		?>
		<?php
	}

	/**
	 * Print the Opening hours as a formatted HTML output.
	 *
	 * @return void
	 *
	 * @codeCoverageIgnore
 	 * No tests made yet.
	 */
	public function print_open_hours() {
		if ( ! $this->open_hours ) {
			return;
		}
		?>
			<strong><?php esc_html_e( 'Open hours', 'krokedil-shipping' ); ?></strong>
			<br />
			<?php foreach ( $this->open_hours as $open_hour ) : ?>
				<?php echo esc_html( $open_hour->get_day() ); ?>:
				<?php echo esc_html( $open_hour->get_open() ); ?> -
				<?php echo esc_html( $open_hour->get_close() ); ?>
				<br />
			<?php endforeach; ?>
		<?php
	}

	/**
	 * Print a google maps link to the pickup point.
	 *
	 * @return void
	 *
	 * @codeCoverageIgnore
 	 * No tests made yet.
	 */
	public function print_google_maps_link() {
		if ( ! $this->coordinates ) {
			return;
		}

		?>
			<a href="https://www.google.com/maps/search/?api=1&query=<?php echo esc_attr( $this->coordinates->get_latitude() ); ?>,<?php echo esc_attr( $this->coordinates->get_longitude() ); ?>" target="_blank">
				<?php esc_html_e( 'Show on map', 'krokedil-shipping' ); ?>
			</a>
		<?php
	}

	/**
	 * Get selected from order.
	 *
	 * @param \WC_Order $order The WooCommerce order.
	 *
	 * @return PickupPoint|bool
	 */
	public static function get_selected_from_order( $order ) {
		$shipping_lines = $order->get_items( 'shipping' );

		if ( empty( $shipping_lines ) ) {
			return false;
		}

		foreach ( $shipping_lines as $shipping_line ) {
			$selected_meta = $shipping_line->get_meta( 'krokedil_selected_pickup_point' );

			if ( ! $selected_meta ) {
				continue;
			}

			return new PickupPoint( $selected_meta );
		}

		return false;
	}

	/**
	 * Get pickup points from order.
	 *
	 * @param \WC_Order $order The WooCommerce order.
	 *
	 * @return array<PickupPoint>|bool
	 *
	 * @codeCoverageIgnore
 	 * No tests made yet.
	 */
	public static function get_from_order( $order ) {
		$shipping_lines = $order->get_items( 'shipping' );

		if ( empty( $shipping_lines ) ) {
			return false;
		}

		$pickup_points = array();
		foreach ( $shipping_lines as $shipping_line ) {
			$pickup_points_meta = json_decode( $shipping_line->get_meta( 'krokedil_pickup_points' ), true );

			if ( ! $pickup_points_meta ) {
				continue;
			}

			foreach ( $pickup_points_meta as $pickup_point ) {
				$pickup_points[] = new PickupPoint( $pickup_point );
			}
		}

		return empty( $pickup_points ) ? false : $pickup_points;
	}
}
