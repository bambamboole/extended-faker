<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Repository\PageRepository;

it('exposes an image path on pages resolving to a committed webp', function () {
    $repo = new PageRepository;

    foreach ($repo->getAllPages('en_US') as $page) {
        expect($page->image)->toBeString()->toStartWith('images/pages/');

        $path = __DIR__.'/../../resources/'.$page->image;
        expect(file_exists($path))->toBeTrue("missing {$page->image}");
        expect(substr((string) file_get_contents($path), 0, 4))->toBe('RIFF');
    }
});
