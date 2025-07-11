<?php

declare(strict_types=1);

namespace Zen\Zorah;

use Illuminate\Support\Facades\File;
use SplFileInfo;
use Zen\Zorah\Contracts\Zorah as ZorahContract;

class Zorah implements ZorahContract
{
  /**
   * Local cache property.
   *
   * @var array<string, mixed>
   */
  protected static array $cache = [];

  /**
   * Locales property array.
   *
   * @var array<int, string>
   */
  protected array $locales = [];

  /**
   * Local translations array.
   *
   * @var array<string, mixed>
   */
  protected array $translations = [];

  /**
   * Create a new instance of the class.
   */
  public function __construct()
  {
    $this->locales = $this->makeLocales();

    if (app()->environment('production')) {
      $this->runProduction();

      return;
    }

    $this->translations = $this->makeTranslations();
  }

  /**
   * Run the class with caching in production.
   */
  protected function runProduction(): Zorah
  {
    if (! static::$cache) {
      static::$cache = $this->makeTranslations();
    }

    $this->translations = static::$cache;

    return $this;
  }

  /**
   * Loop through lang directory and get all locales
   * that we need to process for the app.
   *
   * @return array<int, string>
   */
  public function makeLocales(): array
  {
    $locales = [];

    $directories = File::directories(lang_path());

    foreach ($directories as $directory) {
      if (is_string($directory)) {
        $path = str_replace(lang_path().'/', '', $directory);
        $locales[] = $path;
      }
    }

    return $locales;
  }

  /**
   * Static function to clear the cache.
   */
  public static function clearTranslations(): void
  {
    static::$cache = [];
  }

  /**
   * Build our translations.
   *
   * @return array<string, mixed>
   */
  protected function makeTranslations(): array
  {
    $translations = [];

    foreach ($this->locales as $locale) {
      $translations[$locale] = [
        'php' => $this->translatePhp($locale),
        'json' => $this->translateJson($locale),
      ];
    }

    return $translations;
  }

  /**
   * Rollup the PHP language vars.
   *
   * @return array<string, mixed>
   */
  protected function translatePhp(string $locale): array
  {
    $path = lang_path($locale);

    return collect(File::allFiles($path))->flatMap(function (SplFileInfo $file) use ($locale) {
      $key = ($translation = $file->getBasename('.php'));

      return [$key => trans($translation, [], $locale)];
    })->toArray();
  }

  /**
   * Rollup the JSON language vars.
   *
   * @return array<string, mixed>
   */
  protected function translateJson(string $locale): array
  {
    $path = lang_path("$locale.json");

    if (is_readable($path)) {
      $content = file_get_contents($path);
      if ($content !== false) {
        $decoded = json_decode($content, true);
        if (is_array($decoded)) {
          /** @var array<string, mixed> $decoded */
          return $decoded;
        }
      }
    }

    return [];
  }

  /**
   * Convert this Zorah instance to an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(): array
  {
    return [
      'translations' => $this->translations,
    ];
  }

  /**
   * Convert this Zorah instance into something JSON serializable.
   *
   * @return array<string, mixed>
   */
  public function jsonSerialize(): array
  {
    return array_merge($translations = $this->toArray(), [
      'defaults' => (object) $translations['translations'],
    ]);
  }

  /**
   * Convert this Zorah instance to JSON.
   */
  public function toJson(int $options = 0): string
  {
    $json = json_encode($this->jsonSerialize(), $options);

    return $json !== false ? $json : '{}';
  }
}
