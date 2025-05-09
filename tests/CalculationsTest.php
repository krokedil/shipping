<?php
use Krokedil\Shipping\Calculations;

class CalculationsTest extends BaseTestCase {
	/**
	 * @var \WC_Tax
	 */
	private $mockTax;

	/**
	 * @var array<string, array<string, mixed>>
	 */
	private $rates;

	public function setUp(): void {
		parent::setUp();

		$this->rates = array(
			'25' => array(
				'label'    => __( 'Shipping tax 25%', 'krokedil-shipping' ),
				'rate'     => 25,
				'shipping' => 'yes',
				'compound' => 'no',
			),
			'12' => array(
				'label'    => __( 'Shipping tax 12%', 'krokedil-shipping' ),
				'rate'     => 12,
				'shipping' => 'yes',
				'compound' => 'no',
			),
			'6' => array(
				'label'    => __( 'Shipping tax 6%', 'krokedil-shipping' ),
				'rate'     => 6,
				'shipping' => 'yes',
				'compound' => 'no',
			),
			'0' => array(
				'label'    => __( 'Shipping tax 0%', 'krokedil-shipping' ),
				'rate'     => 0,
				'shipping' => 'yes',
				'compound' => 'no',
			),
			'25.5' => array(
				'label'    => __( 'Shipping tax 25.5%', 'krokedil-shipping' ),
				'rate'     => 25.5,
				'shipping' => 'yes',
				'compound' => 'no',
			),
		);

		$this->mockTax = Mockery::mock( 'alias:WC_Tax' );
		$this->mockTax->shouldReceive( 'get_shipping_tax_rates' )
			->andReturn( array(
				$this->rates['25'],
				$this->rates['12'],
				$this->rates['6'],
				$this->rates['0'],
				$this->rates['25.5'],
			) );
	}

	public function testGetTaxRateFromPercentage() {
		// Test each of the test rates that we expect.
		foreach ( $this->rates as $rate ) {
			$result = Calculations::get_tax_rate_from_percentage( $rate['rate'] );
			// Print the result into the test run.
			$this->assertEquals( $rate['label'], $result['label'] );
			$this->assertEquals( $rate['rate'], $result['rate'] );
			$this->assertEquals( $rate['shipping'], $result['shipping'] );
			$this->assertEquals( $rate['compound'], $result['compound'] );
		}

		// Test a rate that does not exist in the rates array.
		$nonExistingRates = array( 50, 33.33 );
		foreach ( $nonExistingRates as $rate ) {
			$result = Calculations::get_tax_rate_from_percentage( $rate );
			$this->assertEquals( array(
				'label'    => __( 'Shipping tax', 'krokedil-shipping' ),
				'rate'     => $rate,
				'shipping' => 'yes',
				'compound' => 'no',
			), $result );
		}

	}
}
