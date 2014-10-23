<?php
namespace Kir\Url\Tools;

class UrlDefaults {
	/**
	 * @var string
	 */
	private $scheme = null;

	/**
	 * @var string|null
	 */
	private $username = null;

	/**
	 * @var string|null
	 */
	private $password = null;

	/**
	 * @var string
	 */
	private $host = null;

	/**
	 * @var int|null
	 */
	private $port = null;

	/**
	 * @var string|null
	 */
	private $path = null;

	/**
	 * @var array
	 */
	private $query = array();

	/**
	 * @var string|null
	 */
	private $fragment = null;

	/**
	 * @return string
	 */
	public function getScheme() {
		return $this->scheme;
	}

	/**
	 * @param string $scheme
	 * @return $this
	 */
	public function setScheme($scheme) {
		$this->scheme = $scheme;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * @param null|string $username
	 * @return $this
	 */
	public function setUsername($username) {
		$this->username = $username;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param null|string $password
	 * @return $this
	 */
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getHost() {
		return $this->host;
	}

	/**
	 * @param string $host
	 * @return $this
	 */
	public function setHost($host) {
		$this->host = $host;
		return $this;
	}

	/**
	 * @return int|null
	 */
	public function getPort() {
		return $this->port;
	}

	/**
	 * @param int|null $port
	 * @return $this
	 */
	public function setPort($port) {
		$this->port = $port;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getPath() {
		return $this->path;
	}

	/**
	 * @param null|string $path
	 * @return $this
	 */
	public function setPath($path) {
		$this->path = $path;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getQuery() {
		return $this->query;
	}

	/**
	 * @param array $query
	 * @return $this
	 */
	public function setQuery($query) {
		$this->query = $query;
		return $this;
	}

	/**
	 * @return null|string
	 */
	public function getFragment() {
		return $this->fragment;
	}

	/**
	 * @param null|string $fragment
	 * @return $this
	 */
	public function setFragment($fragment) {
		$this->fragment = $fragment;
		return $this;
	}

	/**
	 * @param array $parts
	 * @return array
	 */
	public function extend(array $parts) {
		$defaults = array(
			UrlConstants::SCHEME => $this->scheme,
			UrlConstants::USER => $this->username,
			UrlConstants::PASS => $this->password,
			UrlConstants::HOST => $this->host,
			UrlConstants::PORT => $this->port,
			UrlConstants::PATH => $this->path,
			UrlConstants::QUERY => $this->query,
			UrlConstants::FRAGMENT => $this->fragment,
		);

		return array_merge($defaults, $parts);
	}
}