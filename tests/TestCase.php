<?php

declare(strict_types=1);

namespace Zorah\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Zen\Zorah\ZorahServiceProvider;

abstract class TestCase extends BaseTestCase
{
  /**
   * Set up the test environment.
   */
  protected function setUp(): void
  {
    parent::setUp();

    // Clear any static cache between tests
    \Zen\Zorah\Zorah::clearTranslations();
  }

  /**
   * Get package providers.
   */
  protected function getPackageProviders($app): array
  {
    return [
      ZorahServiceProvider::class,
    ];
  }

  /**
   * Define environment setup.
   */
  protected function defineEnvironment($app): void
  {
    // Setup default database to use sqlite :memory:
    $app['config']->set('database.default', 'testbench');
    $app['config']->set('database.connections.testbench', [
      'driver' => 'sqlite',
      'database' => ':memory:',
      'prefix' => '',
    ]);

    // Setup language path
    $app['config']->set('app.locale', 'en');
    $app['config']->set('app.fallback_locale', 'en');
  }
}
