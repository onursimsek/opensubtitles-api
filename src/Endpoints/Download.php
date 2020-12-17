<?php

declare(strict_types=1);

namespace OpenSubtitles\Endpoints;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use OpenSubtitles\HttpClientHandler;

class Download implements Endpoint
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
     * Request a download url for a subtitle.
     *
     * @param string $accessToken
     * @param int $fileId
     * @param array $params
     * @return mixed
     * @throws GuzzleException
     */
    public function download(string $accessToken, int $fileId, array $params = [])
    {
        return $this->clientHandler->toJson(
            $this->clientHandler->setAccessToken($accessToken)->post(
                $this->baseUrl . '/download',
                [
                    RequestOptions::HEADERS => [
                        // If the accept header dont set, this won't run (response: 406 Not Acceptable)
                        'Accept' => 'application/json',
                        'Content-Type' => 'multipart/form-data',
                    ],
                    RequestOptions::FORM_PARAMS => ['file_id' => $fileId],
                ]
            )
        );
    }
}
