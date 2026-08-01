<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\ContactDto;
use Bambamboole\ExtendedFaker\Dto\ContactRole;
use Bambamboole\ExtendedFaker\Dto\PrivateCustomerDto;
use Bambamboole\ExtendedFaker\Dto\Salutation;
use Bambamboole\ExtendedFaker\Generator\CustomerGenerator;
use Bambamboole\ExtendedFaker\Repository\CategoryRepository;
use Faker\Calculator\Iban;
use Faker\Generator;
use Faker\Provider\de_DE\Person;

/**
 * @return array{male: list<string>, female: list<string>}
 */
function deFirstNamePools(): array
{
    $exposer = new class(new Generator) extends Person
    {
        /** @return array{male: list<string>, female: list<string>} */
        public function pools(): array
        {
            return ['male' => self::$firstNameMale, 'female' => self::$firstNameFemale];
        }
    };

    return $exposer->pools();
}

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
        ->and($a->email)->toMatch('/^[a-z0-9.]+@example\.(com|org|net)$/');
});

it('uses US legal forms and EIN-style tax ids for US companies', function () {
    $company = (new CustomerGenerator)->companyCustomer(9, 'US');

    expect(['Inc.', 'LLC', 'Corp.', 'Ltd.'])->toContain($company->legalForm)
        ->and($company->vatId)->toMatch('/^\d{2}-\d{7}$/')
        ->and($company->iban)->toBeNull();
});

it('generates identical customers regardless of process timezone', function () {
    $gen = new CustomerGenerator;
    $tz = date_default_timezone_get();

    try {
        date_default_timezone_set('UTC');
        $utc = $gen->privateCustomer(42, 'DE')->toArray();
        date_default_timezone_set('Pacific/Kiritimati');
        $kiritimati = $gen->privateCustomer(42, 'DE')->toArray();
    } finally {
        date_default_timezone_set($tz);
    }

    expect($kiritimati)->toBe($utc);
});

it('transliterates German characters deterministically in emails', function () {
    // seed 9, DE: firstName/lastName resolve to "Heinz-Jürgen Wiedemann"
    $gen = new CustomerGenerator;

    $c = $gen->privateCustomer(9, 'DE');

    expect($c->email)->toMatch('/^[a-z0-9.]+@example\.(com|org|net)$/')
        ->and($c->email)->toBe('heinz.juergen.wiedemann@example.net');
});

it('draws only mr, mrs and neutral salutations that match the first name', function () {
    $gen = new CustomerGenerator;
    $pools = deFirstNamePools();
    $seen = [];

    foreach (range(0, 199) as $seed) {
        $c = $gen->privateCustomer($seed, 'DE');
        $seen[$c->salutation->value] = true;

        if ($c->salutation === Salutation::Mr) {
            expect($pools['male'])->toContain($c->firstName);
        }
        if ($c->salutation === Salutation::Mrs) {
            expect($pools['female'])->toContain($c->firstName);
        }
    }

    expect(array_keys($seen))->toEqualCanonicalizing(['mr', 'mrs', 'neutral']);
});

it('round-trips the salutation through toArray as its backed value', function () {
    $c = (new CustomerGenerator)->privateCustomer(42, 'DE');

    expect($c->salutation)->toBeInstanceOf(Salutation::class)
        ->and($c->toArray()['salutation'])->toBe($c->salutation->value);
});

it('generates 0-5 gender-consistent contacts with roles for companies and suppliers', function () {
    $gen = new CustomerGenerator;
    $pools = deFirstNamePools();
    $counts = [];

    foreach (range(0, 49) as $seed) {
        $company = $gen->companyCustomer($seed, 'DE');
        $counts[count($company->contacts)] = true;

        expect(count($company->contacts))->toBeLessThanOrEqual(5);
        foreach ($company->contacts as $contact) {
            expect($contact)->toBeInstanceOf(ContactDto::class)
                ->and([Salutation::Mr, Salutation::Mrs])->toContain($contact->salutation)
                ->and($contact->email)->toMatch('/^[a-z0-9.]+@example\.(com|org|net)$/')
                ->and($contact->role)->toBeInstanceOf(ContactRole::class)
                ->and($pools[$contact->salutation === Salutation::Mr ? 'male' : 'female'])->toContain($contact->firstName);
        }
    }

    expect(count($counts))->toBeGreaterThan(2);
});

it('gives companies a German tax number and a distinct mobile number', function () {
    $gen = new CustomerGenerator;

    $de = $gen->companyCustomer(11, 'DE');
    $us = $gen->companyCustomer(11, 'US');

    expect($de->taxNumber)->toMatch('/^\d{2}\/\d{3}\/\d{5}$/')
        ->and($us->taxNumber)->toBeNull()
        ->and($de->mobile)->toMatch('/^\+49 1[567]\d \d{7}$/')
        ->and($us->mobile)->toMatch('/^\+1 \d{3} \d{3}-\d{4}$/');
});

it('gives private customers a mobile number and an occasional academic title', function () {
    $gen = new CustomerGenerator;
    $titles = [];

    foreach (range(0, 99) as $seed) {
        $c = $gen->privateCustomer($seed, 'DE');
        $titles[$c->academicTitle ?? 'none'] = true;

        expect($c->mobile)->toMatch('/^\+49 1[567]\d \d{7}$/')
            ->and([null, 'Dr.', 'Prof. Dr.'])->toContain($c->academicTitle);
    }

    expect($titles)->toHaveKeys(['none', 'Dr.']);
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
