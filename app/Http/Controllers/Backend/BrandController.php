<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

final class BrandController extends Controller
{
    /**
     * Display brand listing.
     */
    public function index(): View
    {
        $brands = Brand::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $totalBrands = Brand::query()->count();

        $activeBrands = Brand::query()
            ->where('status', true)
            ->count();

        $featuredBrands = Brand::query()
            ->where('featured', true)
            ->count();

        return view(
            'backend.pages.ecommerce.admin.brands.index',
            compact(
                'brands',
                'totalBrands',
                'activeBrands',
                'featuredBrands',
            ),
        );
    }

    /**
     * Show create brand form.
     */
    public function create(): View
    {
        return view(
            'backend.pages.ecommerce.admin.brands.create',
        );
    }

    /**
     * Store brand.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:brands,slug',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'brand_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
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
        ]);

        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */

        $slug = $validated['slug']
            ?: Str::slug($validated['name']);

        /*
        |--------------------------------------------------------------------------
        | Make Slug Unique
        |--------------------------------------------------------------------------
        */

        $originalSlug = $slug;
        $counter = 1;

        while (
        Brand::query()
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Brand Logo
        |--------------------------------------------------------------------------
        */

        $logo = null;

        if (
            isset($validated['brand_logo'])
            && $validated['brand_logo']
        ) {
            $uploadPath = public_path(
                'uploads/ecommerce/brands',
            );

            if (! is_dir($uploadPath)) {
                mkdir(
                    $uploadPath,
                    0755,
                    true,
                );
            }

            $fileName = 'brand-'
                . Str::uuid()
                . '.'
                . $validated['brand_logo']
                    ->getClientOriginalExtension();

            $validated['brand_logo']->move(
                $uploadPath,
                $fileName,
            );

            $logo = 'uploads/ecommerce/brands/' . $fileName;
        }

        /*
        |--------------------------------------------------------------------------
        | Create Brand
        |--------------------------------------------------------------------------
        */

        Brand::query()->create([
            'name' => $validated['name'],

            'slug' => $slug,

            'logo' => $logo,

            'description' =>
                $validated['description'] ?? null,

            'sort_order' =>
                $validated['sort_order'] ?? 0,

            'status' =>
                $request->boolean('status'),

            'featured' =>
                $request->boolean('featured'),

            'meta_title' =>
                $validated['meta_title'] ?? null,

            'meta_description' =>
                $validated['meta_description'] ?? null,
        ]);

        return redirect()
            ->route('admin-brands')
            ->with(
                'success',
                'Brand created successfully.',
            );
    }

    /**
     * Display brand details.
     */
    public function show(Brand $brand): View
    {
        return view(
            'backend.pages.ecommerce.admin.brands.details',
            compact('brand'),
        );
    }

    /**
     * Show the form for editing the specified brand.
     */
    public function edit(Brand $brand): View
    {
        return view(
            'backend.pages.ecommerce.admin.brands.edit',
            compact('brand'),
        );
    }

    /**
     * Update brand.
     */
    public function update(
        Request $request,
        Brand $brand,
    ): RedirectResponse {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:brands,slug,' . $brand->id,
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],

            'brand_logo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
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
        ]);

        /*
        |--------------------------------------------------------------------------
        | Slug
        |--------------------------------------------------------------------------
        */

        $slug = $validated['slug']
            ?: Str::slug($validated['name']);

        /*
        |--------------------------------------------------------------------------
        | Make Slug Unique
        |--------------------------------------------------------------------------
        */

        $originalSlug = $slug;
        $counter = 1;

        while (
        Brand::query()
            ->where('slug', $slug)
            ->where('id', '!=', $brand->id)
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        /*
        |--------------------------------------------------------------------------
        | Brand Logo
        |--------------------------------------------------------------------------
        */

        $logo = $brand->logo;

        if (
            isset($validated['brand_logo'])
            && $validated['brand_logo']
        ) {
            /*
            |--------------------------------------------------------------------------
            | Delete Old Logo
            |--------------------------------------------------------------------------
            */

            if ($brand->logo) {
                $oldLogoPath = public_path(
                    $brand->logo,
                );

                if (is_file($oldLogoPath)) {
                    unlink($oldLogoPath);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Upload Path
            |--------------------------------------------------------------------------
            */

            $uploadPath = public_path(
                'uploads/ecommerce/brands',
            );

            if (! is_dir($uploadPath)) {
                mkdir(
                    $uploadPath,
                    0755,
                    true,
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Generate File Name
            |--------------------------------------------------------------------------
            */

            $fileName = 'brand-'
                . Str::uuid()
                . '.'
                . $validated['brand_logo']
                    ->getClientOriginalExtension();

            /*
            |--------------------------------------------------------------------------
            | Move Logo
            |--------------------------------------------------------------------------
            */

            $validated['brand_logo']->move(
                $uploadPath,
                $fileName,
            );

            $logo = 'uploads/ecommerce/brands/' . $fileName;
        }

        /*
        |--------------------------------------------------------------------------
        | Update Brand
        |--------------------------------------------------------------------------
        */

        $brand->update([
            'name' => $validated['name'],

            'slug' => $slug,

            'logo' => $logo,

            'description' =>
                $validated['description'] ?? null,

            'sort_order' =>
                $validated['sort_order'] ?? 0,

            'status' =>
                $request->boolean('status'),

            'featured' =>
                $request->boolean('featured'),

            'meta_title' =>
                $validated['meta_title'] ?? null,

            'meta_description' =>
                $validated['meta_description'] ?? null,
        ]);

        return redirect()
            ->route('admin-brands')
            ->with(
                'success',
                'Brand updated successfully.',
            );
    }

    /**
     * Delete brand.
     */
    public function destroy(Brand $brand): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Delete Brand Logo
        |--------------------------------------------------------------------------
        */

        if ($brand->logo) {
            $logoPath = public_path($brand->logo);

            if (is_file($logoPath)) {
                unlink($logoPath);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Delete Brand
        |--------------------------------------------------------------------------
        */

        $brand->delete();

        return redirect()
            ->route('admin-brands')
            ->with(
                'success',
                'Brand deleted successfully.',
            );
    }
}
