<?php

declare(strict_types=1);

namespace OpenSubtitles\Tests\Endpoints;

use OpenSubtitles\OpenSubtitles;
use OpenSubtitles\Tests\TestCase;

class DownloadTest extends TestCase
{
    public function testCanBeDownloadedASubtitle()
    {
        $auth = $this->app->login('USERNAME', 'PASSWORD');
        $movie = $this->app->subtitle->findByTitle('The Matrix');

        $response = $this->app->download->download($auth->token, $movie->data[0]->attributes->files[0]->file_id);

        self::assertObjectHasProperty('link', $response);
        self::assertObjectHasProperty('file_name', $response);
        self::assertObjectHasProperty('requests', $response);
        self::assertObjectHasProperty('allowed', $response);
        self::assertObjectHasProperty('remaining', $response);
        self::assertObjectHasProperty('message', $response);
    }

    protected function setUp(): void
    {
        $this->app = new OpenSubtitles(
            [
                'host' => 'HOST',
                'api_key' => 'API_KEY',
                'app_name' => 'APP_NAME',
            ],
            $this->getClient(
                $this->loginMock(),
                $this->findSubtitleMock(),
                $this->downloadMock()
            )
        );
    }
}
