<?php
use Krokedil\Shipping\PickupPoint\Address;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase {
    public function testGetters() {
        $address = new Address('123 Main St', 'Anytown', '12345', 'US');
        $this->assertEquals('123 Main St', $address->get_street());
        $this->assertEquals('Anytown', $address->get_city());
        $this->assertEquals('12345', $address->get_postcode());
        $this->assertEquals('US', $address->get_country());
    }

    public function testSetters() {
        $address = new Address();
        $address->set_street('123 Main St');
        $address->set_city('Anytown');
        $address->set_postcode('12345');
        $address->set_country('US');
        $this->assertEquals('123 Main St', $address->get_street());
        $this->assertEquals('Anytown', $address->get_city());
        $this->assertEquals('12345', $address->get_postcode());
        $this->assertEquals('US', $address->get_country());
    }
}
