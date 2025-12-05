<?php

declare(strict_types=1);

namespace Zen\Zorah\Payloads;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use SplFileInfo;

class TranslationPayload
{
  /**
   * Compile all of the local translations.
   *
   * @param  array<int, string>  $locales
   * @return Collection<string, mixed>
   */
  public static function compile(array $locales = []): Collection
  {
    $payload = new self;

    $translations = [];

    foreach ($locales as $locale) { // supported locales
      $translations[$locale] = [
        'php' => $payload->phpTranslations($locale),
        'json' => $payload->jsonTranslations($locale),
      ];
    }

    return collect($translations);
  }

  /**
   * Compile the PHP file translations.
   *
   * @return Collection<string, mixed>
   */
  private function phpTranslations(string $locale): Collection
  {
    $path = lang_path($locale);

    return collect(File::allFiles($path))->flatMap(function (SplFileInfo $file) use ($locale): array {
      $key = ($translation = $file->getBasename('.php'));

      return [$key => trans($translation, [], $locale)];
    });
  }

  /**
   * Compile the JSON file translations.
   *
   * @return array<string, mixed>
   */
  private function jsonTranslations(string $locale): array
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
}
