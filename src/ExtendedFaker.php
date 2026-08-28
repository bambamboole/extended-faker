<?php
declare(strict_types=1);

namespace Bambamboole\ExtendedFaker;

use DavidBadura\FakerMarkdownGenerator\FakerProvider;
use Faker\Generator;

class ExtendedFaker
{
    public static function extend(Generator $faker, string $locale = 'en_US'): void
    {
        $faker->addProvider(new FakerProvider($faker));
        if (str_starts_with($locale, 'de')) {
            $faker->addProvider(new Providers\de_DE\Product($faker));
            $faker->addProvider(new Providers\de_DE\Category($faker));
            $faker->addProvider(new Providers\de_DE\BlogPost($faker));
            $faker->addProvider(new Providers\de_DE\Page($faker));
            $faker->addProvider(new Providers\de_DE\PrivateCustomer($faker));
            $faker->addProvider(new Providers\de_DE\CompanyCustomer($faker));
            $faker->addProvider(new Providers\de_DE\Supplier($faker));
            $faker->addProvider(new Providers\de_DE\Conversation($faker));
        } else {
            $faker->addProvider(new Providers\en_US\Product($faker));
            $faker->addProvider(new Providers\en_US\Category($faker));
            $faker->addProvider(new Providers\en_US\BlogPost($faker));
            $faker->addProvider(new Providers\en_US\Page($faker));
            $faker->addProvider(new Providers\en_US\PrivateCustomer($faker));
            $faker->addProvider(new Providers\en_US\CompanyCustomer($faker));
            $faker->addProvider(new Providers\en_US\Supplier($faker));
            $faker->addProvider(new Providers\en_US\Conversation($faker));
        }
    }
}
