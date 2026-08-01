<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\CompanyCustomerDto;
use Bambamboole\ExtendedFaker\Dto\PrivateCustomerDto;
use Bambamboole\ExtendedFaker\Dto\SupplierDto;
use Bambamboole\ExtendedFaker\ExtendedFaker;
use Faker\Factory;
use Faker\Generator;

function customerFaker(string $locale = 'en_US'): Generator
{
    $faker = Factory::create($locale);
    ExtendedFaker::extend($faker, $locale);

    return $faker;
}

it('exposes all three customer types through the faker generator', function () {
    $faker = customerFaker();

    expect($faker->privateCustomer())->toBeInstanceOf(PrivateCustomerDto::class)
        ->and($faker->companyCustomer())->toBeInstanceOf(CompanyCustomerDto::class)
        ->and($faker->supplier())->toBeInstanceOf(SupplierDto::class);
});

it('generates deterministically by seed through the provider', function () {
    $faker = customerFaker();

    expect($faker->generatePrivateCustomer(5)->toArray())->toBe($faker->generatePrivateCustomer(5)->toArray())
        ->and($faker->generateSupplier(5)->toArray())->toBe($faker->generateSupplier(5)->toArray());
});

it('returns identical entities across locales for the same number', function () {
    $de = customerFaker('de_DE');
    $en = customerFaker('en_US');

    $customer = $de->generatePrivateCustomer(42);
    $supplier = $de->generateSupplier(42);

    expect($customer->address->countryCode)->toBe('DE')
        ->and($en->privateCustomerByNumber($customer->number)->toArray())->toBe($customer->toArray())
        ->and($en->supplierByNumber($supplier->number)->toArray())->toBe($supplier->toArray());
});

it('accepts a number as identifier argument', function () {
    $faker = customerFaker();
    $made = $faker->generateCompanyCustomer(88);

    expect($faker->companyCustomer($made->number)->toArray())->toBe($made->toArray());
});

it('throws for an unknown customer number', function () {
    customerFaker()->privateCustomerByNumber('CUS-FR-16');
})->throws(InvalidArgumentException::class);

it('yields unique customers at scale via unique()', function () {
    $faker = customerFaker();

    $seen = [];
    for ($i = 0; $i < 2000; $i++) {
        $seen[$faker->unique()->privateCustomer()->number] = true;
    }

    expect(count($seen))->toBe(2000);
})->group('scale');
