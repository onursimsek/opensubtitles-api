<?php

declare(strict_types=1);

namespace OpenSubtitles;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

class Subtitle
{
    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    private string $baseUrl;
    private ?string $apiKey;

    public function __construct(ClientInterface $client, string $baseUrl, string $apiKey = null)
    {
        $this->client = $client;
        $this->baseUrl = $baseUrl;
        $this->apiKey = $apiKey;
    }

    public function find(array $params)
    {
        $response = $this->client->request(
            'GET',
            $this->baseUrl . '/subtitles',
            [
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Api-Key' => $this->apiKey,
                ],
                RequestOptions::QUERY => $params,
            ]
        );

        return json_decode($response->getBody()->getContents());
    }
}
