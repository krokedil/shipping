<?php
use Krokedil\Shipping\Admin\EditOrderPage;

class EditOrderPageTest extends BaseTestCase {
	/**
	 * @var EditOrderPage
	 */
	private $editOrderPage;

	public function testConstructor() {
		$this->mockPickupPointService();
		$editOrderPage = new EditOrderPage( $this->mockPickupPointService );
		WP_Mock::expectActionAdded( 'add_meta_boxes', array( $editOrderPage, 'add_shipping_metabox' ), 10, 2 );
		WP_Mock::expectActionAdded( 'ks_metabox_content', array( $editOrderPage, 'print_selected_pickup_point_info' ), 10, 2 );
		WP_Mock::expectActionAdded( 'ks_metabox_content', array( $editOrderPage, 'print_selected_pickup_point_selection' ), 20, 2 );
		$editOrderPage->init();
		$this->assertInstanceOf( EditOrderPage::class, $editOrderPage );
	}

	public function testCanAddShippingMetabox() {
		$this->mockPickupPointService();
		$this->editOrderPage = new EditOrderPage( $this->mockPickupPointService );
		$order = Mockery::mock( 'alias:WC_Order' );
		$shippingLine = Mockery::mock( 'alias:WC_Order_Item_Shipping' );
		$this->mockPickupPointService
			->shouldReceive( 'get_shipping_lines_from_order' )
			->with($order)
			->once()
			->andReturn( array( $shippingLine ) );
		WP_Mock::userFunction( 'add_meta_box' )
			->once()
			->with(
				'krokedil_shipping',
				'Shipping Information',
				array( $this->editOrderPage, 'render_shipping_metabox' ),
				'woocommerce_page_wc-order',
				'side',
				'core',
				array( 'shipping_lines' => array( $shippingLine ) )
			);

		$this->editOrderPage->add_shipping_metabox( 'woocommerce_page_wc-order', $order );
		$this->assertTrue( true );
	}

	public function testRenderShippingMetabox() {
		$this->mockPickupPointService();
		$this->editOrderPage = new EditOrderPage( $this->mockPickupPointService );
		$order = Mockery::mock( 'alias:WC_Order' );
		$shippingLine = Mockery::mock( 'alias:WC_Order_Item_Shipping' );
		$shippingLine->shouldReceive( 'get_id' )
			->andReturn( '123' )
			->once();

		ob_start();
		$this->editOrderPage->render_shipping_metabox( $order, array( 'args' => array( 'shipping_lines' => array( $shippingLine ) ) ) );
		$output = ob_get_clean();

		$this->assertStringContainsString( 'data-shipping-line-id="123"', $output );
		$this->assertTrue( true );
	}

	public function testPrintSelectedPickupPointInfo() {
		$this->mockWooCommerce();
		$this->mockWoocommerce->countries->shouldReceive( 'get_formatted_address');
		$this->mockPickupPointService();

		$this->editOrderPage = new EditOrderPage( $this->mockPickupPointService );
		$order               = Mockery::mock( 'alias:WC_Order' );
		$shippingLine        = Mockery::mock( 'alias:WC_Order_Item_Shipping' );

		$shippingLine->shouldReceive( 'get_id' )
			->andReturn( '123' )
			->twice();
		$shippingLine->shouldReceive( 'get_meta' )
			->with( 'krokedil_selected_pickup_point' )
			->andReturn( json_encode( self::$pickupPoint ) )
			->once();
		$order->shouldReceive( 'get_items' )
			->with( 'shipping' )
			->andReturn( array( $shippingLine ) )
			->once();

		WP_Mock::userFunction( 'wp_kses_post' )->once();

		ob_start();
		$this->editOrderPage->print_selected_pickup_point_info( $order, $shippingLine );
		$output = ob_get_clean();

		$this->assertStringContainsString( 'Selected pickup point', $output );
		$this->assertStringContainsString( 'data-shipping-line-id="123"', $output );
	}

}
