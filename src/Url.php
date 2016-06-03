<?php
namespace Kir\Url;

use Psr\Http\Message\UriInterface;

class Url implements UriInterface {
	/** @var ImmutableUrl */
	private $url;

	/**
	 * @param ImmutableUrl $url
	 */
	public function __construct(ImmutableUrl $url = null) {
		if($url === null) {
			$url = new ImmutableUrl([]);
		}
		$this->url = $url;
	}

	/**
	 * Retrieve the scheme component of the URI.
	 * If no scheme is present, this method MUST return an empty string.
	 * The value returned MUST be normalized to lowercase, per RFC 3986
	 * Section 3.1.
	 * The trailing ":" character is not part of the scheme and MUST NOT be
	 * added.
	 *
	 * @see https://tools.ietf.org/html/rfc3986#section-3.1
	 * @return string The URI scheme.
	 */
	public function getScheme() {
		return $this->url->getScheme();
	}

	/**
	 * Return an instance with the specified scheme.
	 * This method MUST retain the state of the current instance, and return
	 * an instance that contains the specified scheme.
	 * Implementations MUST support the schemes "http" and "https" case
	 * insensitively, and MAY accommodate other schemes if required.
	 * An empty scheme is equivalent to removing the scheme.
	 *
	 * @param string $scheme The scheme to use with the new instance.
	 * @return static A new instance with the specified scheme.
	 * @throws \InvalidArgumentException for invalid or unsupported schemes.
	 */
	public function withScheme($scheme) {
		return new static($this->url->withScheme($scheme));
	}

	/**
	 * @param string $schema
	 * @return $this
	 */
	public function setScheme($schema = null) {
		$this->url = $this->url->withScheme($schema);
		return $this;
	}

	/**
	 * Retrieve the authority component of the URI.
	 * If no authority information is present, this method MUST return an empty
	 * string.
	 * The authority syntax of the URI is:
	 * <pre>
	 * [user-info@]host[:port]
	 * </pre>
	 * If the port component is not set or is the standard port for the current
	 * scheme, it SHOULD NOT be included.
	 *
	 * @see https://tools.ietf.org/html/rfc3986#section-3.2
	 * @return string The URI authority, in "[user-info@]host[:port]" format.
	 */
	public function getAuthority() {
		return $this->url->getAuthority();
	}

	/**
	 * Retrieve the user information component of the URI.
	 * If no user information is present, this method MUST return an empty
	 * string.
	 * If a user is present in the URI, this will return that value;
	 * additionally, if the password is also present, it will be appended to the
	 * user value, with a colon (":") separating the values.
	 * The trailing "@" character is not part of the user information and MUST
	 * NOT be added.
	 *
	 * @return string The URI user information, in "username[:password]" format.
	 */
	public function getUserInfo() {
		return $this->url->getUserInfo();
	}

	/**
	 * Return an instance with the specified user information.
	 * This method MUST retain the state of the current instance, and return
	 * an instance that contains the specified user information.
	 * Password is optional, but the user information MUST include the
	 * user; an empty string for the user is equivalent to removing user
	 * information.
	 *
	 * @param string $user The user name to use for authority.
	 * @param null|string $password The password associated with $user.
	 * @return static A new instance with the specified user information.
	 */
	public function withUserInfo($user, $password = null) {
		return new static($this->url->withUserInfo($user, $password));
	}

