<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Generator;

use Bambamboole\ExtendedFaker\Dto\AddressDto;
use Bambamboole\ExtendedFaker\Dto\CompanyCustomerDto;
use Bambamboole\ExtendedFaker\Dto\ContactDto;
use Bambamboole\ExtendedFaker\Dto\ContactRole;
use Bambamboole\ExtendedFaker\Dto\PrivateCustomerDto;
use Bambamboole\ExtendedFaker\Dto\Salutation;
use Bambamboole\ExtendedFaker\Dto\SupplierDto;
use Bambamboole\ExtendedFaker\Repository\CategoryRepository;
use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Faker\Factory;
use Faker\Generator;
use InvalidArgumentException;

final class CustomerGenerator
{
    private const EMAIL_DOMAINS = ['example.com', 'example.org', 'example.net'];

    private const FAKER_LOCALES = ['DE' => 'de_DE', 'US' => 'en_US'];

    private const BRANDS = ['Voltari', 'Nexora', 'Kintsu', 'Aeris', 'Orbiq', 'Vantec', 'Zephyr', 'Helix', 'Nimbus', 'Arcadia', 'Wavera', 'Pulsar'];

    private const SUFFIXES = ['Logistics', 'Trading', 'Group', 'Solutions', 'Industries', 'Supply', 'Distribution', 'Systems', 'Partners', 'Holding'];

    private const LEGAL_FORMS = ['DE' => ['GmbH', 'AG', 'KG', 'SE'], 'US' => ['Inc.', 'LLC', 'Corp.', 'Ltd.']];

    private const PAYMENT_TERMS = ['net 14', 'net 30', 'net 60', 'net 90', '2/10 net 30'];

    /** @var array<string, Generator> */
    private array $fakers = [];

    public function __construct(
        private readonly CategoryRepository $categories = new CategoryRepository,
    ) {}

    public function privateCustomer(int $seed, string $country = 'US'): PrivateCustomerDto
    {
        $f = $this->faker($country, $seed);

        $roll = $f->numberBetween(0, 9);
        $salutation = match (true) {
            $roll < 4 => Salutation::Mr,
            $roll < 8 => Salutation::Mrs,
            default => Salutation::Neutral,
        };
        $firstName = match ($salutation) {
            Salutation::Mr => $f->firstName('male'),
            Salutation::Mrs => $f->firstName('female'),
            default => $f->firstName(),
        };
        $lastName = $f->lastName();

        $titleRoll = $f->numberBetween(1, 100);
        $academicTitle = match (true) {
            $titleRoll <= 10 => 'Dr.',
            $titleRoll <= 12 => 'Prof. Dr.',
            default => null,
        };

        return new PrivateCustomerDto(
            number: CustomerNumber::encode(CustomerNumber::TYPE_PRIVATE, $country, $seed),
            salutation: $salutation,
            academicTitle: $academicTitle,
            firstName: $firstName,
            lastName: $lastName,
            email: $this->email($f, $firstName.' '.$lastName),
            phone: $this->phone($f, $country),
            mobile: $this->mobile($f, $country),
            birthdate: $this->dateBetween($f, '1946-01-01', '2008-01-01'),
            address: $this->address($f, $country),
            customerSince: $this->dateBetween($f, '2018-01-01', '2026-01-01'),
            iban: $country === 'DE' ? $f->iban('DE') : null,
        );
    }

    public function companyCustomer(int $seed, string $country = 'US'): CompanyCustomerDto
    {
        $f = $this->faker($country, $seed);

        return new CompanyCustomerDto(
            ...$this->companyFields($f, $country),
            number: CustomerNumber::encode(CustomerNumber::TYPE_COMPANY, $country, $seed),
        );
    }

    public function supplier(int $seed, string $country = 'US'): SupplierDto
    {
        $f = $this->faker($country, $seed);
        $fields = $this->companyFields($f, $country);

        $keys = $this->categories->getAllCategoryKeys();
        sort($keys);

        return new SupplierDto(
            ...$fields,
            number: CustomerNumber::encode(CustomerNumber::TYPE_SUPPLIER, $country, $seed),
            paymentTerms: $f->randomElement(self::PAYMENT_TERMS),
            suppliedCategories: $f->randomElements($keys, $f->numberBetween(1, 3)),
        );
    }

