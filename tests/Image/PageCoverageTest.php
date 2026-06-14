<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Image\Motif\FallbackMotif;
use Bambamboole\ExtendedFaker\Image\MotifRegistry;

it('has a non-fallback motif for every page slug', function () {
    $registry = new MotifRegistry;

    $slugs = array_map(
        fn (string $f) => basename($f, '.json'),
        glob(__DIR__.'/../../resources/pages/*.json'),
    );

    expect($slugs)->not->toBeEmpty();

    foreach ($slugs as $slug) {
        expect($registry->has($slug))->toBeTrue("missing motif for page '{$slug}'")
            ->and($registry->for($slug))->not->toBeInstanceOf(FallbackMotif::class);
    }
});
