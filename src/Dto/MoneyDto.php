<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

class MoneyDto
{
    public function __construct(
        public int $amount,
        public string $currency,
    ) {}

    /**
     * @return array{amount: int, currency: string}
     */
    public function toArray(): array
    {
        return [
            'amount' => $this->amount,
            'currency' => $this->currency,
        ];
    }
}
