<?php

declare(strict_types=1);

namespace OpenSubtitles\Tests;

use Dotenv\Dotenv;
use OpenSubtitles\OpenSubtitles;
use PHPUnit\Framework\TestCase;

class OpenSubtitlesTest extends TestCase
{
    /**
     * @var OpenSubtitles
     */
    private OpenSubtitles $app;

    public function test_can_be_login()
    {
        $response = $this->app->login(getenv('USERNAME'), getenv('PASSWORD'));

        self::assertObjectHasAttribute('user', $response);
        self::assertObjectHasAttribute('token', $response);
    }

    public function test_can_be_logout()
    {
        $response = $this->app->login(getenv('USERNAME'), getenv('PASSWORD'));

        $response = $this->app->logout($response->token);

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

    public function test_can_be_found_subtitles_with_title()
    {
        $response = $this->app->findByTitle('How i met your mother');

        self::assertObjectHasAttribute('total_pages', $response);
        self::assertObjectHasAttribute('total_count', $response);
        self::assertObjectHasAttribute('page', $response);
        self::assertObjectHasAttribute('data', $response);
    }

    public function test_can_be_found_subtitles_with_movie_hash()
    {
        $response = $this->app->findByMovieHash('b30f3a478e56ba96fdee607a8538265a');

        self::assertObjectHasAttribute('total_pages', $response);
        self::assertObjectHasAttribute('total_count', $response);
        self::assertObjectHasAttribute('page', $response);
        self::assertObjectHasAttribute('data', $response);
    }

    protected function setUp(): void
    {
        Dotenv::createUnsafeImmutable(__DIR__ . '/..')->load();

        $this->app = new OpenSubtitles(getenv('API_KEY'));
    }
}
