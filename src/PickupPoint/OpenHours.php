<?php
namespace Krokedil\Shipping\PickupPoint;

use Krokedil\Shipping\Traits\ArrayFormat;
use Krokedil\Shipping\Traits\JsonFormat;

/**
 * Contains the open hours for the pickup point location for a specific day.
 *
 * @since 1.0.0
 */
class OpenHours {
	use JsonFormat;
	use ArrayFormat;

	/**
	 * Day
	 *
	 * @var string
	 */
	public $day;

	/**
	 * Open
	 *
	 * @var string
	 */
	public $open;

	/**
	 * Close
	 *
	 * @var string
	 */
	public $close;

	/**
	 * OpenHours constructor. Sets the day, open and close properties.
	 *
	 * @param string|null $day Day.
	 * @param string|null $open Open.
	 * @param string|null $close Close.
	 *
	 * @since 1.0.0
	 *
	 * @example $open_hours = new OpenHours( 'Monday', '08:00', '17:00' );
	 *
	 * @return void
	 */
	public function __construct( $day = '', $open = '', $close = '' ) {
		$this->set_day( $day );
		$this->set_open( $open );
		$this->set_close( $close );
	}

	/**
	 * Get day.
	 *
	 * @return string
	 */
	public function get_day() {
		return $this->day;
	}

	/**
	 * Get open.
	 *
	 * @return string
	 */
	public function get_open() {
		return $this->open;
	}

	/**
	 * Get close.
	 *
	 * @return string
	 */
	public function get_close() {
		return $this->close;
	}

	/**
	 * Set day.
	 *
	 * @param string|null $day Day.
	 */
	public function set_day( $day ) {
		$this->day = $day ?? '';

		return $this;
	}

	/**
	 * Set open.
	 *
	 * @param string|null $open Open.
	 */
	public function set_open( $open ) {
		$this->open = $open ?? '';

		return $this;
	}

	/**
	 * Set close.
	 *
	 * @param string|null $close Close.
	 */
	public function set_close( $close ) {
		$this->close = $close ?? '';

		return $this;
	}
}
