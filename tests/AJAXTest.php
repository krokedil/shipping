<?php
use Krokedil\Shipping\AJAX;
use WP_Mock\Tools\TestCase;

class AJAXTest extends TestCase {
	public function testCanAddAjaxEvents() {
		$this->expectNotToPerformAssertions();
		WP_Mock::expectActionAdded( 'wc_ajax_test', array( $this, 'test_callback' ) );

		$ajax = new AJAX();
		$ajax->add_ajax_events(
			array(
				'test' => array( $this, 'test_callback' ),
			)
		);
	}

	public function testCanAddAjaxEvent() {
		$this->expectNotToPerformAssertions();
		WP_Mock::expectActionAdded( 'wc_ajax_test', array( $this, 'test_callback' ) );

		$ajax = new AJAX();
		$ajax->add_ajax_event(
			'test',
			array( $this, 'test_callback' )
		);
	}
}
