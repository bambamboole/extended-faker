<?php declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\ProductDto;
use Bambamboole\ExtendedFaker\Providers\en_US\Product;
use Faker\Factory as FakerFactory;

beforeEach(function () {
    $this->faker = FakerFactory::create('en_US');
    $this->faker->addProvider(new Product($this->faker));
});

test('english provider returns english content', function () {
    $product = $this->faker->product();
    expect($product)->toBeInstanceOf(ProductDto::class);
    expect($product->name)->toBeString()->not->toBeEmpty();
});

test('english provider inherits from base', function () {
    expect($this->faker)->toBeInstanceOf(Faker\Generator::class);
    expect($this->faker->productName())->toBeString();
});
