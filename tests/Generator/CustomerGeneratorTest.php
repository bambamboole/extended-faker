<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\PrivateCustomerDto;
use Bambamboole\ExtendedFaker\Generator\CustomerGenerator;
use Bambamboole\ExtendedFaker\Repository\CategoryRepository;
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

it('generates deterministic company customers with synthetic names', function () {
    $gen = new CustomerGenerator;

    $a = $gen->companyCustomer(42, 'DE');

    expect($a->toArray())->toBe($gen->companyCustomer(42, 'DE')->toArray())
        ->and($a->number)->toBe('BUS-DE-16')
        ->and($a->name)->toEndWith(' '.$a->legalForm)
        ->and(['GmbH', 'AG', 'KG', 'SE'])->toContain($a->legalForm)
        ->and($a->vatId)->toMatch('/^DE\d{9}$/')
        ->and($a->website)->toMatch('/^https:\/\/[a-z0-9-]+\.example\.com$/')
        ->and($a->email)->toMatch('/^[a-z0-9.]+@example\.(com|org|net)$/')
        ->and($a->contactEmail)->toMatch('/^[a-z0-9.]+@example\.(com|org|net)$/');
});

it('uses US legal forms and EIN-style tax ids for US companies', function () {
    $company = (new CustomerGenerator)->companyCustomer(9, 'US');

    expect(['Inc.', 'LLC', 'Corp.', 'Ltd.'])->toContain($company->legalForm)
        ->and($company->vatId)->toMatch('/^\d{2}-\d{7}$/')
        ->and($company->iban)->toBeNull();
});

it('generates suppliers with valid supplied categories and payment terms', function () {
    $gen = new CustomerGenerator;

    $s = $gen->supplier(7, 'US');
    $keys = (new CategoryRepository)->getAllCategoryKeys();

    expect($s->toArray())->toBe($gen->supplier(7, 'US')->toArray())
        ->and($s->number)->toBe('SUP-US-7')
        ->and(['net 14', 'net 30', 'net 60', 'net 90', '2/10 net 30'])->toContain($s->paymentTerms)
        ->and($s->suppliedCategories)->not->toBeEmpty()
        ->and(count($s->suppliedCategories))->toBeLessThanOrEqual(3);

    foreach ($s->suppliedCategories as $key) {
        expect($keys)->toContain($key);
    }
});