	/**
	 * @param string $user
	 * @param string|null $password
	 * @return $this
	 */
	public function setUserInfo($user, $password = null) {
		$this->url = $this->url->withUserInfo($user, $password);
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getUsername() {
		$userinfo = $this->getUserInfo();
		if(strlen((string) $userinfo) > 0) {
			list($username) = explode(':', "{$userinfo}:");
			return $username;
		}
		return null;
	}

	/**
	 * @param string $username
	 * @return $this
	 */
	public function setUsername($username) {
		$this->setUserInfo($username, $this->getPassword());
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPassword() {
		$userinfo = $this->getUserInfo();
		if(strpos($userinfo, ':')) {
			list(, $password) = explode(':', "{$userinfo}:");
			return $password;
		}
		return null;
	}

	/**
	 * @param string $password
	 * @return $this
	 */
	public function setPassword($password) {
		$this->setUserInfo($this->getUsername(), $password);
		return $this;
	}

	/**
	 * Retrieve the host component of the URI.
	 * If no host is present, this method MUST return an empty string.
	 * The value returned MUST be normalized to lowercase, per RFC 3986
	 * Section 3.2.2.
	 *
	 * @see http://tools.ietf.org/html/rfc3986#section-3.2.2
	 * @return string The URI host.
	 */
	public function getHost() {
		return $this->url->getHost();
	}

	/**
	 * Return an instance with the specified host.
	 *
	 * This method MUST retain the state of the current instance, and return
	 * an instance that contains the specified host.
	 *
	 * An empty host value is equivalent to removing the host.
	 *
	 * @param string $host The hostname to use with the new instance.
	 * @return static A new instance with the specified host.
	 * @throws \InvalidArgumentException for invalid hostnames.
	 */
	public function withHost($host) {
		return new static($this->url->withHost($host));
	}

	/**
	 * @param string $host
	 * @return $this
	 */
	public function setHost($host) {
		$this->url = $this->url->withHost($host);
		return $this;
	}

	/**
	 * Retrieve the port component of the URI.
	 * If a port is present, and it is non-standard for the current scheme,
	 * this method MUST return it as an integer. If the port is the standard port
	 * used with the current scheme, this method SHOULD return null.
	 * If no port is present, and no scheme is present, this method MUST return
	 * a null value.
	 * If no port is present, but a scheme is present, this method MAY return
	 * the standard port for that scheme, but SHOULD return null.
	 *
	 * @return null|int The URI port.
	 */
	public function getPort() {
		return $this->url->getPort();
	}

	/**
	 * Return an instance with the specified port.
	 * This method MUST retain the state of the current instance, and return
	 * an instance that contains the specified port.
	 * Implementations MUST raise an exception for ports outside the
	 * established TCP and UDP port ranges.
	 * A null value provided for the port is equivalent to removing the port
	 * information.
	 *
	 * @param null|int $port The port to use with the new instance; a null value removes the port information.
	 * @return static A new instance with the specified port.
	 * @throws \InvalidArgumentException for invalid ports.
	 */
	public function withPort($port) {
		return new static($this->url->withPort($port));
	}

	/**
	 * @param int|null $port
	 * @return $this
	 */
	public function setPort($port) {
		$this->url = $this->url->withPort($port);
		return $this;
	}

	/**
	 * Retrieve the path component of the URI.
	 * The path can either be empty or absolute (starting with a slash) or
	 * rootless (not starting with a slash). Implementations MUST support all
	 * three syntaxes.
	 * Normally, the empty path "" and absolute path "/" are considered equal as
	 * defined in RFC 7230 Section 2.7.3. But this method MUST NOT automatically
	 * do this normalization because in contexts with a trimmed base path, e.g.
	 * the front controller, this difference becomes significant. It's the task
	 * of the user to handle both "" and "/".
	 * The value returned MUST be percent-encoded, but MUST NOT double-encode
	 * any characters. To determine what characters to encode, please refer to
	 * RFC 3986, Sections 2 and 3.3.
	 * As an example, if the value should include a slash ("/") not intended as
	 * delimiter between path segments, that value MUST be passed in encoded
	 * form (e.g., "%2F") to the instance.
	 *
	 * @see https://tools.ietf.org/html/rfc3986#section-2
	 * @see https://tools.ietf.org/html/rfc3986#section-3.3
	 * @return string The URI path.
	 */
	public function getPath() {
		return $this->url->getPath();
	}

	/**
	 * Return an instance with the specified path.
	 * This method MUST retain the state of the current instance, and return
	 * an instance that contains the specified path.
	 * The path can either be empty or absolute (starting with a slash) or
	 * rootless (not starting with a slash). Implementations MUST support all
	 * three syntaxes.
	 * If the path is intended to be domain-relative rather than path relative then
	 * it must begin with a slash ("/"). Paths not starting with a slash ("/")
	 * are assumed to be relative to some base path known to the application or
	 * consumer.
	 * Users can provide both encoded and decoded path characters.
	 * Implementations ensure the correct encoding as outlined in getPath().
	 *
	 * @param string $path The path to use with the new instance.
	 * @return static A new instance with the specified path.
	 * @throws \InvalidArgumentException for invalid paths.
	 */
	public function withPath($path) {
		return new static($this->url->withPath($path));
	}

	/**
	 * @param string $path
	 * @return $this
	 */
	public function setPath($path) {
		$this->url = $this->url->withPath($path);
		return $this;
	}

	/**
	 * Retrieve the query string of the URI.
	 * If no query string is present, this method MUST return an empty string.
	 * The leading "?" character is not part of the query and MUST NOT be
	 * added.
	 * The value returned MUST be percent-encoded, but MUST NOT double-encode
	 * any characters. To determine what characters to encode, please refer to
	 * RFC 3986, Sections 2 and 3.4.
	 * As an example, if a value in a key/value pair of the query string should
	 * include an ampersand ("&") not intended as a delimiter between values,
	 * that value MUST be passed in encoded form (e.g., "%26") to the instance.
	 *
	 * @see https://tools.ietf.org/html/rfc3986#section-2
	 * @see https://tools.ietf.org/html/rfc3986#section-3.4
	 * @return string The URI query string.
	 */
	public function getQuery() {
		return $this->url->getQuery();
	}

	/**
	 * Return an instance with the specified query string.
	 * This method MUST retain the state of the current instance, and return
	 * an instance that contains the specified query string.
	 * Users can provide both encoded and decoded query characters.
	 * Implementations ensure the correct encoding as outlined in getQuery().
	 * An empty query string value is equivalent to removing the query string.
	 *
	 * @param string $query The query string to use with the new instance.
	 * @return static A new instance with the specified query string.
	 * @throws \InvalidArgumentException for invalid query strings.
	 */
	public function withQuery($query) {
		return new static($this->url->withQuery($query));
	}

	/**
	 * @param string $query
	 * @return $this
	 */
	public function setQuery($query) {
		$this->url = $this->url->withQuery($query);
		return $this;
	}

	/**
	 * @return array
	 */
	public function getQueryData() {
		$query = (string) $this->getQuery();
		$data = array();
		parse_str($query, $data);
		return $data;
	}

	/**
	 * @param array $data
	 * @return static
	 */
	public function withQueryData(array $data) {
		$query = http_build_query($data);
		return new static($this->url->withQuery($query));
	}

	/**
	 * @param array $data
	 * @return array
	 */
	public function setQueryData(array $data) {
		$query = http_build_query($data);
		$this->setQuery($query);
		return $this;
	}

	/**
	 * Retrieve the fragment component of the URI.
	 * If no fragment is present, this method MUST return an empty string.
	 * The leading "#" character is not part of the fragment and MUST NOT be
	 * added.
	 * The value returned MUST be percent-encoded, but MUST NOT double-encode
	 * any characters. To determine what characters to encode, please refer to
	 * RFC 3986, Sections 2 and 3.5.
	 *
	 * @see https://tools.ietf.org/html/rfc3986#section-2
	 * @see https://tools.ietf.org/html/rfc3986#section-3.5
	 * @return string The URI fragment.
	 */
	public function getFragment() {
		return $this->url->getFragment();
	}

	/**
	 * Return an instance with the specified URI fragment.
	 * This method MUST retain the state of the current instance, and return
	 * an instance that contains the specified URI fragment.
	 * Users can provide both encoded and decoded fragment characters.
	 * Implementations ensure the correct encoding as outlined in getFragment().
	 * An empty fragment value is equivalent to removing the fragment.
	 *
	 * @param string $fragment The fragment to use with the new instance.
	 * @return static A new instance with the specified fragment.
	 */
	public function withFragment($fragment) {
		return new static($this->url->withFragment($fragment));
	}

	/**
	 * @param string $fragment
	 * @return $this
	 */
	public function setFragment($fragment) {
		$this->url = $this->url->withFragment($fragment);
		return $this;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		return $this->url->__toString();
	}
}
