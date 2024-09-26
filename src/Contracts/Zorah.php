<?php

namespace Zen\Zorah\Contracts;

use JsonSerializable;

interface Zorah extends JsonSerializable
{
  /**
   * Make the class json serialized.
   */
  public function jsonSerialize(): array;

  /**
   * Convert this Zorah instance to an array.
   */
  public function toArray(): array;

  /**
   * Static function to clear the cache.
   */
  public static function clearTranslations(): void;

  /**
   * Loop through lang directory and get all locales
   * that we need to process for the app.
   */
  public function makeLocales(): array;

  /**
   * Convert this Zorah instance to JSON.
   */
  public function toJson(int $options = 0): string;
}
