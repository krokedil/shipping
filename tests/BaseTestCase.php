<?php
use Krokedil\Shipping\AJAX;
use Krokedil\Shipping\Assets;
use Krokedil\Shipping\Container\Container;
use Krokedil\Shipping\Interfaces\PickupPointServiceInterface;
use WP_Mock\Tools\TestCase;

abstract class BaseTestCase extends TestCase {
	// WooCommerce mocks.
	protected $mockWoocommerce;
	protected $mockShipping;
	protected $mockSession;
	protected $mockCart;
	protected $mockCountries;

	// Internal mocks.
	protected $mockPickupPointService;
	protected $mockContainer;
	protected $mockAssets;
	protected $mockAjax;
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
			),
		),
		'eta'         => array(
			'utc'   => '2019-01-01T00:00:00+00:00',
			'local' => '2019-01-01T00:00:00+10:00',
		),
		'meta_data'   => array(),
	);

	public function mockShippingRate( $rate_id = 'rate_id' ) {
		$shippingRate = Mockery::mock( 'alias:WC_Shipping_Rate' );
		$shippingRate->shouldReceive( 'get_id' )->andReturn( $rate_id );

		return $shippingRate;
	}

	public function mockWooCommerce() {
		$this->mockWoocommerce = Mockery::mock( 'WooCommerce' );
		$this->mockShipping    = Mockery::mock( 'WC_Shipping' );
		$this->mockSession     = Mockery::mock( 'WC_Session' );
		$this->mockCart        = Mockery::mock( 'WC_Cart' );
		$this->mockCountries   = Mockery::mock( 'WC_Countries' );

		$this->mockWoocommerce->shouldReceive( 'shipping' )->andReturn( $this->mockShipping );
		$this->mockWoocommerce->session   = $this->mockSession;
		$this->mockWoocommerce->cart      = $this->mockCart;
		$this->mockWoocommerce->countries = $this->mockCountries;

		WP_Mock::userFunction( 'WC' )->andReturn( $this->mockWoocommerce );
	}

	public function mockPickupPointService() {
		$this->mockContainer();
		$this->mockAssetsRegistry();
		$this->mockAjaxRegistry();
		$this->mockSessionHandler();

		$this->mockContainer->shouldReceive( 'get' )->with( 'assets' )->andReturn( $this->mockAssets );
		$this->mockContainer->shouldReceive( 'get' )->with( 'ajax' )->andReturn( $this->mockAjax );
		$this->mockContainer->shouldReceive( 'get' )->with( 'session-handler' )->andReturn( $this->mockSessionHandler );

		$this->mockPickupPointService = Mockery::mock( PickupPointServiceInterface::class );

		$this->mockPickupPointService->shouldReceive( 'get_container' )->andReturn( $this->mockContainer );
	}

	public function mockContainer() {
		$this->mockContainer = Mockery::mock( Container::class );
	}

	public function mockAssetsRegistry() {
		$this->mockAssets = Mockery::mock( Assets::class );

		$this->mockAssets->shouldReceive( 'register_assets' )->andReturn( null );
		$this->mockAssets->shouldReceive( 'enqueue_assets' )->andReturn( null );
	}

	public function mockAjaxRegistry() {
		$this->mockAjax = Mockery::mock( AJAX::class );

		$this->mockAjax->shouldReceive( 'add_ajax_events' )->andReturn( null );
		$this->mockAjax->shouldReceive( 'add_ajax_event' )->andReturn( null );
	}

	public function mockSessionHandler() {
		$this->mockSessionHandler = Mockery::mock( SessionHandler::class );
	}
}
