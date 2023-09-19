<?php
use PHPUnit\Framework\TestCase;
use Krokedil\Shipping\PickupPoint\PickupPoint;
use Krokedil\Shipping\PickupPoint\Address;
use Krokedil\Shipping\PickupPoint\Coordinates;
use Krokedil\Shipping\PickupPoint\OpenHours;
use Krokedil\Shipping\PickupPoint\EstimatedTimeOfArrival;

class PickupPointTest extends TestCase {
    public function testCanCreatePickupPoint() {
        $pickup_point_data = array(
            'id' => '123',
            'name' => 'Test Pickup Point',
            'description' => 'This is a test pickup point',
            'address' => array(
                'street' => '123 Main St',
                'city' => 'Anytown',
                'postcode' => '12345',
                'country' => 'US'
            ),
            'coordinates' => array(
                'latitude' => '37.7749',
                'longitude' => '-122.4194'
            ),
            'open_hours' => array(
                array(
                    'day' => 'Monday',
                    'open' => '09:00',
                    'close' => '17:00'
                ),
                array(
                    'day' => 'Tuesday',
                    'open' => '09:00',
                    'close' => '17:00'
                ),
                array(
                    'day' => 'Wednesday',
                    'open' => '09:00',
                    'close' => '17:00'
                ),
                array(
                    'day' => 'Thursday',
                    'open' => '09:00',
                    'close' => '17:00'
                ),
                array(
                    'day' => 'Friday',
                    'open' => '09:00',
                    'close' => '17:00'
                ),
                array(
                    'day' => 'Saturday',
                    'open' => '10:00',
                    'close' => '14:00'
                ),
                array(
                    'day' => 'Sunday',
                    'open' => 'Closed',
                    'close' => 'Closed'
                )
            ),
            'eta' => array(
                'utc' => '2022-01-01T12:00:00Z',
                'local' => '2022-01-01T12:00:00+01:00'
            ),
            'meta_data' => array(
                'key1' => 'value1',
                'key2' => 'value2'
            )
        );

        $pickup_point = new PickupPoint($pickup_point_data);

        $this->assertInstanceOf(PickupPoint::class, $pickup_point);
        $this->assertEquals('123', $pickup_point->get_id());
        $this->assertEquals('Test Pickup Point', $pickup_point->get_name());
        $this->assertEquals('This is a test pickup point', $pickup_point->get_description());

        $address = $pickup_point->get_address();
        $this->assertInstanceOf(Address::class, $address);
        $this->assertEquals('123 Main St', $address->get_street());
        $this->assertEquals('Anytown', $address->get_city());
        $this->assertEquals('12345', $address->get_postcode());
        $this->assertEquals('US', $address->get_country());

        $coordinates = $pickup_point->get_coordinates();
        $this->assertInstanceOf(Coordinates::class, $coordinates);
        $this->assertEquals('37.7749', $coordinates->get_latitude());
        $this->assertEquals('-122.4194', $coordinates->get_longitude());

        $open_hours = $pickup_point->get_open_hours();
        $this->assertIsArray($open_hours);
        $this->assertCount(7, $open_hours);
        $this->assertInstanceOf(OpenHours::class, $open_hours[0]);
        $this->assertEquals('Monday', $open_hours[0]->get_day());
        $this->assertEquals('09:00', $open_hours[0]->get_open());
        $this->assertEquals('17:00', $open_hours[0]->get_close());

        $eta = $pickup_point->get_eta();
        $this->assertInstanceOf(EstimatedTimeOfArrival::class, $eta);
        $this->assertEquals('2022-01-01T12:00:00Z', $eta->get_utc());
        $this->assertEquals('2022-01-01T12:00:00+01:00', $eta->get_local());

        $meta_data = $pickup_point->get_meta_data('key1');
        $this->assertIsString($meta_data);
        $this->assertEquals('value1', $meta_data);
    }
}
