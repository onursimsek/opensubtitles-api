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

        self::assertObjectHasProperty('user', $response);
        self::assertObjectHasProperty('token', $response);
    }

    public function testCanBeLogout()
    {
        $auth = $this->app->authentication->login(['username' => 'USERNAME', 'password' => 'PASSWORD']);
        $response = $this->app->authentication->logout($auth->token);

        self::assertIsObject($response);
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
                $this->logoutMock()
            )
        );
    }
}
