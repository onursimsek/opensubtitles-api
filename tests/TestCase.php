<?php

declare(strict_types=1);

namespace OpenSubtitles\Tests;

use Dotenv\Dotenv;
use OpenSubtitles\OpenSubtitles;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    /**
     * @var OpenSubtitles
     */
    protected OpenSubtitles $app;

    protected function setUp(): void
    {
        Dotenv::createUnsafeImmutable(__DIR__ . '/..')->load();

        $this->app = new OpenSubtitles(getenv('API_KEY'));
    }
}