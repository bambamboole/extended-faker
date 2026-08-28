<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

use DateTimeImmutable;

class MessageDto
{
    public function __construct(
        public MessageRole $role,
        public string $authorName,
        public string $authorEmail,
        public DateTimeImmutable $sentAt,
        public string $body,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'role' => $this->role->value,
            'author_name' => $this->authorName,
            'author_email' => $this->authorEmail,
            'sent_at' => $this->sentAt->format('Y-m-d H:i:s'),
            'body' => $this->body,
        ];
    }
}
