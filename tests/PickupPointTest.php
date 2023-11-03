<?php
use Krokedil\Shipping\PickupPoint\PickupPoint;
use Krokedil\Shipping\PickupPoint\Address;
use Krokedil\Shipping\PickupPoint\Coordinates;
use Krokedil\Shipping\PickupPoint\OpenHours;
use Krokedil\Shipping\PickupPoint\EstimatedTimeOfArrival;

class PickupPointTest extends BaseTestCase {

	public function testConstructor() {
		$pickup_point = new PickupPoint();

		$this->assertInstanceOf( PickupPoint::class, $pickup_point );
	}

	public function testConstructorWithArray() {
		// Add metadata to pickup point
		$pickupPointArray              = self::$pickupPoint;
		$pickupPointArray['meta_data'] = array(
			'test' => 'test'
        );

		$pickup_point = new PickupPoint( $pickupPointArray );

		$this->assertInstanceOf( PickupPoint::class, $pickup_point );
		$this->assertEquals( self::$pickupPoint['id'], $pickup_point->get_id() );
		$this->assertEquals( self::$pickupPoint['name'], $pickup_point->get_name() );
		$this->assertEquals( self::$pickupPoint['description'], $pickup_point->get_description() );
		$this->assertEquals( 'test', $pickup_point->get_meta_data( 'test' ) );
	}

	public function testConstructorWithJson() {
		$pickup_point = new PickupPoint( json_encode( self::$pickupPoint ) );

		$this->assertInstanceOf( PickupPoint::class, $pickup_point );
		$this->assertEquals( self::$pickupPoint['id'], $pickup_point->get_id() );
		$this->assertEquals( self::$pickupPoint['name'], $pickup_point->get_name() );
		$this->assertEquals( self::$pickupPoint['description'], $pickup_point->get_description() );
	}

	public function testGetId() {
		$pickup_point = new PickupPoint( self::$pickupPoint );

		$this->assertEquals( self::$pickupPoint['id'], $pickup_point->get_id() );
	}

	public function testGetName() {
		$pickup_point = new PickupPoint( self::$pickupPoint );

		$this->assertEquals( self::$pickupPoint['name'], $pickup_point->get_name() );
	}

	public function testGetDescription() {
		$pickup_point = new PickupPoint( self::$pickupPoint );

		$this->assertEquals( self::$pickupPoint['description'], $pickup_point->get_description() );
	}

	public function testGetAddress() {
		$pickup_point = new PickupPoint( self::$pickupPoint );

		$this->assertInstanceOf( Address::class, $pickup_point->get_address() );
	}

	public function testGetCoordinates() {
		$pickup_point = new PickupPoint( self::$pickupPoint );

		$this->assertInstanceOf( Coordinates::class, $pickup_point->get_coordinates() );
	}

	public function testGetOpenHours() {
		$pickup_point = new PickupPoint( self::$pickupPoint );

		$this->assertIsArray( $pickup_point->get_open_hours() );
		$this->assertInstanceOf( OpenHours::class, $pickup_point->get_open_hours()[0] );
	}

	public function testGetEstimatedTimeOfArrival() {
		$pickup_point = new PickupPoint( self::$pickupPoint );

		$this->assertInstanceOf( EstimatedTimeOfArrival::class, $pickup_point->get_eta() );
	}

	public function testSetId() {
		$pickup_point = new PickupPoint();
		$pickup_point->set_id( self::$pickupPoint['id'] );

		$this->assertEquals( self::$pickupPoint['id'], $pickup_point->get_id() );
	}

	public function testSetName() {
		$pickup_point = new PickupPoint();
		$pickup_point->set_name( self::$pickupPoint['name'] );

		$this->assertEquals( self::$pickupPoint['name'], $pickup_point->get_name() );
	}

	public function testSetDescription() {
		$pickup_point = new PickupPoint();
		$pickup_point->set_description( self::$pickupPoint['description'] );

		$this->assertEquals( self::$pickupPoint['description'], $pickup_point->get_description() );
	}

	public function testSetAddress() {
		$pickup_point = new PickupPoint();
		$pickup_point->set_address( '', '', '', '' );

		$this->assertInstanceOf( Address::class, $pickup_point->get_address() );
	}

	public function testSetCoordinates() {
		$pickup_point = new PickupPoint();
		$pickup_point->set_coordinates( '', '' );

		$this->assertInstanceOf( Coordinates::class, $pickup_point->get_coordinates() );
	}

	public function testSetOpenHours() {
		$pickup_point = new PickupPoint();
		$pickup_point->set_open_hours( array() );

		$this->assertIsArray( $pickup_point->get_open_hours() );
	}

	public function testSetOpenHour() {
		$pickup_point = new PickupPoint();
		$pickup_point->set_open_hour( '', '', '' );

		$this->assertIsArray( $pickup_point->get_open_hours() );
	}

	public function testSetEstimatedTimeOfArrival() {
		$pickup_point = new PickupPoint();
		$pickup_point->set_eta( '', '' );

		$this->assertInstanceOf( EstimatedTimeOfArrival::class, $pickup_point->get_eta() );
	}

	public function testGetMetaData() {
		$pickup_point = new PickupPoint( self::$pickupPoint );
		$pickup_point->add_meta_data( 'test', 'test' );

		$this->assertEquals( 'test', $pickup_point->get_meta_data( 'test' ) );
	}

	public function testAddMetaData() {
		$pickup_point = new PickupPoint( self::$pickupPoint );
		$pickup_point->add_meta_data( 'test', 'test' );

		$this->assertEquals( 'test', $pickup_point->get_meta_data( 'test' ) );
	}
}
