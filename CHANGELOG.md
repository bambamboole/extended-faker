# Changelog

## [0.11.0](https://github.com/bambamboole/extended-faker/compare/0.10.0...0.11.0) (2026-08-01)


### Features

* add project-management and site-management contact roles ([bce8b99](https://github.com/bambamboole/extended-faker/commit/bce8b992b02ba670d522543a4cd29a0a83aa03c6))
* construction-specific contact roles ([49163e3](https://github.com/bambamboole/extended-faker/commit/49163e3c3928e237704d0ff83c09efa03d1d441a))

## [0.10.0](https://github.com/bambamboole/extended-faker/compare/0.9.0...0.10.0) (2026-08-01)


### ⚠ BREAKING CHANGES

* CompanyCustomerDto/SupplierDto lose contactName and contactEmail in favor of contacts; PrivateCustomerDto constructor order changed (salutation moved before the name fields).

### Features

* add contacts, tax number, mobile and academic title to customers ([64218c5](https://github.com/bambamboole/extended-faker/commit/64218c50fd27487075e28a239dd813c75edfeb53))
* add gender-consistent salutation to private customers ([12181fc](https://github.com/bambamboole/extended-faker/commit/12181fcde1a4e0439b44805d1e6efb6d5c9d8361))
* add salutation to private customers ([2e4376a](https://github.com/bambamboole/extended-faker/commit/2e4376a9a62770fe07e72b486e67a73b66d82cae))
* company-domain emails for companies and contacts ([fed3a93](https://github.com/bambamboole/extended-faker/commit/fed3a9381bc58a923ec6ef8c2db13beacb886cb3))
* put company and contact emails on the company's own domain ([1927a9c](https://github.com/bambamboole/extended-faker/commit/1927a9c76e49f145480af1f765dab50ebcfe4996))

## [0.9.0](https://github.com/bambamboole/extended-faker/compare/0.8.0...0.9.0) (2026-08-01)


### Features

* add CustomerNumber codec for customer/supplier identifiers ([0f3d531](https://github.com/bambamboole/extended-faker/commit/0f3d531688dadd82a694d2f16954f38874eb82d2))
* add CustomerRepository ([b9daa56](https://github.com/bambamboole/extended-faker/commit/b9daa56e141dc485bd71b0a6fb18f8f639874888))
* add fasteners and electrical supplies categories ([f91cd14](https://github.com/bambamboole/extended-faker/commit/f91cd14ff6a5feeee2ba0e7e2e4466296d266b16))
* add generative company customers and suppliers ([252e023](https://github.com/bambamboole/extended-faker/commit/252e0236ea238fa5ba2b8901f14c912975349dfe))
* add generative private customers ([4e2cd33](https://github.com/bambamboole/extended-faker/commit/4e2cd33e49f0907b3c218f3a752ee59b2ea48e06))
* add MoneyDto and ProductPrice scale-and-snap helper ([fb6bafc](https://github.com/bambamboole/extended-faker/commit/fb6bafc38b5563ea59ad4904e11b2c51376c2f8e))
* add paint, wood and concrete material categories ([63afb75](https://github.com/bambamboole/extended-faker/commit/63afb754b94479e5cfd323c6adacb3c4f01c939b))
* add unit and price to generated products ([d5467f3](https://github.com/bambamboole/extended-faker/commit/d5467f3219b6e988cb0108a2f917b73d7a980595))
* add unitVariants and priceRange to all product templates ([2436001](https://github.com/bambamboole/extended-faker/commit/2436001e34348a5c37404fe2b70dd8002eeec42a))
* expose customer and supplier providers via ExtendedFaker ([692bb00](https://github.com/bambamboole/extended-faker/commit/692bb00e738e9c206ec4a6619bd68ecffe63e7f8))
* generative customers and suppliers ([6bdd9b8](https://github.com/bambamboole/extended-faker/commit/6bdd9b8d25f8528f1810051cee4c53b6bc90ee3e))
* material products with units and prices ([ddb14ff](https://github.com/bambamboole/extended-faker/commit/ddb14ff3abd6aefb9af2d63fa076a387c4c04add))


### Bug Fixes

* make customer generation timezone- and platform-independent ([689559e](https://github.com/bambamboole/extended-faker/commit/689559e59dc5add1e51ffe095653a4a7e2d40257))

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
