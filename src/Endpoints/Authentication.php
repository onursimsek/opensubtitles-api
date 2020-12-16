<?php

declare(strict_types=1);

namespace OpenSubtitles\Endpoints;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use OpenSubtitles\HttpClientHandler;

class Authentication implements Endpoint
{
    private string $baseUrl;

    /**
     * @var HttpClientHandler
     */
    private HttpClientHandler $clientHandler;

    public function __construct(ClientInterface $client, string $baseUrl, string $apiKey = null)
    {
        $this->baseUrl = $baseUrl;

        $this->clientHandler = new HttpClientHandler($client);
        if ($apiKey) {
            $this->clientHandler->setApiKey($apiKey);
        }
    }

    /**
     * Create a token to authenticate a user
     *
     * @param array $credentials
     * @return mixed
     * @throws GuzzleException
     */
    public function login(array $credentials)
    {
        return $this->clientHandler->toJson(
            $this->clientHandler->post($this->baseUrl . '/login', [RequestOptions::JSON => $credentials])
        );
    }

    /**
     * Destroy a user token to end a session
     *
     * @param string $accessToken
     * @return mixed
     * @throws GuzzleException
     */
    public function logout(string $accessToken)
    {
        return $this->clientHandler->toJson(
            $this->clientHandler->setAccessToken($accessToken)->delete($this->baseUrl . '/logout')
        );
    }
}
