<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Dto;

enum ConversationCategory: string
{
    case Support = 'support';
    case Quote = 'quote';
    case Complaint = 'complaint';
    case General = 'general';

    public function code(): string
    {
        return match ($this) {
            self::Support => 'S',
            self::Quote => 'Q',
            self::Complaint => 'C',
            self::General => 'G',
        };
    }

    public static function fromCode(string $code): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->code() === $code) {
                return $case;
            }
        }

        return null;
    }
}
