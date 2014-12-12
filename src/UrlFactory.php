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
	public function __construct(UrlBuilder $builder = null) {
		$this->builder = $builder ?: new UrlBuilder();
	}

	/**
	 * @param string $url
	 * @param null|string $canonical
	 * @return Url
	 */
	public function create($url, $canonical = null) {
		return new Url($url, $canonical, $this->builder);
	}
}