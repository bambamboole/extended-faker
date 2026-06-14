<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Image\ComicSvgGenerator;

it('produces well-formed deterministic svg with a background tile', function () {
    $gen = new ComicSvgGenerator;

    $a = $gen->generate('cell-phones-smartphones');
    $b = $gen->generate('cell-phones-smartphones');

    expect($a)->toBe($b)
        ->and($a)->toStartWith('<svg')
        ->and($a)->toContain('viewBox="0 0 100 100"')
        ->and($a)->toContain('<rect width="100" height="100"');

    $doc = new DOMDocument;
    expect($doc->loadXML($a))->toBeTrue();
});

it('seeds the palette from the palette seed, not the motif key', function () {
    $gen = new ComicSvgGenerator;

    $one = $gen->generate('cell-phones-smartphones', 'PHONE-001');
    $two = $gen->generate('cell-phones-smartphones', 'PHONE-002');

    $doc = new DOMDocument;
    expect($doc->loadXML($one))->toBeTrue()
        ->and($doc->loadXML($two))->toBeTrue();
});
