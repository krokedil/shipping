<?php
use Krokedil\Shipping\Ajax\AjaxRequest;

class AjaxRequestTest extends BaseTestCase {
	/**
	 * @var AjaxRequest
	 */
	private $ajaxRequest;

	public function setUp(): void {
		parent::setUp();

		$this->ajaxRequest = new AjaxRequest( 'test_action', function () {
			echo 'test output';
		}, false );
	}

	public function testGetAction() {
		$result = $this->ajaxRequest->get_action();

		$this->assertEquals( 'test_action', $result );
	}

	public function testGetCallback() {
		$result = $this->ajaxRequest->get_callback();

		$this->assertInstanceOf( Closure::class, $result );
	}

	public function testGetNoPriv() {
		$result = $this->ajaxRequest->get_no_priv();

		$this->assertFalse( $result );
	}

	public function testGetNoPrivTrue() {
		$ajaxRequest = new AjaxRequest( 'test_action', function () {
			echo 'test output';
		}, true );

		$result = $ajaxRequest->get_no_priv();

		$this->assertTrue( $result );
	}

	public function testGetNoPrivFalse() {
		$ajaxRequest = new AjaxRequest( 'test_action', function () {
			echo 'test output';
		}, false );

		$result = $ajaxRequest->get_no_priv();

		$this->assertFalse( $result );
	}

	public function testProcessValidNonce() {
		WP_Mock::userFunction( 'check_ajax_referer' )->once()->with( 'test_action', 'nonce' )->andReturn( true );
		WP_Mock::userFunction( 'wp_die' )->once()->andReturn( null );

		ob_start();
		$this->ajaxRequest->process();
		$result = ob_get_clean();

		$this->assertEquals( 'test output', $result );
	}

	public function testProcessInvalidNonce() {
		$this->expectException( Exception::class);
		WP_Mock::userFunction( 'check_ajax_referer' )->once()->with( 'test_action', 'nonce' )->andReturn( false );
		WP_Mock::userFunction( 'wp_die' )->with( 'bad nonce' )->once()->andThrows( new Exception( 'bad nonce' ) );

		$this->ajaxRequest->process();
	}
}
