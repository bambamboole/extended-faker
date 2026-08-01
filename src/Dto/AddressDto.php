<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

class AddressDto
{
    public function __construct(
        public string $street,
        public string $city,
        public string $zip,
        public string $countryCode,
    ) {}

    /**
     * @return array{street: string, city: string, zip: string, country_code: string}
     */
    public function toArray(): array
    {
        return [
            'street' => $this->street,
            'city' => $this->city,
            'zip' => $this->zip,
            'country_code' => $this->countryCode,
        ];
    }
}
