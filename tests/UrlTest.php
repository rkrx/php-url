<?php
namespace Kir\Url;

use PHPUnit\Framework\TestCase;

class UrlTest extends TestCase {
	/** @return void */
	public function testHttp() {
		$uri = 'http://user:pass@host:1234/path?query=aaa&bbb=ccc#fragment';
		$url = new Url($uri);
		$this->assertEquals($uri, $url->__toString());
	}

	/** @return void */
	public function testMailTo() {
		$uri = 'mailto:username@example.com?subject=Topic&body=Hello';
		$url = new Url($uri);
		$this->assertEquals($uri, $url->__toString());
	}

	/** @return void */
	public function testDSN() {
		$uri = 'mysql:host=127.0.0.1;port=3306;charset=utf8';
		$url = new Url($uri);
		$this->assertEquals($uri, $url->__toString());
	}

	/** @return void */
	public function testPath() {
		$uri = '/test/path';
		$url = new Url($uri);
		$this->assertEquals($uri, $url->__toString());
	}

	/** @return void */
	public function testGetters() {
		$url = new Url('proto://root:pa55w0rd@example.org:443/path?a=1&b=%C3%B6%C3%A4%C3%BC%C3%9F#test');
		$this->assertEquals('proto', $url->getScheme());
		$this->assertEquals('root', $url->getUsername());
		$this->assertEquals('pa55w0rd', $url->getPassword());
		$this->assertEquals('example.org', $url->getHost());
		$this->assertEquals('443', $url->getPort());
		$this->assertEquals('/path', $url->getPath());
		$this->assertEquals(array('a' => 1, 'b' => 'öäüß'), $url->getQuery());
		$this->assertEquals('test', $url->getFragment());
	}

	/** @return void */
	public function testSetters() {
		$url = new Url();
		$url->setScheme('proto');
		$url->setUsername('root');
		$url->setPassword('pa55w0rd');
		$url->setHost('example.org');
		$url->setPort(443);
		$url->setPath('/path');
		$url->setQuery(['a' => 1, 'b' => 'öäüß']);
		$url->setFragment('test');
		$this->assertEquals('proto://root:pa55w0rd@example.org:443/path?a=1&b=%C3%B6%C3%A4%C3%BC%C3%9F#test', $url->__toString());
	}

	/** @return void */
	public function testCanonicalUrl() {
		$url = new Url('/path', 'http://example.org/?a=1');
		$this->assertEquals('http://example.org/path?a=1', $url->__toString());
	}
}
