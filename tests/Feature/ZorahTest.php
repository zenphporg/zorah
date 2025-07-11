<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;
use Zen\Zorah\Contracts\Zorah as ZorahContract;
use Zen\Zorah\Zorah;

beforeEach(function () {
  // Set up test language files
  setupZorahTestLanguageStructure();
});

afterEach(function () {
  // Clean up test files
  cleanupZorahTestLanguageStructure();
});

it('can resolve Zorah service from container', function () {
  $zorah = app(ZorahContract::class);

  expect($zorah)->toBeInstanceOf(Zorah::class);
  expect($zorah)->toBeInstanceOf(ZorahContract::class);
});

it('maintains singleton behavior', function () {
  $zorah1 = app(ZorahContract::class);
  $zorah2 = app(ZorahContract::class);

  expect($zorah1)->toBe($zorah2);
});

it('can convert to array format', function () {
  $zorah = app(ZorahContract::class);
  $array = $zorah->toArray();

  expect($array)->toHaveKey('translations');
  expect($array['translations'])->toBeArray();
});

it('can convert to JSON format', function () {
  $zorah = app(ZorahContract::class);
  $json = $zorah->toJson();

  expect($json)->toBeString();

  $decoded = json_decode($json, true);
  expect($decoded)->not->toBeNull();
  expect($decoded)->toHaveKey('translations');
  expect($decoded)->toHaveKey('defaults');
});

it('can clear translations cache', function () {
  // Get initial instance
  $zorah1 = app(ZorahContract::class);

  // Clear cache
  Zorah::clearTranslations();

  // This should work without issues
  $zorah2 = new Zorah;

  expect($zorah1)->toBeInstanceOf(Zorah::class);
  expect($zorah2)->toBeInstanceOf(Zorah::class);
});

it('processes translations with actual language files', function () {
  createZorahTestTranslations();

  $zorah = new Zorah;
  $array = $zorah->toArray();

  expect($array['translations'])->toHaveKey('en');
  expect($array['translations'])->toHaveKey('es');
  expect($array['translations']['en'])->toHaveKey('php');
  expect($array['translations']['en'])->toHaveKey('json');
});

it('handles production environment with caching', function () {
  createZorahTestTranslations();

  // Clear cache first
  Zorah::clearTranslations();

  // Set environment to production
  app()->detectEnvironment(function () {
    return 'production';
  });

  // Create first instance - should populate cache and use production path
  $zorah1 = new Zorah;

  // Create second instance - should use cache
  $zorah2 = new Zorah;

  expect($zorah1->toArray())->toBe($zorah2->toArray());

  // Reset environment
  app()->detectEnvironment(function () {
    return 'testing';
  });
});

it('handles missing JSON files gracefully', function () {
  // Clear any existing files first
  Zorah::clearTranslations();

  // Clean up any existing JSON files
  $jsonFile = lang_path('en.json');
  if (File::exists($jsonFile)) {
    File::delete($jsonFile);
  }

  // Create language directory without JSON files
  $langPath = lang_path();
  if (! File::exists($langPath)) {
    File::makeDirectory($langPath, 0755, true);
  }

  $enPath = lang_path('en');
  if (! File::exists($enPath)) {
    File::makeDirectory($enPath, 0755, true);
  }

  // Create only PHP file, no JSON file
  $messagesFile = $enPath.'/messages.php';
  File::put($messagesFile, "<?php\n\nreturn ['hello' => 'Hello'];");

  // Ensure JSON file doesn't exist
  expect(File::exists($jsonFile))->toBeFalse();

  $zorah = new Zorah;
  $array = $zorah->toArray();

  expect($array['translations']['en']['json'])->toBe([]);
});

// Helper methods
function setupZorahTestLanguageStructure()
{
  // Create basic language structure if it doesn't exist
  $langPath = lang_path();

  if (! File::exists($langPath)) {
    File::makeDirectory($langPath, 0755, true);
  }
}

function cleanupZorahTestLanguageStructure()
{
  // Only clean up if we're in a test environment
  if (app()->environment('testing')) {
    // Don't actually delete language files as they might be needed
    // This is just a placeholder for cleanup logic
  }
}

function createZorahTestTranslations()
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
