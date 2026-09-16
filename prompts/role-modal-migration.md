# Product Details Page — Laravel 12 Implementation Prompt

## Project Context

I am building a Laravel 12 + PHP 8.3+ ecommerce/marketplace application.

I already have a `MarketplaceController` with a working `/shop` listing page. I now want to implement a complete, production-ready **Product Details Page**.

IMPORTANT:
- Do NOT invent database columns, relationships, tables, routes, or model methods.
- Use ONLY the models and migrations described below.
- Follow Laravel default-first conventions.
- Keep controllers thin and presentation logic clean.
- The implementation must work with the existing schema exactly as provided.

---

# Existing Route

The existing shop listing route is:

```php
Route::get('/shop', [MarketplaceController::class, 'index'])
    ->name('shop');
```

The product details route should use the product slug:

```php
Route::get('/shop/{product:slug}', [MarketplaceController::class, 'show'])
    ->name('shop.details');
```

Use Laravel implicit route model binding.

Only active products should be publicly accessible. An inactive product should return 404.

---

# Existing Product Architecture

## Product

`Product` fields:

```text
id
brand_id
name
slug
sku
source
thumbnail
video_url
short_description
description
price
compare_price
cost_price
status
featured
sort_order
meta_title
meta_description
created_at
updated_at
```

Relationships:

```php
brand(): BelongsTo
categories(): BelongsToMany
images(): HasMany
variants(): HasMany
inventoryTransactions(): HasMany
```

Existing helpers:

```php
scopeActive()
scopeFeatured()
isActive()
isFeatured()
hasVariants()
```

---

# Brand

Fields:

```text
id
name
slug
logo
description
sort_order
status
featured
meta_title
meta_description
created_at
updated_at
```

---

# Category

Fields:

```text
id
parent_id
name
slug
image
description
sort_order
status
featured
meta_title
meta_description
created_at
updated_at
```

Relationships:

```php
parent(): BelongsTo
children(): HasMany
products(): BelongsToMany
```

---

# ProductImage

Fields:

```text
id
product_id
variant_id
image
alt_text
sort_order
is_primary
created_at
updated_at
```

Relationships:

```php
product(): BelongsTo
variant(): BelongsTo
```

Important:
- Product images belong to a product.
- An image can optionally belong to a variant.
- `is_primary` identifies the primary image.
- `sort_order` controls ordering.

---

# ProductVariant

Fields:

```text
id
product_id
sku
price
compare_price
stock
image
status
created_at
updated_at
```

Relationships:

```php
product(): BelongsTo
values(): HasMany
images(): HasMany
```

Important:
- Variants can have their own price.
- Variants can have their own compare price.
- Variants have their own stock.
- Variants can have their own image.
- Only active variants (`status = true`) should be selectable/purchasable.

---

# ProductVariantValue

Fields:

```text
id
product_variant_id
attribute_id
attribute_value_id
created_at
updated_at
```

Relationships:

```php
variant(): BelongsTo
attribute(): BelongsTo
attributeValue(): BelongsTo
```

This means the variant structure is:

```text
Product
    ↓
Variants
    ↓
Variant Values
    ↓
Attribute
    ↓
Attribute Value
```

---

# Attribute

Fields:

```text
id
name
slug
sort_order
status
created_at
updated_at
```

Relationship:

```php
values(): HasMany
```

---

# AttributeValue

Fields:

```text
id
attribute_id
label
value
slug
sort_order
status
created_at
updated_at
```

Relationship:

```php
attribute(): BelongsTo
```

---

# What I Want

Build a complete premium ecommerce **Product Details Page**.

The page should feel modern, polished, professional, and production-ready.

Do not create an overcomplicated UI. Prioritize:
- excellent product presentation
- clear pricing
- clear variant selection
- clear stock information
- strong CTA
- excellent responsive behavior
- clean visual hierarchy
- maintainable code

---

# Product Details Layout

Create a page containing:

## 1. Breadcrumb

Example:

