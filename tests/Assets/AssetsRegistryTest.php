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

		WP_Mock::userFunction( 'plugins_url' )->andReturn( 'http://example.com/wp-content/plugins/my-plugin/vendor/krokedil/shipping/assets/js/my-script.js' );
		WP_Mock::userFunction( 'doing_action' )->andReturn( true );
		WP_Mock::userFunction( 'doing_filter', )->andReturn( true );

		$this->assetsRegistry = new AssetsRegistry();
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
		$script = Mockery::mock( Script::class);
		$script->shouldReceive( 'get_handle' )->once()->andReturns( 'test-handle' );
		$script->shouldReceive( 'register' )->once();

		$this->assetsRegistry->add_script( $script );

		$this->assetsRegistry->register_assets();
		$this->expectNotToPerformAssertions();
	}

	public function testEnqueueScripts() {
		WP_Mock::userFunction( 'is_admin' )->andReturn( false );

		$script = Mockery::mock( Script::class);
		$script->shouldReceive( 'get_admin' )->once()->andReturns( false );
		$script->shouldReceive( 'get_handle' )->once()->andReturns( 'test-handle' );
		$script->shouldReceive( 'enqueue' )->once();

		$this->assetsRegistry->add_script( $script );

		$this->assetsRegistry->enqueue_assets();
		$this->expectNotToPerformAssertions();
	}

	public function testEnqueueAdminScripts() {
		WP_Mock::userFunction( 'is_admin' )->twice()->andReturn( true );

		$adminStyle = Mockery::mock( Script::class)->makePartial();
		$adminStyle->shouldReceive( 'get_admin' )->once()->andReturns( true );
		$adminStyle->shouldReceive( 'get_handle' )->once()->andReturns( 'test-handle-admin' );
		$adminStyle->shouldReceive( 'enqueue' )->once();

		$style = Mockery::mock( Script::class)->makePartial();
		$style->shouldReceive( 'get_admin' )->once()->andReturns( false );
		$style->shouldReceive( 'get_handle' )->once()->andReturns( 'test-handle' );
		$style->shouldReceive( 'enqueue' )->never();

		$this->assetsRegistry->add_script( $adminStyle );
		$this->assetsRegistry->add_script( $style );

		$this->assetsRegistry->enqueue_assets();

		$this->expectNotToPerformAssertions();
	}

	public function testGetAssetUrl() {
		$asset       = 'js/my-script.js';
		$expectedUrl = 'http://example.com/wp-content/plugins/my-plugin/vendor/krokedil/shipping/assets/js/my-script.js';
		$this->assertEquals( $expectedUrl, $this->assetsRegistry->get_asset_url( $asset ) );
	}

	public function testAddScriptWithDependencies() {
		$script = new Script( 'test-handle', 'test-src', array( 'jquery' ) );
		$this->assetsRegistry->add_script( $script );
		$this->assertArrayHasKey( 'test-handle', $this->assetsRegistry->scripts );
		$this->assertEquals( array( 'jquery' ), $this->assetsRegistry->scripts['test-handle']->get_deps() );
	}

	public function testAddStyleWithDependencies() {
		$style = new Style( 'test-handle', 'test-src', array( 'bootstrap' ) );
		$this->assetsRegistry->add_style( $style );
		$this->assertArrayHasKey( 'test-handle', $this->assetsRegistry->styles );
		$this->assertEquals( array( 'bootstrap' ), $this->assetsRegistry->styles['test-handle']->get_deps() );
	}

	public function testRegisterStyles() {
		$style = Mockery::mock( Script::class);
		$style->shouldReceive( 'get_handle' )->once()->andReturns( 'test-handle' );
		$style->shouldReceive( 'register' )->once();

		/** @var Style $style */
		$this->assetsRegistry->add_style( $style );

		$this->assetsRegistry->register_assets();
		$this->expectNotToPerformAssertions();
	}

	public function testEnqueueStyles() {
		WP_Mock::userFunction( 'is_admin' )->andReturn( false );

		$style = Mockery::mock( Style::class);
		$style->shouldReceive( 'get_admin' )->once()->andReturns( false );
		$style->shouldReceive( 'get_handle' )->once()->andReturns( 'test-handle' );
		$style->shouldReceive( 'enqueue' )->once();

		/** @var Style $style */
		$this->assetsRegistry->add_style( $style );

		$this->assetsRegistry->enqueue_assets();
		$this->expectNotToPerformAssertions();
	}

	public function testEnqueueAdminStyles() {
		WP_Mock::userFunction( 'is_admin' )->twice()->andReturn( true );

		$adminStyle = Mockery::mock( Style::class);
		$adminStyle->shouldReceive( 'get_admin' )->once()->andReturns( true );
		$adminStyle->shouldReceive( 'get_handle' )->once()->andReturns( 'test-handle-admin' );
		$adminStyle->shouldReceive( 'enqueue' )->once();

		$style = Mockery::mock( Style::class);
		$style->shouldReceive( 'get_admin' )->once()->andReturns( false );
		$style->shouldReceive( 'get_handle' )->once()->andReturns( 'test-handle' );
		$style->shouldReceive( 'enqueue' )->never();

		$this->assetsRegistry->add_style( $adminStyle );
		$this->assetsRegistry->add_style( $style );

		$this->assetsRegistry->enqueue_assets();
		$this->expectNotToPerformAssertions();
	}
}
