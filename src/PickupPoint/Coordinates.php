<?php
namespace Krokedil\Shipping\PickupPoint;
use Krokedil\Shipping\Traits\ArrayFormat;
use Krokedil\Shipping\Traits\JsonFormat;

/**
 * Contains the coordinates for the location of a pickup point.
 *
 * @since 1.0.0
 */
class Coordinates {
	use JsonFormat;
	use ArrayFormat;

    #region Properties
    /**
     * Latitute
     *
     * @var float
     */
	public $latitude;

    /**
     * Longitude
     *
     * @var float
     */
	public $longitude;

    #endregion

    /**
     * Coordinates constructor. Sets the latitude and longitude properties.
     * Latitude and longitude are floats.
     * If no latitude or longitude is provided, the default value is 0.0.
     *
     * @param float|string|null $latitude Latitude.
     * @param float|string|null $longitude Longitude.
     *
     * @since 1.0.0
     *
     * @example $coordinates = new Coordinates( 59.329323, 18.068581 );
     *
     * @return void
     */
	public function __construct( $latitude = 0.0, $longitude = 0.0 ) {
		$this->set_latitude( $latitude );
		$this->set_longitude( $longitude );
	}

    #region Getters
    /**
     * Get latitude.
     *
     * @return float
     */
    public function get_latitude() {
        return $this->latitude;
    }

    /**
     * Get longitude.
     *
     * @return float
     */
	public function get_longitude() {
		return $this->longitude;
	}
    #endregion

    #region Setters
    /**
     * Set latitude.
     *
     * @param float|string|null $latitude Latitude.
     */
	public function set_latitude( $latitude ) {
        // Ensure that the latitude is a float.
        $latitude = (float) $latitude ?? 0.0;

		$this->latitude = $latitude;

        return $this;
	}

    /**
     * Set longitude.
     *
     * @param float|string|null $longitude Longitude.
     */
	public function set_longitude( $longitude ) {
        // Ensure that the longitude is a float.
        $longitude = (float) $longitude ?? 0.0;

        $this->longitude = $longitude;

        return $this;
	}
    #endregion
}
