<?php
namespace Krokedil\Shipping\Assets;

/**
 * Class AssetsRegistry
 *
 * Class that stores the assets that should be enqueued.
 */
class AssetsRegistry {
	/**
	 * The base path of the plugin that the package is in.
	 *
	 * @var string
	 */
	private $base_path;

	/**
	 * Array of scripts to be enqueued.
	 *
	 * @var array<string, Script>
	 */
	public $scripts = array();

	/**
	 * Array of styles to be enqueued.
	 *
	 * @var array<string, Style>
	 */
	public $styles = array();

	/**
	 * Class constructor.
	 */
	public function __construct( $plugin_file_path ) {
		$this->base_path = plugin_dir_url( $plugin_file_path );

		// Add the action to register the scripts and styles.
		add_action( 'init', array( $this, 'register_assets' ) );

		// Add the action to enqueue the scripts and styles.
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_assets' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_assets' ) );
	}

	/**
	 * Register the scripts and styles.
	 *
	 * @return void
	 */
	public function register_assets() {
		foreach ( $this->scripts as $script ) {
			$script->register();
		}

		foreach ( $this->styles as $style ) {
			$style->register();
		}
	}

	/**
	 * Enqueue the scripts and styles.
	 *
	 * @return void
	 */
	public function enqueue_assets() {
		foreach ( $this->scripts as $script ) {
			// If we are on the admin pages, only enqueue the admin scripts.
			if ( $script->get_admin() && ! is_admin() ) {
				continue;
			}

			$script->enqueue();
		}

		foreach ( $this->styles as $style ) {
			// If we are on the admin pages, only enqueue the admin styles.
			if ( $style->get_admin() && ! is_admin() ) {
				continue;
			}

			$style->enqueue();
		}
	}

	/**
	 * Add a script to the registry.
	 *
	 * @param Script $script The script to add.
	 * @return void
	 */
	public function add_script( $script ) {
		$this->scripts[ $script->get_handle()] = $script;
	}

	/**
	 * Add a style to the registry.
	 *
	 * @param Style $style The style to add.
	 * @return void
	 */
	public function add_style( $style ) {
		$this->styles[ $style->get_handle()] = $style;
	}

	/**
	 * Get the URL of an asset in the package
	 *
	 * @param string $asset The asset to get the URL for. The path of the file from the assets folder.
	 * @return string
	 */
	public function get_asset_url( $asset ) {
		return $this->base_path . 'vendor/krokedil/shipping/assets/' . $asset;
	}
}
