<?php declare(strict_types=1);

use Bambamboole\ExtendedFaker\Providers\en_US\Product;
use Faker\Factory as FakerFactory;

beforeEach(function () {
    $this->faker = FakerFactory::create();
    $this->faker->addProvider(new Product($this->faker));
});

test('product methods return expected types', function () {
    expect($this->faker->productName())->toBeString()->not->toBeEmpty();
    expect($this->faker->productDescription())->toBeString()->not->toBeEmpty();
    expect($this->faker->productCategory())->toBeString()->not->toBeEmpty();

    $product = $this->faker->product();
    expect($product)->toBeArray()->toHaveKeys(['name', 'description', 'category', 'sku']);
});

test('product methods with identifier work', function () {
    expect($this->faker->productName('PHONE-001'))->toBeString();
    expect($this->faker->productBySku('PHONE-001'))->toBeArray()->toHaveKey('sku', 'PHONE-001');
    expect($this->faker->getProductSku('Samsung Galaxy S24 Ultra 5G'))->toBeString();
});

test('cross locale functionality works', function () {
    $enProduct = $this->faker->getProductInLocale('PHONE-001', 'en_US');
    $deProduct = $this->faker->getProductInLocale('PHONE-001', 'de_DE');

    expect($enProduct['sku'])->toBe($deProduct['sku']);
    expect($enProduct['name'])->not->toBe($deProduct['name']);
});

test('invalid product throws exception', function () {
    expect(fn() => $this->faker->productName('NonExistent'))->toThrow(InvalidArgumentException::class);
});