```text
Home / Shop / Category / Product Name
```

Use actual product/category data.

Do not hardcode product/category names.

---

## 2. Product Gallery

Create a premium product image gallery.

Use:

- primary product image
- all product images ordered by `sort_order`
- product thumbnail as fallback if no ProductImage exists
- variant image when a variant is selected, if available

Gallery should include:

- large main image
- thumbnail navigation
- active thumbnail state
- image switching
- responsive layout
- graceful fallback when no image exists

Use `alt_text` where available.

If `alt_text` is empty, use the product name.

---

# 3. Product Information

Show:

- Brand
- Product name
- SKU
- categories
- short description
- price
- compare price when available
- discount percentage when meaningful
- stock status
- variant information
- quantity selector
- Add to Cart button
- Buy Now button
- Wishlist button if the existing application already supports a wishlist route/functionality

Do NOT invent a wishlist backend implementation if one does not already exist.

---

# 4. Pricing Logic

For a product without a selected variant:

Use:

```text
Product.price
Product.compare_price
```

For a selected variant:

Use:

```text
ProductVariant.price
ProductVariant.compare_price
```

The displayed price must update dynamically when the user selects a valid variant.

Do not use `cost_price` in the customer-facing page.

If `compare_price` is null or not greater than the current price, do not display it as a sale price.

If there is a valid compare price, calculate discount percentage safely.

Example:

```text
$799
$999
20% OFF
```

---

# 5. Variant Selection

This is a critical part.

Variants are combinations of attribute values.

Example:

```text
Color
  Black
  White

Storage
  128GB
  256GB
  512GB
```

Each actual `ProductVariant` represents a valid combination.

The UI must be generated from the existing active variants.

Do NOT show attribute values that cannot participate in any active product variant.

When the customer selects attribute values:

1. Determine the matching active variant.
2. If a complete valid combination exists:
    - select that variant
    - update price
    - update compare price
    - update SKU
    - update stock
    - update product image if the variant has one
    - update quantity limits
3. If the combination does not exist:
    - clearly indicate that the combination is unavailable
    - prevent adding it to cart
4. Do not allow an invalid variant combination to be purchased.

Prefer server-provided variant data serialized safely into the page rather than making unnecessary AJAX requests if the existing cart architecture does not require them.

---

# 6. Stock Logic

Product variants have:

```text
stock
status
```

For products with variants:

- Stock should come from the selected active variant.
- A variant with `stock <= 0` should be unavailable/out of stock.
- Quantity cannot exceed available stock.
- Add to Cart and Buy Now must be disabled when the selected variant is unavailable.

For products without variants:

The current schema has no direct `products.stock` field.

Therefore:

- Do NOT invent a product stock column.
- Treat a non-variant product as purchasable according to the existing cart/business logic.
- If the existing application requires stock for non-variant products, inspect the existing cart/inventory implementation instead of changing this page by assumption.

---

# 7. Quantity Selector

Create:

```text
[-] 1 [+]
```

Requirements:

- minimum 1
- for variant products, maximum = selected variant stock
- prevent negative values
- prevent non-numeric invalid values
- buttons should work on desktop and mobile
- disabled state when quantity cannot increase/decrease

---

# 8. Product Description

Create a clean description section.

Show:

```text
Description
```

Use:

```php
$product->description
```

Handle null/empty descriptions gracefully.

Do not expose internal fields such as `cost_price`.

---

# 9. Product Meta / Specifications

Create a compact product information area containing relevant public information such as:

- SKU
- Brand
- Categories
- Source if appropriate for the storefront

Do not expose internal/admin-only information.

---

# 10. Product Video

The product has:

```text
video_url
```

If present, create a premium video section.

Support common YouTube URL formats, including:

```text
https://www.youtube.com/watch?v=...
https://youtu.be/...
```

Convert YouTube URLs to an embeddable URL safely.

If no video exists, hide the section.

Do not display a broken iframe.

---

# 11. Related Products

Show a small related products section.

Related products should preferably share one or more categories with the current product.

