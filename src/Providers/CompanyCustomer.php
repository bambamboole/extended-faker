<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Bambamboole\ExtendedFaker\Dto\CompanyCustomerDto;
use Bambamboole\ExtendedFaker\Repository\CustomerRepository;
use Faker\Provider\Base;
use InvalidArgumentException;

abstract class CompanyCustomer extends Base
{
    protected CustomerRepository $repository;

    public function __construct($generator)
    {
        parent::__construct($generator);
        $this->repository = new CustomerRepository;
    }

    public function companyCustomer(?string $number = null): CompanyCustomerDto
    {
        if ($number === null) {
            return $this->repository->getRandomCompanyCustomer($this->getLocale());
        }

        return $this->companyCustomerByNumber($number);
    }

    public function generateCompanyCustomer(int $seed, ?string $country = null): CompanyCustomerDto
    {
        return $this->repository->generateCompanyCustomer($seed, $country, $this->getLocale());
    }

    public function companyCustomerByNumber(string $number): CompanyCustomerDto
    {
        $customer = $this->repository->getCompanyCustomerByNumber($number);
        if ($customer === null) {
            throw new InvalidArgumentException("Company customer with number '{$number}' not found.");
        }

        return $customer;
    }

    abstract protected function getLocale(): string;
}
