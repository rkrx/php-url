<?php
namespace Kir\Url;

use Kir\Url\Tools\UrlBuilder;
use Kir\Url\Tools\UrlConstants AS Con;
use Kir\Url\Tools\UrlConstants;

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

		$parts = array_merge($defaults, $canonicalParts, $parts);

		$parts = array_merge(array(Con::QUERY => ''), $parts);
		parse_str($parts[Con::QUERY], $query);
		$parts[Con::QUERY] = $query;
		$this->parts = $parts;
	}

	/**
	 * @return string
	 */
	public function getScheme() {
		if(array_key_exists(Con::SCHEME, $this->parts)) {
			return $this->parts[Con::SCHEME];
		}
		return null;
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
		if(array_key_exists(Con::USER, $this->parts)) {
			return $this->parts[Con::USER];
		}
		return null;
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
		if(array_key_exists(Con::PASS, $this->parts)) {
			return $this->parts[Con::PASS];
		}
		return null;
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
		if(array_key_exists(Con::HOST, $this->parts)) {
			return $this->parts[Con::HOST];
		}
		return null;
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
		if(array_key_exists(Con::PORT, $this->parts)) {
			return $this->parts[Con::PORT];
		}
		return null;
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
		if(array_key_exists(Con::PATH, $this->parts)) {
			return $this->parts[Con::PATH];
		}
		return null;
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
		if(array_key_exists(Con::QUERY, $this->parts)) {
			return $this->parts[Con::QUERY];
		}
		return null;
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
		if(array_key_exists(Con::FRAGMENT, $this->parts)) {
			return $this->parts[Con::FRAGMENT];
		}
		return null;
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
