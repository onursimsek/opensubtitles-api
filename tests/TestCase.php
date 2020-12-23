<?php

declare(strict_types=1);

namespace OpenSubtitles\Tests;

use Dotenv\Dotenv;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use OpenSubtitles\OpenSubtitles;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    protected OpenSubtitles $app;

    protected function setUp(): void
    {
        Dotenv::createUnsafeImmutable(__DIR__ . '/..')->load();
    }

    protected function getClient(...$response): Client
    {
        return new Client(
            [
                'handler' => HandlerStack::create(new MockHandler($response))
            ]
        );
    }

    protected function loginMock(): Response
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(
                [
                    'user' => '',
                    'token' => '',
                ]
            )
        );
    }

    protected function logoutMock(): Response
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(new \stdClass())
        );
    }

    protected function findSubtitleMock()
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(
                [
                    'total_pages' => 1,
                    'total_count' => 5,
                    'page' => 5,
                    'data' => [
                        [
                            'attributes' => [
                                'files' => [
                                    ['file_id' => 12345],
                                ],
                            ]
                        ]
                    ],
                ]
            )
        );
    }

    protected function downloadMock()
    {
        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode(
                [
                    'link' => '',
                    'file_name' => '',
                    'requests' => '',
                    'allowed' => '',
                    'remaining' => '',
                    'message' => '',
                ]
            )
        );
    }
}
