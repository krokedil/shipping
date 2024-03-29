<?php
use Krokedil\Shipping\Traits\ArrayFormat;
use WP_Mock\Tools\TestCase;

class ArrayFormatTest extends TestCase {
	public function testToArray() {
		$object = new ArrayFormatClass();
		$array = $object->to_array();
		$this->assertEquals( $array['foo'], 'bar' );
		$this->assertEquals( $array['baz'], 42 );
	}
}

class ArrayFormatClass {
	use ArrayFormat;

	public $foo = 'bar';
	public $baz = 42;
}
