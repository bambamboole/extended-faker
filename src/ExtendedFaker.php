<?php declare(strict_types=1);
namespace Bambamboole\ExtendedFaker;

use Bambamboole\ExtendedFaker\Providers as Providers;

class ExtendedFaker
{
    public static function extend(\Faker\Generator $faker): void
    {
        $faker->addProvider(new Providers\en_US\Product($faker));
        $faker->addProvider(new Providers\en_US\Category($faker));
        $faker->addProvider(new Providers\de_DE\Product($faker));
        $faker->addProvider(new Providers\de_DE\Category($faker));
    }
}
