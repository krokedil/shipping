<?php
use Krokedil\Shipping\PickupPoint\OpenHours;
use PHPUnit\Framework\TestCase;

class OpenHoursTest extends TestCase {
    public function testGetters() {
        $open_hours = new OpenHours('Monday', '09:00', '17:00');
        $this->assertEquals('Monday', $open_hours->get_day());
        $this->assertEquals('09:00', $open_hours->get_open());
        $this->assertEquals('17:00', $open_hours->get_close());
    }

    public function testSetters() {
        $open_hours = new OpenHours();
        $open_hours->set_day('Tuesday');
        $open_hours->set_open('10:00');
        $open_hours->set_close('18:00');
        $this->assertEquals('Tuesday', $open_hours->get_day());
        $this->assertEquals('10:00', $open_hours->get_open());
        $this->assertEquals('18:00', $open_hours->get_close());
    }
}
