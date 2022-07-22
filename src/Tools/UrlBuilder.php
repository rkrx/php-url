<?php
namespace Kir\Url\Tools;

class UrlBuilder {
	/**
	 * @param UrlParts $urlParts
	 * @return string
	 */
	public function build(UrlParts $urlParts) {
		$hierarchicalPart = $this->buildHierarchicalPart($urlParts);

		if($urlParts->scheme !== null) {
			if($urlParts->host !== null) {
				$hierarchicalPart = self::concat($urlParts->scheme, $hierarchicalPart, '://');
			} else {
				$hierarchicalPart = self::concat($urlParts->scheme, $hierarchicalPart, ':');
			}
		}

		$url = self::concat($hierarchicalPart, self::buildQuery($urlParts), '?');
		$url = self::concat($url, $urlParts->fragment, '#');

		return (string) $url;
	}

	/**
	 * @return string
	 */
	private function buildHierarchicalPart(UrlParts $urlParts) {
		$authority = self::buildAuthority($urlParts);
		$path = null;
		if($urlParts->path) {
			$path = $urlParts->path;
			if($authority !== null) {
				$path = ltrim($urlParts->path, '/');
			}
		}
		return (string) self::concat($authority, $path, '/');
	}

	/**
	 * @param UrlParts $parts
	 * @return string|null
	 */
	private static function buildAuthority(UrlParts $parts) {
		$userInfo = self::buildUserInfo($parts);
		$target = self::buildTarget($parts);
		if($target === null) {
			return null;
		}
		return self::concat($userInfo, $target, '@');
	}
	
	/**
	 * @param UrlParts $parts
	 * @return null|string
	 */
	private static function buildUserInfo(UrlParts $parts) {
		if($parts->user === null) {
			return null;
		}
		$username = urlencode($parts->user);
		$password = $parts->pass !== null ? urlencode($parts->pass) : null;
		return self::concat($username, $password, ':');
	}
	
	/**
	 * @param UrlParts $parts
	 * @return string|null
	 */
	private static function buildTarget(UrlParts $parts) {
		if($parts->host === null) {
			return null;
		}
		return self::concat($parts->host, $parts->port, ':');
	}
	
	/**
	 * @param UrlParts $parts
	 * @return string|null
	 */
	private static function buildQuery(UrlParts $parts) {
		if(!count($parts->query)) {
			return null;
		}
		return http_build_query($parts->query);
	}

	/**
	 * @param int|string|null $a
	 * @param int|string|null $b
	 * @param string $concatenator
	 * @return string|null
	 */
	private static function concat($a, $b, $concatenator) {
		if($a === null && $b === null) {
			return null;
		}
		$result = array();
		if($a !== null) {
			$result[] = (string) $a;
		}
		if($b !== null) {
			$result[] = (string) $b;
		}
		return implode($concatenator, $result);
	}
}
