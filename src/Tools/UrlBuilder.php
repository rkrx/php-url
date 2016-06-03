<?php
namespace Kir\Url\Tools;

class UrlBuilder {
	/**
	 * @param array $urlParts
	 * @return string
	 */
	public function build(array $urlParts) {
		$defaults = array(
			PHP_URL_SCHEME => null,
			PHP_URL_USER => null,
			PHP_URL_PASS => null,
			PHP_URL_HOST => null,
			PHP_URL_PORT => null,
			PHP_URL_PATH => null,
			PHP_URL_QUERY => null,
			PHP_URL_FRAGMENT => null,
		);

		$urlParts = UrlTools::merge($defaults, $urlParts);

		$hierarchicalPart = $this->buildHierarchicalPart($urlParts);

		if($urlParts[PHP_URL_HOST] !== null) {
			$schemeAndHierarchicalPart = $this->concat($urlParts[PHP_URL_SCHEME], $hierarchicalPart, '://');
		} else {
			$schemeAndHierarchicalPart = $this->concat($urlParts[PHP_URL_SCHEME], $hierarchicalPart, ':');
		}

		$url = $this->concat($schemeAndHierarchicalPart, $this->buildQuery($urlParts), '?');
		$url = $this->concat($url, $urlParts[PHP_URL_FRAGMENT], '#');

		return $url;
	}

	/**
	 * @param array $parts
	 * @return string
	 */
	private function buildHierarchicalPart(array $parts) {
		$authority = $this->buildAuthority($parts);
		$path = null;
		if($parts[PHP_URL_PATH]) {
			$path = $parts[PHP_URL_PATH];
			if($authority !== null) {
				$path = ltrim($parts[PHP_URL_PATH], '/');
			}
		}
		return $this->concat($authority, $path, '/');
	}

	/**
	 * @param array $parts
	 * @return string
	 */
	private function buildAuthority(array $parts) {
		$userInfo = $this->buildUserInfo($parts);
		$target = $this->buildTarget($parts);
		if($target === null) {
			return null;
		}
		return $this->concat($userInfo, $target, '@');
	}

	/**
	 * @param array $parts
	 * @return null|string
	 */
	private function buildUserInfo(array $parts) {
		if($parts[PHP_URL_USER] === null) {
			return null;
		}
		return $this->concat($parts[PHP_URL_USER], $parts[PHP_URL_PASS], ':');
	}

	/**
	 * @param array $parts
	 * @return string
	 */
	private function buildTarget(array $parts) {
		if($parts[PHP_URL_HOST] === null) {
			return null;
		}
		return $this->concat($parts[PHP_URL_HOST], $parts[PHP_URL_PORT], ':');
	}

	/**
	 * @param array $parts
	 * @return string|null
	 */
	private function buildQuery(array $parts) {
		if(!strlen($parts[PHP_URL_QUERY])) {
			return null;
		}
		return $parts[PHP_URL_QUERY];
	}

	/**
	 * @param string $a
	 * @param string $b
	 * @param string $concatenator
	 * @return string
	 */
	private function concat($a, $b, $concatenator) {
		$result = array();
		if($a !== null) {
			$result[] = $a;
		}
		if($b !== null) {
			$result[] = $b;
		}
		return join($concatenator, $result);
	}
}
