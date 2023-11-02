<?php
use Krokedil\Shipping\Assets\AssetsRegistry;
use Krokedil\Shipping\Assets\Script;
use Krokedil\Shipping\Assets\Style;
use WP_Mock\Tools\TestCase;

class AssetsRegistryTest extends TestCase {
	private $assetsRegistry;
	private $pluginFilePath = 'path/to/plugin/file.php';

	public function setUp(): void {
		parent::setUp();

		WP_Mock::userFunction( 'plugin_dir_url' )->andReturn( 'http://example.com/wp-content/plugins/my-plugin/' );
		WP_Mock::userFunction( 'doing_action' )->andReturn( true );
		WP_Mock::userFunction( 'doing_filter', )->andReturn( true );

		$this->assetsRegistry = new AssetsRegistry( 'path/to/plugin/file.php' );
	}

	public function testConstruct() {
		$this->assertNotEmpty( $this->assetsRegistry );
	}

	public function testAddScript() {
		$script = new Script( 'test-handle', 'test-src' );
		$this->assetsRegistry->add_script( $script );
		$this->assertArrayHasKey( 'test-handle', $this->assetsRegistry->scripts );
	}

	public function testAddStyle() {
		$style = new Style( 'test-handle', 'test-src' );
		$this->assetsRegistry->add_style( $style );
		$this->assertArrayHasKey( 'test-handle', $this->assetsRegistry->styles );
	}

	public function testRegisterScripts() {
		$script = $this->createMock( Script::class);
		$script->expects( $this->once() )->method( 'register' );

		/** @var Script $script */
		$this->assetsRegistry->add_script( $script );

		$this->assetsRegistry->register_scripts();
	}

	public function testEnqueueScripts() {
		$script = $this->createMock( Script::class);
		$script->method( 'get_admin' )->willReturn( false );
		$script->expects( $this->once() )->method( 'enqueue' );

		/** @var Script $script */
		$this->assetsRegistry->add_script( $script );

		$this->assetsRegistry->enqueue_scripts();
	}

	public function testGetAssetUrl() {
		$asset       = 'js/my-script.js';
		$expectedUrl = 'http://example.com/wp-content/plugins/my-plugin/vendor/krokedil/shipping/assets/js/my-script.js';
		$this->assertEquals( $expectedUrl, $this->assetsRegistry->get_asset_url( $asset ) );
	}
}
