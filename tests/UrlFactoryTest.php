<?php
use Kir\Url\UrlFactory;

class UrlFactoryTest extends PHPUnit_Framework_TestCase {
	public function test() {
		$factory = new UrlFactory();
		$url = $factory->create('/path?a=1', 'http://example.org/');
		$this->assertEquals('http://example.org/path?a=1', (string) $url);
	}
}