    /**
     * @return array{name: string, legalForm: string, vatId: string, taxNumber: string|null, email: string, phone: string, mobile: string, website: string, address: AddressDto, contacts: list<ContactDto>, customerSince: DateTimeImmutable, iban: string|null}
     */
    private function companyFields(Generator $f, string $country): array
    {
        $base = $f->randomElement(self::BRANDS).' '.$f->randomElement(self::SUFFIXES);
        $legalForm = $f->randomElement(self::LEGAL_FORMS[$country]);

        return [
            'name' => $base.' '.$legalForm,
            'legalForm' => $legalForm,
            'vatId' => $this->vatId($f, $country),
            'taxNumber' => $country === 'DE' ? $f->numerify('##/###/#####') : null,
            'email' => $this->email($f, $base),
            'phone' => $this->phone($f, $country),
            'mobile' => $this->mobile($f, $country),
            'website' => 'https://'.$this->slug($base, '-').'.example.com',
            'address' => $this->address($f, $country),
            'contacts' => $this->contacts($f, $country),
            'customerSince' => $this->dateBetween($f, '2018-01-01', '2026-01-01'),
            'iban' => $country === 'DE' ? $f->iban('DE') : null,
        ];
    }

    /**
     * @return list<ContactDto>
     */
    private function contacts(Generator $f, string $country): array
    {
        $contacts = [];
        $count = $f->numberBetween(0, 5);
        for ($i = 0; $i < $count; $i++) {
            $salutation = $f->numberBetween(0, 1) === 0 ? Salutation::Mr : Salutation::Mrs;
            $firstName = $salutation === Salutation::Mr ? $f->firstName('male') : $f->firstName('female');
            $lastName = $f->lastName();

            $contacts[] = new ContactDto(
                salutation: $salutation,
                firstName: $firstName,
                lastName: $lastName,
                email: $this->email($f, $firstName.' '.$lastName),
                phone: $this->mobile($f, $country),
                role: $f->randomElement(ContactRole::cases()),
            );
        }

        return $contacts;
    }

    private function vatId(Generator $f, string $country): string
    {
        return $country === 'DE'
            ? 'DE'.$f->numerify('#########')
            : $f->numerify('##-#######');
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

    private function mobile(Generator $f, string $country): string
    {
        return $country === 'DE'
            ? '+49 1'.$f->randomElement(['5', '6', '7']).$f->numerify('# #######')
            : '+1 '.$f->numerify('### ###-####');
    }

    private function email(Generator $f, string $name): string
    {
        return $this->slug($name).'@'.$f->randomElement(self::EMAIL_DOMAINS);
    }

    private const TRANSLIT_MAP = [
        'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue',
        'Ä' => 'ae', 'Ö' => 'oe', 'Ü' => 'ue',
        'ß' => 'ss',
        'é' => 'e', 'è' => 'e', 'ê' => 'e',
        'á' => 'a', 'à' => 'a', 'â' => 'a',
        'í' => 'i', 'ì' => 'i',
        'ó' => 'o', 'ò' => 'o', 'ô' => 'o',
        'ú' => 'u', 'ù' => 'u', 'û' => 'u',
        'ñ' => 'n', 'ç' => 'c',
    ];

    private function slug(string $value, string $separator = '.'): string
    {
        $value = strtr(mb_strtolower($value), self::TRANSLIT_MAP);

        return trim((string) preg_replace('/[^a-z0-9]+/', $separator, $value), $separator);
    }

    private function dateBetween(Generator $f, string $from, string $to): DateTimeImmutable
    {
        $utc = new DateTimeZone('UTC');

        return DateTimeImmutable::createFromMutable(
            $f->dateTimeBetween(new DateTime($from, $utc), new DateTime($to, $utc), 'UTC')
        )->setTime(0, 0);
    }
}
