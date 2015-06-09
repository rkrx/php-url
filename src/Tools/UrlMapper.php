<?php
namespace Kir\Url\Tools;

use Psr\Http\Message\UriInterface;

class UrlMapper {
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
			UrlConstants::SCHEME => $map[PHP_URL_SCHEME],
			UrlConstants::USER => $map[PHP_URL_USER],
			UrlConstants::PASS => $map[PHP_URL_PASS],
			UrlConstants::HOST => $map[PHP_URL_HOST],
			UrlConstants::PORT => $map[PHP_URL_PORT],
			UrlConstants::PATH => $map[PHP_URL_PATH],
			UrlConstants::QUERY => $map[PHP_URL_QUERY],
			UrlConstants::FRAGMENT => $map[PHP_URL_FRAGMENT],
		];
	}
}