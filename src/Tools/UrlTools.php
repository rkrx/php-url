<?php

namespace Kir\Url\Tools;

class UrlTools {
	/**
	 * @param string|null $input
	 * @return array<string, string|int>
	 */
	public static function parseUrl(?string $input) {
		if($input === null) {
			return array();
		}
		$urlData = parse_url($input);
		if($urlData === false) {
			return array();
		}
		return $urlData;
	}
	
	/**
	 * @param string|null $input
	 * @param int<0, max> $component
	 * @return string|null
	 */
	public static function parseUrlComponent(?string $input, int $component) {
		if($input === null) {
			return null;
		}
		/** @var string|int|false|null $urlData */
		$urlData = parse_url($input, $component);
		if($urlData === null || $urlData === false) {
			return null;
		}
		return (string) $urlData;
	}
	
	/**
	 * @param string|null $input
	 * @return array<int|string, string|array<int|string, mixed>>
	 */
	public static function parseQuery($input) {
		if($input === null) {
			return array();
		}
		$query = array();
		parse_str($input, $query);
		return $query;
	}
	
	/**
	 * @template T
	 * @param T ...$args
	 * @return T|null
	 */
	public static function coalesce(...$args) {
		foreach($args as $arg) {
			if($arg !== null) {
				return $arg;
			}
		}
		return null;
	}
}