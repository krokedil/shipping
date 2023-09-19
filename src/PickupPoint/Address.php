<?php
/**
 * Class for pickup point address.
 *
 * @package Krokedil/Shipping/PickupPoint
 */

namespace Krokedil\Shipping\PickupPoint;
use Krokedil\Shipping\Traits\JsonFormat;
use Krokedil\Shipping\Traits\ArrayFormat;

/**
 * Contains the address for the location of a pickup point.
 *
 * @since 1.0.0
 */
class Address {
    use JsonFormat;
	use ArrayFormat;

    #region Properties
    /**
     * @var string
     */
    public $street;

    /**
     * @var string
     */
	public $city;

    /**
     * @var string
     */
	public $postcode;

    /**
     * @var string
     */
	public $country;
    #endregion

    /**
     * PickupPointAddress constructor. Sets the street, city, postcode and country properties for the pickup point address.
     *
     * @param string|null $street Street.
     * @param string|null $city City.
     * @param string|null $postcode Postcode.
     * @param string|null $country Country.
     *
     * @since 1.0.0
     *
     * @example $address = new Address( 'Street 1', 'City', '12345', 'Country' );
     *
     * @return void
     */
    public function __construct($street = '', $city = '', $postcode = '', $country = '') {
        $this->set_street($street);
        $this->set_city($city);
        $this->set_postcode($postcode);
        $this->set_country($country);
    }

    #region Getters
    /**
     * Get street.
     *
     * @return string
     */
	public function get_street() {
		return $this->street;
	}

    /**
     * Get city.
     *
     * @return string
     */
	public function get_city() {
		return $this->city;
	}

    /**
     * Get postcode.
     *
     * @return string
     */
	public function get_postcode() {
		return $this->postcode;
	}

    /**
     * Get country.
     *
     * @return string
     */
    public function get_country() {
        return $this->country;
    }
    #endregion

    #region Setters
    /**
     * Set street.
     *
     * @param string|null $street Street.
     */
    public function set_street( $street ) {
        $this->street = $street ?? '';

        return $this;
    }

    /**
     * Set city.
     *
     * @param string|null $city City.
     */
	public function set_city( $city ) {
		$this->city = $city ?? '';

        return $this;
	}

    /**
     * Set postcode.
     *
     * @param string|null $postcode Postcode.
     */
    public function set_postcode( $postcode ) {
        $this->postcode = $postcode ?? '';

        return $this;
    }

    /**
     * Set country.
     *
     * @param string|null $country Country.
     */
	public function set_country( $country ) {
		$this->country = $country ?? '';

        return $this;
	}
    #endregion
}
