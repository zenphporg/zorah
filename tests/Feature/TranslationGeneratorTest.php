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

it('generates translation file with default path', function () {
  $exitCode = Artisan::call('zorah:generate');

  expect($exitCode)->toBe(0);
  expect(Artisan::output())->toContain('Translations file generated.');
});

it('generates translation file with custom path', function () {
  $customPath = './test_translations.js';

  $exitCode = Artisan::call('zorah:generate', ['path' => $customPath]);

  expect($exitCode)->toBe(0);
  expect(File::exists($customPath))->toBeTrue();

  // Clean up
  if (File::exists($customPath)) {
    File::delete($customPath);
  }
});

it('generates valid JavaScript output', function () {
  $testPath = './test_output.js';

  Artisan::call('zorah:generate', ['path' => $testPath]);

  expect(File::exists($testPath))->toBeTrue();

  $content = File::get($testPath);
  expect($content)->toContain('const Zorah = { translations:');
  expect($content)->toContain('export { Zorah }');
  expect($content)->toContain('if (typeof window !== \'undefined\'');

  // Clean up
  File::delete($testPath);
});

it('creates directories when they do not exist', function () {
  $testPath = './test_dir/nested/translations.js';

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

  $testPath = './test_multilang.js';

  Artisan::call('zorah:generate', ['path' => $testPath]);

  expect(File::exists($testPath))->toBeTrue();

  $content = File::get($testPath);
  expect($content)->toContain('"en"');
  expect($content)->toContain('"es"');

  // Clean up
  File::delete($testPath);
});

it('handles invalid path argument', function () {
  // Create a custom command instance to test error handling
  $filesystem = app(\Illuminate\Filesystem\Filesystem::class);

  // Create a test command that simulates invalid path
  $command = new class($filesystem) extends \Zen\Zorah\Console\TranslationGenerator
  {
    public function argument($key = null)
    {
      if ($key === 'path') {
        return null; // Simulate invalid path
      }

      return parent::argument($key);
    }

    public function error($string, $verbosity = null)
    {
      // Capture the error call
      expect($string)->toBe('Invalid path argument');

      return $this;
    }

    public function generate(): string
    {
      throw new Exception('Generate should not be called');
    }
  };

  // This should trigger the error path and return early
  $command->handle();

  // Test passes if we get here without exception
  expect(true)->toBeTrue();
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
  $testFiles = ['./test_translations.js', './test_output.js', './test_multilang.js'];
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
