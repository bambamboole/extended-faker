<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

class ConversationDto
{
    /**
     * @param  list<MessageDto>  $messages
     */
    public function __construct(
        public string $number,
        public ConversationCategory $category,
        public ConversationStatus $status,
        public string $subject,
        public PrivateCustomerDto|CompanyCustomerDto $customer,
        public ?string $productSku,
        public array $messages,
        public string $locale,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'number' => $this->number,
            'category' => $this->category->value,
            'status' => $this->status->value,
            'subject' => $this->subject,
            'customer_number' => $this->customer->number,
            'product_sku' => $this->productSku,
            'messages' => array_map(fn (MessageDto $message) => $message->toArray(), $this->messages),
            'locale' => $this->locale,
        ];
    }
}
