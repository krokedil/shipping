<?php
use Krokedil\Shipping\Ajax\AjaxRegistry;
use Krokedil\Shipping\Assets\AssetsRegistry;
use Krokedil\Shipping\Container;
use Krokedil\Shipping\Interfaces\PickupPointServiceInterface;
use WP_Mock\Tools\TestCase;

abstract class BaseTestCase extends TestCase {
	// WooCommerce mocks.
	protected $mockWoocommerce;
	protected $mockShipping;
	protected $mockSession;
	protected $mockCart;

	// Internal mocks.
	protected $mockPickupPointService;
	protected $mockContainer;
	protected $mockAssetsRegistry;
	protected $mockAjaxRegistry;
	protected $mockSessionHandler;

	// Test data.
	public static $pickupPoint = array(
		'id'          => '123',
		'name'        => 'TestName',
		'description' => 'TestDescription',
		'address'     => array(
			'street'   => 'Test',
			'city'     => 'Test',
			'postcode' => '12345',
			'country'  => 'SE',
		),
		'coordinates' => array(
			'latitude'  => 123,
			'longitude' => 123,
		),
		'open_hours'  => array(
			array(
				'day'   => 'monday',
				'open'  => '08:00',
				'close' => '17:00',
			)
		),
		'eta'         => array(
			'utc'   => '2019-01-01T00:00:00+00:00',
			'local' => '2019-01-01T00:00:00+10:00',
		),
		'meta_data'   => array(),
	);

	public function mockShippingRate( $rate_id = 'rate_id' ) {
		$shippingRate = Mockery::mock( 'WC_Shipping_Rate' );
		$shippingRate->shouldReceive( 'get_id' )->andReturn( $rate_id );

		return $shippingRate;
	}

	public function mockWooCommerce() {
		$this->mockWoocommerce = Mockery::mock( 'WooCommerce' );
		$this->mockShipping    = Mockery::mock( 'WC_Shipping' );
		$this->mockSession     = Mockery::mock( 'WC_Session' );
		$this->mockCart        = Mockery::mock( 'WC_Cart' );

		$this->mockWoocommerce->shouldReceive( 'shipping' )->andReturn( $this->mockShipping );
		$this->mockWoocommerce->session = $this->mockSession;
		$this->mockWoocommerce->cart    = $this->mockCart;

		WP_Mock::userFunction( 'WC' )->andReturn( $this->mockWoocommerce );
	}

	public function mockPickupPointService() {
		$this->mockContainer();
		$this->mockAssetsRegistry();
		$this->mockAjaxRegistry();
		$this->mockSessionHandler();

		$this->mockContainer->shouldReceive( 'get' )->with( 'assets-registry' )->andReturn( $this->mockAssetsRegistry );
		$this->mockContainer->shouldReceive( 'get' )->with( 'ajax-registry' )->andReturn( $this->mockAjaxRegistry );
		$this->mockContainer->shouldReceive( 'get' )->with( 'session-handler' )->andReturn( $this->mockSessionHandler );

		$this->mockPickupPointService = Mockery::mock( PickupPointServiceInterface::class);

		$this->mockPickupPointService->shouldReceive( 'get_container' )->andReturn( $this->mockContainer );
	}

	public function mockContainer() {
		$this->mockContainer = Mockery::mock( Container::class);
	}

	public function mockAssetsRegistry() {
		$this->mockAssetsRegistry           = Mockery::mock( AssetsRegistry::class);
		$this->mockAssetsRegistry->basePath = 'https://krokedil-test.com/wp-content/plugins/krokedil-shipping/assets/';

		$this->mockAssetsRegistry->shouldReceive( 'add_script' )->andReturn( null );
		$this->mockAssetsRegistry->shouldReceive( 'add_style' )->andReturn( null );
		$this->mockAssetsRegistry->shouldReceive( 'register_assets' )->andReturn( null );
		$this->mockAssetsRegistry->shouldReceive( 'enqueue_assets' )->andReturn( null );
		$this->mockAssetsRegistry->shouldReceive( 'get_asset_url' )->andReturnUsing( function ($asset) {
			return $this->mockAssetsRegistry->basePath . 'vendor/krokedil/shipping/assets/' . $asset;
		} );
	}

	public function mockAjaxRegistry() {
		$this->mockAjaxRegistry = Mockery::mock( AjaxRegistry::class);

		$this->mockAjaxRegistry->shouldReceive( 'add_request' )->andReturn( null );
		$this->mockAjaxRegistry->shouldReceive( 'register_ajax_requests' )->andReturn( null );
	}

	public function mockSessionHandler() {
		$this->mockSessionHandler = Mockery::mock( SessionHandler::class);
	}
}
