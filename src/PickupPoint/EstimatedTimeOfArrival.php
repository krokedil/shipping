<?php
/**
 * Class for the estimated time of arrival of a pickup point.
 *
 * @package Krokedil/Shipping/PickupPoint
 */

namespace Krokedil\Shipping\PickupPoint;
use Krokedil\Shipping\Traits\ArrayFormat;
use Krokedil\Shipping\Traits\JsonFormat;

/**
 * Contains the estimated time of arrival for the pickup point location.
 * Both in UTC and local time.
 *
 * @since 1.0.0
 */
class EstimatedTimeOfArrival {
	use JsonFormat;
	use ArrayFormat;

    #region Properties
    /**
     * UTC
     *
     * @var string
     */
	public $utc;

    /**
     * Local time
     *
     * @var string
     */
	public $local;
    #endregion

    /**
     * EstimatedTimeOfArrival constructor. Sets the UTC and local time properties for the pickup points estimated time of arrival.
     *
     * @param string|null $utc UTC.
     * @param string|null $local Local time.
     *
     * @example $estimated_time_of_arrival = new EstimatedTimeOfArrival( '2020-01-01T08:00:00Z', '2020-01-01T09:00:00+01:00' );
     *
     * @return void
     */
	public function __construct( $utc = '', $local = '' ) {
        $this->set_utc( $utc );
        $this->set_local( $local );
	}

    #region Getters
    /**
     * Get UTC.
     *
     * @return string
     */
    public function get_utc() {
        return $this->utc;
    }

    /**
     * Get local time.
     *
     * @return string
     */
    public function get_local() {
        return $this->local;
    }
    #endregion

    #region Setters
    /**
     * Set UTC.
     *
     * @param string|null $utc UTC.
     */
	public function set_utc( $utc ) {
		$this->utc = $utc ?? '';

        return $this;
	}

    /**
     * Set local time.
     *
     * @param string|null $local Local time.
     */
    public function set_local( $local ) {
        $this->local = $local ?? '';

        return $this;
    }
    #endregion
}
