<?php

declare(strict_types=1);

namespace Zen\Zorah;

use Illuminate\Support\ServiceProvider;
use Override;
use Zen\Zorah\Console\TranslationGenerator;
use Zen\Zorah\Contracts\Zorah as ZorahContract;

class ZorahServiceProvider extends ServiceProvider
{
  /**
   * Boot up our service provider.
   */
  public function boot(): void
  {
    if ($this->app->runningInConsole()) {
      $this->commands([
        TranslationGenerator::class,
      ]);
    }
  }

  /**
   * Register any application services.
   */
  #[Override]
  public function register(): void
  {
    $this->app->singleton(ZorahContract::class, Zorah::class);
  }
}
