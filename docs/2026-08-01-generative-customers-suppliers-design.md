# Generative Customers & Suppliers — Design

**Date:** 2026-08-01
**Status:** Approved

## Goal

Extend Extended Faker with three new generative entity types: private customers
(B2C persons), company customers (B2B), and suppliers. They follow the
generative product pattern: deterministic seed-based generation with a
round-trippable identifier, effectively unlimited unique entities, consistent
across locales.

## Core decisions

- **Generative, not fixture-backed.** Like products: seed → entity, identifier
  encodes the seed, same identifier always yields the same entity.
- **Country baked into the ID.** A person/company lives in one country; names
  and addresses do not translate. The faker locale only picks the default
  country at generation time (`de_DE` → DE, everything else → US). Looking up
  an existing number from any locale returns the identical entity.
- **Synthetic company names** composed from the existing product brand pools —
  trademark-free, consistent with the product philosophy. Person names come
  from native FakerPHP locale pools.
- **Supported countries: DE and US only**, matching the two supported locales.
  Adding a locale later means adding a country mapping.

## Identifiers

Reuse `ProductSku` verbatim; the country is part of the prefix (decode splits
on the last dash, so multi-dash prefixes already work):

| Type             | Example       | Prefix   |
|------------------|---------------|----------|
| Private customer | `CUS-DE-K3J2` | `CUS-DE` |
| Company customer | `BUS-US-8FA1` | `BUS-US` |
| Supplier         | `SUP-DE-2M0X` | `SUP-DE` |

Decoding yields `(type, country, seed)`; regeneration is deterministic.

## DTOs

All `final` + `readonly`, like `ProductDto`.

**`AddressDto`** (shared): `street`, `city`, `zip`, `countryCode` (`"DE"`/`"US"`).

**`PrivateCustomerDto`**: `number`, `firstName`, `lastName`, `email`, `phone`,
`birthdate` (`DateTimeImmutable`), `address`, `customerSince`
(`DateTimeImmutable`), `iban` (`?string`, null for US).

**`CompanyCustomerDto`**: `number`, `name`, `legalForm`, `vatId`, `email`,
`phone`, `website`, `address`, `contactName`, `contactEmail`, `customerSince`,
`iban` (`?string`, null for US).

**`SupplierDto`**: all `CompanyCustomerDto` fields, plus `paymentTerms`
(e.g. `"net 30"`) and `suppliedCategories` (1–3 category keys from the
existing `CategoryRepository`).

## Generation

One `CustomerGenerator` (mirrors `ProductGenerator`: seeded
`Random\Randomizer` with `Mt19937`), with shared person/company/address
helpers used by all three entity types:

- **Person names, streets, cities, zips**: native FakerPHP locale providers.
  A faker instance is created per *country* (`de_DE` pools for DE, `en_US`
  for US — independent of the active provider locale) and seeded per entity,
  so output is deterministic and country-correct with no new curated data.
- **Company names**: synthetic — product brand pool + suffix pool
  ("Logistics", "Trading", "Group", …) + legal form (GmbH/AG for DE,
  Inc/LLC for US). `name` is the full display name including the legal form
  ("Voltari Logistics GmbH"); `legalForm` holds it separately ("GmbH").
- **Emails**: derived from the person/company name on safe domains
  (`example.com` / `example.org` / `example.net`) — never real addresses.
- **Country formats**:
  - DE: IBAN with valid mod-97 checksum (via `Faker\Calculator\Iban`),
    VAT `DE` + 9 digits, phone `+49 …`.
  - US: EIN-style tax id (`xx-xxxxxxx`), phone `+1 …`, `iban` = null.
- **Dates**: `birthdate` (adults, 18–80), `customerSince` (recent years),
  both derived from the seeded randomizer, not the clock, so generation is
  fully deterministic.
- **Supplier extras**: `paymentTerms` from a small pool (net 14/30/60, …),
  `suppliedCategories` picked deterministically from category keys.

## Wiring

- `src/Generator/CustomerGenerator.php` — generates all three types.
- `src/Repository/CustomerRepository.php` — `getRandom*`, `get*ByNumber`,
  `generate*` for all three types, mirroring `ProductRepository`.
- Abstract providers `Providers/PrivateCustomer`, `Providers/CompanyCustomer`,
  `Providers/Supplier` with `en_US`/`de_DE` subclasses (existing `getLocale()`
  pattern), registered in `ExtendedFaker::extend`.

Provider API per type follows the product verbs, e.g. for private customers:

```php
$faker->privateCustomer();                     // random PrivateCustomerDto
$faker->generatePrivateCustomer(42);           // deterministic by seed
$faker->privateCustomerByNumber('CUS-DE-16');  // round-trips
```

Same shape for `companyCustomer*` and `supplier*`. No method-name collisions
with native Faker providers.

## Testing

Mirror the product test suite:

- Determinism: same seed → identical DTO.
- Round-trip: `*ByNumber` on a generated number returns the identical entity.
- Cross-locale identity: a DE customer looked up from an `en_US` faker is
  identical to the original.
- Uniqueness at scale (`unique()` over many draws).
- DE IBANs pass mod-97 validation; US entities have `iban === null`.
- All emails end in `example.com|org|net`.
- Supplier categories are valid `CategoryRepository` keys.

## Out of scope

- Fixture images / avatars for customers (nothing needs them; the existing
  motif system can add them later).
- Countries beyond DE/US.
- Relations between customers and orders/products (no order entity exists).

## Docs

README usage section per type; `docs/` entry alongside the existing
generative-products doc.
