<?php

declare(strict_types=1);

namespace Bambamboole\ExtendedFaker\Generator;

use Bambamboole\ExtendedFaker\Dto\CompanyCustomerDto;
use Bambamboole\ExtendedFaker\Dto\ConversationCategory;
use Bambamboole\ExtendedFaker\Dto\ConversationDto;
use Bambamboole\ExtendedFaker\Dto\ConversationStatus;
use Bambamboole\ExtendedFaker\Dto\MessageDto;
use Bambamboole\ExtendedFaker\Dto\MessageRole;
use Bambamboole\ExtendedFaker\Dto\PrivateCustomerDto;
use Bambamboole\ExtendedFaker\Repository\ProductRepository;
use DateTimeImmutable;
use DateTimeZone;
use Random\Engine\Mt19937;
use Random\Randomizer;

class ConversationGenerator
{
    /** @var array<string, array<int, array<string, mixed>>>|null */
    private static ?array $scripts = null;

    private const AGENTS = [
        'Alex Weber',
        'Sam Rivera',
        'Chris Lindner',
        'Jamie Fischer',
        'Robin Keller',
        'Taylor Brandt',
        'Morgan Vogel',
        'Casey Sommer',
    ];

    private const AGENT_DOMAIN = 'support.example.com';

    private const SEED_MAX = 2147483647;

    private const MIN_REPLY_DELAY_SECONDS = 1800;

    private const MAX_REPLY_DELAY_SECONDS = 172800;

    public function __construct(
        private readonly string $templatesPath,
        private readonly CustomerGenerator $customers = new CustomerGenerator,
        private readonly ProductRepository $products = new ProductRepository,
    ) {}

    public function generate(
        int $seed,
        ?ConversationCategory $category = null,
        string $country = 'US',
        string $locale = 'en_US',
    ): ConversationDto {
        $this->loadScripts();

        $random = new Randomizer(new Mt19937($seed));

        // The category roll is always consumed so that regenerating with the
        // explicit category decoded from the number yields the identical
        // conversation.
        $rolled = ConversationCategory::cases()[$random->getInt(0, count(ConversationCategory::cases()) - 1)];
        $category ??= $rolled;

        $customer = $this->generateCustomer($category, $country, $random);
        $product = $category === ConversationCategory::General
            ? null
            : $this->products->generate($random->getInt(0, self::SEED_MAX), null, $locale);

        $script = $this->pick(self::$scripts[$category->value], $random);
        $agentName = $this->pick(self::AGENTS, $random);
        [$customerName, $customerEmail] = $this->customerAuthor($customer, $random);

        $placeholders = [
            '{customerName}' => $customerName,
            '{agentName}' => $agentName,
            '{agentFirstName}' => explode(' ', $agentName)[0],
            '{product}' => $product->name ?? '',
            '{quantity}' => (string) $random->getInt(10, 500),
            '{orderNumber}' => 'ORD-'.$random->getInt(100000, 999999),
        ];

        $agentEmail = $this->slug($agentName).'@'.self::AGENT_DOMAIN;
        $sentAt = $random->getInt(
            (int) strtotime('2023-01-01 00:00:00 UTC'),
            (int) strtotime('2025-12-31 23:59:59 UTC'),
        );

        $messages = [];
        foreach ($script['messages'] as $index => $message) {
            if ($index > 0) {
                $sentAt += $random->getInt(self::MIN_REPLY_DELAY_SECONDS, self::MAX_REPLY_DELAY_SECONDS);
            }

            $role = MessageRole::from($message['role']);
            $messages[] = new MessageDto(
                role: $role,
                authorName: $role === MessageRole::Customer ? $customerName : $agentName,
                authorEmail: $role === MessageRole::Customer ? $customerEmail : $agentEmail,
                sentAt: (new DateTimeImmutable('@'.$sentAt))->setTimezone(new DateTimeZone('UTC')),
                body: strtr($message['body'][$locale] ?? $message['body']['en_US'], $placeholders),
            );
        }

        return new ConversationDto(
            number: ConversationNumber::encode($country, $category, $seed),
            category: $category,
            status: ConversationStatus::from($script['status']),
            subject: strtr($script['subject'][$locale] ?? $script['subject']['en_US'], $placeholders),
            customer: $customer,
            productSku: $product?->sku,
            messages: $messages,
            locale: $locale,
        );
    }

    private function generateCustomer(
        ConversationCategory $category,
        string $country,
        Randomizer $random,
    ): PrivateCustomerDto|CompanyCustomerDto {
        $isCompany = $category === ConversationCategory::Quote || $random->getInt(0, 9) >= 7;
        $customerSeed = $random->getInt(0, self::SEED_MAX);

        return $isCompany
            ? $this->customers->companyCustomer($customerSeed, $country)
            : $this->customers->privateCustomer($customerSeed, $country);
    }

    /**
     * @return array{string, string}
     */
    private function customerAuthor(PrivateCustomerDto|CompanyCustomerDto $customer, Randomizer $random): array
    {
        if ($customer instanceof PrivateCustomerDto) {
            return [$customer->firstName.' '.$customer->lastName, $customer->email];
        }

        if ($customer->contacts !== []) {
            $contact = $this->pick($customer->contacts, $random);

            return [$contact->firstName.' '.$contact->lastName, $contact->email];
        }

        return [$customer->name, $customer->email];
    }

    private function loadScripts(): void
    {
        if (self::$scripts !== null) {
            return;
        }

        self::$scripts = [];

        foreach (ConversationCategory::cases() as $category) {
            $filePath = $this->templatesPath.'/'.$category->value.'.json';

            $content = @file_get_contents($filePath);
            if ($content === false) {
                throw new \RuntimeException("Conversation template file not readable: {$filePath}");
            }

            $data = json_decode($content, true);
            if (! is_array($data) || ! isset($data['scripts']) || ! is_array($data['scripts']) || $data['scripts'] === []) {
                throw new \RuntimeException("Conversation template must contain a non-empty 'scripts' array: {$filePath}");
            }

            self::$scripts[$category->value] = $data['scripts'];
        }
    }

    /**
     * @template T
     *
     * @param  array<int, T>  $items
     * @return T
     */
    private function pick(array $items, Randomizer $random)
    {
        return $items[$random->getInt(0, count($items) - 1)];
    }

    private function slug(string $value): string
    {
        return trim((string) preg_replace('/[^a-z0-9]+/', '.', strtolower($value)), '.');
    }
}
