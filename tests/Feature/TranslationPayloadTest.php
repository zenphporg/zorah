<?php

declare(strict_types=1);

use Zen\Zorah\Payloads\TranslationPayload;

it('compiles empty locales array', function () {
  $result = TranslationPayload::compile([]);

  expect($result)->toBeInstanceOf(\Illuminate\Support\Collection::class);
  expect($result->toArray())->toBe([]);
});

it('returns Collection instance from compile method', function () {
  $result = TranslationPayload::compile([]);

  expect($result)->toBeInstanceOf(\Illuminate\Support\Collection::class);
});

it('has static compile method', function () {
  $reflection = new ReflectionClass(TranslationPayload::class);
  $method = $reflection->getMethod('compile');

  expect($method->isStatic())->toBeTrue();
  expect($method->isPublic())->toBeTrue();
});

it('has private translation methods', function () {
  $reflection = new ReflectionClass(TranslationPayload::class);

  expect($reflection->hasMethod('phpTranslations'))->toBeTrue();
  expect($reflection->hasMethod('jsonTranslations'))->toBeTrue();

  $phpMethod = $reflection->getMethod('phpTranslations');
  $jsonMethod = $reflection->getMethod('jsonTranslations');

  expect($phpMethod->isPrivate())->toBeTrue();
  expect($jsonMethod->isPrivate())->toBeTrue();
});

it('can be instantiated', function () {
  $payload = new TranslationPayload;

  expect($payload)->toBeInstanceOf(TranslationPayload::class);
});

it('compile method accepts array parameter', function () {
  $reflection = new ReflectionClass(TranslationPayload::class);
  $method = $reflection->getMethod('compile');
  $parameters = $method->getParameters();

  expect($parameters)->toHaveCount(1);
  expect($parameters[0]->getName())->toBe('locales');
  expect($parameters[0]->hasType())->toBeTrue();
  expect($parameters[0]->getDefaultValue())->toBe([]);
});

it('handles missing JSON file gracefully', function () {
  // Test the case where JSON file doesn't exist (line 71 coverage)
  $payload = new TranslationPayload;
  $reflection = new ReflectionClass($payload);
  $method = $reflection->getMethod('jsonTranslations');
  $method->setAccessible(true);

  // Mock a locale that doesn't have a JSON file
  $result = $method->invoke($payload, 'nonexistent');

  expect($result)->toBe([]);
});
