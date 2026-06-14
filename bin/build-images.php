<?php

declare(strict_types=1);

use Bambamboole\ExtendedFaker\Image\ComicSvgGenerator;
use Bambamboole\ExtendedFaker\Repository\CategoryRepository;

require __DIR__.'/../vendor/autoload.php';

$resources = __DIR__.'/../resources';
$generator = new ComicSvgGenerator;

/** @var list<array{key: string, motifKey: string, paletteSeed: string, type: string, size: int}> $jobs */
$jobs = [];

// Products: motif = category, palette seed = base SKU, square 256.
foreach (glob($resources.'/products/*.json') as $file) {
    /** @var array{sku: string, category: string} $data */
    $data = json_decode((string) file_get_contents($file), true, 512, JSON_THROW_ON_ERROR);
    $jobs[] = [
        'key' => $data['sku'],
        'motifKey' => $data['category'],
        'paletteSeed' => $data['sku'],
        'type' => 'products',
        'size' => 256,
    ];
}

// Categories: motif = key, palette seed = key, square 256.
foreach ((new CategoryRepository)->getAllCategoryKeys() as $key) {
    $jobs[] = ['key' => $key, 'motifKey' => $key, 'paletteSeed' => $key, 'type' => 'categories', 'size' => 256];
}

// Pages: motif = slug, palette seed = slug, square 512.
foreach (glob($resources.'/pages/*.json') as $file) {
    $slug = basename($file, '.json');
    $jobs[] = ['key' => $slug, 'motifKey' => $slug, 'paletteSeed' => $slug, 'type' => 'pages', 'size' => 512];
}

// Generate SVGs (PHP, deterministic) and collect a rasterization manifest.
$manifest = [];
foreach ($jobs as $job) {
    $dir = $resources.'/images/'.$job['type'];
    if (! is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    $svgPath = $dir.'/'.$job['key'].'.svg';
    $webpPath = $dir.'/'.$job['key'].'.webp';
    file_put_contents($svgPath, $generator->generate($job['motifKey'], $job['paletteSeed']));
    $manifest[] = ['svg' => $svgPath, 'webp' => $webpPath, 'size' => $job['size']];
}

echo 'Generated '.count($manifest)." SVGs into resources/images/\n";

// Rasterize SVG -> WebP via sharp (Node). Build-time only; the shipped package never needs this.
$manifestPath = tempnam(sys_get_temp_dir(), 'ef-img-').'.json';
file_put_contents($manifestPath, json_encode($manifest, JSON_THROW_ON_ERROR));

$cmd = 'node '.escapeshellarg(__DIR__.'/svg-to-webp.mjs').' '.escapeshellarg($manifestPath).' 2>&1';
exec($cmd, $output, $exitCode);
@unlink($manifestPath);

echo implode("\n", $output)."\n";

if ($exitCode !== 0) {
    fwrite(STDERR, "Rasterization failed. Ensure Node.js and sharp are installed (run: npm install).\n");
    exit(1);
}
