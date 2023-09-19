<?php
use Krokedil\Shipping\PickupPoint\EstimatedTimeOfArrival;
use PHPUnit\Framework\TestCase;

class EstimatedTimeOfArrivalTest extends TestCase {
    public function test_can_set_and_get_utc() {
        $eta = new EstimatedTimeOfArrival();
        $utc = '2022-01-01T00:00:00Z';
        $eta->set_utc($utc);
        $this->assertEquals($utc, $eta->get_utc());
    }

    public function test_can_set_and_get_local() {
        $eta = new EstimatedTimeOfArrival();
        $local = '2022-01-01T01:00:00+01:00';
        $eta->set_local($local);
        $this->assertEquals($local, $eta->get_local());
    }

    public function test_can_be_constructed_with_utc_and_local() {
        $utc = '2022-01-01T00:00:00Z';
        $local = '2022-01-01T01:00:00+01:00';
        $eta = new EstimatedTimeOfArrival($utc, $local);
        $this->assertEquals($utc, $eta->get_utc());
        $this->assertEquals($local, $eta->get_local());
    }
}
