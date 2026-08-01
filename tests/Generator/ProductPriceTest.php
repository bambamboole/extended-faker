<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\MoneyDto;
use Bambamboole\ExtendedFaker\Generator\ProductPrice;

it('snaps prices to retail endings', function () {
    expect(ProductPrice::compute(2450, 1, 1, 0))->toBe(2449)
        ->and(ProductPrice::compute(2450, 1, 1, 1))->toBe(2495)
        ->and(ProductPrice::compute(2450, 1, 1, 2))->toBe(2499);
});

it('scales linearly with the unit amount before snapping', function () {
    $small = ProductPrice::compute(1299, 0.75, 0.75, 2);
    $large = ProductPrice::compute(1299, 10, 0.75, 2);

    expect($small)->toBe(1299)
        ->and($large)->toBe(17399)
        ->and($large)->toBeGreaterThan($small);
});

it('never returns less than the smallest ending', function () {
    expect(ProductPrice::compute(30, 1, 1, 0))->toBe(49);
});

it('wraps amount and currency in MoneyDto', function () {
    $money = new MoneyDto(1999, 'EUR');

    expect($money->amount)->toBe(1999)
        ->and($money->currency)->toBe('EUR')
        ->and($money->toArray())->toBe(['amount' => 1999, 'currency' => 'EUR']);
});
