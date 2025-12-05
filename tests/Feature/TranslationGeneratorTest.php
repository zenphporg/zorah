<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

beforeEach(function () {
  // Create test language files
  setupTestLanguageFiles();
});

afterEach(function () {
  // Clean up test files
  cleanupTestFiles();
});

it('generates TypeScript file by default', function () {
  $exitCode = Artisan::call('zorah:generate');

  expect($exitCode)->toBe(0);
  expect(Artisan::output())->toContain('Translations file generated.');
});

it('generates translation file with custom path', function () {
  $customPath = './test_translations.ts';

  $exitCode = Artisan::call('zorah:generate', ['path' => $customPath]);

  expect($exitCode)->toBe(0);
  expect(File::exists($customPath))->toBeTrue();

  // Clean up
  if (File::exists($customPath)) {
    File::delete($customPath);
  }
});

it('generates valid TypeScript output by default', function () {
  $testPath = './test_output.ts';

  Artisan::call('zorah:generate', ['path' => $testPath]);

  expect(File::exists($testPath))->toBeTrue();

  $content = File::get($testPath);
  expect($content)->toContain("import type { ZorahConfig } from 'zorah-js'");
  expect($content)->toContain('const Zorah: ZorahConfig = { translations:');
  expect($content)->toContain('export { Zorah }');
  expect($content)->toContain('if (typeof window !== \'undefined\'');

  // Clean up
  File::delete($testPath);
});

it('generates valid JavaScript output with --js flag', function () {
  $testPath = './test_output.js';

  Artisan::call('zorah:generate', ['path' => $testPath, '--js' => true]);

  expect(File::exists($testPath))->toBeTrue();

  $content = File::get($testPath);
  expect($content)->not->toContain('import type { ZorahConfig }');
  expect($content)->toContain('const Zorah = { translations:');
  expect($content)->toContain('export { Zorah }');
  expect($content)->toContain('if (typeof window !== \'undefined\'');

  // Clean up
  File::delete($testPath);
});

it('creates directories when they do not exist', function () {
  $testPath = './test_dir/nested/translations.ts';

  // Ensure directory doesn't exist
  if (File::exists('./test_dir')) {
    File::deleteDirectory('./test_dir');
  }

  Artisan::call('zorah:generate', ['path' => $testPath]);

  expect(File::exists($testPath))->toBeTrue();
  expect(File::isDirectory('./test_dir/nested'))->toBeTrue();

  // Clean up
  File::deleteDirectory('./test_dir');
});

it('handles multiple locales correctly', function () {
  // Create test language files for multiple locales
  createTestTranslations();

  $testPath = './test_multilang.ts';

  Artisan::call('zorah:generate', ['path' => $testPath]);

  expect(File::exists($testPath))->toBeTrue();

  $content = File::get($testPath);
  expect($content)->toContain('"en"');
  expect($content)->toContain('"es"');

  // Clean up
  File::delete($testPath);
});

it('uses default ts extension when no path provided', function () {
  Artisan::call('zorah:generate');

  expect(File::exists('./resources/js/zorah.ts'))->toBeTrue();

  // Clean up
  File::delete('./resources/js/zorah.ts');
});

it('uses default js extension when --js flag provided without path', function () {
  Artisan::call('zorah:generate', ['--js' => true]);

  expect(File::exists('./resources/js/zorah.js'))->toBeTrue();

  // Clean up
  File::delete('./resources/js/zorah.js');
});

it('generate method returns JavaScript output', function () {
  $filesystem = app(\Illuminate\Filesystem\Filesystem::class);
  $command = new \Zen\Zorah\Console\TranslationGenerator($filesystem);

  $output = $command->generate();

  expect($output)->toContain('const Zorah = { translations:');
  expect($output)->toContain('export { Zorah }');
  expect($output)->not->toContain('import type { ZorahConfig }');
});

it('handles invalid path argument', function () {
  // Create a custom command instance to test error handling
  $filesystem = app(\Illuminate\Filesystem\Filesystem::class);
  $errorCalled = false;

  // Create a test command that simulates invalid path
  $command = new class($filesystem, $errorCalled) extends \Zen\Zorah\Console\TranslationGenerator
  {
    private bool $errorCalled;

    public function __construct(\Illuminate\Filesystem\Filesystem $files, bool &$errorCalled)
    {
      parent::__construct($files);
      $this->errorCalled = &$errorCalled;
    }

    public function option($key = null)
    {
      if ($key === 'js') {
        return false;
      }

      return null;
    }

    public function argument($key = null)
    {
      if ($key === 'path') {
        return ['invalid', 'array']; // Return non-string to trigger error
      }

      return parent::argument($key);
    }

    public function error($string, $verbosity = null)
    {
      expect($string)->toBe('Invalid path argument');
      $this->errorCalled = true;

      return $this;
    }

    public function generateTs(): string
    {
      throw new Exception('Generate should not be called');
    }

    public function generateJs(): string
    {
      throw new Exception('Generate should not be called');
    }
  };

  // This should trigger the error path and return early
  $command->handle();

  // Test passes if we get here without exception
  expect($errorCalled)->toBeTrue();
});

// Helper methods for setting up test environment
function setupTestLanguageFiles()
{
  // Create basic language structure if it doesn't exist
  $langPath = lang_path();

  if (! File::exists($langPath)) {
    File::makeDirectory($langPath, 0755, true);
  }

  $enPath = lang_path('en');
  if (! File::exists($enPath)) {
    File::makeDirectory($enPath, 0755, true);
  }
}

function cleanupTestFiles()
{
  // Clean up any test files created during testing
  $testFiles = [
    './test_translations.ts',
    './test_translations.js',
    './test_output.ts',
    './test_output.js',
    './test_multilang.ts',
    './test_multilang.js',
    './resources/js/zorah.ts',
    './resources/js/zorah.js',
  ];

  foreach ($testFiles as $file) {
    if (File::exists($file)) {
      File::delete($file);
    }
  }

  if (File::exists('./test_dir')) {
    File::deleteDirectory('./test_dir');
  }
}

function createTestTranslations()
{
  // Create test language directories and files
  $locales = ['en', 'es'];

  foreach ($locales as $locale) {
    $localePath = lang_path($locale);
    if (! File::exists($localePath)) {
      File::makeDirectory($localePath, 0755, true);
    }

    // Create a basic messages file
    $messagesFile = $localePath.'/messages.php';
    File::put($messagesFile, "<?php\n\nreturn [\n    'welcome' => 'Welcome',\n    'hello' => 'Hello :name',\n];");

    // Create a basic JSON file
    $jsonFile = lang_path($locale.'.json');
    File::put($jsonFile, json_encode([
      'Hello' => $locale === 'en' ? 'Hello' : 'Hola',
      'Goodbye' => $locale === 'en' ? 'Goodbye' : 'Adiós',
    ]));
  }
}
