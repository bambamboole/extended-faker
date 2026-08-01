# Material Products, Units & Prices — Design

**Date:** 2026-08-01
**Status:** Approved

## Goal

Add five construction-material product categories (paint & coatings,
construction wood, concrete & mortar, fasteners, electrical supplies) to the
generative product system, and give **every** product — new and existing —
a structured unit (`unitAmount` + `unit`) and a deterministic price
(`MoneyDto`).

## Core decisions

- **Template-driven.** Units and prices are defined per category in the
  existing product-template JSON files; the generator machinery gets two new
  draws, no new subsystems.
- **Units appear in product names** via a `{unit}` placeholder, exactly like
  the existing `storage`/`size` variants ("Structo Wall Paint Matt **10 l**"),
  and simultaneously as structured DTO fields.
- **Every product gets unit and price.** The 19 existing templates gain
  `unitVariants: [{amount: 1, unit: "pc", label: ...}]`-style entries and a
  sensible `priceRange`. No nullable unit fields.
- **Money is integer minor units** (`MoneyDto`), never floats. Currency
  follows locale: `en_US` → `USD`, `de_DE` → `EUR`, same numeric amount
  (fake data does not need FX).
- **Unit codes are locale-independent** short strings: `pc`, `l`, `kg`, `m`,
  `m2`, `set`. Names (which are shared across locales) embed the label
  unchanged.

## New categories

Flat categories like the existing 19 (the `parent` field stays unused).

| Key                   | SKU prefix | Name en / de                                 | Typical units        |
|-----------------------|------------|----------------------------------------------|----------------------|
| `paint-coatings`      | `PT`       | Paint & Coatings / Farben & Lacke            | 0.75 l – 10 l        |
| `construction-wood`   | `WD`       | Construction Wood / Bauholz                  | pc, m, m2 (panels)   |
| `concrete-mortar`     | `CM`       | Concrete & Mortar / Beton & Mörtel           | 5 kg – 40 kg bags    |
| `fasteners`           | `FS`       | Fasteners / Befestigungstechnik              | 50–1000 pc boxes     |
| `electrical-supplies` | `ES`       | Electrical Supplies / Elektromaterial        | m (cable), pc, set   |

Each category ships the usual pair of files (`resources/categories/<key>.json`,
`resources/product-templates/<key>.json`) with synthetic trademark-free brand
pools (new construction-flavored brands, e.g. "Structo", "Betonix", "Fixato" —
distinct from existing pools), item/variant pools appropriate to the trade
(wall paint/primer/varnish; studs/boards/OSB panels; cement/screed/plaster;
screws/nails/anchors/bolts; cable/switches/sockets/breakers), and localized
`en_US`/`de_DE` description templates.

## Template schema additions (all 24 templates)

```json
{
  "unitVariants": [
    { "amount": 2.5, "unit": "l", "label": "2.5 l" },
    { "amount": 10,  "unit": "l", "label": "10 l" }
  ],
  "priceRange": { "min": 1999, "max": 4999 }
}
```

- `unitVariants`: 1–6 entries. The generator picks one deterministically;
  `label` substitutes a `{unit}` placeholder in `nameTemplate` (new
  categories include `{unit}` in their name templates; existing categories
  keep their current name templates — a template without `{unit}` simply
  doesn't show the label in the name, e.g. books stay "…" with `1 pc`).
- `priceRange`: min/max in **minor units**, and it prices the **first**
  `unitVariants` entry (the reference variant). Other variants scale
  linearly by `amount / referenceAmount`, then the result snaps to a
  realistic ending (`…99`, `…95`, `…49` — picked deterministically).
  Existing single-variant categories scale by 1, so their price is simply
  a draw in range + ending snap.

## DTO changes

**New `MoneyDto`** (ProductDto style: plain class, promoted public props):
`amount` (int, minor units), `currency` (string ISO code), `toArray()`.

**`ProductDto`** gains three constructor parameters appended after `image`,
with defaults so existing manual constructions keep compiling
(backward compatible; the generator always passes all three):

```php
public ?ImageDto $image = null,
public float $unitAmount = 1.0,
public string $unit = 'pc',
public ?MoneyDto $price = null,
```

`toArray()` adds `unit_amount`, `unit`, `price` (nested array or null).

## Generator changes

`ProductGenerator::generate(...)` — two new deterministic draws appended
after the existing variant draws (appending draws does not disturb existing
name/description sequences within a generation):

1. Pick a `unitVariant`; substitute `{unit}` in the name template values.
2. Draw a base price in `priceRange`, scale by the picked variant's
   `amount / referenceAmount`, snap to an ending, build
   `MoneyDto(amount, currency)` where currency comes from the locale
   (`de*` → EUR, else USD).

Same seed + category + locale → byte-identical DTO including price, and
the SKU round-trip (`productBySku`) reproduces unit and price exactly.
Cross-locale: same SKU → same name, unit, and price amount; only currency
and description differ.

## Images

Five new comic motifs (paint bucket/roller, wood planks, cement bag, screw,
plug/cable) following the existing `Motif` system, registered in
`MotifRegistry`; per-category product images for all 8 palettes plus one
category image each, generated with the existing `composer images:build`
pipeline (`bin/build-images.php`) per the repo's fixture-image conventions.

## Testing

- Every template (all 24) has non-empty `unitVariants` (valid amount > 0,
  known unit code, non-empty label) and a `priceRange` with
  `0 < min <= max` — extend the existing template-coverage test.
- Determinism: same seed → identical DTO including price/unit; SKU
  round-trip preserves unit + price.
- Cross-locale: same SKU → same price amount, EUR vs USD currency.
- Price plausibility: price positive and within scaled range bounds (with
  ending tolerance); minor-unit ending always in {49, 95, 99}; a larger
  variant of the same product line costs more than a smaller one.
- New categories generate: name contains the unit label, category name
  localizes, image path points at an existing file.
- Existing behavior guarded: an existing category product still generates
  with `unit = 'pc'`, `unitAmount = 1.0`, non-null price.

## Out of scope

- Price localization/FX (same amount across locales).
- Category hierarchy (`parent` stays unused).
- Per-unit price fields (`pricePerLiter` etc.) — consumers can divide.
- Stock levels, suppliers-per-product linking.

## Docs

README: extend the product section (unit/price fields, new categories,
MoneyDto) and the features list.
