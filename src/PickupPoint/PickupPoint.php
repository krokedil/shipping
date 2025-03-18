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

	// region Properties
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
	// endregion

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

	// region Getters
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
	// endregion

	// region Setters
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
	// endregion

	// region Methods
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
		$this->set_id( html_entity_decode( $pickup_point['id'] ?? '' ) );
		$this->set_name( html_entity_decode( $pickup_point['name'] ?? '' ) );
		$this->set_description( html_entity_decode( $pickup_point['description'] ?? '' ) );

		$address = $pickup_point['address'] ?? array();
		$this->set_address(
			html_entity_decode( $address['street'] ?? '' ),
			html_entity_decode( $address['city'] ?? '' ),
			html_entity_decode( $address['postcode'] ?? '' ),
			html_entity_decode( $address['country'] ?? '' )
		);

		$coordinates = $pickup_point['coordinates'] ?? array();
		$this->set_coordinates(
			html_entity_decode( $coordinates['latitude'] ?? '' ),
			html_entity_decode( $coordinates['longitude'] ?? '' )
		);

		$this->set_open_hours( $pickup_point['open_hours'] ?? array() );

		$eta = $pickup_point['eta'] ?? array();
		$this->set_eta(
			html_entity_decode( $eta['utc'] ?? '' ),
			html_entity_decode( $eta['local'] ?? '' )
		);

		$meta_data = $pickup_point['meta_data'] ?? array();
		foreach ( $meta_data as $key => $value ) {
			$this->add_meta_data( $key, $value );
		}
	}
	// endregion
}
