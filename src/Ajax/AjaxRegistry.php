<?php
namespace Krokedil\Shipping\Ajax;

/**
 * Class AjaxRegistry
 *
 * Handles the registration of AJAX requests.
 */
class AjaxRegistry {
	/**
	 * The array of AJAX requests.
	 *
	 * @var array<string, AjaxRequest>
	 */
	private $requests = array();

	/**
	 * Class constructor.
	 *
	 * @return void
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'register_requests' ) );
	}

	/**
	 * Register the AJAX requests.
	 *
	 * @return void
	 */
	public function register_requests() {
		foreach ( $this->requests as $request ) {
			$action = $request->get_action();
			add_action( 'wp_ajax_woocommerce_' . $action, $request->get_callback() );
			if ( $request->get_no_priv() ) {
				add_action( 'wp_ajax_nopriv_woocommerce_' . $action, $request->get_callback() );
				add_action( 'wc_ajax_' . $action, $request->get_callback() );
			}
		}
	}

	/**
	 * Add an AJAX request to the registry.
	 *
	 * @param AjaxRequest $request
	 * @return void
	 */
	public function add_request( $request ) {
		$this->requests[ $request->get_action()] = $request;
	}

	/**
	 * Get an AJAX request from the registry.
	 *
	 * @param string $action
	 * @return AjaxRequest|null
	 */
	public function get_request( $action ) {
		return isset( $this->requests[ $action ] ) ? $this->requests[ $action ] : null;
	}
}
