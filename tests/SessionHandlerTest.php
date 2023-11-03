<?php
use Krokedil\Shipping\SessionHandler;

class SessionHandlerTest extends BaseTestCase {
	private $sessionHandler;
	public function setUp(): void {
		parent::setUp();

		$this->mockWooCommerce();

		$this->sessionHandler = new SessionHandler();
	}

	public function testGetShippingRateReturnsNullIfNoRateFound() {
		$rate = $this->mockShippingRate( 'some_other_rate_id' );

		$packages = [ [ 'rates' => [ $rate ] ] ];

		$this->mockShipping->shouldReceive( 'get_packages' )->andReturn( $packages );
		$result = $this->sessionHandler->get_shipping_rate( 'non_existent_rate_id' );

		$this->assertNull( $result, 'Expected get_shipping_rate to return null for a non-existent rate ID.' );
	}

	public function testGetShippingRateReturnsRateIfFound() {
		$rate = $this->mockShippingRate();

		$packages = [ [ 'rates' => [ $rate ] ] ];

		$this->mockShipping->shouldReceive( 'get_packages' )->andReturn( $packages );
		$result = $this->sessionHandler->get_shipping_rate( 'rate_id' );

		$this->assertEquals( $rate, $result, 'Expected get_shipping_rate to return the rate for the given rate ID.' );
	}

	public function testSetShippingRateDataStoresDataCorrectly() {
		$rate_id = 'rate_id_1';
		$data    = [ 'key' => 'value' ];

		$this->sessionHandler->set_shipping_rate_data( $rate_id, $data );

		$this->assertEquals( $data, $this->sessionHandler->get_shipping_rate_data( $rate_id ), 'Expected set_shipping_rate_data to store the data correctly.' );
	}

	public function testUpdateShippingRatesForcesRecalculation() {
		$this->mockSession->shouldReceive( '__unset' )->times( 3 );
		$this->mockShipping->shouldReceive( 'calculate_shipping_for_package' )->times( 3 );

		$packages = [ 
			[ 'rates' => [] ],
			[ 'rates' => [] ],
			[ 'rates' => [] ],
		];

		$this->mockShipping->shouldReceive( 'get_packages' )->andReturn( $packages );
		$this->sessionHandler->update_shipping_rates();
		$this->expectNotToPerformAssertions();
	}

	public function testPreserveOldMetaData() {
		$this->sessionHandler->set_shipping_rate_data( 'rate_id', array( 'to_update' => 'new_value' ) );
		$rate = $this->mockShippingRate();
		$rate->shouldReceive( 'get_meta_data' )->andReturn( [ 'to_preserve' => 'old_value', 'to_update' => 'old_value' ] );

		$package = [ 'rates' => [ $rate ] ];

		$this->sessionHandler->preserve_old_meta_data( $package );

		$this->assertEquals( [ 'to_preserve' => 'old_value', 'to_update' => 'new_value' ], $this->sessionHandler->get_shipping_rate_data( 'rate_id' ), 'Expected preserve_old_meta_data to preserve old meta data.' );
	}

	public function testPackageRatesHandlerUpdatesRatesWithData() {
		$rateData = [ 
			'rate_id1' => [ 'meta_key1' => 'meta_value1' ],
			'rate_id2' => [ 'meta_key2' => 'meta_value2' ],
		];

		foreach ( $rateData as $rateId => $data ) {
			$this->sessionHandler->set_shipping_rate_data( $rateId, $data );
		}

		$rates = [];
		foreach ( $rateData as $rateId => $data ) {
			$rateMock = $this->mockShippingRate( $rateId );
			$rateMock->shouldReceive( 'get_id' )->andReturn( $rateId );
			foreach ( $data as $key => $value ) {
				$rateMock->shouldReceive( 'add_meta_data' )->with( $key, $value )->once();
			}
			$rates[] = $rateMock;
		}

		$updatedRates = $this->sessionHandler->package_rates_handler( $rates );
		$this->expectNotToPerformAssertions();
	}

	public function testPackageRatesHandlerStopsOnNoData() {
		$rate  = $this->mockShippingRate();
		$rates = [ $rate ];

		$updatedRates = $this->sessionHandler->package_rates_handler( $rates );

		$this->assertEquals( $rates, $updatedRates, 'Expected package_rates_handler to return the rates as is if no data is set.' );
	}

	public function tearDown(): void {
		parent::tearDown();
		Mockery::close();
	}
}
