<?php
use Krokedil\Shipping\PickupPoint\PickupPoint;
use Krokedil\Shipping\PickupPoints;
use PHPUnit\Framework\TestCase;

class PickupPointsTest extends TestCase {
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

	/**
	 * Test that the constructor sets the rate and pickup points correctly.
	 */
	public function testConstructor() {
		// Create a mock WC_Shipping_Rate object
        /** @var \WC_Shipping_Rate&\PHPUnit\Framework\MockObject\MockObject $rate */
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'get_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		$pickup_point = array(
			'id'          => '123',
			'name'        => 'Test',
			'description' => 'Test',
			'address'     => array(
				'street'   => 'Test',
				'postcode' => '12345',
				'city'     => 'Test',
				'country'  => 'SE',
			),
			'coordinates' => array(
				'latitude'  => '123',
				'longitude' => '123',
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
		);

		// Set up the mock rate object to return the mock pickup point object
		$rate->expects( $this->once() )
			->method( 'get_meta_data' )
			->willReturn( array( 'krokedil_pickup_points' => json_encode( array( $pickup_point ) ) ) );

		// Create a new PickupPoints object
		$pickup_points = new PickupPoints( $rate );

		// Assert that the rate and pickup points were set correctly
		$this->assertSame( $rate, $pickup_points->get_rate() );

		// Assert that there is one pickup point
		$this->assertCount( 1, $pickup_points->get_pickup_points() );

		// Check each property of the pickup point
		foreach ( $pickup_points->get_pickup_points() as $pickup_point ) {
			$this->assertInstanceOf( 'Krokedil\Shipping\PickupPoint\PickupPoint', $pickup_point );

			$this->assertEquals( '123', $pickup_point->get_id() );
			$this->assertEquals( 'Test', $pickup_point->get_name() );
			$this->assertEquals( 'Test', $pickup_point->get_description() );
			$this->assertEquals( 'Test', $pickup_point->get_address()->get_street() );
			$this->assertEquals( '12345', $pickup_point->get_address()->get_postcode() );
			$this->assertEquals( 'Test', $pickup_point->get_address()->get_city() );
			$this->assertEquals( 'SE', $pickup_point->get_address()->get_country() );
			$this->assertEquals( '123', $pickup_point->get_coordinates()->get_latitude() );
			$this->assertEquals( '123', $pickup_point->get_coordinates()->get_longitude() );
			$this->assertEquals( 'monday', $pickup_point->get_open_hours()[0]->get_day() );
			$this->assertEquals( '08:00', $pickup_point->get_open_hours()[0]->get_open() );
			$this->assertEquals( '17:00', $pickup_point->get_open_hours()[0]->get_close() );
			$this->assertEquals( '2019-01-01T00:00:00+00:00', $pickup_point->get_eta()->get_utc() );
			$this->assertEquals( '2019-01-01T00:00:00+10:00', $pickup_point->get_eta()->get_local() );
		}
	}

	/**
	 * Test that the set_pickup_points_from_rate method sets the pickup points correctly.
	 */
	public function testSetPickupPointsFromRate() {
		// Create a mock WC_Shipping_Rate object
		/** @var \WC_Shipping_Rate&\PHPUnit\Framework\MockObject\MockObject $rate */
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'get_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		// Set up the mock rate object to return the mock pickup point object
		$rate->expects( $this->exactly( 1 ) )
			->method( 'get_meta_data' )
			->willReturn( array( 'krokedil_pickup_points' => json_encode( array( self::$pickup_point ) ) ) );

		// Create a new PickupPoints object
		$pickup_points = new PickupPoints( null );

		// Set the rate
		$pickup_points->set_rate( $rate );

		// Call the set_pickup_points_from_rate method
		$pickup_points->set_pickup_points_from_rate();

		// Assert that there is one pickup point
		$this->assertCount( 1, $pickup_points->get_pickup_points() );

		// Check each property of the pickup point
		foreach ( $pickup_points->get_pickup_points() as $pickup_point ) {
			$this->assertInstanceOf( 'Krokedil\Shipping\PickupPoint\PickupPoint', $pickup_point );

			$this->assertEquals( '123', $pickup_point->get_id() );
			$this->assertEquals( 'Test', $pickup_point->get_name() );
			$this->assertEquals( 'Test', $pickup_point->get_description() );
			$this->assertEquals( 'Test', $pickup_point->get_address()->get_street() );
			$this->assertEquals( '12345', $pickup_point->get_address()->get_postcode() );
			$this->assertEquals( 'Test', $pickup_point->get_address()->get_city() );
			$this->assertEquals( 'SE', $pickup_point->get_address()->get_country() );
			$this->assertEquals( '123', $pickup_point->get_coordinates()->get_latitude() );
			$this->assertEquals( '123', $pickup_point->get_coordinates()->get_longitude() );
			$this->assertEquals( 'monday', $pickup_point->get_open_hours()[0]->get_day() );
			$this->assertEquals( '08:00', $pickup_point->get_open_hours()[0]->get_open() );
			$this->assertEquals( '17:00', $pickup_point->get_open_hours()[0]->get_close() );
			$this->assertEquals( '2019-01-01T00:00:00+00:00', $pickup_point->get_eta()->get_utc() );
			$this->assertEquals( '2019-01-01T00:00:00+10:00', $pickup_point->get_eta()->get_local() );
		}
	}

