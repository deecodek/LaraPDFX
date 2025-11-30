<?php

namespace Deecodek\LaraPDFX\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Deecodek\LaraPDFX\LaraPDFXServiceProvider;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app): array
    {
        return [
            LaraPDFXServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'PDF' => \Deecodek\LaraPDFX\Facades\PDF::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('larapdfx.timeout', 30);
        config()->set('larapdfx.paper.format', 'A4');
    }
}
