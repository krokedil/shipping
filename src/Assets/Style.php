<?php
namespace Krokedil\Shipping\Assets;

/**
 * Class Style.
 *
 * Defines a style to be enqueued.
 */
class Style extends Asset {
	/**
	 * The media of the style.
	 *
	 * @var string
	 */
	private $media;

	/**
	 * Class constructor.
	 *
	 * @param string $handle The handle of the style.
	 * @param string $src The source of the style. As a URL to the file.
	 * @param array<string> $deps The dependencies of the style.
	 * @param string $version The version of the style.
	 * @param bool $admin Whether or not the style is for the admin pages.
	 * @param string $media The media of the style.
	 */
	public function __construct( $handle, $src, $deps = array(), $version = '1.0.0', $admin = false, $media = 'all' ) {
		parent::__construct( $handle, $src, $deps, $version, $admin );
		$this->media = $media;
	}

	/**
	 * Get the media of the style.
	 *
	 * @return string
	 */
	public function get_media() {
		return $this->media;
	}

	/**
	 * Register the style.
	 *
	 * @return void
	 */
	public function register() {
		wp_register_style( $this->get_handle(), $this->get_src(), $this->get_deps(), $this->get_version(), $this->get_media() );
	}

	/**
	 * Enqueue the style.
	 *
	 * @return void
	 */
	public function enqueue() {
		wp_enqueue_style( $this->handle );
	}
}
