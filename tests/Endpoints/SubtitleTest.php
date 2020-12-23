<?php

namespace OpenSubtitles\Tests\Endpoints;

use OpenSubtitles\OpenSubtitles;
use OpenSubtitles\Tests\TestCase;

class SubtitleTest extends TestCase
{
    public function test_can_be_found_subtitles_with_title()
    {
        $response = $this->app->subtitle->findByTitle('How i met your mother');

        self::assertObjectHasAttribute('total_pages', $response);
        self::assertObjectHasAttribute('total_count', $response);
        self::assertObjectHasAttribute('page', $response);
        self::assertObjectHasAttribute('data', $response);
    }

    public function test_can_be_found_subtitles_with_movie_hash()
    {
        $response = $this->app->subtitle->findByMovieHash('b30f3a478e56ba96fdee607a8538265a');

        self::assertObjectHasAttribute('total_pages', $response);
        self::assertObjectHasAttribute('total_count', $response);
        self::assertObjectHasAttribute('page', $response);
        self::assertObjectHasAttribute('data', $response);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->app = new OpenSubtitles(
            getenv('API_KEY'),
            $this->getClient(
                $this->findSubtitleMock()
            )
        );
    }
}
