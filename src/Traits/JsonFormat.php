<?php
/**
 * Trait with helper methods to format data to and from JSON.
 *
 * @package Krokedil/Shipping/Traits
 */

namespace Krokedil\Shipping\Traits;

/**
 * Trait JsonFormat
 */
trait JsonFormat {
	/**
	 * Convert a JSON string to an array.
	 *
	 * @param string $json JSON string.
	 * @return array
	 */
	public function json_to_array( $json ) {
		return json_decode( $json, true );
	}

	/**
	 * Convert an array to a JSON string.
	 *
	 * @param array|object $item The item to convert to a json string.
	 * @return string
	 */
	public function to_json( $item ) {
		return json_encode( $item );
	}
}
