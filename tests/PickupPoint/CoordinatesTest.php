<?php
use Krokedil\Shipping\PickupPoint\Coordinates;
use WP_Mock\Tools\TestCase;

class CoordinatesTest extends TestCase {
	public function testCanSetAndGetLatitude() {
        $coordinates = new Coordinates();
        $coordinates->set_latitude(59.3293);

        $this->assertEquals(59.3293, $coordinates->get_latitude());
    }

	public function testCanSetAndGetLongitude() {
        $coordinates = new Coordinates();
        $coordinates->set_longitude(18.0686);

        $this->assertEquals(18.0686, $coordinates->get_longitude());
    }

	public function testCanSetLatitudeAndLongitudeInConstructor() {
        $coordinates = new Coordinates(59.3293, 18.0686);

        $this->assertEquals(59.3293, $coordinates->get_latitude());
        $this->assertEquals(18.0686, $coordinates->get_longitude());
    }

	public function testLatitudeAndLongitudeAreFloats() {
        $coordinates = new Coordinates('59.3293', '18.0686');

        $this->assertIsFloat($coordinates->get_latitude());
        $this->assertIsFloat($coordinates->get_longitude());
    }
}
