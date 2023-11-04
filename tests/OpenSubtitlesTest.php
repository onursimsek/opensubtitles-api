<?php

declare(strict_types=1);

namespace OpenSubtitles\Tests;

use OpenSubtitles\Exceptions\UnsupportedEndpoint;
use OpenSubtitles\OpenSubtitles;

class OpenSubtitlesTest extends TestCase
{
    public function testCanBeLogin()
    {
        $response = $this->app->login('USERNAME', 'PASSWORD');

        self::assertObjectHasProperty('user', $response);
        self::assertObjectHasProperty('token', $response);
    }

    public function testCanBeLogout()
    {
        $auth = $this->app->login('USERNAME', 'PASSWORD');
        $response = $this->app->logout($auth->token);

        self::assertIsObject($response);
    }

    public function testCanBeFoundSubtitles()
    {
        $auth = $this->app->login('USERNAME', 'PASSWORD');
        $this->app->logout($auth->token);

        $response = $this->app->find(['query' => 'Big Bang Theory']);

        self::assertObjectHasProperty('total_pages', $response);
        self::assertObjectHasProperty('total_count', $response);
        self::assertObjectHasProperty('page', $response);
        self::assertObjectHasProperty('data', $response);
    }

    public function testCannotBeRunUnsupportedEndpoint()
    {
        self::expectException(UnsupportedEndpoint::class);

        $this->app->unsupported;
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
                $this->logoutMock(),
                $this->findSubtitleMock(),
            )
        );
    }
}
