<?php

declare(strict_types=1);

namespace OpenSubtitles\Tests\Endpoints;

use OpenSubtitles\Tests\TestCase;

class DownloadTest extends TestCase
{
    public function test_can_be_downloaded_a_subtitle()
    {
        $auth = $this->app->login(getenv('USERNAME'), getenv('PASSWORD'));
        $movie = $this->app->subtitle->findByTitle('The Matrix');

        $response = $this->app->download->download($auth->token, $movie->data[0]->attributes->files[0]->file_id);

        self::assertObjectHasAttribute('link', $response);
        self::assertObjectHasAttribute('file_name', $response);
        self::assertObjectHasAttribute('requests', $response);
        self::assertObjectHasAttribute('allowed', $response);
        self::assertObjectHasAttribute('remaining', $response);
        self::assertObjectHasAttribute('message', $response);
    }
}
