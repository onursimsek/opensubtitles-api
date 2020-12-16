<?php

declare(strict_types=1);

namespace OpenSubtitles\Tests;

use OpenSubtitles\Exceptions\UnsupportedEndpoint;

class OpenSubtitlesTest extends TestCase
{
    public function test_can_be_login()
    {
        $response = $this->app->login(getenv('USERNAME'), getenv('PASSWORD'));

        self::assertObjectHasAttribute('user', $response);
        self::assertObjectHasAttribute('token', $response);
    }

    public function test_can_be_logout()
    {
        $auth = $this->app->login(getenv('USERNAME'), getenv('PASSWORD'));
        $response = $this->app->logout($auth->token);

        self::assertIsObject($response);
    }

    public function test_can_be_found_subtitles()
    {
        $response = $this->app->find(['query' => 'Big Bang Theory']);

        self::assertObjectHasAttribute('total_pages', $response);
        self::assertObjectHasAttribute('total_count', $response);
        self::assertObjectHasAttribute('page', $response);
        self::assertObjectHasAttribute('data', $response);
    }

    public function test_cannot_be_run_unsupported_endpoint()
    {
        self::expectException(UnsupportedEndpoint::class);

        $this->app->unsupported;
    }
}
