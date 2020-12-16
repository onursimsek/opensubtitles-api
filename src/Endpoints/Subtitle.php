<?php

declare(strict_types=1);

namespace OpenSubtitles\Endpoints;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use OpenSubtitles\HttpClientHandler;

class Subtitle implements Endpoint
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
     * Find subtitle by title
     *
     * @param string $title
     * @return mixed
     * @throws GuzzleException
     */
    public function findByTitle(string $title)
    {
        return $this->findByQuery($title);
    }

    /**
     * Find subtitle by query
     *
     * @param string $query
     * @return mixed
     * @throws GuzzleException
     */
    public function findByQuery(string $query)
    {
        return $this->find(compact('query'));
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
        return $this->clientHandler->toJson(
            $this->clientHandler->get($this->baseUrl . '/subtitles', [RequestOptions::QUERY => $params])
        );
    }

    /**
     * Find subtitle by movie hash
     *
     * @param string $hash
     * @return mixed
     * @throws GuzzleException
     */
    public function findByMovieHash(string $hash)
    {
        return $this->find(['moviehash' => $hash]);
    }
}
