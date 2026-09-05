<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Throwable;

final class ProductController extends Controller
{
    private const PRODUCT_IMAGE_DIRECTORY =
        'uploads/ecommerce/products';

    private const GALLERY_IMAGE_DIRECTORY =
        'uploads/ecommerce/products/gallery';

    private const VARIANT_IMAGE_DIRECTORY =
        'uploads/ecommerce/products/variants';

    public function index(): View
    {
        $query = Product::query()
            ->with([
                'brand',
                'categories',
                'variants',
            ]);

        // Search
        if ($search = request('search')) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Status filter
        if ($status = request('status')) {
            $query->where('status', $status);
        }

        // Source filter
        if ($source = request('source')) {
            $query->where('source', $source);
        }

        // Brand filter
        if ($brand = request('brand')) {
            $query->where('brand_id', $brand);
        }

        // Category filter
        if ($category = request('category')) {
            $query->whereHas('categories', function ($query) use ($category) {
                $query->where('categories.id', $category);
            });
        }

        $products = $query
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $brands = Brand::query()
            ->orderBy('name')
            ->get();

        $categories = Category::query()
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'backend.pages.ecommerce.admin.products.index',
            compact(
                'products',
                'brands',
                'categories',
            ),
        );
    }

    public function create(): View
    {
        $brands = Brand::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();

        $categories = Category::query()
            ->where('status', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $attributes = Attribute::query()
            ->where('status', true)
            ->with([
                'values' => function ($query): void {
                    $query
                        ->where('status', true)
                        ->orderBy('sort_order')
                        ->orderBy('label');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'backend.pages.ecommerce.admin.products.create',
            compact(
                'brands',
                'categories',
                'attributes',
            ),
        );
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            $this->productValidationRules(),
        );

        $this->validateAttributeData($validated);

        $this->validateVariantData($validated);

        $storedFiles = [];

        try {
            $product = DB::transaction(function () use (
                $request,
                $validated,
                &$storedFiles,
            ): Product {
                $slug = $this->generateUniqueSlug(
                    $validated['slug'] ?? null,
                    $validated['name'],
                );

                $product = Product::query()->create([
                    'brand_id' => $validated['brand_id'] ?? null,
                    'name' => $validated['name'],
                    'slug' => $slug,
                    'sku' => $validated['sku'] ?? null,
                    'source' => $validated['source'],
                    'thumbnail' => null,
                    'video_url' => $validated['video_url'] ?? null,
                    'short_description' =>
                        $validated['short_description'] ?? null,
                    'description' =>
                        $validated['description'] ?? null,
                    'price' => $validated['price'],
                    'compare_price' =>
                        $validated['compare_price'] ?? null,
                    'cost_price' =>
                        $validated['cost_price'] ?? null,
                    'sort_order' =>
                        $validated['sort_order'] ?? 0,
                    'status' => $request->boolean('status'),
                    'featured' => $request->boolean('featured'),
                    'meta_title' =>
                        $validated['meta_title'] ?? null,
                    'meta_description' =>
                        $validated['meta_description'] ?? null,
                ]);

                $product->categories()->sync(
                    $validated['category_ids'] ?? [],
                );

                $this->storeProductThumbnail(
                    $request,
                    $product,
                    $storedFiles,
                );

                $this->storeGalleryImages(
                    $request,
                    $product,
                    $storedFiles,
                );

                $this->storeVariants(
                    $request,
                    $product,
                    $validated['variants'] ?? [],
                    $storedFiles,
                );

                return $product;
            });
        } catch (Throwable $exception) {
            $this->deleteStoredFiles($storedFiles);

            throw $exception;
        }

        return redirect()
            ->route('admin-products')
            ->with(
                'success',
                'Product created successfully.',
            );
    }

    public function show(Product $product): View
    {
        $product->load([
            'brand',
            'categories',
            'images',
            'variants.values.attribute',
            'variants.values.attributeValue',
        ]);

        return view(
            'backend.pages.ecommerce.admin.products.details',
            compact('product'),
        );
    }

    public function edit(Product $product): View
    {
        $product->load([
            'brand',
            'categories',
            'images',
            'variants.values.attribute',
            'variants.values.attributeValue',
        ]);

        $brands = Brand::query()
            ->active()
            ->orderBy('name')
            ->get();

        $categories = Category::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $attributes = Attribute::query()
            ->where('status', true)
            ->with([
                'values' => fn ($query) => $query
                    ->where('status', true)
                    ->orderBy('sort_order')
                    ->orderBy('label'),
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'backend.pages.ecommerce.admin.products.edit',
            compact(
                'product',
                'brands',
                'categories',
                'attributes',
            ),
        );
    }

    public function update(
        Request $request,
        Product $product,
    ): RedirectResponse {
        $validated = $request->validate(
            $this->productValidationRules($product),
        );

        $this->validateAttributeData($validated);

        $this->validateVariantData(
            $validated,
            $product,
        );

        $newFiles = [];
        $oldFiles = [];

        try {
            DB::transaction(function () use (
                $request,
                $validated,
                $product,
                &$newFiles,
                &$oldFiles,
            ): void {
                $slug = $this->generateUniqueSlug(
                    $validated['slug'] ?? null,
                    $validated['name'],
                    $product->id,
                );

                $product->update([
                    'brand_id' => $validated['brand_id'] ?? null,
                    'name' => $validated['name'],
                    'slug' => $slug,
                    'sku' => $validated['sku'] ?? null,
                    'source' => $validated['source'],
                    'video_url' => $validated['video_url'] ?? null,
                    'short_description' =>
                        $validated['short_description'] ?? null,
                    'description' =>
                        $validated['description'] ?? null,
                    'price' => $validated['price'],
                    'compare_price' =>
                        $validated['compare_price'] ?? null,
                    'cost_price' =>
                        $validated['cost_price'] ?? null,
                    'sort_order' =>
                        $validated['sort_order'] ?? 0,
                    'status' => $request->boolean('status'),
                    'featured' => $request->boolean('featured'),
                    'meta_title' =>
                        $validated['meta_title'] ?? null,
                    'meta_description' =>
                        $validated['meta_description'] ?? null,
                ]);

                $product->categories()->sync(
                    $validated['category_ids'] ?? [],
                );

                $this->updateProductThumbnail(
                    $request,
                    $product,
                    $newFiles,
                    $oldFiles,
                );

                $this->storeGalleryImages(
                    $request,
                    $product,
                    $newFiles,
                );

                $this->updateVariants(
                    $request,
                    $product,
                    $validated['variants'] ?? [],
                    $newFiles,
                    $oldFiles,
                );

                $this->removeGalleryImages(
                    $request,
                    $product,
                    $oldFiles,
                );
            });
        } catch (Throwable $exception) {
            $this->deleteStoredFiles($newFiles);

            throw $exception;
        }

        $this->deleteStoredFiles($oldFiles);

        return redirect()
            ->route('admin-products')
            ->with(
                'success',
                'Product updated successfully.',
            );
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->load([
            'images',
            'variants',
        ]);

        $files = [];

        if ($product->thumbnail) {
            $files[] = $product->thumbnail;
        }

        foreach ($product->images as $image) {
            $files[] = $image->image;
        }

        foreach ($product->variants as $variant) {
            if ($variant->image) {
                $files[] = $variant->image;
            }
        }

        DB::transaction(function () use ($product): void {
            $product->delete();
        });

        $this->deleteStoredFiles($files);

        return redirect()
            ->route('admin-products')
            ->with(
                'success',
                'Product deleted successfully.',
            );
    }

    private function productValidationRules(
        ?Product $product = null,
    ): array {
        $productId = $product?->id;

        return [
            'brand_id' => [
                'nullable',
                'integer',
                'exists:brands,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')
                    ->ignore($productId),
            ],

            'sku' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'sku')
                    ->ignore($productId),
            ],

            'source' => [
                'required',
                'string',
                'in:own,amazon,aliexpress',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'gallery' => [
                'nullable',
                'array',
                'max:20',
            ],

            'gallery.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'video_url' => [
                'nullable',
                'url',
                'max:255',
            ],

            'short_description' => [
                'nullable',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'compare_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'cost_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'meta_title' => [
                'nullable',
                'string',
                'max:255',
            ],

            'meta_description' => [
                'nullable',
                'string',
                'max:500',
            ],

            'category_ids' => [
                'nullable',
                'array',
            ],

            'category_ids.*' => [
                'integer',
                'exists:categories,id',
            ],

            'attribute_ids' => [
                'nullable',
                'array',
            ],

            'attribute_ids.*' => [
                'integer',
                'distinct',
                'exists:attributes,id',
            ],

            'attribute_values' => [
                'nullable',
                'array',
            ],

            'attribute_values.*' => [
                'array',
            ],

            'attribute_values.*.*' => [
                'integer',
                'distinct',
                'exists:attribute_values,id',
            ],

            /*
             * Product Variants
             */
            'variants' => [
                'nullable',
                'array',
                'max:100',
            ],

            'variants.*.id' => [
                'nullable',
                'integer',
            ],

            'variants.*.sku' => [
                'required',
                'string',
                'max:255',
            ],

            'variants.*.price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'variants.*.compare_price' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'variants.*.stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'variants.*.image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'variants.*.status' => [
                'nullable',
                'boolean',
            ],

            /*
             * IMPORTANT:
             * Generated variant attribute values.
             *
             * Example:
             * variants[0][values][1] = 5
             * variants[0][values][2] = 8
             */
            'variants.*.values' => [
                'required',
                'array',
                'min:1',
            ],

            'variants.*.values.*' => [
                'required',
                'integer',
                'exists:attribute_values,id',
            ],

            'remove_image_ids' => [
                'nullable',
                'array',
            ],

            'remove_image_ids.*' => [
                'integer',
            ],
        ];
    }

    private function validateAttributeData(
        array $validated,
    ): void {
        $attributeIds = collect(
            $validated['attribute_ids'] ?? [],
        )
            ->map(fn ($id): int => (int) $id)
            ->unique()
            ->values();

        $attributeValues = $validated['attribute_values'] ?? [];

        foreach ($attributeValues as $attributeId => $valueIds) {
            $attributeId = (int) $attributeId;

            if (!$attributeIds->contains($attributeId)) {
                throw ValidationException::withMessages([
                    'attribute_values' =>
                        'An attribute value belongs to an unselected attribute.',
                ]);
            }

            $validCount = DB::table('attribute_values')
                ->where('attribute_id', $attributeId)
                ->whereIn(
                    'id',
                    array_map('intval', $valueIds),
                )
                ->count();

            if ($validCount !== count($valueIds)) {
                throw ValidationException::withMessages([
                    'attribute_values' =>
                        'One or more selected attribute values are invalid.',
                ]);
            }
        }

        foreach ($attributeIds as $attributeId) {
            $values = $attributeValues[$attributeId] ?? [];

            if (count($values) === 0) {
                throw ValidationException::withMessages([
                    'attribute_values' =>
                        'Each selected attribute must have at least one value.',
                ]);
            }
        }
    }

    private function validateVariantData(
        array $validated,
        ?Product $product = null,
    ): void {
        $variants = $validated['variants'] ?? [];

        if ($variants === []) {
            return;
        }

        $selectedAttributeIds = collect(
            $validated['attribute_ids'] ?? [],
        )
            ->map(fn ($id): int => (int) $id)
            ->values();

        if ($selectedAttributeIds->isEmpty()) {
            throw ValidationException::withMessages([
                'variants' =>
                    'Variants require at least one selected attribute.',
            ]);
        }

        $existingVariantIds = $product
            ? $product->variants()
                ->pluck('id')
                ->map(fn ($id): int => (int) $id)
                ->all()
            : [];

        $variantIds = [];

        foreach ($variants as $index => $variant) {
            $variantId = isset($variant['id'])
                ? (int) $variant['id']
                : null;

            if ($variantId !== null) {
                if (
                    !in_array(
                        $variantId,
                        $existingVariantIds,
                        true,
                    )
                ) {
                    throw ValidationException::withMessages([
                        "variants.$index.id" =>
                            'Invalid product variant.',
                    ]);
                }

                $variantIds[] = $variantId;
            }

            $values = $variant['values'] ?? [];

            if (!is_array($values) || $values === []) {
                throw ValidationException::withMessages([
                    "variants.$index.values" =>
                        'Each variant must have attribute values.',
                ]);
            }

            foreach ($values as $attributeId => $valueId) {
                $attributeId = (int) $attributeId;
                $valueId = (int) $valueId;

                if (
                    !$selectedAttributeIds->contains(
                        $attributeId,
                    )
                ) {
                    throw ValidationException::withMessages([
                        "variants.$index.values" =>
                            'Variant contains an unselected attribute.',
                    ]);
                }

                $valid = DB::table('attribute_values')
                    ->where('id', $valueId)
                    ->where('attribute_id', $attributeId)
                    ->exists();

                if (!$valid) {
                    throw ValidationException::withMessages([
                        "variants.$index.values" =>
                            'Variant contains an invalid attribute value.',
                    ]);
                }
            }

            $variantAttributeIds = collect(
                array_keys($values),
            )
                ->map(fn ($id): int => (int) $id)
                ->sort()
                ->values()
                ->all();

            $expectedAttributeIds = $selectedAttributeIds
                ->sort()
                ->values()
                ->all();

            if (
                $variantAttributeIds !==
                $expectedAttributeIds
            ) {
                throw ValidationException::withMessages([
                    "variants.$index.values" =>
                        'Every variant must contain one value for each selected attribute.',
                ]);
            }
        }

        if (
            count($variantIds) !==
            count(array_unique($variantIds))
        ) {
            throw ValidationException::withMessages([
                'variants' =>
                    'A product variant has been submitted more than once.',
            ]);
        }

        $skus = collect($variants)
            ->pluck('sku')
            ->map(
                fn ($sku): string => trim((string) $sku),
            )
            ->filter()
            ->values();

        if (
            $skus->count() !==
            $skus->unique(
                fn (string $sku): string => strtolower($sku),
            )->count()
        ) {
            throw ValidationException::withMessages([
                'variants' =>
                    'Variant SKUs must be unique.',
            ]);
        }

        foreach ($variants as $index => $variant) {
            $query = ProductVariant::query()
                ->where('sku', $variant['sku']);

            if (isset($variant['id'])) {
                $query->where(
                    'id',
                    '!=',
                    (int) $variant['id'],
                );
            }

            if ($query->exists()) {
                throw ValidationException::withMessages([
                    "variants.$index.sku" =>
                        'This variant SKU is already in use.',
                ]);
            }
        }
    }

    private function generateUniqueSlug(
        ?string $slug,
        string $name,
        ?int $ignoreId = null,
    ): string {
        $baseSlug = Str::slug(
            trim($slug ?: $name),
        );

        if ($baseSlug === '') {
            $baseSlug = 'product';
        }

        $generatedSlug = $baseSlug;
        $counter = 1;

        while (
        Product::query()
            ->where('slug', $generatedSlug)
            ->when(
                $ignoreId !== null,
                fn ($query) => $query->where(
                    'id',
                    '!=',
                    $ignoreId,
                ),
            )
            ->exists()
        ) {
            $generatedSlug =
                $baseSlug . '-' . $counter;

            $counter++;
        }

        return $generatedSlug;
    }

    private function storeProductThumbnail(
        Request $request,
        Product $product,
        array &$storedFiles,
    ): void {
        if (!$request->hasFile('thumbnail')) {
            return;
        }

        $file = $request->file('thumbnail');

        if (!$file instanceof UploadedFile) {
            return;
        }

        $path = $this->storeImage(
            $file,
            self::PRODUCT_IMAGE_DIRECTORY,
        );

        $storedFiles[] = $path;

        $product->update([
            'thumbnail' => $path,
        ]);
    }

    private function updateProductThumbnail(
        Request $request,
        Product $product,
        array &$newFiles,
        array &$oldFiles,
    ): void {
        if (!$request->hasFile('thumbnail')) {
            return;
        }

        $file = $request->file('thumbnail');

        if (!$file instanceof UploadedFile) {
            return;
        }

        $path = $this->storeImage(
            $file,
            self::PRODUCT_IMAGE_DIRECTORY,
        );

        $newFiles[] = $path;

        if ($product->thumbnail) {
            $oldFiles[] = $product->thumbnail;
        }

        $product->update([
            'thumbnail' => $path,
        ]);
    }

    private function storeGalleryImages(
        Request $request,
        Product $product,
        array &$storedFiles,
    ): void {
        if (!$request->hasFile('gallery')) {
            return;
        }

        $files = $request->file('gallery');

        if (!is_array($files)) {
            return;
        }

        $sortOrder = (int) $product->images()->max(
            'sort_order',
        );

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) {
                continue;
            }

            $path = $this->storeImage(
                $file,
                self::GALLERY_IMAGE_DIRECTORY,
            );

            $storedFiles[] = $path;

            $sortOrder++;

            ProductImage::query()->create([
                'product_id' => $product->id,
                'variant_id' => null,
                'image' => $path,
                'alt_text' => $product->name,
                'sort_order' => $sortOrder,
                'is_primary' => false,
            ]);
        }
    }

    private function storeVariants(
        Request $request,
        Product $product,
        array $variants,
        array &$storedFiles,
    ): void {
        foreach ($variants as $index => $variantData) {
            $variant = ProductVariant::query()->create([
                'product_id' => $product->id,
                'sku' => $variantData['sku'],
                'price' => $variantData['price'],
                'compare_price' =>
                    $variantData['compare_price'] ?? null,
                'stock' => $variantData['stock'],
                'image' => null,
                'status' =>
                    isset($variantData['status'])
                        ? (bool) $variantData['status']
                        : true,
            ]);

            $variantImage = $request->file(
                "variants.$index.image",
            );

            if ($variantImage instanceof UploadedFile) {
                $path = $this->storeImage(
                    $variantImage,
                    self::VARIANT_IMAGE_DIRECTORY,
                );

                $storedFiles[] = $path;

                $variant->update([
                    'image' => $path,
                ]);
            }

            $this->storeVariantValues(
                $variant,
                $variantData['values'] ?? [],
            );
        }
    }

    private function updateVariants(
        Request $request,
        Product $product,
        array $variants,
        array &$newFiles,
        array &$oldFiles,
    ): void {
        $existingVariants = $product->variants()
            ->get()
            ->keyBy('id');

        $submittedVariantIds = [];

        foreach ($variants as $index => $variantData) {
            $variantId = isset($variantData['id'])
                ? (int) $variantData['id']
                : null;

            if (
                $variantId !== null &&
                $existingVariants->has($variantId)
            ) {
                $variant = $existingVariants->get(
                    $variantId,
                );

                $submittedVariantIds[] = $variantId;

                $oldImage = $variant->image;

                $variant->update([
                    'sku' => $variantData['sku'],
                    'price' => $variantData['price'],
                    'compare_price' =>
                        $variantData['compare_price'] ?? null,
                    'stock' => $variantData['stock'],
                    'status' =>
                        isset($variantData['status'])
                            ? (bool) $variantData['status']
                            : true,
                ]);

                $variantImage = $request->file(
                    "variants.$index.image",
                );

                if ($variantImage instanceof UploadedFile) {
                    $path = $this->storeImage(
                        $variantImage,
                        self::VARIANT_IMAGE_DIRECTORY,
                    );

                    $newFiles[] = $path;

                    if ($oldImage) {
                        $oldFiles[] = $oldImage;
                    }

                    $variant->update([
                        'image' => $path,
                    ]);
                }

                $variant->values()->delete();

                $this->storeVariantValues(
                    $variant,
                    $variantData['values'] ?? [],
                );

                continue;
            }

            $variant = ProductVariant::query()->create([
                'product_id' => $product->id,
                'sku' => $variantData['sku'],
                'price' => $variantData['price'],
                'compare_price' =>
                    $variantData['compare_price'] ?? null,
                'stock' => $variantData['stock'],
                'image' => null,
                'status' =>
                    isset($variantData['status'])
                        ? (bool) $variantData['status']
                        : true,
            ]);

            $submittedVariantIds[] = $variant->id;

            $variantImage = $request->file(
                "variants.$index.image",
            );

            if ($variantImage instanceof UploadedFile) {
                $path = $this->storeImage(
                    $variantImage,
                    self::VARIANT_IMAGE_DIRECTORY,
                );

                $newFiles[] = $path;

                $variant->update([
                    'image' => $path,
                ]);
            }

            $this->storeVariantValues(
                $variant,
                $variantData['values'] ?? [],
            );
        }

        foreach ($existingVariants as $variant) {
            if (
                in_array(
                    $variant->id,
                    $submittedVariantIds,
                    true,
                )
            ) {
                continue;
            }

            if ($variant->image) {
                $oldFiles[] = $variant->image;
            }

            $variant->delete();
        }
    }

    private function storeVariantValues(
        ProductVariant $variant,
        array $values,
    ): void {
        foreach ($values as $attributeId => $valueId) {
            $variant->values()->create([
                'attribute_id' => (int) $attributeId,
                'attribute_value_id' => (int) $valueId,
            ]);
        }
    }

    private function removeGalleryImages(
        Request $request,
        Product $product,
        array &$oldFiles,
    ): void {
        $imageIds = $request->input(
            'remove_image_ids',
            [],
        );

        if (!is_array($imageIds) || $imageIds === []) {
            return;
        }

        $images = $product->images()
            ->whereIn('id', $imageIds)
            ->get();

        foreach ($images as $image) {
            if ($image->image) {
                $oldFiles[] = $image->image;
            }

            $image->delete();
        }
    }

    private function storeImage(
        UploadedFile $file,
        string $directory,
    ): string {
        $fullDirectory = public_path($directory);

        if (!is_dir($fullDirectory)) {
            mkdir(
                $fullDirectory,
                0755,
                true,
            );
        }

        $filename =
            Str::uuid()->toString()
            . '.'
            . $file->extension();

        $file->move(
            $fullDirectory,
            $filename,
        );

        return $directory . '/' . $filename;
    }

    private function deleteStoredFiles(
        array $paths,
    ): void {
        foreach (array_unique($paths) as $path) {
            if (!$path) {
                continue;
            }

            $fullPath = public_path(
                ltrim($path, '/'),
            );

            if (is_file($fullPath)) {
                unlink($fullPath);
            }
        }
    }
}
