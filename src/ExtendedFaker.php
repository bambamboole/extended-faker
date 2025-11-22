<?php declare(strict_types=1);
namespace Bambamboole\ExtendedFaker;

use Bambamboole\ExtendedFaker\Providers as Providers;
use Faker\Generator;

class ExtendedFaker
{
    public static function extend(Generator $faker, string $locale = 'en_US'): void
    {
        if (str_starts_with($locale, 'de')) {
            $faker->addProvider(new Providers\de_DE\Product($faker));
            $faker->addProvider(new Providers\de_DE\Category($faker));
            $faker->addProvider(new Providers\de_DE\BlogPost($faker));
        } else {
            $faker->addProvider(new Providers\en_US\Product($faker));
            $faker->addProvider(new Providers\en_US\Category($faker));
            $faker->addProvider(new Providers\en_US\BlogPost($faker));
        }
    }
}