Requirements:

- exclude the current product
- active products only
- maximum 4 products
- eager load required relationships
- use existing product fields only

Each card can show:

- thumbnail
- brand
- name
- price
- compare price if valid
- link to product details route

---

# Controller Requirements

Implement:

```php
public function show(Product $product): View
```

Use eager loading to avoid N+1 queries.

The product details query should load the required relationships, including:

```text
brand
categories
images
variants
variants.values
variants.values.attribute
variants.values.attributeValue
variants.images
```

Only active variants should be selectable.

For product images, order them by:

```text
sort_order
```

Prefer the primary image where appropriate.

Build related products efficiently.

Do not place complex database logic in the Blade template.

The controller should prepare data required by the view.

---

# Important Variant Data Requirement

The Blade/JavaScript needs enough data to match variants.

Prepare a clean variant data structure containing only what the frontend needs, such as:

```text
variant id
sku
price
compare_price
stock
image
attribute/value IDs
attribute/value slugs
attribute names
value labels
```

Do not dump full Eloquent models into JavaScript unnecessarily.

Use `@json()` or an equivalent Laravel-safe serialization approach.

---

# Route Model Binding

Use:

```php
Route::get('/shop/{product:slug}', [MarketplaceController::class, 'show'])
    ->name('shop.details');
```

The details page should use:

```php
$product
```

from implicit route model binding.

Inactive products must return 404.

---

# Blade Requirements

The Blade file should be:

```text
resources/views/frontend/pages/shop/details.blade.php
```

It MUST start with:

```blade
@extends('frontend.layouts.frontend')

@section('contents')

@endsection

@push('scripts')

@endpush
```

Use an appropriate `<title>` based on the product.

All page HTML MUST be inside one unique wrapper:

```html
<div class="product-details-page">
    ...
</div>
```

No page-specific HTML should exist outside this wrapper.

Use semantic and maintainable BEM-style class names.

Example:

```text
.product-details-page
.product-details-page__gallery
.product-details-page__info
.product-details-page__title
.product-details-page__price
.product-details-page__variants
.product-details-page__quantity
.product-details-page__actions
```

Do not reuse generic classes globally if page-specific classes are appropriate.

---

# SCSS Requirements

Create the page-specific SCSS file, for example:

```text
resources/scss/pages/_product-details.scss
```

It MUST start with:

```scss
@use "../common" as *;
```

ALL page-specific styles must be nested inside:

```scss
.product-details-page {
    ...
}
```

Use the project's existing variables and mixins.

Existing fonts:

```scss
$body-fonts
$header-fonts
$icon-font
```

Existing colors:

```scss
$white
$black
$light
$dark
$gray
$heading-color
$body-color
$theme-color
$theme-color-2
$hr-color
$success
$info
$warning
$danger
```

Existing mixins:

```scss
transition
transform
appearance
input-accent
placeholder
```

Responsive mixins:

```scss
mq('xxl')
mq('xl')
mq('lg')
mq('md')
mq('sm')
mq('xs')
cmq
cmmq
cmaq
```

Do not introduce a new design-token system when the existing project already provides one.

Typography:
- minimum 14px
- maximum 24px
- use existing font variables
- maintain strong hierarchy without oversized text

The page must be fully responsive.

---

# JavaScript Requirements

All JavaScript MUST be scoped to:

```text
.product-details-page
```

First check whether the parent exists.

Example pattern:

```js
const productDetailsPage = document.querySelector(
    '.product-details-page'
);

if (!productDetailsPage) {
    return;
}
```

Do not create global event handlers that can conflict with other pages.

JavaScript should handle:

- gallery image switching
- variant selection
- variant matching
- dynamic price
- dynamic compare price
- discount percentage
- SKU update
- stock update
- quantity controls
- max quantity based on stock
- add-to-cart button state
- buy-now button state
- unavailable combination state

Use `data-*` attributes where appropriate.

Keep the JavaScript readable and maintainable.

Do not introduce unnecessary libraries.

