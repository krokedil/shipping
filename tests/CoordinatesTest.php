<?php
use Krokedil\Shipping\PickupPoint\Coordinates;
use PHPUnit\Framework\TestCase;

class CoordinatesTest extends TestCase {
    public function test_can_set_and_get_latitude() {
        $coordinates = new Coordinates();
        $coordinates->set_latitude(59.3293);

        $this->assertEquals(59.3293, $coordinates->get_latitude());
    }

    public function test_can_set_and_get_longitude() {
        $coordinates = new Coordinates();
        $coordinates->set_longitude(18.0686);

        $this->assertEquals(18.0686, $coordinates->get_longitude());
    }

    public function test_can_set_latitude_and_longitude_in_constructor() {
        $coordinates = new Coordinates(59.3293, 18.0686);

        $this->assertEquals(59.3293, $coordinates->get_latitude());
        $this->assertEquals(18.0686, $coordinates->get_longitude());
    }

    public function test_latitude_and_longitude_are_floats() {
        $coordinates = new Coordinates('59.3293', '18.0686');

        $this->assertIsFloat($coordinates->get_latitude());
        $this->assertIsFloat($coordinates->get_longitude());
    }
}
