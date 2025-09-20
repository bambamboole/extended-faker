<?php declare(strict_types=1);

use Bambamboole\ExtendedFaker\Providers\de_DE\Product;
use Faker\Factory as FakerFactory;

beforeEach(function () {
    $this->faker = FakerFactory::create('de_DE');
    $this->faker->addProvider(new Product($this->faker));
});

test('german provider returns german content', function () {
    $product = $this->faker->product();
    expect($product)->toHaveKeys(['name', 'description', 'category', 'sku']);
    expect($product['name'])->toBeString()->not->toBeEmpty();
});

test('german provider inherits from base', function () {
    expect($this->faker)->toBeInstanceOf(Faker\Generator::class);
    expect($this->faker->productName())->toBeString();
});
