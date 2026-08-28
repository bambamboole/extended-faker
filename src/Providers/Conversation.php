<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Providers;

use Bambamboole\ExtendedFaker\Dto\ConversationCategory;
use Bambamboole\ExtendedFaker\Dto\ConversationDto;
use Bambamboole\ExtendedFaker\Generator\ConversationGenerator;
use Bambamboole\ExtendedFaker\Repository\ConversationRepository;
use Faker\Provider\Base;
use InvalidArgumentException;

abstract class Conversation extends Base
{
    protected ConversationRepository $repository;

    public function __construct($generator, ?ConversationRepository $repository = null)
    {
        parent::__construct($generator);
        $this->repository = $repository ?? new ConversationRepository(
            new ConversationGenerator(__DIR__.'/../../resources/conversation-templates'),
        );
    }

    public function conversation(ConversationCategory|string|null $identifier = null): ConversationDto
    {
        if ($identifier === null) {
            return $this->repository->getRandomConversation($this->getLocale());
        }

        if ($identifier instanceof ConversationCategory) {
            return $this->repository->getRandomConversation($this->getLocale(), $identifier);
        }

        $category = ConversationCategory::tryFrom($identifier);
        if ($category !== null) {
            return $this->repository->getRandomConversation($this->getLocale(), $category);
        }

        return $this->conversationByNumber($identifier);
    }

    public function generateConversation(int $seed, ConversationCategory|string|null $category = null): ConversationDto
    {
        $resolved = is_string($category)
            ? ConversationCategory::tryFrom($category) ?? throw new InvalidArgumentException("Unknown conversation category '{$category}'.")
            : $category;

        return $this->repository->generateConversation($seed, $resolved, null, $this->getLocale());
    }

    public function conversationByNumber(string $number): ConversationDto
    {
        $conversation = $this->repository->getConversationByNumber($number, $this->getLocale());
        if ($conversation === null) {
            throw new InvalidArgumentException("Conversation with number '{$number}' not found.");
        }

        return $conversation;
    }

    public function getConversationInLocale(string $number, string $locale): ConversationDto
    {
        $conversation = $this->repository->getConversationByNumber($number, $locale);
        if ($conversation === null) {
            throw new InvalidArgumentException("Conversation with number '{$number}' not found in locale '{$locale}'.");
        }

        return $conversation;
    }

    abstract protected function getLocale(): string;
}
