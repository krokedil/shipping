<?php
use Krokedil\Shipping\Traits\ArrayFormat;

class ArrayFormatTest extends \PHPUnit\Framework\TestCase {
	public function test_to_array() {
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
