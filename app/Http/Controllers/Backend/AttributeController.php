<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

final class AttributeController extends Controller
{
    /**
     * Display a listing of the attributes.
     */
    public function index(): View
    {
        $attributes = Attribute::query()
            ->withCount('values')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $totalAttributes = Attribute::query()->count();

        $activeAttributes = Attribute::query()
            ->where('status', true)
            ->count();

        $inactiveAttributes = Attribute::query()
            ->where('status', false)
            ->count();

        $totalValues = Attribute::query()
            ->withCount('values')
            ->get()
            ->sum('values_count');

        return view(
            'backend.pages.ecommerce.admin.attributes.index',
            compact(
                'attributes',
                'totalAttributes',
                'activeAttributes',
                'inactiveAttributes',
                'totalValues',
            ),
        );
    }

    /**
     * Show the form for creating a new attribute.
     */
    public function create(): View
    {
        return view(
            'backend.pages.ecommerce.admin.attributes.create',
        );
    }

    /**
     * Store a newly created attribute.
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
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'values' => [
                'nullable',
                'array',
            ],
            'values.*.label' => [
                'nullable',
                'string',
                'max:255',
            ],
            'values.*.value' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $slug = $validated['slug']
            ?: Str::slug($validated['name']);

        $slug = $this->generateUniqueSlug($slug);

        $attribute = Attribute::query()->create([
            'name' => $validated['name'],
            'slug' => $slug,
            'sort_order' => $validated['sort_order'] ?? 0,
            'status' => $request->boolean('status'),
        ]);

        $this->syncValues(
            $attribute,
            $validated['values'] ?? [],
        );

        return redirect()
            ->route('admin-attributes')
            ->with(
                'success',
                'Attribute created successfully.',
            );
    }

    /**
     * Display the specified attribute.
     */
    public function show(Attribute $attribute): View
    {
        $attribute->load('values');

        return view(
            'backend.pages.ecommerce.admin.attributes.details',
            compact('attribute'),
        );
    }

    /**
     * Show the form for editing the specified attribute.
     */
    public function edit(Attribute $attribute): View
    {
        $attribute->load('values');

        return view(
            'backend.pages.ecommerce.admin.attributes.edit',
            compact('attribute'),
        );
    }

    /**
     * Update the specified attribute.
     */
    public function update(
        Request $request,
        Attribute $attribute,
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
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'values' => [
                'nullable',
                'array',
            ],
            'values.*.label' => [
                'nullable',
                'string',
                'max:255',
            ],
            'values.*.value' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $slug = $validated['slug']
            ?: Str::slug($validated['name']);

        $slug = $this->generateUniqueSlug(
            $slug,
            $attribute,
        );

        $attribute->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'sort_order' => $validated['sort_order'] ?? 0,
            'status' => $request->boolean('status'),
        ]);

        $this->syncValues(
            $attribute,
            $validated['values'] ?? [],
        );

        return redirect()
            ->route('admin-attributes')
            ->with(
                'success',
                'Attribute updated successfully.',
            );
    }

    /**
     * Remove the specified attribute.
     */
    public function destroy(Attribute $attribute): RedirectResponse
    {
        $attribute->delete();

        return redirect()
            ->route('admin-attributes')
            ->with(
                'success',
                'Attribute deleted successfully.',
            );
    }

    /**
     * Generate a unique attribute slug.
     */
    private function generateUniqueSlug(
        string $slug,
        ?Attribute $attribute = null,
    ): string {
        $originalSlug = $slug;
        $counter = 1;

        while (
        Attribute::query()
            ->where('slug', $slug)
            ->when(
                $attribute,
                fn ($query) => $query->where(
                    'id',
                    '!=',
                    $attribute->id,
                ),
            )
            ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Create attribute values.
     *
     * @param array<int, array{
     *     value?: string|null,
     *     label?: string|null
     * }> $values
     */
    private function syncValues(
        Attribute $attribute,
        array $values,
    ): void {
        $attribute->values()->delete();

        $sortOrder = 0;

        foreach ($values as $item) {
            $label = trim((string) ($item['label'] ?? ''));
            $value = trim((string) ($item['value'] ?? ''));

            if ($value === '') {
                continue;
            }

            $attribute->values()->create([
                'label' => $label !== ''
                    ? $label
                    : $value,
                'value' => $value,
                'slug' => Str::slug($value),
                'sort_order' => $sortOrder,
                'status' => true,
            ]);

            $sortOrder++;
        }
    }
}
