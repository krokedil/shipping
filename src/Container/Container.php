<?php
namespace Krokedil\Shipping\Container;

use Krokedil\Shipping\Container\Exceptions\NotFoundException;
use Psr\Container\ContainerInterface;

/**
 * Class Container
 *
 * Handles the dependency injection for the package.
 */
class Container implements ContainerInterface {
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
	 * Add a entry to the container.
	 *
	 * @param string $name The name of the entry to add to the container.
	 * @param mixed $service The entry to add to the container.
	 * @return void
	 */
	public function add( $id, $service ) {
		// If the service is already registered, return.
		if( $this->has( $id ) ) {
			return;
		}

		$this->services[ $id ] = $service;
	}

	/** {@inheritDoc} */
	public function get( string $id ) {
		if ( ! $this->has( $id ) ) {
			throw new NotFoundException( sprintf( 'Service %s not found in container.', $id ) );
		}

		return $this->services[ $id ];
	}

	/** {@inheritDoc} */
	public function has( string $id ): bool {
		return isset( $this->services[ $id ] );
	}
}
