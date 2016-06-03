<?php
namespace Kir\Url\Tools;

use Psr\Http\Message\UriInterface;

abstract class UrlTools {
	static private $parts = [
		PHP_URL_SCHEME,
		PHP_URL_HOST,
		PHP_URL_PORT,
		PHP_URL_USER,
		PHP_URL_PASS,
		PHP_URL_PATH,
		PHP_URL_QUERY,
		PHP_URL_FRAGMENT,
	];

	/**
	 * @param array $a
	 * @param array $b
	 * @return array
	 */
	public static function merge(array $a, array $b) {
		foreach(self::$parts as $partNo) {
			if(array_key_exists($partNo, $b) && $b[$partNo] !== null) {
				$a[$partNo] = $b[$partNo];
			}
		}
		return $a;
	}

	/**
	 * @param UriInterface $url
	 * @return array
	 */
	public static function map(UriInterface $url) {
		$userInfo = $url->getUserInfo();
		$userInfo .= ':';
		list($username, $password) = explode(':', $userInfo, 2);
		return [
			PHP_URL_SCHEME => $url->getScheme(),
			PHP_URL_USER => $username,
			PHP_URL_PASS => $password,
			PHP_URL_HOST => $url->getHost(),
			PHP_URL_PORT => $url->getPort(),
			PHP_URL_PATH => $url->getPath(),
			PHP_URL_QUERY => $url->getQuery(),
			PHP_URL_FRAGMENT => $url->getFragment(),
		];
	}

	/**
	 * @param UriInterface $url
	 * @return array
	 */
	public static function namedMap(UriInterface $url) {
		$map = self::map($url);
		return [
			'scheme' => $map[PHP_URL_SCHEME],
			'user' => $map[PHP_URL_USER],
			'pass' => $map[PHP_URL_PASS],
			'host' => $map[PHP_URL_HOST],
			'port' => $map[PHP_URL_PORT],
			'path' => $map[PHP_URL_PATH],
			'query' => $map[PHP_URL_QUERY],
			'fragment' => $map[PHP_URL_FRAGMENT],
		];
	}
}