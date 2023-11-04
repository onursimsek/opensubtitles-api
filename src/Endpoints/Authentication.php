<?php

declare(strict_types=1);

namespace OpenSubtitles\Endpoints;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use OpenSubtitles\HttpClientHandler;

class Authentication implements Endpoint
{
    /**
     * @var HttpClientHandler
     */
    private HttpClientHandler $clientHandler;

    private array $config;

    public function __construct(ClientInterface $client, array $config)
    {
        $this->clientHandler = new HttpClientHandler($client, $config);
        $this->config = $config;
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
            $this->clientHandler->post($this->config['host'] . '/login', [RequestOptions::JSON => $credentials])
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
            $this->clientHandler->setAccessToken($accessToken)->delete($this->config['host'] . '/logout')
        );
    }
}
