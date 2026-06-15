<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Generator\ProductSku;

it('encodes prefix + seed and round-trips', function () {
    $sku = ProductSku::encode('PH', 123456);

    expect($sku)->toBe('PH-'.strtoupper(base_convert('123456', 10, 36)))
        ->and(ProductSku::decode($sku))->toBe(['prefix' => 'PH', 'seed' => 123456]);
});

it('round-trips seed 0 and large seeds', function () {
    foreach ([0, 1, 2147483647] as $seed) {
        $decoded = ProductSku::decode(ProductSku::encode('EL', $seed));
        expect($decoded)->toBe(['prefix' => 'EL', 'seed' => $seed]);
    }
});

it('returns null for malformed skus', function () {
    expect(ProductSku::decode('nodash'))->toBeNull()
        ->and(ProductSku::decode(''))->toBeNull();
});