---

# Add to Cart / Buy Now

The UI must be ready for the application's existing cart implementation.

IMPORTANT:

Before implementing backend requests, inspect the existing cart route/controller/service/session implementation if it exists.

Do NOT invent an API endpoint such as:

```text
/cart/add
/api/cart
```

unless that route already exists.

The frontend should submit the correct:

```text
product_id
variant_id
quantity
```

according to the existing cart architecture.

For products with variants, `variant_id` must be sent.

For products without variants, do not invent a fake variant ID.

---

# Wishlist

If the application already has wishlist functionality:

- connect the product details wishlist button to the existing implementation.

If it does not:

- create the visual button only if appropriate
- do not invent a new wishlist database/API implementation as part of this task.

---

# Image Handling

Use the existing storage/public asset conventions already used by the application.

Do not invent a new image storage system.

Support:

```text
$product->thumbnail
$product->images
$product->variants->image
$product->variants->images
```

Only use fields that actually exist.

---

# Security / Safety

Do not expose:

```text
cost_price
```

Do not expose internal inventory transaction details.

Escape normal text output.

Only render trusted HTML from `description` if the existing application intentionally stores sanitized HTML.

Do not blindly use `{!! !!}` on untrusted content.

Do not expose unnecessary Eloquent model data to JavaScript.

---

# Performance

Avoid N+1 queries.

Use eager loading.

Do not execute repeated relationship queries from Blade.

Do not call methods such as:

```php
$product->variants()->exists()
```

repeatedly from the view.

Prepare required values in the controller or use already-loaded collections.

Keep frontend JavaScript lightweight.

---

# UX Requirements

The product page should feel like a premium ecommerce website.

Important visual priorities:

1. Product imagery
2. Product name
3. Price
4. Variant selection
5. Stock status
6. Quantity
7. Add to Cart
8. Buy Now
9. Product information
10. Related products

Use:

- clean cards
- subtle borders
- balanced spacing
- clear CTA buttons
- polished hover states
- clear disabled states
- mobile-friendly controls
- accessible labels
- visible focus states
- smooth but subtle transitions

Avoid:

- excessive gradients
- excessive animations
- oversized typography
- clutter
- unnecessary decorative elements
- random icons
- fake data

---

# Accessibility

Include:

- meaningful image alt text
- button labels
- form labels
- keyboard-friendly controls
- visible focus states
- disabled states
- accessible quantity controls
- appropriate ARIA attributes where useful

Do not rely only on color to communicate unavailable/out-of-stock states.

---

# Expected Deliverables

Provide the implementation in this order:

## 1. Route

```php
Route::get('/shop/{product:slug}', [MarketplaceController::class, 'show'])
    ->name('shop.details');
```

## 2. MarketplaceController

Provide the complete `show()` method.

Do not rewrite unrelated `index()` code unless necessary.

## 3. Blade

Provide:

```text
resources/views/frontend/pages/shop/details.blade.php
```

Complete production-ready Blade.

## 4. SCSS

Provide:

```text
resources/scss/pages/_product-details.scss
```

Complete responsive SCSS.

## 5. JavaScript

Include it in the Blade's:

```blade
@push('scripts')
```

and keep it fully scoped to:

```text
.product-details-page
```

## 6. Existing Cart Integration

If cart functionality already exists in the project, explain exactly where the existing route/controller/service should be connected.

Do not invent backend cart logic without inspecting the existing implementation.

---

# Critical Rule

The supplied models and migrations are the source of truth.

Never assume:

- missing fields
- missing relationships
- missing stock columns
- missing cart routes
- missing wishlist routes
- missing review tables
- missing rating tables
- missing customer/product pivot tables

If a feature cannot be implemented from the supplied schema, either:
1. use an existing project implementation if available, or
2. clearly mark it as requiring the existing application infrastructure.

Do not silently invent architecture.

The final result must be clean, production-ready Laravel 12 + PHP 8.3+ code and must respect the project's existing coding standards.
