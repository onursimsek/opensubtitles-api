<?php

declare(strict_types=1);

namespace OpenSubtitles\Tests\Endpoints;

use OpenSubtitles\OpenSubtitles;
use OpenSubtitles\Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function testCanBeLogin()
    {
        $response = $this->app->authentication->login(['username' => 'USERNAME', 'password' => 'PASSWORD']);

        self::assertObjectHasAttribute('user', $response);
        self::assertObjectHasAttribute('token', $response);
    }

    public function testCanBeLogout()
    {
        $auth = $this->app->authentication->login(['username' => 'USERNAME', 'password' => 'PASSWORD']);
        $response = $this->app->authentication->logout($auth->token);

        self::assertIsObject($response);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app = new OpenSubtitles(
            getenv('API_KEY'),
            $this->getClient(
                $this->loginMock(),
                $this->logoutMock()
            )
        );
    }
}
