<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display category listing.
     */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Filters
        |--------------------------------------------------------------------------
        */

        $search = trim(
            $request->input('search', '')
        );

        $status = $request->input('status');

        $type = $request->input('type');


        /*
        |--------------------------------------------------------------------------
        | Category Query
        |--------------------------------------------------------------------------
        */

        $categoryQuery = Category::query()
            ->with([
                'children' => function ($query) use (
                    $search,
                    $status
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Child Search
                    |--------------------------------------------------------------------------
                    */

                    if ($search !== '') {

                        $query->where(function ($q) use ($search) {

                            $q->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            )
                                ->orWhere(
                                    'slug',
                                    'like',
                                    '%' . $search . '%'
                                );

                        });

                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Child Status
                    |--------------------------------------------------------------------------
                    */

                    if ($status === 'active') {

                        $query->where('status', true);

                    } elseif ($status === 'inactive') {

                        $query->where('status', false);

                    }


                    $query
                        ->withCount('products')
                        ->orderBy('sort_order')
                        ->orderBy('name');

                }
            ])
            ->withCount('products');


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($search !== '') {

            $categoryQuery->where(function ($query) use ($search) {

                /*
                |--------------------------------------------------------------------------
                | Parent Category Search
                |--------------------------------------------------------------------------
                */

                $query->where(function ($q) use ($search) {

                    $q->where(
                        'name',
                        'like',
                        '%' . $search . '%'
                    )
                        ->orWhere(
                            'slug',
                            'like',
                            '%' . $search . '%'
                        );

                })
                    /*
                    |--------------------------------------------------------------------------
                    | Include Parent If Child Matches
                    |--------------------------------------------------------------------------
                    */

                    ->orWhereHas(
                        'children',
                        function ($q) use ($search) {

                            $q->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            )
                                ->orWhere(
                                    'slug',
                                    'like',
                                    '%' . $search . '%'
                                );

                        }
                    );

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if ($status === 'active') {

            $categoryQuery->where('status', true);

        } elseif ($status === 'inactive') {

            $categoryQuery->where('status', false);

        }


        /*
        |--------------------------------------------------------------------------
        | Type Filter
        |--------------------------------------------------------------------------
        */

        if ($type === 'subcategory') {

            /*
            |--------------------------------------------------------------------------
            | Get Parent Categories Which Have Matching Subcategories
            |--------------------------------------------------------------------------
            */

            $categoryQuery->whereHas(
                'children',
                function ($query) use (
                    $search,
                    $status
                ) {

                    if ($search !== '') {

                        $query->where(function ($q) use ($search) {

                            $q->where(
                                'name',
                                'like',
                                '%' . $search . '%'
                            )
                                ->orWhere(
                                    'slug',
                                    'like',
                                    '%' . $search . '%'
                                );

                        });

                    }

                    if ($status === 'active') {

                        $query->where('status', true);

                    } elseif ($status === 'inactive') {

                        $query->where('status', false);

                    }

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Get Categories
        |--------------------------------------------------------------------------
        */

        $categories = $categoryQuery
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Filter Children For Subcategory Type
        |--------------------------------------------------------------------------
        */

        if ($type === 'subcategory') {

            $categories = $categories
                ->map(function ($category) {

                    $category->setRelation(
                        'children',
                        $category->children
                    );

                    return $category;

                })
                ->filter(function ($category) {

                    return $category->children->isNotEmpty();

                })
                ->values();

        }


        /*
        |--------------------------------------------------------------------------
        | Statistics
        |--------------------------------------------------------------------------
        */

        $totalCategories = Category::count();

        $activeCategories = Category::where(
            'status',
            true
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Total Assigned Products
        |--------------------------------------------------------------------------
        */

        $productsAssigned = Category::query()
            ->withCount('products')
            ->get()
            ->sum('products_count');


        /*
        |--------------------------------------------------------------------------
        | Empty Categories
        |--------------------------------------------------------------------------
        */

        $emptyCategories = Category::query()
            ->withCount('products')
            ->having(
                'products_count',
                '=',
                0
            )
            ->count();


        /*
        |--------------------------------------------------------------------------
        | Return View
        |--------------------------------------------------------------------------
        */

        return view(
            'backend.pages.ecommerce.admin.categories.index',
            compact(
                'categories',
                'totalCategories',
                'activeCategories',
                'productsAssigned',
                'emptyCategories',
                'search',
                'status',
                'type'
            )
        );
    }


    /**
     * Show create category form.
     */
    public function create()
    {
        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->orderBy('name')
            ->get();

        return view(
            'backend.pages.ecommerce.admin.categories.create',
            compact('parentCategories')
        );
    }


    /**
     * Store category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_type' => [
                'required',
                'in:parent,subcategory',
            ],

            'parent_id' => [
                'nullable',
                'required_if:category_type,subcategory',
                'exists:categories,id',
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
                'unique:categories,slug',
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

            'category_image' => [
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
        | Parent ID
        |--------------------------------------------------------------------------
        */

        $parentId = $validated['category_type'] === 'subcategory'
            ? $validated['parent_id']
            : null;


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
        Category::where('slug', $slug)->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | Upload Category Image
        |--------------------------------------------------------------------------
        */

        $image = null;

        if (
            isset($validated['category_image'])
            && $validated['category_image']
        ) {

            $uploadPath = public_path(
                'uploads/ecommerce/categories'
            );

            /*
            |--------------------------------------------------------------------------
            | Create Directory If Not Exists
            |--------------------------------------------------------------------------
            */

            if (!file_exists($uploadPath)) {

                mkdir(
                    $uploadPath,
                    0755,
                    true
                );

            }

            /*
            |--------------------------------------------------------------------------
            | Generate Unique File Name
            |--------------------------------------------------------------------------
            */

            $fileName = 'category-'
                . Str::uuid()
                . '.'
                . $validated['category_image']
                    ->getClientOriginalExtension();

            /*
            |--------------------------------------------------------------------------
            | Move Category Image
            |--------------------------------------------------------------------------
            */

            $validated['category_image']->move(
                $uploadPath,
                $fileName
            );

            /*
            |--------------------------------------------------------------------------
            | Save Relative Image Path
            |--------------------------------------------------------------------------
            */

            $image =
                'uploads/ecommerce/categories/'
                . $fileName;
        }


        /*
        |--------------------------------------------------------------------------
        | Create Category
        |--------------------------------------------------------------------------
        */

        $category = Category::create([

            'parent_id' => $parentId,

            'name' => $validated['name'],

            'slug' => $slug,

            'image' => $image,

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


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin-categories')
            ->with(
                'success',
                'Category created successfully.'
            );
    }


    /**
     * Display category.
     */
    public function show(Category $category)
    {
        $category->load([
            'parent',
            'children',
        ]);

        $category->loadCount('products');

        return view(
            'backend.pages.ecommerce.admin.categories.details',
            compact('category'),
        );
    }


    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        $parentCategories = Category::query()
            ->whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'backend.pages.ecommerce.admin.categories.edit',
            compact(
                'category',
                'parentCategories'
            )
        );
    }


    /**
     * Update category.
     */
    public function update(
        Request  $request,
        Category $category
    )
    {
        $validated = $request->validate([

            'category_type' => [
                'required',
                'in:parent,subcategory',
            ],

            'parent_id' => [
                'nullable',
                'required_if:category_type,subcategory',
                'exists:categories,id',
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
                'unique:categories,slug,' . $category->id,
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

            'category_image' => [
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
        | Prevent Category Becoming Its Own Parent
        |--------------------------------------------------------------------------
        */

        if (
            $validated['category_type'] === 'subcategory'
            &&
            (int)$validated['parent_id'] === $category->id
        ) {

            return back()
                ->withErrors([
                    'parent_id' =>
                        'A category cannot be its own parent.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Parent ID
        |--------------------------------------------------------------------------
        */

        $parentId =
            $validated['category_type'] === 'subcategory'
                ? $validated['parent_id']
                : null;


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
        Category::where('slug', $slug)
            ->where('id', '!=', $category->id)
            ->exists()
        ) {

            $slug =
                $originalSlug .
                '-' .
                $counter;

            $counter++;
        }


        /*
        |--------------------------------------------------------------------------
        | Category Image
        |--------------------------------------------------------------------------
        */

        $image = $category->image;

        if (
            isset($validated['category_image'])
            && $validated['category_image']
        ) {

            /*
            |--------------------------------------------------------------------------
            | Delete Old Category Image
            |--------------------------------------------------------------------------
            */

            if ($category->image) {

                $oldImagePath = public_path(
                    $category->image
                );

                if (file_exists($oldImagePath)) {

                    unlink($oldImagePath);

                }
            }


            /*
            |--------------------------------------------------------------------------
            | Upload Path
            |--------------------------------------------------------------------------
            */

            $uploadPath = public_path(
                'uploads/ecommerce/categories'
            );


            /*
            |--------------------------------------------------------------------------
            | Create Directory If Not Exists
            |--------------------------------------------------------------------------
            */

            if (!file_exists($uploadPath)) {

                mkdir(
                    $uploadPath,
                    0755,
                    true
                );

            }


            /*
            |--------------------------------------------------------------------------
            | Generate Unique File Name
            |--------------------------------------------------------------------------
            */

            $fileName = 'category-'
                . Str::uuid()
                . '.'
                . $validated['category_image']
                    ->getClientOriginalExtension();


            /*
            |--------------------------------------------------------------------------
            | Move Category Image
            |--------------------------------------------------------------------------
            */

            $validated['category_image']->move(
                $uploadPath,
                $fileName
            );


            /*
            |--------------------------------------------------------------------------
            | Save Relative Image Path
            |--------------------------------------------------------------------------
            */

            $image =
                'uploads/ecommerce/categories/'
                . $fileName;
        }


        /*
        |--------------------------------------------------------------------------
        | Update Category
        |--------------------------------------------------------------------------
        */

        $category->update([

            'parent_id' => $parentId,

            'name' => $validated['name'],

            'slug' => $slug,

            'image' => $image,

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


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin-categories')
            ->with(
                'success',
                'Category updated successfully.'
            );
    }


    /**
     * Delete category.
     */
    public function destroy(Category $category)
    {
        /*
        |--------------------------------------------------------------------------
        | Prevent Delete If Subcategories Exist
        |--------------------------------------------------------------------------
        */

        if ($category->children()->exists()) {

            return back()->with(
                'error',
                'You cannot delete this category while it has subcategories.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Category Image
        |--------------------------------------------------------------------------
        */

        if ($category->image) {

            $imagePath = public_path($category->image);

            if (file_exists($imagePath)) {

                unlink($imagePath);
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Delete Category
        |--------------------------------------------------------------------------
        */

        $category->delete();


        /*
        |--------------------------------------------------------------------------
        | Redirect
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('admin-categories')
            ->with(
                'success',
                'Category deleted successfully.'
            );
    }

}
