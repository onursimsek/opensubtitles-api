<?php

declare(strict_types=1);

namespace OpenSubtitles;

use GuzzleHttp\Client;

class OpenSubtitles
{
    private string $baseUrl = 'https://www.opensubtitles.com/api/v1';

    private ?string $apiKey;

    /**
     * @var Client
     */
    private Client $client;

    public function __construct(string $apiKey = null)
    {
        $this->client = new Client();
        $this->apiKey = $apiKey;
    }

    public function login(string $username, string $password)
    {
        return (new Authentication($this->client, $this->baseUrl, $this->apiKey))->login(
            compact('username', 'password')
        );
    }

    public function logout(string $accessToken)
    {
        return (new Authentication($this->client, $this->baseUrl, $this->apiKey))->logout($accessToken);
    }

    public function find(array $params)
    {
        return (new Subtitle($this->client, $this->baseUrl, $this->apiKey))->find($params);
    }

    public function findByQuery(string $query)
    {
        return $this->find(compact('query'));
    }

    public function findByTitle(string $title)
    {
        return $this->findByQuery($title);
    }

    public function findByMovieHash(string $hash)
    {
        return $this->find(['moviehash' => $hash]);
    }
}
