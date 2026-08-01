<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\SupplierDto;
use Bambamboole\ExtendedFaker\Repository\CustomerRepository;

it('round-trips each type by number', function () {
    $repo = new CustomerRepository;

    $private = $repo->generatePrivateCustomer(123, null, 'de_DE');
    $company = $repo->generateCompanyCustomer(123, null, 'en_US');
    $supplier = $repo->generateSupplier(123, 'DE');

    expect($repo->getPrivateCustomerByNumber($private->number)->toArray())->toBe($private->toArray())
        ->and($repo->getCompanyCustomerByNumber($company->number)->toArray())->toBe($company->toArray())
        ->and($repo->getSupplierByNumber($supplier->number)->toArray())->toBe($supplier->toArray());
});

it('returns null for wrong-type or malformed numbers', function () {
    $repo = new CustomerRepository;
    $company = $repo->generateCompanyCustomer(5);

    expect($repo->getPrivateCustomerByNumber($company->number))->toBeNull()
        ->and($repo->getSupplierByNumber('garbage'))->toBeNull();
});

it('maps locale to default country', function () {
    $repo = new CustomerRepository;

    expect($repo->generatePrivateCustomer(1, null, 'de_DE')->address->countryCode)->toBe('DE')
        ->and($repo->generatePrivateCustomer(1, null, 'en_US')->address->countryCode)->toBe('US')
        ->and($repo->getRandomSupplier('de_DE'))->toBeInstanceOf(SupplierDto::class)
        ->and(CustomerRepository::countryForLocale('de_AT'))->toBe('DE');
});
