<?php

declare(strict_types=1);

namespace OpenSubtitles;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;

use function json_decode;

final class HttpClientHandler
{
    /**
     * @var ClientInterface
     */
    protected ClientInterface $client;

    private array $options;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;

        $this->options = [
            RequestOptions::HEADERS => [
                'Content-Type' => 'application/json',
            ]
        ];
    }

    /**
     * Set api key on the header
     *
     * @param string $apiKey
     * @return $this
     */
    final public function setApiKey(string $apiKey): self
    {
        $this->options[RequestOptions::HEADERS]['Api-Key'] = $apiKey;
        return $this;
    }

    /**
     * Set access token on the header
     *
     * @param string $accessToken
     * @return $this
     */
    final public function setAccessToken(string $accessToken): self
    {
        $this->options[RequestOptions::HEADERS]['Authorization'] = 'Bearer ' . $accessToken;
        return $this;
    }

    /**
     * Get request with the http client
     *
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    final public function get(string $uri, array $options = []): ResponseInterface
    {
        return $this->sendRequest('GET', $uri, $options);
    }

    /**
     * Send request with the http client
     *
     * @param string $method
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    final private function sendRequest(string $method, string $uri, array $options): ResponseInterface
    {
        return $this->client->request($method, $uri, $options + $this->options);
    }

    /**
     * Post request with the http client
     *
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    final public function post(string $uri, array $options = []): ResponseInterface
    {
        return $this->sendRequest('POST', $uri, $options);
    }

    /**
     * Delete request with the http client
     *
     * @param string $uri
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     */
    final public function delete(string $uri, array $options = []): ResponseInterface
    {
        return $this->sendRequest('DELETE', $uri, $options);
    }

    /**
     * @param ResponseInterface $response
     * @return mixed
     */
    final public function toJson(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents());
    }
}
