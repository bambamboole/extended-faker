---
name: creating-fixture-images
description: Use when adding or regenerating Extended Faker's comic fixture images (products, categories, pages) — covers the bold-outline SVG motif system and the WebP build command.
---

# Creating Fixture Images

Extended Faker ships small, copyright-safe, **bold-outline comic** images for every
product, category, and page. They are generated procedurally as SVG and committed as
both `.svg` (canonical source) and `.webp` (shipped fixture) under `resources/images/`.

## Style rules

- Draw inside a `0 0 100 100` viewBox.
- Bold outlines: `stroke="'.$p->outline.'"`, `stroke-width="3"` (2–2.5 for fine detail).
- Flat fills from the palette: `$p->primary`, `$p->secondary`, `$p->accent`.
- Reverse details out with `$p->background` (matches the tile, e.g. a lock keyhole).
- Keep the subject simple and recognizable at thumbnail size.

## Architecture

- `src/Image/Palette.php` / `PaletteBook.php` — color sets; `pick($seed)` is deterministic
  (`crc32($seed) % count`).
- `src/Image/Motif.php` + `src/Image/Motif/*Motif.php` — one class per subject, each a
  `draw(Palette $p): string` returning inner SVG shapes.
- `src/Image/MotifRegistry.php` — maps category keys + page slugs → motif.
- `src/Image/ComicSvgGenerator.php` — assembles the full `<svg>` (background tile + motif).
- `src/Image/ImagePath.php` — the `images/{type}/{key}.webp` path scheme.

## Add a new motif

1. Create `src/Image/Motif/<Name>Motif.php` implementing `Motif` (copy `PhoneMotif` or
   `ShoeMotif` as a template).
2. Register it in `src/Image/MotifRegistry.php` under the category key or page slug.
3. The coverage tests (`tests/Image/CategoryCoverageTest.php`,
   `tests/Image/PageCoverageTest.php`) enforce that every key has a non-fallback motif.
4. Regenerate (below) and review the rendered output.

## Regenerate the images

```bash
npm install            # one-time: installs sharp (the SVG rasterizer)
composer images:build  # generates resources/images/{type}/{key}.{svg,webp}
```

`composer images:build` generates the SVGs in PHP, then rasterizes them to WebP with
`bin/svg-to-webp.mjs` (Node + sharp). **sharp is required because the common ImageMagick
build renders SVG via its internal MSVG renderer, which silently drops strokes — i.e. the
outlines.** sharp (libvips) renders strokes correctly. The shipped package never rasterizes;
it only reads the committed WebP files.

## Determinism

The SVG is fully deterministic (motif + palette seeded from the item key). WebP bytes may
differ slightly across sharp/libvips versions, so treat `.svg` as the source of truth and
only regenerate `.webp` intentionally — review the diff before committing.

## Variety

Each item's palette is picked by `crc32(seed) % count`, so same-category products differ in
color. Product palettes are seeded from the base SKU, categories/pages from their key/slug.
