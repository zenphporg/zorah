<?php

declare(strict_types=1);

namespace Zen\Zorah\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\File;
use Zen\Zorah\Payloads\TranslationPayload;

class TranslationGenerator extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'zorah:generate {path?} {--js : Generate JavaScript instead of TypeScript}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Generate translation file for including in build process';

  /**
   * Create a new console command instance.
   *
   * @return void
   */
  public function __construct(/**
   * Filesystem instance for moving files.
   */
    protected Filesystem $files)
  {
    parent::__construct();
  }

  /**
   * Process the command.
   */
  public function handle(): void
  {
    $useJs = $this->option('js');
    $path = $this->argument('path');

    if ($path === null) {
      $extension = $useJs ? 'js' : 'ts';
      $path = "./resources/js/zorah.{$extension}";
    }

    if (! is_string($path)) {
      $this->error('Invalid path argument');

      return;
    }

    $file = $useJs ? $this->generateJs() : $this->generateTs();

    $this->makeDirectory($path);

    $this->files->put($path, $file);

    $this->info('Translations file generated.');
  }

  /**
   * Generate the TypeScript translations file.
   */
  public function generateTs(): string
  {
    $json = $this->getTranslationsJson();

    return <<<EOT
import type { ZorahConfig } from 'zorah-js'

const Zorah: ZorahConfig = { translations: $json }

if (typeof window !== 'undefined' && typeof window.Zorah !== 'undefined') {
  Object.assign(Zorah.translations, window.Zorah.translations);
}

export { Zorah }

EOT;
  }

  /**
   * Generate the JavaScript translations file.
   */
  public function generateJs(): string
  {
    $json = $this->getTranslationsJson();

    return <<<EOT
const Zorah = { translations: $json }

if (typeof window !== 'undefined' && typeof window.Zorah !== 'undefined') {
  Object.assign(Zorah.translations, window.Zorah.translations);
}

export { Zorah }

EOT;
  }

  /**
   * Get the translations JSON string.
   */
  protected function getTranslationsJson(): string
  {
    $locales = [];

    $directories = File::directories(lang_path());

    foreach ($directories as $directory) {
      if (is_string($directory)) {
        $path = str_replace(lang_path().DIRECTORY_SEPARATOR, '', $directory);
        $locales[] = $path;
      }
    }

    return TranslationPayload::compile($locales)->toJson();
  }

  /**
   * Generate the translations for the file.
   */
  public function generate(): string
  {
    return $this->generateJs();
  }

  /**
   * Make the directory if it doesn't exist.
   */
  protected function makeDirectory(string $path): string
  {
    if (! $this->files->isDirectory(dirname($path))) {
      $this->files->makeDirectory(dirname($path), 0777, true, true);
    }

    return $path;
  }
}
