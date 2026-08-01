<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

use DateTimeImmutable;

class SupplierDto
{
    /**
     * @param  list<ContactDto>  $contacts
     * @param  list<string>  $suppliedCategories
     */
    public function __construct(
        public string $number,
        public string $name,
        public string $legalForm,
        public string $vatId,
        public ?string $taxNumber,
        public string $email,
        public string $phone,
        public string $mobile,
        public string $website,
        public AddressDto $address,
        public array $contacts,
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
            'tax_number' => $this->taxNumber,
            'email' => $this->email,
            'phone' => $this->phone,
            'mobile' => $this->mobile,
            'website' => $this->website,
            'address' => $this->address->toArray(),
            'contacts' => array_map(fn (ContactDto $contact): array => $contact->toArray(), $this->contacts),
            'customer_since' => $this->customerSince->format('Y-m-d'),
            'iban' => $this->iban,
            'payment_terms' => $this->paymentTerms,
            'supplied_categories' => $this->suppliedCategories,
        ];
    }
}
