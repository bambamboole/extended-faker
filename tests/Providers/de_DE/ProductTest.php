<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Providers\de_DE\Product as DeProduct;
use Bambamboole\ExtendedFaker\Providers\en_US\Product as EnProduct;
use Faker\Factory;

it('keeps the sku stable across locales and localizes the description', function () {
    $en = (new EnProduct(Factory::create('en_US')))->generateProduct(50);
    $de = (new DeProduct(Factory::create('de_DE')))->generateProduct(50);

    expect($de->sku)->toBe($en->sku)
        ->and($de->description)->not->toBe($en->description);
});
