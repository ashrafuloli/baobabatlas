<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Contracts\View\View;

final class HomeController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->where('status', true)
            ->whereNull('parent_id')
            ->withCount('products')
            ->with([
                'children' => function ($query): void {
                    $query
                        ->where('status', true)
                        ->withCount('products')
                        ->orderBy('sort_order')
                        ->orderBy('name');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view(
            'frontend.pages.home.index',
            compact('categories'),
        );
    }
}
