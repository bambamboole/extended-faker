<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Repository;

use Bambamboole\ExtendedFaker\Dto\CompanyCustomerDto;
use Bambamboole\ExtendedFaker\Dto\PrivateCustomerDto;
use Bambamboole\ExtendedFaker\Dto\SupplierDto;
use Bambamboole\ExtendedFaker\Generator\CustomerGenerator;
use Bambamboole\ExtendedFaker\Generator\CustomerNumber;

class CustomerRepository
{
    private const SEED_MAX = 2147483647;

    public function __construct(
        private readonly CustomerGenerator $generator = new CustomerGenerator,
    ) {}

    public static function countryForLocale(string $locale): string
    {
        return str_starts_with($locale, 'de') ? 'DE' : 'US';
    }

    public function generatePrivateCustomer(int $seed, ?string $country = null, string $locale = 'en_US'): PrivateCustomerDto
    {
        return $this->generator->privateCustomer($seed, $country ?? self::countryForLocale($locale));
    }

    public function getPrivateCustomerByNumber(string $number): ?PrivateCustomerDto
    {
        $decoded = CustomerNumber::decode($number);
        if ($decoded === null || $decoded['type'] !== CustomerNumber::TYPE_PRIVATE) {
            return null;
        }

        return $this->generator->privateCustomer($decoded['seed'], $decoded['country']);
    }

    public function getRandomPrivateCustomer(string $locale = 'en_US'): PrivateCustomerDto
    {
        return $this->generatePrivateCustomer(random_int(0, self::SEED_MAX), null, $locale);
    }

    public function generateCompanyCustomer(int $seed, ?string $country = null, string $locale = 'en_US'): CompanyCustomerDto
    {
        return $this->generator->companyCustomer($seed, $country ?? self::countryForLocale($locale));
    }

    public function getCompanyCustomerByNumber(string $number): ?CompanyCustomerDto
    {
        $decoded = CustomerNumber::decode($number);
        if ($decoded === null || $decoded['type'] !== CustomerNumber::TYPE_COMPANY) {
            return null;
        }

        return $this->generator->companyCustomer($decoded['seed'], $decoded['country']);
    }

    public function getRandomCompanyCustomer(string $locale = 'en_US'): CompanyCustomerDto
    {
        return $this->generateCompanyCustomer(random_int(0, self::SEED_MAX), null, $locale);
    }

    public function generateSupplier(int $seed, ?string $country = null, string $locale = 'en_US'): SupplierDto
    {
        return $this->generator->supplier($seed, $country ?? self::countryForLocale($locale));
    }

    public function getSupplierByNumber(string $number): ?SupplierDto
    {
        $decoded = CustomerNumber::decode($number);
        if ($decoded === null || $decoded['type'] !== CustomerNumber::TYPE_SUPPLIER) {
            return null;
        }

        return $this->generator->supplier($decoded['seed'], $decoded['country']);
    }

    public function getRandomSupplier(string $locale = 'en_US'): SupplierDto
    {
        return $this->generateSupplier(random_int(0, self::SEED_MAX), null, $locale);
    }
}
