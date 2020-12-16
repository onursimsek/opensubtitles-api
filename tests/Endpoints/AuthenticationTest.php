<?php

declare(strict_types=1);

namespace OpenSubtitles\Tests\Endpoints;

use OpenSubtitles\Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_can_be_login()
    {
        $response = $this->app->authentication->login(
            ['username' => getenv('USERNAME'), 'password' => getenv('PASSWORD')]
        );

        self::assertObjectHasAttribute('user', $response);
        self::assertObjectHasAttribute('token', $response);
    }

    public function test_can_be_logout()
    {
        $auth = $this->app->authentication->login(
            ['username' => getenv('USERNAME'), 'password' => getenv('PASSWORD')]
        );
        $response = $this->app->authentication->logout($auth->token);

        self::assertIsObject($response);
    }
}
