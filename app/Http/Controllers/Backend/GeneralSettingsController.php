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
            ->whereIn('key', [
                'website_name',
                'website_url',
                'website_tagline',
                'website_logo',
                'favicon',
                'maintenance_mode',
                'customer_registration',
            ])
            ->pluck('value', 'key');

        return view(
            'backend.pages.settings.general',
            compact('settings')
        );
    }

    public function update(
        GeneralSettingsRequest $request,
    ): RedirectResponse {
        $validated = $request->validated();

        DB::transaction(function () use ($request, $validated): void {
            /*
            |--------------------------------------------------------------------------
            | Website Information
            |--------------------------------------------------------------------------
            */

            $settings = [
                'website_name' => $validated['website_name'],
                'website_url' => $validated['website_url'],
                'website_tagline' => $validated['website_tagline'] ?? '',

                /*
                |--------------------------------------------------------------------------
                | System Preferences
                |--------------------------------------------------------------------------
                */

                'maintenance_mode' => $request->boolean(
                    'maintenance_mode'
                )
                    ? '1'
                    : '0',

                'customer_registration' => $request->boolean(
                    'customer_registration'
                )
                    ? '1'
                    : '0',
            ];

            foreach ($settings as $key => $value) {
                Setting::query()->updateOrCreate(
                    ['key' => $key],
                    ['value' => $value],
                );
            }

            $uploadPath = public_path('uploads/website');

            if (! File::isDirectory($uploadPath)) {
                File::makeDirectory(
                    $uploadPath,
                    0755,
                    true,
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
                    is_string($oldLogo)
                    && $oldLogo !== ''
                    && File::exists(public_path($oldLogo))
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
                    $logoName,
                );

                Setting::query()->updateOrCreate(
                    ['key' => 'website_logo'],
                    [
                        'value' => 'uploads/website/' . $logoName,
                    ],
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
                    is_string($oldFavicon)
                    && $oldFavicon !== ''
                    && File::exists(public_path($oldFavicon))
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
                    $faviconName,
                );

                Setting::query()->updateOrCreate(
                    ['key' => 'favicon'],
                    [
                        'value' => 'uploads/website/' . $faviconName,
                    ],
                );
            }
        });

        return back()->with(
            'success',
            'General settings updated successfully.',
        );
    }
}
