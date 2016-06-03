<?php
namespace Kir\Url;

use Kir\Url\Tools\UrlBuilder;
use Kir\Url\Tools\UrlTools;

class UrlFactory {
	/** @var UrlBuilder */
	private $builder;

	/**
	 * @param UrlBuilder $builder
	 */
	public function __construct(UrlBuilder $builder = null) {
		if($builder === null) {
			$builder = new UrlBuilder();
		}
		$this->builder = $builder;
	}

	/**
	 * @param string $url
	 * @param string|null $canonical
	 * @return Url
	 */
	public function create($url, $canonical = null) {
		$parts = $this->parseUrl((string) $url);
		if($canonical !== null) {
			$canonicalParts = $this->parseUrl((string) $canonical);
			$parts = UrlTools::merge($canonicalParts, $parts);
		}
		if(!array_key_exists(PHP_URL_QUERY, $parts)) {
			$parts[PHP_URL_QUERY] = '';
		}
		if(!is_string($parts[PHP_URL_QUERY])) {
			$parts[PHP_URL_QUERY] = '';
		}
		$immutableUrl = new ImmutableUrl($parts, $this->builder);
		return new Url($immutableUrl);
	}

	/**
	 * @param string $url
	 * @return array
	 */
	private function parseUrl($url) {
		$result = [
			PHP_URL_SCHEME => parse_url($url, PHP_URL_SCHEME),
			PHP_URL_HOST => parse_url($url, PHP_URL_HOST),
			PHP_URL_PORT => parse_url($url, PHP_URL_PORT),
			PHP_URL_USER => parse_url($url, PHP_URL_USER),
			PHP_URL_PASS => parse_url($url, PHP_URL_PASS),
			PHP_URL_PATH => parse_url($url, PHP_URL_PATH),
			PHP_URL_QUERY => parse_url($url, PHP_URL_QUERY),
			PHP_URL_FRAGMENT => parse_url($url, PHP_URL_FRAGMENT),
		];
		return $result;
	}
}
