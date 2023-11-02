<?php
namespace Krokedil\Shipping\Assets;

/**
 * Class Script
 *
 * Defines a script to be enqueued.
 */
class Script extends Asset {
	/**
	 * Whether or not to enqueue the script in the footer.
	 *
	 * @var bool
	 */
	private $in_footer;

	/**
	 * Parameters for the script to be localized with it.
	 *
	 * @var array<string, mixed>
	 */
	private $parameters;

	/**
	 * Class constructor.
	 *
	 * @param string $handle The handle of the script.
	 * @param string $src The source of the script. As a URL to the file.
	 * @param array $deps The dependencies of the script.
	 * @param string $version The version of the script.
	 * @param bool $admin Whether or not the script is for the admin pages.
	 * @param bool $in_footer Whether or not to enqueue the script in the footer.
	 * @param array<string, mixed> $parameters Parameters for the script to be localized with it.
	 *
	 * @return void
	 */
	public function __construct( $handle, $src, $deps = array(), $version = '1.0.0', $admin = false, $in_footer = false, $parameters = array() ) {
		parent::__construct( $handle, $src, $deps, $version, $admin );
		$this->in_footer  = $in_footer;
		$this->parameters = $parameters;
	}

	/**
	 * Get whether or not to enqueue the script in the footer.
	 *
	 * @return bool
	 */
	public function get_in_footer() {
		return $this->in_footer;
	}

	/**
	 * Get parameters for the script to be localized with it.
	 *
	 * @return array<string, mixed>
	 */
	public function get_parameters() {
		return $this->parameters;
	}

	/**
	 * Register the script.
	 *
	 * @return void
	 */
	public function register() {
		wp_register_script( $this->get_handle(), $this->get_src(), $this->get_deps(), $this->get_version(), $this->get_in_footer() );
	}

	/**
	 * Enqueue the script.
	 *
	 * @return void
	 */
	public function enqueue() {
		// If we have any parameters to localize, do so.
		if ( ! empty( $this->parameters ) ) {
			foreach ( $this->parameters as $name => $value ) {
				wp_localize_script( $this->handle, $name, $value );
			}
		}

		wp_enqueue_script( $this->handle );
	}
}
