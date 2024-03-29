<?php
use Krokedil\Shipping\Traits\JsonFormat;
use WP_Mock\Tools\TestCase;

class JsonFormatTest extends TestCase {
	use JsonFormat;

	public function testJsonToArray() {
		$json = '{"name":"John","age":30,"city":"New York"}';
		$array = $this->json_to_array( $json );
		$this->assertEquals( $array['name'], 'John' );
		$this->assertEquals( $array['age'], 30 );
		$this->assertEquals( $array['city'], 'New York' );
	}

	public function testToJson() {
		$array = array(
			'name' => 'John',
			'age' => 30,
			'city' => 'New York',
		);
		$json  = $this->to_json( $array );
		$this->assertEquals( $json, '{"name":"John","age":30,"city":"New York"}' );
	}
}
