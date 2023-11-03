<?php
use Krokedil\Shipping\Ajax\AjaxRegistry;
use Krokedil\Shipping\Ajax\AjaxRequest;
use WP_Mock\Tools\TestCase;

class AjaxRegistryTest extends TestCase {
	/**
	 * @var AjaxRegistry
	 */
	private $ajaxRegistry;

	public function setUp(): void {
		$this->ajaxRegistry = new AjaxRegistry();
	}

	public function testAddRequest() {
		$mockRequest = Mockery::mock( AjaxRequest::class);
		$mockRequest->shouldReceive( 'get_action' )->once()->andReturn( 'test_action' );

		$this->ajaxRegistry->add_request( $mockRequest );

		$retrievedRequest = $this->ajaxRegistry->get_request( 'test_action' );
		$this->assertEquals( $mockRequest, $retrievedRequest );
	}

	public function testRegisterRequests() {
		$mockRequest = Mockery::mock( AjaxRequest::class);
		$mockRequest->shouldReceive( 'get_action' )->twice()->andReturn( 'test_action' );
		$mockRequest->shouldReceive( 'get_callback' )->once()->andReturn( 'callback_function' );
		$mockRequest->shouldReceive( 'get_no_priv' )->once()->andReturn( true );

		$this->ajaxRegistry->add_request( $mockRequest );
		$this->ajaxRegistry->register_requests();

		$this->expectNotToPerformAssertions();
	}

	public function tearDown(): void {
		parent::tearDown();
		Mockery::close();
	}
}
