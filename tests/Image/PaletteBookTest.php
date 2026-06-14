<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Image\Palette;
use Bambamboole\ExtendedFaker\Image\PaletteBook;

it('returns a Palette and is deterministic for the same key', function () {
    $book = new PaletteBook;

    $a = $book->pick('PHONE-002');
    $b = $book->pick('PHONE-002');

    expect($a)->toBeInstanceOf(Palette::class)
        ->and($a)->toEqual($b);
});

it('spreads different keys across more than one palette', function () {
    $book = new PaletteBook;
    $keys = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l'];

    $backgrounds = array_map(fn (string $k) => $book->pick($k)->background, $keys);

    expect(count(array_unique($backgrounds)))->toBeGreaterThan(1);
});
