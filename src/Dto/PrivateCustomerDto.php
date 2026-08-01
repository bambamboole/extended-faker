<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

use DateTimeImmutable;

class PrivateCustomerDto
{
    public function __construct(
        public string $number,
        public Salutation $salutation,
        public ?string $academicTitle,
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $phone,
        public string $mobile,
        public DateTimeImmutable $birthdate,
        public AddressDto $address,
        public DateTimeImmutable $customerSince,
        public ?string $iban,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'number' => $this->number,
            'salutation' => $this->salutation->value,
            'academic_title' => $this->academicTitle,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'birthdate' => $this->birthdate->format('Y-m-d'),
            'address' => $this->address->toArray(),
            'customer_since' => $this->customerSince->format('Y-m-d'),
            'iban' => $this->iban,
        ];
    }
}
