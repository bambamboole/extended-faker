<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Dto\CompanyCustomerDto;
use Bambamboole\ExtendedFaker\Dto\ConversationCategory;
use Bambamboole\ExtendedFaker\Dto\ConversationDto;
use Bambamboole\ExtendedFaker\Dto\MessageDto;
use Bambamboole\ExtendedFaker\Dto\MessageRole;
use Bambamboole\ExtendedFaker\ExtendedFaker;
use Faker\Factory;
use Faker\Generator;

function conversationFaker(string $locale = 'en_US'): Generator
{
    $faker = Factory::create($locale);
    ExtendedFaker::extend($faker, $locale);

    return $faker;
}

it('exposes conversations through the faker generator', function () {
    $conversation = conversationFaker()->conversation();

    expect($conversation)->toBeInstanceOf(ConversationDto::class)
        ->and($conversation->messages)->not->toBeEmpty()
        ->and($conversation->messages)->each->toBeInstanceOf(MessageDto::class)
        ->and($conversation->messages[0]->role)->toBe(MessageRole::Customer);
});

it('generates deterministically by seed', function () {
    $faker = conversationFaker();

    expect($faker->generateConversation(7)->toArray())->toBe($faker->generateConversation(7)->toArray());
});

it('accepts a category as identifier and filter', function () {
    $faker = conversationFaker();

    expect($faker->conversation('quote')->category)->toBe(ConversationCategory::Quote)
        ->and($faker->conversation(ConversationCategory::Complaint)->category)->toBe(ConversationCategory::Complaint)
        ->and($faker->generateConversation(3, 'support')->category)->toBe(ConversationCategory::Support);
});

it('links quote conversations to company customers', function () {
    $conversation = conversationFaker()->conversation(ConversationCategory::Quote);

    expect($conversation->customer)->toBeInstanceOf(CompanyCustomerDto::class);
});

it('round-trips a conversation by its number', function () {
    $faker = conversationFaker();
    $made = $faker->generateConversation(123);

    expect($faker->conversation($made->number)->toArray())->toBe($made->toArray())
        ->and($faker->conversationByNumber($made->number)->toArray())->toBe($made->toArray());
});

it('returns the same structure with localized text across locales', function () {
    $de = conversationFaker('de_DE');
    $en = conversationFaker('en_US');

    $conversation = $de->generateConversation(42, 'support');
    $translated = $en->getConversationInLocale($conversation->number, 'en_US');

    expect($conversation->customer->address->countryCode)->toBe('DE')
        ->and($translated->customer->toArray())->toBe($conversation->customer->toArray())
        ->and($translated->productSku)->toBe($conversation->productSku)
        ->and($translated->status)->toBe($conversation->status)
        ->and(count($translated->messages))->toBe(count($conversation->messages))
        ->and($translated->subject)->not->toBe($conversation->subject);

    foreach ($conversation->messages as $index => $message) {
        expect($translated->messages[$index]->role)->toBe($message->role)
            ->and($translated->messages[$index]->sentAt->getTimestamp())->toBe($message->sentAt->getTimestamp());
    }
});

it('resolves all placeholders in subject and messages', function () {
    $faker = conversationFaker();

    foreach (range(0, 25) as $seed) {
        $conversation = $faker->generateConversation($seed);

        expect($conversation->subject)->not->toContain('{');
        foreach ($conversation->messages as $message) {
            expect($message->body)->not->toContain('{');
        }
    }
});

it('references a resolvable product for product-related categories', function () {
    $faker = conversationFaker();
    $conversation = $faker->generateConversation(11, ConversationCategory::Complaint);

    expect($conversation->productSku)->not->toBeNull()
        ->and($faker->productBySku($conversation->productSku)->name)->not->toBe('')
        ->and($faker->generateConversation(11, ConversationCategory::General)->productSku)->toBeNull();
});

it('keeps messages in chronological order', function () {
    $conversation = conversationFaker()->generateConversation(99);

    $previous = null;
    foreach ($conversation->messages as $message) {
        if ($previous !== null) {
            expect($message->sentAt->getTimestamp())->toBeGreaterThan($previous->getTimestamp());
        }
        $previous = $message->sentAt;
    }
});

it('throws for an unknown conversation number', function () {
    conversationFaker()->conversationByNumber('CON-FR-Q-16');
})->throws(InvalidArgumentException::class);

it('yields unique conversations at scale via unique()', function () {
    $faker = conversationFaker();

    $seen = [];
    for ($i = 0; $i < 500; $i++) {
        $seen[$faker->unique()->conversation()->number] = true;
    }

    expect(count($seen))->toBe(500);
})->group('scale');
