<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PermissionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Display Permissions
    |--------------------------------------------------------------------------
    */

    public function index(): View
    {
        $permissions = Permission::withCount('roles')
            ->latest()
            ->paginate(20);

        return view(
            'backend.pages.permissions.index',
            compact('permissions')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Create Form
    |--------------------------------------------------------------------------
    */

    public function create(): View
    {
        return view('backend.pages.permissions.create');
    }


    /*
    |--------------------------------------------------------------------------
    | Store Permission
    |--------------------------------------------------------------------------
    */

    public function store(Request $request): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($validated['name']);


        /*
        |--------------------------------------------------------------------------
        | Check Duplicate
        |--------------------------------------------------------------------------
        */

        if (Permission::where('slug', $slug)->exists()) {

            return back()
                ->withErrors([
                    'name' => 'This permission already exists.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Create Permission
        |--------------------------------------------------------------------------
        */

        Permission::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('permissions')
            ->with(
                'success',
                'Permission has been created successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Display Permission
    |--------------------------------------------------------------------------
    */

    public function show(Permission $permission): View
    {
        $permission->load('roles');

        return view(
            'backend.pages.permissions.details',
            compact('permission')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Show Edit Form
    |--------------------------------------------------------------------------
    */

    public function edit(Permission $permission): View
    {
        return view(
            'backend.pages.permissions.edit',
            compact('permission')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Permission
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Permission $permission
    ): RedirectResponse {

        /*
        |--------------------------------------------------------------------------
        | Validate
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:150',
            ],

            'description' => [
                'nullable',
                'string',
                'max:500',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | Generate Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($validated['name']);


        /*
        |--------------------------------------------------------------------------
        | Check Duplicate
        |--------------------------------------------------------------------------
        */

        $exists = Permission::where('slug', $slug)
            ->where('id', '!=', $permission->id)
            ->exists();

        if ($exists) {

            return back()
                ->withErrors([
                    'name' => 'This permission already exists.',
                ])
                ->withInput();
        }


        /*
        |--------------------------------------------------------------------------
        | Update Permission
        |--------------------------------------------------------------------------
        */

        $permission->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
        ]);


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('permissions')
            ->with(
                'success',
                'Permission has been updated successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Delete Permission
    |--------------------------------------------------------------------------
    */

    public function destroy(Permission $permission): RedirectResponse
    {
        /*
        |--------------------------------------------------------------------------
        | Remove Role Relationships
        |--------------------------------------------------------------------------
        */

        $permission->roles()->detach();


        /*
        |--------------------------------------------------------------------------
        | Delete Permission
        |--------------------------------------------------------------------------
        */

        $permission->delete();


        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('permissions')
            ->with(
                'success',
                'Permission has been deleted successfully.'
            );
    }
}
