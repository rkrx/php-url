<?php
namespace Kir\Url;

use Kir\Url\Tools\UrlBuilder;
use Kir\Url\Tools\UrlConstants AS Con;

class Url {
	/**
	 * @var array
	 */
	private $parts = array();
	/**
	 * @var UrlBuilder
	 */
	private $builder;

	/**
	 * @param string $url
	 * @param string|null $canonicalUrl
	 * @param UrlBuilder $builder
	 */
	public function __construct($url = null, $canonicalUrl = null, UrlBuilder $builder = null) {
		$this->builder = $builder ?: new UrlBuilder();

		$parts = parse_url($url);
		$canonicalParts = parse_url($canonicalUrl);

		$parts = array_merge($canonicalParts, $parts);

		$parts = array_merge(array(Con::QUERY => ''), $parts);
		parse_str($parts[Con::QUERY], $query);
		$parts[Con::QUERY] = $query;
		$this->parts = $parts;
	}

	/**
	 * @return string
	 */
	public function getScheme() {
		return $this->parts[Con::SCHEME];
	}

	/**
	 * @param string $scheme
	 * @return $this
	 */
	public function setScheme($scheme) {
		$this->parts[Con::SCHEME] = $scheme;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getUsername() {
		return $this->parts[Con::USER];
	}

	/**
	 * @param null|string $username
	 * @return $this
	 */
	public function setUsername($username) {
		$this->parts[Con::USER] = $username;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getPassword() {
		return $this->parts[Con::PASS];
	}

	/**
	 * @param null|string $password
	 * @return $this
	 */
	public function setPassword($password) {
		$this->parts[Con::PASS] = $password;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getHost() {
		return $this->parts[Con::HOST];
	}

	/**
	 * @param string $host
	 * @return $this
	 */
	public function setHost($host) {
		$this->parts[Con::HOST] = $host;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getPort() {
		return $this->parts[Con::PORT];
	}

	/**
	 * @param int|null $port
	 * @return $this
	 */
	public function setPort($port) {
		$this->parts[Con::PORT] = $port;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getPath() {
		return $this->parts[Con::PATH];
	}

	/**
	 * @param null|string $path
	 * @return $this
	 */
	public function setPath($path) {
		$this->parts[Con::PATH] = $path;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getQuery() {
		return $this->parts[Con::QUERY];
	}

	/**
	 * @param array $query
	 * @return $this
	 */
	public function setQuery($query) {
		$this->parts[Con::QUERY] = $query;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getFragment() {
		return $this->parts[Con::FRAGMENT];
	}

	/**
	 * @param null|string $fragment
	 * @return $this
	 */
	public function setFragment($fragment) {
		$this->parts[Con::FRAGMENT] = $fragment;
		return $this;
	}

	/**
	 * @return string
	 */
	function __toString() {
		return $this->builder->build($this->parts);
	}
}
