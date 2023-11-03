<?php
use Krokedil\Shipping\Frontend\PickupPointSelect;
use Krokedil\Shipping\PickupPoint\PickupPoint;

class PickupPointSelectTest extends BaseTestCase {
	private $pickupPointSelect;

	public function setUp(): void {
		parent::setUp();

		$this->mockWooCommerce();
		$this->mockPickupPointService();

		WP_Mock::userFunction( 'wp_create_nonce', array(
			'args'   => array( 'krokedil_shipping_set_selected_pickup_point' ),
			'return' => 'some_nonce',
		) );

		$wcAjaxMock = Mockery::mock( 'alias:WC_AJAX' );
		$wcAjaxMock->shouldReceive( 'get_endpoint' )
			->with( 'krokedil_shipping_set_selected_pickup_point' )
			->andReturn( 'some_url' );

		$this->pickupPointSelect = new PickupPointSelect( $this->mockPickupPointService );
	}

	public function testRenderPickupPointSelect() {
		$pickupPointObj = new PickupPoint( self::$pickupPoint );

		$this->mockSession->shouldReceive( 'get' )->with( 'chosen_shipping_methods' )->andReturn( array( 'rate_id' ) );
		$this->mockPickupPointService->shouldReceive( 'get_pickup_points_from_rate' )->andReturn( array( $pickupPointObj ) );
		$this->mockPickupPointService->shouldReceive( 'get_selected_pickup_point_from_rate' )->andReturn( $pickupPointObj );

		$rate = $this->mockShippingRate();

		WP_Mock::userFunction( 'selected', array(
			'times' => 1,
		) );

		ob_start();
		$this->pickupPointSelect->render( $rate );
		$output = ob_get_clean();

		$this->assertStringContainsString( '123', $output );
		$this->assertStringContainsString( 'TestName', $output );
	}

	public function testSetSelectedPickupPointAjax() {
		$_POST = array(
			'pickupPointId' => '123',
			'rateId'        => 'rate_id',
		);

		$pickupPointObj = new PickupPoint( self::$pickupPoint );

		$this->mockCart->shouldReceive( 'calculate_shipping' )->once()->andReturn( null );

		$rate = $this->mockShippingRate();

		$this->mockSessionHandler->shouldReceive( 'get_shipping_rate' )->with( 'rate_id' )->once()->andReturn( $rate );
		$this->mockPickupPointService->shouldReceive( 'get_pickup_point_from_rate_by_id' )->with( $rate, '123' )->once()->andReturn( $pickupPointObj );
		$this->mockPickupPointService->shouldReceive( 'save_selected_pickup_point_to_rate' )->with( $rate, $pickupPointObj )->once()->andReturn( null );

		WP_Mock::userFunction( 'is_wp_error', array(
			'times'  => 1,
			'return' => false,
		) );

		WP_Mock::userFunction( 'wp_send_json_success', array(
			'times' => 1,
		) );

		$packages = array(
			array(
				'rates' => array(
					'rate_id' => $rate,
				),
			),
		);

		$this->mockShipping->shouldReceive( 'get_packages' )->andReturn( $packages );

		$this->pickupPointSelect->set_selected_pickup_point_ajax();
		$this->expectNotToPerformAssertions();
	}
}
