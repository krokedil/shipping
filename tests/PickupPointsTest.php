<?php
use Krokedil\Shipping\PickupPoint\PickupPoint;
use Krokedil\Shipping\PickupPoints;
use PHPUnit\Framework\TestCase;

class PickupPointsTest extends TestCase {
	/**
	 * @var PickupPoints
	 */
	private $pickupPoints;

	protected function setUp(): void {
		include_once 'mock.php'; // phpcs:ignore WPThemeReview.CoreFunctionality.FileInclude.FileIncludeFound
		$this->pickupPoints = new PickupPoints();
	}

	public static $pickup_point = array(
		'id'          => '123',
		'name'        => 'Test',
		'description' => 'Test',
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

	public function testSavePickupPointsToRate() {
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'add_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		$rate->expects( $this->once() )
			->method( 'add_meta_data' )
			->with( 'krokedil_pickup_points', json_encode( array( self::$pickup_point ) ) );

		$pickupPoint = new PickupPoint( self::$pickup_point );

		$this->pickupPoints->save_pickup_points_to_rate( $rate, array( $pickupPoint ) );
	}

	public function testGetPickupPointsFromRate() {
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'get_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		$rate->expects( $this->once() )
			->method( 'get_meta_data' )
			->willReturn( array( 'krokedil_pickup_points' => $this->pickupPoints->to_json( array( new PickupPoint( self::$pickup_point ) ) ) ) );

		$result = $this->pickupPoints->get_pickup_points_from_rate( $rate );

		$this->assertEquals( 1, count( $result ) );
		$this->assertEquals( self::$pickup_point['id'], $result[0]->get_id() );
	}

	public function testAddPickupPointToRate() {
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'get_meta_data', 'add_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		$rate->expects( $this->once() )
			->method( 'add_meta_data' )
			->with( 'krokedil_pickup_points', json_encode( array( self::$pickup_point ) ) );

		$rate->expects( $this->exactly( 2 ) )
			->method( 'get_meta_data' )
			->willReturnOnConsecutiveCalls( array(), array( 'krokedil_pickup_points' => $this->pickupPoints->to_json( array( new PickupPoint( self::$pickup_point ) ) ) ) );

		$pickupPoint = new PickupPoint( self::$pickup_point );

		$this->pickupPoints->add_pickup_point_to_rate( $rate, $pickupPoint );

		$result = $this->pickupPoints->get_pickup_points_from_rate( $rate );
	}

	public function testRemovePickupPointFromRate() {
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'get_meta_data', 'add_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		$rawPickupPoint1       = self::$pickup_point;
		$rawPickupPoint2       = self::$pickup_point;
		$rawPickupPoint2['id'] = '321';

		$pickupPoint1 = new PickupPoint( $rawPickupPoint1 );
		$pickupPoint2 = new PickupPoint( $rawPickupPoint2 );

		$rate->expects( $this->exactly( 3 ) )
			->method( 'add_meta_data' )
			->withConsecutive(
				array( 'krokedil_pickup_points', json_encode( array( $rawPickupPoint1 ) ) ),
				array( 'krokedil_pickup_points', json_encode( array( $rawPickupPoint1, $rawPickupPoint2 ) ) ),
				array( 'krokedil_pickup_points', json_encode( array( $rawPickupPoint2 ) ) )
			);

		$rate->expects( $this->exactly( 4 ) )
			->method( 'get_meta_data' )
			->willReturnOnConsecutiveCalls(
				array(),
				array( 'krokedil_pickup_points' => $this->pickupPoints->to_json( array( $pickupPoint1 ) ) ),
				array( 'krokedil_pickup_points' => $this->pickupPoints->to_json( array( $pickupPoint1, $pickupPoint2 ) ) ),
				array( 'krokedil_pickup_points' => $this->pickupPoints->to_json( array( $pickupPoint2 ) ) )
			);

		$this->pickupPoints->add_pickup_point_to_rate( $rate, $pickupPoint1 );
		$this->pickupPoints->add_pickup_point_to_rate( $rate, $pickupPoint2 );

		$this->pickupPoints->remove_pickup_point_from_rate( $rate, $pickupPoint1 );

		$this->pickupPoints->get_pickup_points_from_rate( $rate );
	}

	public function testSaveSelectedPickupPointToRate() {
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'add_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		$rate->expects( $this->once() )
			->method( 'add_meta_data' )
			->with( 'krokedil_selected_pickup_point', json_encode( self::$pickup_point ) );

		$pickupPoint = new PickupPoint( self::$pickup_point );

		$this->pickupPoints->save_selected_pickup_point_to_rate( $rate, $pickupPoint );
	}

	public function testGetSelectedPickupPointFromRate() {
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'get_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		$rate->expects( $this->once() )
			->method( 'get_meta_data' )
			->willReturn( array( 'krokedil_selected_pickup_point' => $this->pickupPoints->to_json( self::$pickup_point ) ) );

		$result = $this->pickupPoints->get_selected_pickup_point_from_rate( $rate );

		$this->assertEquals( self::$pickup_point['id'], $result->get_id() );
	}

	public function testGetPickupPointFromRateById() {
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'get_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		$rawPickupPoint1       = self::$pickup_point;
		$rawPickupPoint2       = self::$pickup_point;
		$rawPickupPoint2['id'] = '321';

		$pickupPoint1 = new PickupPoint( $rawPickupPoint1 );
		$pickupPoint2 = new PickupPoint( $rawPickupPoint2 );

		$rate->expects( $this->exactly( 2 ) )
			->method( 'get_meta_data' )
			->willReturnOnConsecutiveCalls(
				array( 'krokedil_pickup_points' => $this->pickupPoints->to_json( array( $pickupPoint1, $pickupPoint2 ) ) ),
				array( 'krokedil_pickup_points' => $this->pickupPoints->to_json( array( $pickupPoint1, $pickupPoint2 ) ) )
			);

		$result = $this->pickupPoints->get_pickup_point_from_rate_by_id( $rate, $rawPickupPoint1['id'] );
		$this->assertEquals( $rawPickupPoint1['id'], $result->get_id() );

		$result = $this->pickupPoints->get_pickup_point_from_rate_by_id( $rate, $rawPickupPoint2['id'] );
		$this->assertEquals( $rawPickupPoint2['id'], $result->get_id() );
	}
}
