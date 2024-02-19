<?php
namespace Krokedil\Shipping\Container;

use Krokedil\Shipping\Container\Exceptions\NotFoundException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

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
	 * @param string $id The name of the entry to add to the container.
	 * @param mixed  $service The entry to add to the container.
	 * @return void
	 */
	public function add( $id, $service ) {
		$this->services[ $id ] = $service;
	}

	/**
	 * Finds an entry of the container by its identifier and returns it.
	 *
	 * @param string $id Identifier of the entry to look for.
	 *
	 * @throws NotFoundException  No entry was found for **this** identifier.
	 *
	 * @return mixed Entry.
	 */
	public function get( string $id ) {
		if ( ! $this->has( $id ) ) {
			throw new NotFoundException( sprintf( 'Service %s not found in container.', $id ) ); // phpcs:ignore
		}

		return $this->services[ $id ];
	}

	/**
	 * Returns true if the container can return an entry for the given identifier.
	 * Returns false otherwise.
	 *
	 * `has($id)` returning true does not mean that `get($id)` will not throw an exception.
	 * It does however mean that `get($id)` will not throw a `NotFoundExceptionInterface`.
	 *
	 * @param string $id Identifier of the entry to look for.
	 *
	 * @return bool
	 */
	public function has( string $id ): bool {
		return isset( $this->services[ $id ] );
	}
}
