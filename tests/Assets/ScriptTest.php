<?php
use Krokedil\Shipping\Assets\Script;
use WP_Mock\Tools\TestCase;

class ScriptTest extends TestCase {
	public function testConstruct() {
		$script = new Script( 'test-handle', 'test-src' );
		$this->assertNotEmpty( $script );
	}

	public function testRegister() {
		WP_Mock::userFunction( 'wp_register_script' )->once()->with( 'test-handle', 'test-src', array(), '1.0.0', false );

		$script = new Script( 'test-handle', 'test-src' );
		$script->register();

		$this->expectNotToPerformAssertions();
	}

	public function testEnqueue() {
		WP_Mock::userFunction( 'wp_enqueue_script' )->once()->with( 'test-handle' );

		$script = new Script( 'test-handle', 'test-src' );
		$script->enqueue();

		$this->expectNotToPerformAssertions();
	}

	public function testEnqueueAndLocalize() {
		WP_Mock::userFunction( 'wp_enqueue_script' )->once()->with( 'test-handle' );
		WP_Mock::userFunction( 'wp_localize_script' )->once()->with( 'test-handle', 'testObject', array( 'test' => 'test' ) );

		$script = new Script( 'test-handle', 'test-src', array(), '1.0.0', false, false, array( 'testObject' => array( 'test' => 'test' ) ) );
		$script->enqueue();

		$this->expectNotToPerformAssertions();
	}

	public function testGetParameters() {
		$script = new Script( 'test-handle', 'test-src', array(), '1.0.0', false, false, array( 'testObject' => array( 'test' => 'test' ) ) );
		$this->assertEquals( array( 'testObject' => array( 'test' => 'test' ) ), $script->get_parameters() );
	}
}
