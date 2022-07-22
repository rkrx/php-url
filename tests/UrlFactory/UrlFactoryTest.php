<?php

namespace Kir\Url\UrlFactory;

use Kir\Url\UrlFactory;
use PHPUnit\Framework\TestCase;

class UrlFactoryTest extends TestCase {
	/** @return void */
	public function test() {
		$factory = new UrlFactory();
		$url = $factory->create('/path?a=1', 'http://example.org/');
		$this->assertEquals('http://example.org/path?a=1', (string) $url);
	}
}
