<?php declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\ProductDto;
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
    expect($product)->toBeInstanceOf(ProductDto::class);
    expect($product->name)->toBeString()->not->toBeEmpty();
    expect($product->description)->toBeString()->not->toBeEmpty();
    expect($product->category)->toBeString()->not->toBeEmpty();
    expect($product->sku)->toBeString()->not->toBeEmpty();
});

test('product methods with identifier work', function () {
    expect($this->faker->productName('PHONE-001-256GB-TITANIUMBLACK'))->toBeString();
    $product = $this->faker->productBySku('PHONE-001-256GB-TITANIUMBLACK');
    expect($product)->toBeInstanceOf(ProductDto::class);
    expect($product->sku)->toBe('PHONE-001-256GB-TITANIUMBLACK');
    expect($this->faker->getProductSku('Samsung Galaxy S24 Ultra 256GB Titanium Black'))->toBeString();
});

test('cross locale functionality works', function () {
    $enProduct = $this->faker->getProductInLocale('PHONE-001-256GB-TITANIUMBLACK', 'en_US');
    $deProduct = $this->faker->getProductInLocale('PHONE-001-256GB-TITANIUMBLACK', 'de_DE');

    expect($enProduct->sku)->toBe($deProduct->sku);
    expect($enProduct->name)->not->toBe($deProduct->name);
});

test('invalid product throws exception', function () {
    expect(fn() => $this->faker->productName('NonExistent'))->toThrow(InvalidArgumentException::class);
});
