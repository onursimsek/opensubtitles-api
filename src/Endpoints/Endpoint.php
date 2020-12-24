<?php

declare(strict_types=1);

namespace OpenSubtitles\Endpoints;

use GuzzleHttp\ClientInterface;

interface Endpoint
{
    public function __construct(ClientInterface $client, string $baseUrl, string $apiKey = null);
}
