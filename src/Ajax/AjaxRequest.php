<?php
namespace Krokedil\Shipping\Ajax;

/**
 * Class AjaxRequest
 *
 * Defines a single AJAX request and how to process it.
 */
class AjaxRequest {
	/**
	 * The name of the AJAX action.
	 *
	 * @var string
	 */
	private $action;

	/**
	 * The callback function to process the AJAX request.
	 *
	 * @var callable
	 */
	private $callback;

	/**
	 * If the AJAX request requires a logged in user.
	 *
	 * @var bool
	 */
	private $no_priv;

	/**
	 * Class constructor.
	 *
	 * @param string $action
	 * @param callable $callback
	 * @param bool $no_priv
	 * @return void
	 */
	public function __construct( $action, $callback, $no_priv = false ) {
		$this->action   = $action;
		$this->callback = $callback;
		$this->no_priv  = $no_priv;
	}

	/**
	 * Get the name of the AJAX action.
	 *
	 * @return string
	 */
	public function get_action() {
		return $this->action;
	}

	/**
	 * Get the callback function to process the AJAX request.
	 *
	 * @return callable
	 */
	public function get_callback() {
		return $this->callback;
	}

	/**
	 * Get if the AJAX request requires a logged in user.
	 *
	 * @return bool
	 */
	public function get_no_priv() {
		return $this->no_priv;
	}

	/**
	 * Process the AJAX request.
	 *
	 * @return void
	 */
	public function process() {
		// Check the nonce.
		if ( check_ajax_referer( $this->action, 'nonce' ) === false ) {
			wp_die( 'bad nonce' );
		}

		call_user_func( $this->callback );

		wp_die();
	}
}
