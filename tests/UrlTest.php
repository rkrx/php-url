<?php
namespace Kir\Url;

class UrlTest extends \PHPUnit_Framework_TestCase {
	public function testHttp() {
		$uri = 'http://user:pass@host:1234/path?query=aaa&bbb=ccc#fragment';
		$url = new Url($uri);
		$this->assertEquals($uri, $url->__toString());
	}

	public function testMailTo() {
		$uri = 'mailto:username@example.com?subject=Topic&body=Hello';
		$url = new Url($uri);
		$this->assertEquals($uri, $url->__toString());
	}

	public function testDSN() {
		$uri = 'mysql:host=127.0.0.1;port=3306;charset=utf8';
		$url = new Url($uri);
		$this->assertEquals($uri, $url->__toString());
	}

	public function testPath() {
		$uri = '/test/path';
		$url = new Url($uri);
		$this->assertEquals($uri, $url->__toString());
	}
}
