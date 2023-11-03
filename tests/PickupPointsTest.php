<?php
use Krokedil\Shipping\PickupPoint\PickupPoint;
use Krokedil\Shipping\PickupPoints;
use Krokedil\Shipping\Container\Container;

class PickupPointsTest extends BaseTestCase {
	/**
	 * @var PickupPoints
	 */
	private $pickupPoints;

	public function setUp(): void {
		parent::setUp();

		$this->mockWooCommerce();

		$this->mockShipping->allows( 'get_packages' )->andReturn( array() );
		$this->mockShipping->allows( 'calculate_shipping_for_package' )->andReturn( null );
		$this->mockSession->allows( '__unset' )->andReturn( null );

		WP_Mock::userFunction( 'plugin_dir_url' )->andReturn( 'http://example.com/wp-content/plugins/my-plugin/' );

		WP_Mock::userFunction( 'wp_create_nonce', array(
			'args'   => array( 'krokedil_shipping_set_selected_pickup_point' ),
			'return' => 'some_nonce',
		) );

		$wcAjaxMock = Mockery::mock( 'alias:WC_AJAX' );
		$wcAjaxMock->shouldReceive( 'get_endpoint' )
			->with( 'krokedil_shipping_set_selected_pickup_point' )
			->andReturn( 'some_url' );

		$this->pickupPoints = new PickupPoints( '', true );
	}

	public function testGetContainer() {
		$result = $this->pickupPoints->get_container();

		$this->assertInstanceOf( Container::class, $result );
	}

	public function testSavePickupPointsToRate() {
		$rate = $this->mockShippingRate();
		$rate->shouldReceive( 'add_meta_data' )
			->with( 'krokedil_pickup_points', json_encode( array( self::$pickupPoint ) ) )
			->once();

		WP_Mock::userFunction( 'doing_action' )->andReturn( true );
		WP_Mock::userFunction( 'doing_filter', )->andReturn( true );

		$pickupPoint = new PickupPoint( self::$pickupPoint );

		$this->pickupPoints->save_pickup_points_to_rate( $rate, array( $pickupPoint ) );

		$this->expectNotToPerformAssertions();
	}

	public function testSavePickupPointsToRateForceSave() {
		$rate = $this->mockShippingRate();

		WP_Mock::userFunction( 'doing_action' )->andReturn( false );
		WP_Mock::userFunction( 'doing_filter', )->andReturn( false );

		$pickupPoint = new PickupPoint( self::$pickupPoint );

		$this->pickupPoints->save_pickup_points_to_rate( $rate, array( $pickupPoint ) );

		$this->expectNotToPerformAssertions();
	}

	public function testGetPickupPointsFromRate() {
		$rate = $this->mockShippingRate();
		$rate->shouldReceive( 'get_meta_data' )
			->andReturn( array( 'krokedil_pickup_points' => json_encode( array( self::$pickupPoint ) ) ) )
			->once();

		$result = $this->pickupPoints->get_pickup_points_from_rate( $rate );

		$this->assertEquals( 1, count( $result ) );
		$this->assertEquals( self::$pickupPoint['id'], $result[0]->get_id() );
	}

	public function testGetPickupPointsFromRateReturnsEmptyIfNotExists() {
		$rate = $this->mockShippingRate();
		$rate->shouldReceive( 'get_meta_data' )
			->andReturn( array( 'krokedil_pickup_points' => json_encode( array() ) ) )
			->once();

		$result = $this->pickupPoints->get_pickup_points_from_rate( $rate );

		$this->assertEquals( 0, count( $result ) );
	}

	public function testAddPickupPointToRate() {
		$pickupPoint = new PickupPoint( self::$pickupPoint );

		WP_Mock::userFunction( 'doing_action' )->andReturn( true );
		WP_Mock::userFunction( 'doing_filter', )->andReturn( true );

		$rate = $this->mockShippingRate();
		$rate->shouldReceive( 'add_meta_data' )
			->with( 'krokedil_pickup_points', json_encode( array( self::$pickupPoint ) ) )
			->once();

		$rate->shouldReceive( 'get_meta_data' )
			->andReturn( array() )
			->once();

		$this->pickupPoints->add_pickup_point_to_rate( $rate, $pickupPoint );

		$this->expectNotToPerformAssertions();
	}

	public function testAddPickupPointToRateDoesNotOverride() {
		$pickupPoint = new PickupPoint( self::$pickupPoint );

		$rate = $this->mockShippingRate();

		$rate->shouldReceive( 'get_meta_data' )
			->andReturn( array( 'krokedil_pickup_points' => json_encode( array( self::$pickupPoint ) ) ) )
			->once();

		$this->pickupPoints->add_pickup_point_to_rate( $rate, $pickupPoint );

		$this->expectNotToPerformAssertions();
	}

