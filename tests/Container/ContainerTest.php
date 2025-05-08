<?php
use Krokedil\Shipping\Container\Container;
use Krokedil\Shipping\Container\Exceptions\NotFoundException;

class ContainerTest extends BaseTestCase {
	private $container;

	public function setUp(): void {
		parent::setUp();

		$this->container = new Container();
	}

	public function testGetInstance() {
		$instance = Container::get_instance();
		$this->assertInstanceOf( Container::class, $instance );
	}

	public function testGetInstanceTwice() {
		$instance1 = Container::get_instance();
		$instance2 = Container::get_instance();
		$this->assertSame( $instance1, $instance2 );
	}

	public function testAddAndGet() {
		$service = new stdClass();
		$this->container->add( 'test_service', $service );
		$this->assertSame( $service, $this->container->get( 'test_service' ) );
	}

	public function testGetNonExistentEntry() {
		$this->expectException( NotFoundException::class);
		$this->container->get( 'non_existent_service' );
	}

	public function testAddAndGetEntryTwice() {
		$service1 = new stdClass();
		$service2 = new stdClass();
		$this->container->add( 'test_service', $service1 );
		$this->container->add( 'test_service', $service2 );
		$this->assertSame( $service1, $this->container->get( 'test_service' ) );
	}

	public function testHas() {
		$service = new stdClass();
		$this->container->add( 'test_service', $service );
		$this->assertTrue( $this->container->has( 'test_service' ) );
	}

	public function testHasNonExistentEntry() {
		$this->assertFalse( $this->container->has( 'non_existent_service' ) );
	}
}
