<?php

namespace Zen\Zorah;

use Illuminate\Support\ServiceProvider;
use Zen\Zorah\Console\TranslationGenerator;
use Zen\Zorah\Contracts\Zorah as ZorahContract;

class ZorahServiceProvider extends ServiceProvider
{
  /**
   * Boot up our service provider.
   *
   * @return void
   */
  public function boot()
  {
    if ($this->app->runningInConsole()) {
      $this->commands([
        TranslationGenerator::class,
      ]);
    }
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register(): void
  {
    $this->app->singleton(ZorahContract::class, Zorah::class);
  }
}
