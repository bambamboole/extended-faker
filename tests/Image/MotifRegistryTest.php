<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Image\Motif;
use Bambamboole\ExtendedFaker\Image\Motif\FallbackMotif;
use Bambamboole\ExtendedFaker\Image\MotifRegistry;
use Bambamboole\ExtendedFaker\Image\Palette;

function samplePalette(): Palette
{
    return new Palette('#ffffff', '#111111', '#ff6b6b', '#ffd23f', '#4c6ef5');
}

it('resolves a registered motif and falls back for unknown keys', function () {
    $registry = new MotifRegistry;

    expect($registry->has('cell-phones-smartphones'))->toBeTrue()
        ->and($registry->for('cell-phones-smartphones'))->toBeInstanceOf(Motif::class)
        ->and($registry->has('does-not-exist'))->toBeFalse()
        ->and($registry->for('does-not-exist'))->toBeInstanceOf(FallbackMotif::class);
});

it('draws non-empty markup that references palette colors', function () {
    $svg = (new MotifRegistry)->for('coffee-tea')->draw(samplePalette());

    expect($svg)->toBeString()->not->toBe('')
        ->and($svg)->toContain('#111111');
});

it('every registered motif draws well-formed svg fragments', function () {
    $registry = new MotifRegistry;

    foreach ($registry->keys() as $key) {
        $fragment = $registry->for($key)->draw(samplePalette());
        $doc = new DOMDocument;
        $loaded = $doc->loadXML('<svg xmlns="http://www.w3.org/2000/svg">'.$fragment.'</svg>');
        expect($loaded)->toBeTrue("malformed svg for motif '{$key}'");
    }
});
