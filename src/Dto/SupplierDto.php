<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

use DateTimeImmutable;

class SupplierDto
{
    /**
     * @param  list<string>  $suppliedCategories
     */
    public function __construct(
        public string $number,
        public string $name,
        public string $legalForm,
        public string $vatId,
        public string $email,
        public string $phone,
        public string $website,
        public AddressDto $address,
        public string $contactName,
        public string $contactEmail,
        public DateTimeImmutable $customerSince,
        public ?string $iban,
        public string $paymentTerms,
        public array $suppliedCategories,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'number' => $this->number,
            'name' => $this->name,
            'legal_form' => $this->legalForm,
            'vat_id' => $this->vatId,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
            'address' => $this->address->toArray(),
            'contact_name' => $this->contactName,
            'contact_email' => $this->contactEmail,
            'customer_since' => $this->customerSince->format('Y-m-d'),
            'iban' => $this->iban,
            'payment_terms' => $this->paymentTerms,
            'supplied_categories' => $this->suppliedCategories,
        ];
    }
}
