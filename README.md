php-url
=======

Url-manipulation component

[![Build Status](https://travis-ci.org/rkrx/php-url.svg?branch=master)](https://travis-ci.org/rkrx/php-url)

```PHP
$url = new Url('/subpath?a=1', 'http://example.org/#test');
echo (string) $url; // http://example.org/subpath?a=1#test
```