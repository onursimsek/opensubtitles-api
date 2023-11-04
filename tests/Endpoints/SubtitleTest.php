<?php

namespace OpenSubtitles\Tests\Endpoints;

use OpenSubtitles\OpenSubtitles;
use OpenSubtitles\Tests\TestCase;

class SubtitleTest extends TestCase
{
    public function testCanBeFoundSubtitlesWithTitle()
    {
        $response = $this->app->subtitle->findByTitle('How i met your mother');

        self::assertObjectHasProperty('total_pages', $response);
        self::assertObjectHasProperty('total_count', $response);
        self::assertObjectHasProperty('page', $response);
        self::assertObjectHasProperty('data', $response);
    }

    public function testCanBeFoundSubtitlesWithMovieHash()
    {
        $response = $this->app->subtitle->findByMovieHash('b30f3a478e56ba96fdee607a8538265a');

        self::assertObjectHasProperty('total_pages', $response);
        self::assertObjectHasProperty('total_count', $response);
        self::assertObjectHasProperty('page', $response);
        self::assertObjectHasProperty('data', $response);
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
                $this->findSubtitleMock()
            )
        );
    }
}
