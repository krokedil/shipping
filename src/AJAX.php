<?php
namespace Krokedil\Shipping;

defined( 'ABSPATH' ) || exit;

/**
 * AJAX class for Klarna Express Checkout
 *
 * @package Krokedil\KlarnaExpressCheckout
 */
class AJAX {
	/**
	 * The callable to get the payload for the Klarna Express Checkout.
	 *
	 * @var callable
	 */
	private $get_payload;

	/**
	 * AJAX constructor.
	 *
	 * @param array $events The AJAX events to add with their callbacks.
	 */
	public function __construct( $events = array() ) {
		$this->add_ajax_events( $events );
	}

	/**
	 * Setup hooks for the AJAX events.
	 *
	 * @param array $events The AJAX events to add with their callbacks.
	 *
	 * @return void
	 */
	public function add_ajax_events( $events = array() ) {
		foreach ( $events as $action => $callback ) {
			add_action( 'wc_ajax_' . $action, $callback );
		}
	}

	/**
	 * Add a single AJAX event.
	 *
	 * @param string   $action The action to add.
	 * @param callable $callback The callback to add.
	 * @param bool     $nopriv Whether the callback should be allowed for non-logged in users.
	 *
	 * @return self
	 */
	public function add_ajax_event( $action, $callback, $nopriv = true ) {
		if ( $nopriv ) {
			add_action( 'wc_ajax_' . $action, $callback );
		} else {
			add_action( 'wp_ajax_' . $action, $callback );
		}
		return $this;
	}
}
