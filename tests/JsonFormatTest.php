<?php
use Krokedil\Shipping\Traits\JsonFormat;
use PHPUnit\Framework\TestCase;

class JsonFormatTest extends TestCase {
	use JsonFormat;

	public function testJsonToArray() {
		$json = '{"name":"John","age":30,"city":"New York"}';
		$array = $this->json_to_array( $json );
		$this->assertEquals( $array['name'], 'John' );
		$this->assertEquals( $array['age'], 30 );
		$this->assertEquals( $array['city'], 'New York' );
	}

	public function testArrayToJson() {
		$array = array(
			'name' => 'John',
			'age' => 30,
			'city' => 'New York',
		);
		$json = $this->array_to_json( $array );
		$this->assertEquals( $json, '{"name":"John","age":30,"city":"New York"}' );
	}
}
