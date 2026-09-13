<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\GeneralSettingsRequest;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

final class GeneralSettingsController extends Controller
{
    public function index(): View
    {
        $settings = Setting::query()
            ->pluck('value', 'key');

        return view(
            'backend.pages.settings.general',
            compact('settings')
        );
    }

    public function update(
        GeneralSettingsRequest $request
    ): RedirectResponse {
        $validated = $request->validated();

        DB::transaction(function () use ($request, $validated): void {
            $settings = [
                'website_name' => $validated['website_name'],
                'website_url' => $validated['website_url'],
                'website_tagline' => $validated['website_tagline'] ?? '',

                'currency' => $validated['currency'],
                'currency_position' => $validated['currency_position'],
                'products_per_page' => (string) $validated['products_per_page'],

                'shipping_method' => $validated['shipping_method'],
                'free_shipping_threshold' => (string) $validated['free_shipping_threshold'],
                'processing_time' => $validated['processing_time'],

                'maintenance_mode' => $request->boolean('maintenance_mode')
                    ? '1'
                    : '0',

                'customer_registration' => $request->boolean('customer_registration')
                    ? '1'
                    : '0',
            ];

            foreach ($settings as $key => $value) {
                Setting::query()->updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            $uploadPath = public_path('uploads/website');

            if (! File::isDirectory($uploadPath)) {
                File::makeDirectory(
                    $uploadPath,
                    0755,
                    true
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Website Logo
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('website_logo')) {
                $oldLogo = Setting::query()
                    ->where('key', 'website_logo')
                    ->value('value');

                if (
                    $oldLogo &&
                    File::exists(public_path($oldLogo))
                ) {
                    File::delete(public_path($oldLogo));
                }

                $logo = $request->file('website_logo');

                $logoName = 'logo_'
                    . time()
                    . '_'
                    . uniqid()
                    . '.'
                    . $logo->getClientOriginalExtension();

                $logo->move(
                    $uploadPath,
                    $logoName
                );

                Setting::query()->updateOrCreate(
                    ['key' => 'website_logo'],
                    [
                        'value' => 'uploads/website/' . $logoName,
                    ]
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Favicon
            |--------------------------------------------------------------------------
            */

            if ($request->hasFile('favicon')) {
                $oldFavicon = Setting::query()
                    ->where('key', 'favicon')
                    ->value('value');

                if (
                    $oldFavicon &&
                    File::exists(public_path($oldFavicon))
                ) {
                    File::delete(public_path($oldFavicon));
                }

                $favicon = $request->file('favicon');

                $faviconName = 'favicon_'
                    . time()
                    . '_'
                    . uniqid()
                    . '.'
                    . $favicon->getClientOriginalExtension();

                $favicon->move(
                    $uploadPath,
                    $faviconName
                );

                Setting::query()->updateOrCreate(
                    ['key' => 'favicon'],
                    [
                        'value' => 'uploads/website/' . $faviconName,
                    ]
                );
            }
        });

        return back()->with(
            'success',
            'General settings updated successfully.'
        );
    }
}
