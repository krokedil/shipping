<?php
use Krokedil\Shipping\Assets;
use WP_Mock\Tools\TestCase;

class AssetsTest extends TestCase {
	public function testCanRegisterAssets() {
		$this->expectNotToPerformAssertions();
		WP_Mock::userFunction(
			'plugin_dir_url',
			array(
				'times'  => 1,
				'return' => 'test',
			)
		);
		WP_Mock::userFunction(
			'wp_register_script',
			array(
				'times' => 1,
			)
		);
		WP_Mock::userFunction(
			'wp_register_style',
			array(
				'times' => 1,
			)
		);

		$assets = new Assets();
		$assets->register_assets();
	}

	public function testCanEnqueueAssets() {
		$this->expectNotToPerformAssertions();
		// Create a mock for WC_AJAX and the get_endpoint static method.
		$mock = Mockery::mock( 'alias:WC_AJAX' );
		$mock->shouldReceive( 'get_endpoint' )->andReturn( 'test' );

		WP_Mock::userFunction(
			'plugin_dir_url',
			array(
				'times'  => 1,
				'return' => 'test',
			)
		);
		WP_Mock::userFunction(
			'is_checkout',
			array(
				'times'  => 1,
				'return' => true,
			)
		);
		WP_Mock::userFunction(
			'wp_create_nonce',
			array(
				'times'  => 1,
				'return' => 'test',
			)
		);
		WP_Mock::userFunction(
			'wp_localize_script',
			array(
				'times' => 1,
			)
		);
		WP_Mock::userFunction(
			'wp_enqueue_script',
			array(
				'times' => 1,
			)
		);
		WP_Mock::userFunction(
			'wp_enqueue_style',
			array(
				'times' => 1,
			)
		);

		$assets = new Assets();
		$assets->enqueue_assets();
	}

	public function testDoesNotEnqueueOnNonCheckoutPages() {
		$this->expectNotToPerformAssertions();

		WP_Mock::userFunction(
			'plugin_dir_url',
			array(
				'times'  => 1,
				'return' => 'test',
			)
		);

		WP_Mock::userFunction(
			'is_checkout',
			array(
				'times'  => 1,
				'return' => false,
			)
		);

		WP_Mock::userFunction(
			'wp_create_nonce',
			array(
				'times'  => 0,
				'return' => 'test',
			)
		);

		$assets = new Assets();
		$assets->enqueue_assets();
	}
}
