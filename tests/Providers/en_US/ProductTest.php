<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Providers\en_US\Product;
use Faker\Factory;

it('generates english products', function () {
    $faker = Factory::create('en_US');
    $provider = new Product($faker);

    expect($provider->generateProduct(1)->name)->toBeString()->not->toBe('');
});
