<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Repository;

use Bambamboole\ExtendedFaker\Dto\ConversationCategory;
use Bambamboole\ExtendedFaker\Dto\ConversationDto;
use Bambamboole\ExtendedFaker\Generator\ConversationGenerator;
use Bambamboole\ExtendedFaker\Generator\ConversationNumber;

class ConversationRepository
{
    private const SEED_MAX = 2147483647;

    public function __construct(
        private readonly ConversationGenerator $generator,
    ) {}

    public function generateConversation(
        int $seed,
        ?ConversationCategory $category = null,
        ?string $country = null,
        string $locale = 'en_US',
    ): ConversationDto {
        return $this->generator->generate(
            $seed,
            $category,
            $country ?? CustomerRepository::countryForLocale($locale),
            $locale,
        );
    }

    public function getConversationByNumber(string $number, string $locale = 'en_US'): ?ConversationDto
    {
        $decoded = ConversationNumber::decode($number);
        if ($decoded === null) {
            return null;
        }

        return $this->generator->generate($decoded['seed'], $decoded['category'], $decoded['country'], $locale);
    }

    public function getRandomConversation(string $locale = 'en_US', ?ConversationCategory $category = null): ConversationDto
    {
        return $this->generateConversation(random_int(0, self::SEED_MAX), $category, null, $locale);
    }
}
