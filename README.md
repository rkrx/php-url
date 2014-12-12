php-url
=======

Url-manipulation component

[![Build Status](https://travis-ci.org/rkrx/php-url.svg?branch=master)](https://travis-ci.org/rkrx/php-url) [![SensioLabsInsight](https://insight.sensiolabs.com/projects/932e02c0-c334-420a-ade5-aa4b1aaca19f/mini.png)](https://insight.sensiolabs.com/projects/932e02c0-c334-420a-ade5-aa4b1aaca19f)

```PHP
$url = new Url('/subpath?a=1', 'http://example.org/#test');
echo (string) $url; // http://example.org/subpath?a=1#test

var_dump($url->getScheme());
var_dump($url->getUsername());
var_dump($url->getPassword());
var_dump($url->getHost());
var_dump($url->getPort());
var_dump($url->getPath());
var_dump($url->getQuery());
var_dump($url->getFragment());
```
