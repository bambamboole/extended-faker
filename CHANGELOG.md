# Changelog

## [0.8.0](https://github.com/bambamboole/extended-faker/compare/0.7.0...0.8.0) (2026-06-15)


### Features

* add deterministic compositional ProductGenerator ([f4aa81b](https://github.com/bambamboole/extended-faker/commit/f4aa81ba9af88877d14c9f5c06b86a9c94a7616e))
* add product template loader and exemplar pool ([d1ef567](https://github.com/bambamboole/extended-faker/commit/d1ef567d6e5d3cc09c353f2262c68141529086ca))
* add seed-encoding product SKU codec ([b48786f](https://github.com/bambamboole/extended-faker/commit/b48786f12dbf26f405e326e4009917f2b456ef46))
* author product templates for all categories ([c69fc1e](https://github.com/bambamboole/extended-faker/commit/c69fc1edbf60a1cd0ef5bda45ab730666b7e5c36))
* back ProductRepository with the generator ([e6e2dd2](https://github.com/bambamboole/extended-faker/commit/e6e2dd20ba8faf60e2429c3d2bae7247e38495af))
* enlarge product name space past 1M combinations ([a05c559](https://github.com/bambamboole/extended-faker/commit/a05c5590803f9ed5cc001b9cfed59f2538748161))
* generate products deterministically (unlimited unique products) ([70fc564](https://github.com/bambamboole/extended-faker/commit/70fc5644c3dd4b4b0e99a26c03a0cc2be361cc61))
* generate products in the Product provider; drop name lookups ([e1203a4](https://github.com/bambamboole/extended-faker/commit/e1203a47b9057d3ee80df16b3b0751ae5598ef1a))
* give generated products a per-category, per-colour committed WebP image ([8d28eaf](https://github.com/bambamboole/extended-faker/commit/8d28eaf5f0d02425eb208a7428c32e47153f16c6))


### Bug Fixes

* always consume the category draw so every SKU round-trips ([eff7a27](https://github.com/bambamboole/extended-faker/commit/eff7a2708cb0fa2b0528d29901b01f366044410a))

## [0.6.0](https://github.com/bambamboole/extended-faker/compare/0.5.1...0.6.0) (2026-06-15)


### Features

* add image build pipeline (PHP generator + sharp rasterizer) and committed comic assets ([61b8f6d](https://github.com/bambamboole/extended-faker/commit/61b8f6d619f7c6fd3463c90f8c539f0750aaf90e))
* add procedural comic SVG generator with motifs for all categories and pages ([d1a56cd](https://github.com/bambamboole/extended-faker/commit/d1a56cd79d35992442c3b9699c84711e6ed47b71))
* expose comic image path on products, categories, and pages ([6498199](https://github.com/bambamboole/extended-faker/commit/64981990de3c93e3e6914a08bc26da553f19d19c))
* expose product image metadata dto ([8e13a95](https://github.com/bambamboole/extended-faker/commit/8e13a958d12e762859122395a6a91f7844275243))
* expose product image metadata DTO ([b2d3ad1](https://github.com/bambamboole/extended-faker/commit/b2d3ad167b297137f9503fcb11ad31b78da1520e))
* render all fixture images at 1024x1024 ([1042aa2](https://github.com/bambamboole/extended-faker/commit/1042aa217a6b622373577d50b5f42af4e8742421))
