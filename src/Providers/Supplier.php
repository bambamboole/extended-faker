<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Bambamboole\ExtendedFaker\Dto\SupplierDto;
use Bambamboole\ExtendedFaker\Repository\CustomerRepository;
use Faker\Provider\Base;
use InvalidArgumentException;

abstract class Supplier extends Base
{
    protected CustomerRepository $repository;

    public function __construct($generator)
    {
        parent::__construct($generator);
        $this->repository = new CustomerRepository;
    }

    public function supplier(?string $number = null): SupplierDto
    {
        if ($number === null) {
            return $this->repository->getRandomSupplier($this->getLocale());
        }

        return $this->supplierByNumber($number);
    }

    public function generateSupplier(int $seed, ?string $country = null): SupplierDto
    {
        return $this->repository->generateSupplier($seed, $country, $this->getLocale());
    }

    public function supplierByNumber(string $number): SupplierDto
    {
        $supplier = $this->repository->getSupplierByNumber($number);
        if ($supplier === null) {
            throw new InvalidArgumentException("Supplier with number '{$number}' not found.");
        }

        return $supplier;
    }

    abstract protected function getLocale(): string;
}
