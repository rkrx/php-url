<?php

namespace Kir\Url\Tools;

class UrlParts {
	/** @var string|null */
	public $scheme;

	/** @var string|null */
	public $user;
	
	/** @var string|null */
	public $pass;
	
	/** @var string|null */
	public $host;
	
	/** @var int|null */
	public $port;
	
	/** @var string|null */
	public $path;
	
	/** @var array<int|string, int|float|string|array<int|string, mixed>> */
	public $query = [];
	
	/** @var string|null */
	public $fragment;
}