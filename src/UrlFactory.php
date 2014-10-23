<?php
namespace Kir\Url;

use Kir\Url\Tools\UrlBuilder;

class UrlFactory {
	/**
	 * @var UrlBuilder
	 */
	private $builder;

	/**
	 * @param UrlBuilder $builder
	 */
	public function __construct(UrlBuilder $builder) {
		$this->builder = $builder;
	}

	/**
	 * @param string $url
	 * @param null|string $canonical
	 * @return Url
	 */
	public function create($url, $canonical = null) {
	}
}