<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\PrivateCustomerDto;
use Bambamboole\ExtendedFaker\Generator\CustomerGenerator;
use Faker\Calculator\Iban;

it('generates a deterministic private customer for a seed', function () {
    $gen = new CustomerGenerator;

    $a = $gen->privateCustomer(42, 'DE');
    $b = $gen->privateCustomer(42, 'DE');

    expect($a)->toBeInstanceOf(PrivateCustomerDto::class)
        ->and($a->toArray())->toBe($b->toArray())
        ->and($a->number)->toBe('CUS-DE-16');
});

it('produces German data for DE and US data for US', function () {
    $gen = new CustomerGenerator;

    $de = $gen->privateCustomer(7, 'DE');
    $us = $gen->privateCustomer(7, 'US');

    expect($de->address->countryCode)->toBe('DE')
        ->and($de->phone)->toStartWith('+49 ')
        ->and($de->iban)->toStartWith('DE')
        ->and(Iban::isValid($de->iban))->toBeTrue()
        ->and($us->address->countryCode)->toBe('US')
        ->and($us->phone)->toStartWith('+1 ')
        ->and($us->iban)->toBeNull();
});

it('derives safe emails and sane dates for many seeds', function () {
    $gen = new CustomerGenerator;

    foreach (range(0, 49) as $seed) {
        $c = $gen->privateCustomer($seed, $seed % 2 === 0 ? 'DE' : 'US');

        expect($c->email)->toMatch('/^[a-z0-9.]+@example\.(com|org|net)$/')
            ->and((int) $c->birthdate->format('Y'))->toBeGreaterThanOrEqual(1946)
            ->and((int) $c->birthdate->format('Y'))->toBeLessThanOrEqual(2008)
            ->and((int) $c->customerSince->format('Y'))->toBeGreaterThanOrEqual(2018);
    }
});

it('rejects unsupported countries', function () {
    (new CustomerGenerator)->privateCustomer(1, 'FR');
})->throws(InvalidArgumentException::class);
