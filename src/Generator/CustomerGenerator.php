<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Generator;

use Bambamboole\ExtendedFaker\Dto\AddressDto;
use Bambamboole\ExtendedFaker\Dto\PrivateCustomerDto;
use Bambamboole\ExtendedFaker\Repository\CategoryRepository;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;

final class CustomerGenerator
{
    private const EMAIL_DOMAINS = ['example.com', 'example.org', 'example.net'];

    private const FAKER_LOCALES = ['DE' => 'de_DE', 'US' => 'en_US'];

    /** @var array<string, Generator> */
    private array $fakers = [];

    public function __construct(
        private readonly CategoryRepository $categories = new CategoryRepository,
    ) {}

    public function privateCustomer(int $seed, string $country = 'US'): PrivateCustomerDto
    {
        $f = $this->faker($country, $seed);

        $firstName = $f->firstName();
        $lastName = $f->lastName();

        return new PrivateCustomerDto(
            number: CustomerNumber::encode(CustomerNumber::TYPE_PRIVATE, $country, $seed),
            firstName: $firstName,
            lastName: $lastName,
            email: $this->email($f, $firstName.' '.$lastName),
            phone: $this->phone($f, $country),
            birthdate: $this->dateBetween($f, '1946-01-01', '2008-01-01'),
            address: $this->address($f, $country),
            customerSince: $this->dateBetween($f, '2018-01-01', '2026-01-01'),
            iban: $country === 'DE' ? $f->iban('DE') : null,
        );
    }

    private function faker(string $country, int $seed): Generator
    {
        $locale = self::FAKER_LOCALES[$country]
            ?? throw new InvalidArgumentException("Unsupported country [{$country}].");

        $f = $this->fakers[$locale] ??= Factory::create($locale);
        $f->seed($seed);

        return $f;
    }

    private function address(Generator $f, string $country): AddressDto
    {
        return new AddressDto(
            street: $f->streetAddress(),
            city: $f->city(),
            zip: $f->postcode(),
            countryCode: $country,
        );
    }

    private function phone(Generator $f, string $country): string
    {
        return $country === 'DE'
            ? '+49 '.$f->numerify('1## #######')
            : '+1 '.$f->numerify('### ###-####');
    }

    private function email(Generator $f, string $name): string
    {
        return $this->slug($name).'@'.$f->randomElement(self::EMAIL_DOMAINS);
    }

    private function slug(string $value, string $separator = '.'): string
    {
        $value = strtolower((string) iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value));

        return trim((string) preg_replace('/[^a-z0-9]+/', $separator, $value), $separator);
    }

    private function dateBetween(Generator $f, string $from, string $to): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($f->dateTimeBetween($from, $to))->setTime(0, 0);
    }
}
