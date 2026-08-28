<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\ConversationCategory;
use Bambamboole\ExtendedFaker\Generator\ConversationNumber;

it('encodes and decodes conversation numbers', function () {
    $number = ConversationNumber::encode('DE', ConversationCategory::Quote, 42);

    expect($number)->toBe('CON-DE-Q-16')
        ->and(ConversationNumber::decode($number))->toBe([
            'country' => 'DE',
            'category' => ConversationCategory::Quote,
            'seed' => 42,
        ]);
});

it('returns null for invalid numbers', function (string $number) {
    expect(ConversationNumber::decode($number))->toBeNull();
})->with(['CON-FR-Q-16', 'CON-DE-X-16', 'CUS-DE-16', 'CON-DE-Q', 'garbage']);
