<?php

declare(strict_types=1);

use Zen\Zorah\Contracts\Zorah as ZorahContract;
use Zen\Zorah\Zorah;

it('ensures Zorah class implements the contract', function () {
  $reflection = new ReflectionClass(Zorah::class);

  expect($reflection->implementsInterface(ZorahContract::class))->toBeTrue();
});

it('ensures contract extends JsonSerializable', function () {
  $reflection = new ReflectionClass(ZorahContract::class);

  expect($reflection->implementsInterface(JsonSerializable::class))->toBeTrue();
});

it('ensures contract has all required methods', function () {
  $reflection = new ReflectionClass(ZorahContract::class);
  $methods = $reflection->getMethods();
  $methodNames = array_map(fn ($method) => $method->getName(), $methods);

  expect($methodNames)->toContain('jsonSerialize');
  expect($methodNames)->toContain('toArray');
  expect($methodNames)->toContain('clearTranslations');
  expect($methodNames)->toContain('makeLocales');
  expect($methodNames)->toContain('toJson');
});

it('ensures clearTranslations is static', function () {
  $reflection = new ReflectionClass(ZorahContract::class);
  $method = $reflection->getMethod('clearTranslations');

  expect($method->isStatic())->toBeTrue();
});

it('ensures toJson has correct signature', function () {
  $reflection = new ReflectionClass(ZorahContract::class);
  $method = $reflection->getMethod('toJson');
  $parameters = $method->getParameters();

  expect($parameters)->toHaveCount(1);
  expect($parameters[0]->getName())->toBe('options');
  expect($parameters[0]->getType()->getName())->toBe('int');
  expect($parameters[0]->getDefaultValue())->toBe(0);
});
