// Rasterizes fixture SVGs to WebP using sharp.
// Invoked by bin/build-images.php with a manifest path. Build-time only.
import sharp from 'sharp';
import { readFileSync } from 'node:fs';

const manifestPath = process.argv[2];
if (!manifestPath) {
    console.error('usage: node bin/svg-to-webp.mjs <manifest.json>');
    process.exit(1);
}

/** @type {{svg: string, webp: string, size: number}[]} */
const jobs = JSON.parse(readFileSync(manifestPath, 'utf8'));

let count = 0;
for (const job of jobs) {
    const svg = readFileSync(job.svg);
    const density = Math.round((72 * job.size) / 100); // render the 100-unit viewBox crisply at target px
    await sharp(svg, { density })
        .resize(job.size, job.size)
        .webp({ lossless: true })
        .toFile(job.webp);
    count++;
}

console.log(`Rasterized ${count} images to webp`);
