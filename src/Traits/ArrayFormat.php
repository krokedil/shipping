<?php
/**
 * Trait to convert an object to an array.
 *
 * @package Krokedil/Shipping/Traits
 */

namespace Krokedil\Shipping\Traits;

/**
 * Trait ArrayFormat
 */
trait ArrayFormat {
	/**
	 * Convert an object to an array.
	 *
	 * @return array<string, mixed>|null
	 */
	public function to_array() {
		return json_decode( json_encode( $this ), true );
	}
}
