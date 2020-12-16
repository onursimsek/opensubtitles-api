<?php

declare(strict_types=1);

namespace OpenSubtitles;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use OpenSubtitles\Endpoints\Authentication;
use OpenSubtitles\Endpoints\Endpoint;
use OpenSubtitles\Endpoints\Subtitle;
use OpenSubtitles\Exceptions\UnsupportedEndpoint;

/**
 * Class OpenSubtitles
 * @package OpenSubtitles
 *
 * @property Authentication $authentication;
 * @property Subtitle $subtitle;
 */
class OpenSubtitles
{
    private string $baseUrl = 'https://www.opensubtitles.com/api/v1';

    private ?string $apiKey;

    /**
     * @var Client
     */
    private Client $client;

    private array $routes = [
        'authentication' => Authentication::class,
        'subtitle' => Subtitle::class,
    ];

    private array $container = [];

    public function __construct(string $apiKey = null)
    {
        $this->client = new Client();
        $this->apiKey = $apiKey;
    }

    /**
     * Create a token to authenticate a user
     *
     * @param string $username
     * @param string $password
     * @return mixed
     * @throws GuzzleException
     */
    public function login(string $username, string $password)
    {
        return (new Authentication($this->client, $this->baseUrl, $this->apiKey))->login(
            compact('username', 'password')
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
        return (new Authentication($this->client, $this->baseUrl, $this->apiKey))->logout($accessToken);
    }

    /**
     * Find subtitle for a movie or tv show
     *
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function find(array $params)
    {
        return (new Subtitle($this->client, $this->baseUrl, $this->apiKey))->find($params);
    }

    /**
     * @param $name
     * @return Endpoint
     * @throws UnsupportedEndpoint
     */
    public function __get($name): Endpoint
    {
        $key = strtolower($name);
        if (!array_key_exists($key, $this->routes)) {
            throw new UnsupportedEndpoint();
        }

        return $this->instanceFromContainer($key)
            ?: $this->container[$key] = (new $this->routes[$key]($this->client, $this->baseUrl, $this->apiKey));
    }

    /**
     * @param $key
     * @return mixed|null
     */
    private function instanceFromContainer($key): ?Endpoint
    {
        if (!array_key_exists($key, $this->container)) {
            return null;
        }

        return $this->container[$key];
    }
}
