<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Generator\CustomerNumber;

it('round-trips type, country and seed', function () {
    $number = CustomerNumber::encode(CustomerNumber::TYPE_PRIVATE, 'DE', 42);

    expect($number)->toBe('CUS-DE-16')
        ->and(CustomerNumber::decode($number))->toBe(['type' => 'CUS', 'country' => 'DE', 'seed' => 42]);
});

it('encodes each type with its own prefix', function () {
    expect(CustomerNumber::encode(CustomerNumber::TYPE_COMPANY, 'US', 7))->toBe('BUS-US-7')
        ->and(CustomerNumber::encode(CustomerNumber::TYPE_SUPPLIER, 'DE', 7))->toBe('SUP-DE-7');
});

it('rejects unknown types, countries and malformed numbers', function () {
    expect(CustomerNumber::decode('XXX-DE-16'))->toBeNull()
        ->and(CustomerNumber::decode('CUS-FR-16'))->toBeNull()
        ->and(CustomerNumber::decode('CUS-16'))->toBeNull()
        ->and(CustomerNumber::decode('nonsense'))->toBeNull();
});
