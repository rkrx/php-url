<?php
namespace Kir\Url\Tools;

class UrlBuilder {
	/**
	 * @param array $urlParts
	 * @return string
	 */
	public function build(array $urlParts) {
		$defaults = array(
			UrlConstants::SCHEME => null,
			UrlConstants::USER => null,
			UrlConstants::PASS => null,
			UrlConstants::HOST => null,
			UrlConstants::PORT => null,
			UrlConstants::PATH => null,
			UrlConstants::QUERY => null,
			UrlConstants::FRAGMENT => null,
		);

		$urlParts = array_merge($defaults, $urlParts);

		$hierarchicalPart = $this->buildHierarchicalPart($urlParts);

		if($urlParts[UrlConstants::HOST] !== null) {
			$schemeAndHierarchicalPart = $this->concat($urlParts[UrlConstants::SCHEME], $hierarchicalPart, '://');
		} else {
			$schemeAndHierarchicalPart = $this->concat($urlParts[UrlConstants::SCHEME], $hierarchicalPart, ':');
		}

		$url = $this->concat($schemeAndHierarchicalPart, $this->buildQuery($urlParts), '?');
		$url = $this->concat($url, $urlParts[UrlConstants::FRAGMENT], '#');

		return $url;
	}

	/**
	 * @param array $parts
	 * @return string
	 */
	private function buildHierarchicalPart(array $parts) {
		$authority = $this->buildAuthority($parts);
		$path = null;
		if($parts[UrlConstants::PATH]) {
			$path = $parts[UrlConstants::PATH];
			if($authority !== null) {
				$path = ltrim($parts[UrlConstants::PATH], '/');
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
		if($parts[UrlConstants::USER] === null) {
			return null;
		}
		return $this->concat($parts[UrlConstants::USER], $parts[UrlConstants::PASS], ':');
	}

	/**
	 * @param array $parts
	 * @return string
	 */
	private function buildTarget(array $parts) {
		if($parts[UrlConstants::HOST] === null) {
			return null;
		}
		return $this->concat($parts[UrlConstants::HOST], $parts[UrlConstants::PORT], ':');
	}

	/**
	 * @param array $parts
	 * @return string|null
	 */
	private function buildQuery(array $parts) {
		if(!count($parts[UrlConstants::QUERY])) {
			return null;
		}
		return http_build_query($parts[UrlConstants::QUERY]);
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
