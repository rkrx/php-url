<?php
namespace Kir\Url;

use Kir\Url\Tools\UrlBuilder;
use Kir\Url\Tools\UrlParts;
use Kir\Url\Tools\UrlTools;
use Traversable;

class Url {
	/** @var UrlParts */
	private $urlParts;
	/** @var UrlBuilder */
	private $builder;
	
	/**
	 * @param string $url
	 * @param null|string $canonicalUrl
	 * @param UrlBuilder $builder
	 */
	public function __construct(string $url = null, ?string $canonicalUrl = null, ?UrlBuilder $builder = null) {
		$this->urlParts = new UrlParts();
		
		$this->builder = $builder ?: new UrlBuilder();
		
		$this->urlParts->scheme = UrlTools::coalesce(
			UrlTools::parseUrlComponent($url, PHP_URL_SCHEME),
			UrlTools::parseUrlComponent($canonicalUrl, PHP_URL_SCHEME)
		);
		
		$this->urlParts->user = UrlTools::coalesce(
			UrlTools::parseUrlComponent($url, PHP_URL_USER),
			UrlTools::parseUrlComponent($canonicalUrl, PHP_URL_USER)
		);
		
		$this->urlParts->pass = UrlTools::coalesce(
			UrlTools::parseUrlComponent($url, PHP_URL_PASS),
			UrlTools::parseUrlComponent($canonicalUrl, PHP_URL_PASS)
		);
		
		$this->urlParts->host = UrlTools::coalesce(
			UrlTools::parseUrlComponent($url, PHP_URL_HOST),
			UrlTools::parseUrlComponent($canonicalUrl, PHP_URL_HOST)
		);
		
		$port = UrlTools::coalesce(
			UrlTools::parseUrlComponent($url, PHP_URL_PORT),
			UrlTools::parseUrlComponent($canonicalUrl, PHP_URL_PORT)
		);
		
		$this->urlParts->port = $port !== null ? (int) $port : null;
		
		$this->urlParts->path = UrlTools::coalesce(
			UrlTools::parseUrlComponent($url, PHP_URL_PATH),
			UrlTools::parseUrlComponent($canonicalUrl, PHP_URL_PATH)
		);
		
		$this->urlParts->query = UrlTools::parseQuery(
			UrlTools::coalesce(
				UrlTools::parseUrlComponent($url, PHP_URL_QUERY),
				UrlTools::parseUrlComponent($canonicalUrl, PHP_URL_QUERY)
			)
		);
		
		$this->urlParts->fragment = UrlTools::coalesce(
			UrlTools::parseUrlComponent($url, PHP_URL_FRAGMENT),
			UrlTools::parseUrlComponent($canonicalUrl, PHP_URL_FRAGMENT)
		);
	}

	/**
	 * @return string|null
	 */
	public function getScheme() {
		return $this->urlParts->scheme;
	}

	/**
	 * @param string|null $scheme
	 * @return $this
	 */
	public function setScheme($scheme) {
		$this->urlParts->scheme = $scheme;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getUsername() {
		return $this->urlParts->user;
	}

	/**
	 * @param string|null $username
	 * @return $this
	 */
	public function setUsername($username) {
		$this->urlParts->user = $username;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPassword() {
		return $this->urlParts->pass;
	}

	/**
	 * @param string|null $password
	 * @return $this
	 */
	public function setPassword($password) {
		$this->urlParts->pass = $password;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getHost() {
		return $this->urlParts->host;
	}

	/**
	 * @param string $host
	 * @return $this
	 */
	public function setHost($host) {
		$this->urlParts->host = $host;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getPort() {
		return $this->urlParts->port;
	}

	/**
	 * @param int|null $port
	 * @return $this
	 */
	public function setPort($port) {
		$this->urlParts->port = $port;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPath() {
		return $this->urlParts->path;
	}

	/**
	 * @param string|null $path
	 * @return $this
	 */
	public function setPath($path) {
		$this->urlParts->path = $path;
		return $this;
	}

	/**
	 * @return null|array<int|string, int|float|string|array<int|string, mixed>>
	 */
	public function getQuery() {
		return $this->urlParts->query;
	}

	/**
	 * @param array<int|string, int|float|string|array<int|string, mixed>>|Traversable<int|string, int|float|string|array<int|string, mixed>> $query
	 * @return $this
	 */
	public function setQuery($query) {
		if($query instanceof Traversable) {
			$query = iterator_to_array($query, true);
		}
		if(!is_array($query)) {
			$query = [];
		}
		$this->urlParts->query = $query;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getFragment() {
		return $this->urlParts->fragment;
	}

	/**
	 * @param string|null $fragment
	 * @return $this
	 */
	public function setFragment($fragment) {
		$this->urlParts->fragment = $fragment;
		return $this;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->builder->build($this->urlParts);
	}
}
