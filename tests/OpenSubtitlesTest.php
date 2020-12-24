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

        self::assertObjectHasAttribute('user', $response);
        self::assertObjectHasAttribute('token', $response);
    }

    public function testCanBeLogout()
    {
        $auth = $this->app->login('USERNAME', 'PASSWORD');
        $response = $this->app->logout($auth->token);

        self::assertIsObject($response);
    }

    public function testCanBeFoundSubtitles()
    {
        $auth = $this->app->login(getenv('USERNAME'), getenv('PASSWORD'));
        $this->app->logout($auth->token);

        $response = $this->app->find(['query' => 'Big Bang Theory']);

        self::assertObjectHasAttribute('total_pages', $response);
        self::assertObjectHasAttribute('total_count', $response);
        self::assertObjectHasAttribute('page', $response);
        self::assertObjectHasAttribute('data', $response);
    }

    public function testCannotBeRunUnsupportedEndpoint()
    {
        self::expectException(UnsupportedEndpoint::class);

        $this->app->unsupported;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app = new OpenSubtitles(
            getenv('API_KEY'),
            $this->getClient(
                $this->loginMock(),
                $this->logoutMock(),
                $this->findSubtitleMock(),
            )
        );
    }
}
