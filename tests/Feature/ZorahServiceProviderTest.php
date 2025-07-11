<?php

declare(strict_types=1);

use Zen\Zorah\Console\TranslationGenerator;
use Zen\Zorah\Contracts\Zorah as ZorahContract;
use Zen\Zorah\Zorah;
use Zen\Zorah\ZorahServiceProvider;

it('extends Laravel ServiceProvider', function () {
  $reflection = new ReflectionClass(ZorahServiceProvider::class);

  expect($reflection->getParentClass()->getName())->toBe(\Illuminate\Support\ServiceProvider::class);
});

it('has required methods', function () {
  $reflection = new ReflectionClass(ZorahServiceProvider::class);

  expect($reflection->hasMethod('register'))->toBeTrue();
  expect($reflection->hasMethod('boot'))->toBeTrue();
});

it('register method has Override attribute', function () {
  $reflection = new ReflectionClass(ZorahServiceProvider::class);
  $method = $reflection->getMethod('register');
  $attributes = $method->getAttributes();

  expect($attributes)->toHaveCount(1);
  expect($attributes[0]->getName())->toBe('Override');
});

it('references correct command class', function () {
  expect(class_exists(TranslationGenerator::class))->toBeTrue();
});

it('references correct contract and implementation', function () {
  expect(interface_exists(ZorahContract::class))->toBeTrue();
  expect(class_exists(Zorah::class))->toBeTrue();

  $reflection = new ReflectionClass(Zorah::class);
  expect($reflection->implementsInterface(ZorahContract::class))->toBeTrue();
});

it('has correct method visibility', function () {
  $reflection = new ReflectionClass(ZorahServiceProvider::class);

  $registerMethod = $reflection->getMethod('register');
  $bootMethod = $reflection->getMethod('boot');

  expect($registerMethod->isPublic())->toBeTrue();
  expect($bootMethod->isPublic())->toBeTrue();
});
