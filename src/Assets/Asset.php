<?php
namespace Krokedil\Shipping\Assets;

/**
 * Asset base class.
 *
 * Contains the common properties and methods for all asset types
 */
abstract class Asset {
	/**
	 * The handle of the asset.
	 *
	 * @var string
	 */
	protected $handle;

	/**
	 * The source of the asset. As a URL to the file.
	 *
	 * @var string
	 */
	protected $src;

	/**
	 * The dependencies of the asset.
	 *
	 * @var array<string>
	 */
	protected $deps;

	/**
	 * The version of the asset.
	 *
	 * @var string
	 */
	protected $version;

	/**
	 * Whether or not the asset is for the admin pages.
	 *
	 * @var bool
	 */
	protected $admin;

	/**
	 * Class constructor.
	 *
	 * @param string $handle The handle of the asset.
	 * @param string $src The source of the asset. As a URL to the file.
	 * @param array<string> $deps The dependencies of the asset.
	 * @param string $version The version of the asset.
	 * @param bool $admin Whether or not the asset is for the admin pages.
	 */
	public function __construct( $handle, $src, $deps = array(), $version = '', $admin = false ) {
		$this->handle  = $handle;
		$this->src     = $src;
		$this->deps    = $deps;
		$this->version = $version;
		$this->admin   = $admin;
	}

	/**
	 * Get the handle of the asset.
	 *
	 * @return string
	 */
	public function get_handle() {
		return $this->handle;
	}

	/**
	 * Get the source of the asset. As a URL to the file.
	 *
	 * @return string
	 */
	public function get_src() {
		return $this->src;
	}

	/**
	 * Get the dependencies of the asset.
	 *
	 * @return array<string>
	 */
	public function get_deps() {
		return $this->deps;
	}

	/**
	 * Get the version of the asset.
	 *
	 * @return string
	 */
	public function get_version() {
		return $this->version;
	}

	/**
	 * Get whether or not the asset is for the admin pages.
	 *
	 * @return bool
	 */
	public function get_admin() {
		return $this->admin;
	}

	/**
	 * Register the asset.
	 *
	 * @return void
	 */
	abstract public function register();

	/**
	 * Enqueue the asset.
	 *
	 * @return void
	 */
	abstract public function enqueue();
}
