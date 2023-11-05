# OpenSubtitles SDK

[![Latest Version on Packagist](https://img.shields.io/packagist/v/onursimsek/opensubtitles-api.svg?style=flat-square)](https://packagist.org/packages/onursimsek/opensubtitles-api)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Tests](https://github.com/onursimsek/opensubtitles-api/workflows/tests/badge.svg)](https://github.com/onursimsek/opensubtitles-api/actions)
[![Quality Score](https://img.shields.io/scrutinizer/g/onursimsek/opensubtitles-api.svg?style=flat-square)](https://scrutinizer-ci.com/g/onursimsek/opensubtitles-api)
[![Total Downloads](https://img.shields.io/packagist/dt/onursimsek/opensubtitles-api.svg?style=flat-square)](https://packagist.org/packages/onursimsek/opensubtitles-api)

OpenSubtitle.com REST API SDK for PHP

## Installation

You can install the package via composer:

``` bash
composer require onursimsek/opensubtitles-api
```

## Usage

Create a new instance with api key

``` php
$client = new OpenSubtitles();
```

### Auth

``` php
// Login
$auth = $client->authentication->login(['username' => $username, 'password' => $password]);
// You can use short way
// $client->login($username, $password);

// Logout
$client->authentication->logout($auth->token);
```

### Find Subtitles

``` php
// Find subtitles (for all parameters: https://opensubtitles.stoplight.io/docs/opensubtitles-api/open_api.json/paths/~1api~1v1~1subtitles/get)
$subtitles = $client->find([
    'id' => '',
    'query' => '',
    'imdb_id' => '',
    ...
]);

foreach ($subtitles->data as $subtitle) {
    echo $subtitle->id . PHP_EOL;
    echo $subtitle->attributes->language . PHP_EOL;
    echo $subtitle->attributes->feature_details->title . PHP_EOL;
    echo $subtitle->attributes->files[0]->file_id . PHP_EOL;
}

// Find subtitles by title
$subtitles = $client->subtitle->findByTitle('How i met your mother');

// Find subtitles by movie hash
$hash = (new \OpenSubtitles\Hash())->make(__DIR__ . '/../breakdance.avi');
$subtitles = $client->subtitle->findByMovieHash($hash);
```

### Download Subtitle

``` php
$download = $client->download->download($auth->token, $subtitle->attributes->files[0]->file_id);

file_put_contents($subtitle->attributes->feature_details->title . $response->file_name, file_get_contents($response->link));
```
