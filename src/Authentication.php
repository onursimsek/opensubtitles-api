<?php

declare(strict_types=1);

namespace OpenSubtitles;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\RequestOptions;

class Authentication
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

    public function login(array $credentials)
    {
        $response = $this->client->request(
            'POST',
            $this->baseUrl . '/login',
            [
                RequestOptions::HEADERS => [
                    'Content-Type' => 'application/json',
                    'Api-Key' => $this->apiKey,
                ],
                RequestOptions::JSON => $credentials,
            ]
        );

        return json_decode($response->getBody()->getContents());
    }

    public function logout(string $accessToken)
    {
        $response = $this->client->request(
            'DELETE',
            $this->baseUrl . '/logout',
            [
                RequestOptions::HEADERS => [
                    'Authorization' => 'Bearer ' . $accessToken,
                    'Api-Key' => $this->apiKey,
                ],
            ]
        );

        return json_decode($response->getBody()->getContents());
    }
}
