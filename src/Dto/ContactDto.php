<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

class ContactDto
{
    public function __construct(
        public Salutation $salutation,
        public string $firstName,
        public string $lastName,
        public string $email,
        public string $phone,
        public ContactRole $role,
    ) {}

    /**
     * @return array{salutation: string, first_name: string, last_name: string, email: string, phone: string, role: string}
     */
    public function toArray(): array
    {
        return [
            'salutation' => $this->salutation->value,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'role' => $this->role->value,
        ];
    }
}
