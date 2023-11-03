<?php

namespace Ymigval\LaravelSLResponse\Tests;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Orchestra\Testbench\TestCase as TestCaseBase;
use Ymigval\LaravelSLResponse\SLProvider;

class TestCase extends TestCaseBase
{
    /**
     * Get package providers.
     *
     * @param  Application  $app
     *
     * @return array<int, class-string<ServiceProvider>>
     */
    protected function getPackageProviders($app)
    {
        return [
            SLProvider::class
        ];
    }
}
