<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Bambamboole\ExtendedFaker\Dto\PrivateCustomerDto;
use Bambamboole\ExtendedFaker\Repository\CustomerRepository;
use Faker\Provider\Base;
use InvalidArgumentException;

abstract class PrivateCustomer extends Base
{
    protected CustomerRepository $repository;

    public function __construct($generator)
    {
        parent::__construct($generator);
        $this->repository = new CustomerRepository;
    }

    public function privateCustomer(?string $number = null): PrivateCustomerDto
    {
        if ($number === null) {
            return $this->repository->getRandomPrivateCustomer($this->getLocale());
        }

        return $this->privateCustomerByNumber($number);
    }

    public function generatePrivateCustomer(int $seed, ?string $country = null): PrivateCustomerDto
    {
        return $this->repository->generatePrivateCustomer($seed, $country, $this->getLocale());
    }

    public function privateCustomerByNumber(string $number): PrivateCustomerDto
    {
        $customer = $this->repository->getPrivateCustomerByNumber($number);
        if ($customer === null) {
            throw new InvalidArgumentException("Private customer with number '{$number}' not found.");
        }

        return $customer;
    }

    abstract protected function getLocale(): string;
}
