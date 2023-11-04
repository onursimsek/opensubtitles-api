<?php

declare(strict_types=1);

namespace OpenSubtitles\Endpoints;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use OpenSubtitles\HttpClientHandler;

class Subtitle implements Endpoint
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
            $this->clientHandler->get($this->config['host'] . '/subtitles', [RequestOptions::QUERY => $params])
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
