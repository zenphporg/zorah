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
  protected $signature = 'zorah:generate {path=./resources/js/zorah.js}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Generate translation js file for including in build process';

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
    $path = $this->argument('path');
    if (! is_string($path)) {
      $this->error('Invalid path argument');

      return;
    }

    $file = $this->generate();

    $this->makeDirectory($path);

    $this->files->put($path, $file);

    $this->info('Translations file generated.');
  }

  /**
   * Generate the translations for the file.
   */
  public function generate(): string
  {
    $locales = [];

    $directories = File::directories(lang_path());

    foreach ($directories as $directory) {
      if (is_string($directory)) {
        $path = str_replace(lang_path().DIRECTORY_SEPARATOR, '', $directory);
        $locales[] = $path;
      }
    }

    $json = TranslationPayload::compile($locales)->toJson();

    return <<<EOT
const Zorah = { translations: $json }

if (typeof window !== 'undefined' && typeof window.Zorah !== 'undefined') {
  Object.assign(Zorah.translations, window.Zorah.translations);
}

export { Zorah }

EOT;
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