	/**
	 * Test that the set_pickup_points method sets the pickup points correctly.
	 */
	public function testSetPickupPoints() {
		// Create a new PickupPoints object
		$pickup_points = new PickupPoints( null );

		// Create an array of mock PickupPoint objects
		$pickup_points_array = array(
			$this->getMockBuilder( 'Krokedil\Shipping\PickupPoint\PickupPoint' )
				->disableOriginalConstructor()
				->getMock(),
			$this->getMockBuilder( 'Krokedil\Shipping\PickupPoint\PickupPoint' )
				->disableOriginalConstructor()
				->getMock(),
		);

		// Call the set_pickup_points method
		$pickup_points->set_pickup_points( $pickup_points_array );

		// Assert that the pickup points were set correctly
		$this->assertEquals( $pickup_points_array, $pickup_points->get_pickup_points() );
	}

	/**
	 * Test that the set_rate method sets the rate correctly.
	 */
	public function testSetRate() {
		// Create a new PickupPoints object
		$pickup_points = new PickupPoints( null );

		// Create a mock WC_Shipping_Rate object
		/** @var \WC_Shipping_Rate&\PHPUnit\Framework\MockObject\MockObject $rate */
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->disableOriginalConstructor()
			->getMock();

		// Call the set_rate method
		$pickup_points->set_rate( $rate );

		// Assert that the rate was set correctly
		$this->assertSame( $rate, $pickup_points->get_rate() );
	}

	/**
	 * Test that add_pickup_point adds a pickup point correctly.
	 */
	public function testAddPickupPoint() {
		$pickup_point = new PickupPoint( self::$pickup_point );

		// Create a mock WC_Shipping_Rate object
		/** @var \WC_Shipping_Rate&\PHPUnit\Framework\MockObject\MockObject $rate */
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'get_meta_data', 'add_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		// Set up the mock rate object to return the mock pickup point object
		$rate->expects( $this->once() )
			->method( 'add_meta_data' );

		// Handle the consecutive calls to get_meta_data
		$rate->expects( $this->once() )
			->method( 'get_meta_data' )
			->willReturn( array() );

		// Create a new PickupPoints object
		$pickup_points = new PickupPoints( $rate );

		// Call the add_pickup_point method
		$pickup_points->add_pickup_point( $pickup_point );

		// Assert that the pickup point was added correctly
		$this->assertEquals( array( $pickup_point ), $pickup_points->get_pickup_points() );
	}

	/**
	 * Test case for remove_pickup_point method.
	 */
	public function testRemovePickupPoint() {
		$pickup_point = new PickupPoint( self::$pickup_point );

		// Create a mock WC_Shipping_Rate object
		/** @var \WC_Shipping_Rate&\PHPUnit\Framework\MockObject\MockObject $rate */
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'get_meta_data', 'add_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		// Set up the mock rate object to return the mock pickup point object
		$rate->expects( $this->exactly( 2 ) )
			->method( 'add_meta_data' );

		// Handle the consecutive calls to get_meta_data
		$rate->expects( $this->once() )
			->method( 'get_meta_data' )
			->willReturn( array( 'krokedil_pickup_points', json_encode( array( self::$pickup_point ) ) ) );

		// Create a new PickupPoints object
		$pickup_points = new PickupPoints( $rate );

		// Add the pickup point to the pickup points.
		$pickup_points->add_pickup_point( $pickup_point );

		// Call the remove_pickup_point method
		$pickup_points->remove_pickup_point( $pickup_point );

		// Assert that the pickup point was removed correctly
		$this->assertEquals( array(), $pickup_points->get_pickup_points() );
	}

	/**
	 * Test case for save_pickup_points_to_rate method.
	 *
	 * Supress PHP0406 since the type for the with method on the rate mock is correct in this case, but the IDE doesn't recognize it.
	 * @suppress PHP0406
	 */
	public function testSavePickupPointsToRate() {
		$pickup_point = new PickupPoint( self::$pickup_point );

		// Create a mock WC_Shipping_Rate object
		/** @var \WC_Shipping_Rate&\PHPUnit\Framework\MockObject\MockObject $rate */
		$rate = $this->getMockBuilder( 'WC_Shipping_Rate' )
			->setMethods( array( 'get_meta_data', 'add_meta_data' ) )
			->disableOriginalConstructor()
			->getMock();

		// Set up the mock rate object to return the mock pickup point object
		$rate->expects( $this->once() ) // Should cover the call to add_meta_data and ensure that its been called with the correct data.
			->method( 'add_meta_data' )
			->with( 'krokedil_pickup_points', json_encode( array( self::$pickup_point ) ) );

		// Handle the consecutive calls to get_meta_data
		$rate->expects( $this->once() )
			->method( 'get_meta_data' )
			->willReturn( array() );

		// Create a new PickupPoints object
		$pickup_points = new PickupPoints( $rate );

		// Set the pickup point to the pickup points.
		$pickup_points->set_pickup_points( array( $pickup_point ) );

		// Call the save_pickup_points_to_rate method
		$pickup_points->save_pickup_points_to_rate();

		// Assert that the pickup point was saved correctly
		$this->assertEquals( array( $pickup_point ), $pickup_points->get_pickup_points() );
	}
}
