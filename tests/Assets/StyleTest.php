<?php
use Krokedil\Shipping\Assets\Style;
use WP_Mock\Tools\TestCase;

class StyleTest extends TestCase {
	public function testConstruct() {
		$style = new Style( 'test-handle', 'test-src' );
		$this->assertNotEmpty( $style );
	}

	public function testRegister() {
		WP_Mock::userFunction( 'wp_register_style' )->once()->with( 'test-handle', 'test-src', array(), '1.0.0', 'all' );

		$style = new Style( 'test-handle', 'test-src' );
		$style->register();

		$this->expectNotToPerformAssertions();
	}

	public function testEnqueue() {
		WP_Mock::userFunction( 'wp_enqueue_style' )->once()->with( 'test-handle' );

		$style = new Style( 'test-handle', 'test-src' );
		$style->enqueue();

		$this->expectNotToPerformAssertions();
	}

	public function testGetAdmin() {
		$style = new Style( 'test-handle', 'test-src', array(), '1.0.0', true );
		$this->assertTrue( $style->get_admin() );
	}
}