	public function testRemovePickupPointFromRate() {
		$rate = $this->mockShippingRate();

		WP_Mock::userFunction( 'doing_action' )->andReturn( true );
		WP_Mock::userFunction( 'doing_filter', )->andReturn( true );

		$pickupPoint2       = self::$pickupPoint;
		$pickupPoint2['id'] = '321';

		$toRemove = new PickupPoint( self::$pickupPoint );

		$rate->shouldReceive( 'get_meta_data' )
			->andReturn( array( 'krokedil_pickup_points' => json_encode( array( self::$pickupPoint, $pickupPoint2 ) ) ) )
			->once();

		$rate->shouldReceive( 'add_meta_data' )
			->with( 'krokedil_pickup_points', json_encode( array( $pickupPoint2 ) ) )
			->once();

		$this->pickupPoints->remove_pickup_point_from_rate( $rate, $toRemove );

		$this->expectNotToPerformAssertions();
	}

	public function testRemovePickupPointFromRateExistsIfRateDoesNotExist() {
		$rate = $this->mockShippingRate();

		$toRemove = new PickupPoint( self::$pickupPoint );

		$rate->shouldReceive( 'get_meta_data' )
			->andReturn( array( 'krokedil_pickup_points' => json_encode( array() ) ) )
			->once();

		$this->pickupPoints->remove_pickup_point_from_rate( $rate, $toRemove );

		$this->expectNotToPerformAssertions();
	}

	public function testSaveSelectedPickupPointToRate() {
		$rate = $this->mockShippingRate();

		WP_Mock::userFunction( 'doing_action' )->andReturn( true );
		WP_Mock::userFunction( 'doing_filter', )->andReturn( true );

		$rate->shouldReceive( 'add_meta_data' )
			->andReturn( 'krokedil_selected_pickup_point', json_encode( self::$pickupPoint ) )
			->once();

		$pickupPoint = new PickupPoint( self::$pickupPoint );

		$this->pickupPoints->save_selected_pickup_point_to_rate( $rate, $pickupPoint );

		$this->expectNotToPerformAssertions();
	}

	public function testGetSelectedPickupPointFromRate() {
		$rate = $this->mockShippingRate();

		$rate->shouldReceive( 'get_meta_data' )
			->andReturn( array( 'krokedil_selected_pickup_point' => json_encode( self::$pickupPoint ) ) )
			->once();

		$result = $this->pickupPoints->get_selected_pickup_point_from_rate( $rate );

		$this->assertEquals( self::$pickupPoint['id'], $result->get_id() );
	}

	public function testGetSelectedPickupPointFromRateFalseIfNoSelectedExists() {
		$rate = $this->mockShippingRate();

		$rate->shouldReceive( 'get_meta_data' )
			->andReturn( array() )
			->once();

		$result = $this->pickupPoints->get_selected_pickup_point_from_rate( $rate );

		$this->assertFalse( $result );
	}

	public function testGetPickupPointFromRateById() {
		$rate = $this->mockShippingRate();

		$pickupPoint2       = self::$pickupPoint;
		$pickupPoint2['id'] = '321';

		$rate->shouldReceive( 'get_meta_data' )
			->andReturn( array( 'krokedil_pickup_points' => json_encode( array( self::$pickupPoint, $pickupPoint2 ) ) ) )
			->times( 3 );

		$result = $this->pickupPoints->get_pickup_point_from_rate_by_id( $rate, self::$pickupPoint['id'] );
		$this->assertEquals( self::$pickupPoint['id'], $result->get_id() );

		$result = $this->pickupPoints->get_pickup_point_from_rate_by_id( $rate, $pickupPoint2['id'] );
		$this->assertEquals( $pickupPoint2['id'], $result->get_id() );

		$result = $this->pickupPoints->get_pickup_point_from_rate_by_id( $rate, 'non-existing' );
		$this->assertNull( $result );
	}

	public function testGetPickupPointFromRateByIdNullIfNoneExist() {
		$rate = $this->mockShippingRate();

		$pickupPoint2       = self::$pickupPoint;
		$pickupPoint2['id'] = '321';

		$rate->shouldReceive( 'get_meta_data' )
			->andReturn( array() )
			->once();

		$result = $this->pickupPoints->get_pickup_point_from_rate_by_id( $rate, 'non-existing' );
		$this->assertNull( $result );
	}

	public function testAddHiddenOrderItemMeta() {
		$result = $this->pickupPoints->add_hidden_order_itemmeta( array() );

		$this->assertEquals( 2, count( $result ) );
		$this->assertEquals( 'krokedil_pickup_points', $result[0] );
		$this->assertEquals( 'krokedil_selected_pickup_point', $result[1] );
	}
}
