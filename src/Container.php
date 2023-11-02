<?php
namespace Krokedil\Shipping;

/**
 * Class Container
 *
 * Handles the dependency injection for the package.
 */
class Container {
	/**
	 * Class instance.
	 *
	 * @var Container|null
	 */
	private static $instance;

	/**
	 * The array of services.
	 *
	 * @var array<string, object>
	 */
	private $services = array();

	/**
	 * Get the class instance.
	 *
	 * @return Container
	 */
	public static function get_instance() {
		if ( ! self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Add a service to the container.
	 *
	 * @param string $name
	 * @param object $service
	 * @return void
	 */
	public function add_service( $name, $service ) {
		$this->services[ $name ] = $service;
	}

	/**
	 * Get a service from the container.
	 *
	 * @param string $name
	 * @return object
	 */
	public function get_service( $name ) {
		return $this->services[ $name ];
	}

	/**
	 * Check if a service exists in the container.
	 *
	 * @param string $name
	 * @return bool
	 */
	public function has_service( $name ) {
		return isset( $this->services[ $name ] );
	}
}
