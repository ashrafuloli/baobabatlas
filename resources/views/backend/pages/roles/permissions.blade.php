@extends('backend.layouts.backend')

@section('title', 'Manage Role Permissions')

@section('content')

    <section class="role-permissions-page">


        {{-- =========================================================
        Page Header
        ========================================================== --}}
        <div class="role-permissions-page__header">

            <div class="role-permissions-page__heading">

            <span class="role-permissions-page__eyebrow">
                ACCESS CONTROL
            </span>

                <h1>
                    Manage Permissions
                </h1>

                <p>
                    Configure which permissions are available to this role.
                </p>

            </div>


            {{-- =====================================================
            Header Actions
            ====================================================== --}}
            <div class="role-permissions-page__actions">

                <a
                    href="{{ route('role-details', $role) }}"
                    class="role-permissions-back-btn"
                >

                    <i class="ri-arrow-left-line"></i>

                    <span>
                    Back to Role
                </span>

                </a>

            </div>

        </div>


        {{-- =========================================================
        Role Information
        ========================================================== --}}
        <div class="role-permissions-role-card">


            {{-- Role Icon --}}
            <div class="role-permissions-role-card__icon">

                <i class="ri-shield-user-line"></i>

            </div>


            {{-- Role Information --}}
            <div class="role-permissions-role-card__content">

            <span>
                ROLE
            </span>

                <h2>
                    {{ $role->name }}
                </h2>

                <p>
                    {{ $role->slug }}
                </p>

            </div>


            {{-- Role Statistics --}}
            <div class="role-permissions-role-card__stats">

                {{-- Available --}}
                <div>

                    <strong>
                        {{ $permissions->count() }}
                    </strong>

                    <span>
                    Available
                </span>

                </div>


                {{-- Assigned --}}
                <div>

                    <strong id="selected-permission-count-top">
                        {{ count($assignedPermissionIds) }}
                    </strong>

                    <span>
                    Assigned
                </span>

                </div>

            </div>

        </div>


        {{-- =========================================================
        Permission Form
        ========================================================== --}}
        <form
            action="{{ route('role-permissions.update', $role) }}"
            method="POST"
            class="role-permissions-form"
        >

            @csrf

            @method('PUT')


            {{-- =====================================================
            Permission Card
            ====================================================== --}}
            <div class="role-permissions-card">


                {{-- =================================================
                Card Header
                ================================================== --}}
                <div class="role-permissions-card__header">

                    <div>

                        <h2>
                            Permissions
                        </h2>

                        <p>
                            Select the permissions this role should have access to.
                        </p>

                    </div>


                    {{-- =================================================
                    Permission Tools
                    ================================================== --}}
                    @if($permissions->count())

                        <div class="role-permissions-card__tools">

                            <button
                                type="button"
                                class="role-permissions-tool-btn"
                                id="select-all-permissions"
                            >

                                <i class="ri-checkbox-multiple-line"></i>

                                <span>
                                Select All
                            </span>

                            </button>


                            <button
                                type="button"
                                class="role-permissions-tool-btn"
                                id="clear-all-permissions"
                            >

                                <i class="ri-checkbox-blank-line"></i>

                                <span>
                                Clear All
                            </span>

                            </button>

                        </div>

                    @endif

                </div>


                {{-- =================================================
                Validation Error
                ================================================== --}}
                @if($errors->has('permissions'))

                    <div class="role-permissions-form-error">

                        <i class="ri-error-warning-line"></i>

                        <span>
                        {{ $errors->first('permissions') }}
                    </span>

                    </div>

                @endif


                {{-- =================================================
                Permission List
                ================================================== --}}
                <div class="role-permissions-list">

                    @forelse($permissions as $permission)

                        @php

                            $isChecked = in_array(
                                $permission->id,
                                $assignedPermissionIds,
                                true
                            );

                        @endphp


                        <label
                            class="role-permission-item"
                            for="permission-{{ $permission->id }}"
                        >


                            {{-- Hidden Checkbox --}}
                            <input
                                type="checkbox"
                                id="permission-{{ $permission->id }}"
                                name="permissions[]"
                                value="{{ $permission->id }}"
                                {{ $isChecked ? 'checked' : '' }}
                            >


                            {{-- Custom Check Icon --}}
                            <span class="role-permission-item__checkbox">

                            <i class="ri-check-line"></i>

                        </span>


                            {{-- Permission Content --}}
                            <span class="role-permission-item__content">

                            <strong>
                                {{ $permission->name }}
                            </strong>


                            <span>
                                {{ $permission->slug }}
                            </span>


                            @if($permission->description)

                                    <small>
                                    {{ $permission->description }}
                                </small>

                                @endif

                        </span>

                        </label>

                    @empty


                        {{-- =================================================
                        Empty State
                        ================================================== --}}
                        <div class="role-permissions-empty">

                            <div class="role-permissions-empty__icon">

                                <i class="ri-lock-unlock-line"></i>

                            </div>


                            <h3>
                                No Permissions Available
                            </h3>


                            <p>
                                Create permissions first before assigning them to a role.
                            </p>


                            <a
                                href="{{ route('permission-create') }}"
                                class="role-permissions-empty__btn"
                            >

                                <i class="ri-add-line"></i>

                                <span>
                                Create Permission
                            </span>

                            </a>

                        </div>

                    @endforelse

                </div>


                {{-- =================================================
                Form Footer
                ================================================== --}}
                @if($permissions->count())

                    <div class="role-permissions-card__footer">


                        {{-- Selected Count --}}
                        <div class="role-permissions-selected">

                            <i class="ri-shield-check-line"></i>

                            <span>
                            Selected:
                        </span>

                            <strong id="selected-permission-count">
                                {{ count($assignedPermissionIds) }}
                            </strong>

                        </div>


                        {{-- Form Actions --}}
                        <div class="role-permissions-form-actions">


                            {{-- Cancel --}}
                            <a
                                href="{{ route('role-details', $role) }}"
                                class="role-permissions-cancel-btn"
                            >

                                <i class="ri-close-line"></i>

                                <span>
                                Cancel
                            </span>

                            </a>


                            {{-- Save --}}
                            <button
                                type="submit"
                                class="role-permissions-save-btn"
                            >

                                <i class="ri-save-line"></i>

                                <span>
                                Save Permissions
                            </span>

                            </button>

                        </div>

                    </div>

                @endif


            </div>

        </form>

    </section>


    {{-- =========================================================
    JavaScript
    ========================================================= --}}
    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {


                /*
                |--------------------------------------------------------------------------
                | Permission Checkboxes
                |--------------------------------------------------------------------------
                */

                const checkboxes = document.querySelectorAll(
                    '.role-permission-item input[type="checkbox"]'
                );


                /*
                |--------------------------------------------------------------------------
                | Select All Button
                |--------------------------------------------------------------------------
                */

                const selectAllButton = document.getElementById(
                    'select-all-permissions'
                );


                /*
                |--------------------------------------------------------------------------
                | Clear All Button
                |--------------------------------------------------------------------------
                */

                const clearAllButton = document.getElementById(
                    'clear-all-permissions'
                );


                /*
                |--------------------------------------------------------------------------
                | Selected Count
                |--------------------------------------------------------------------------
                */

                const selectedCount = document.getElementById(
                    'selected-permission-count'
                );


                /*
                |--------------------------------------------------------------------------
                | Top Assigned Count
                |--------------------------------------------------------------------------
                */

                const selectedCountTop = document.getElementById(
                    'selected-permission-count-top'
                );


                /*
                |--------------------------------------------------------------------------
                | Update Selected Count
                |--------------------------------------------------------------------------
                */

                function updateSelectedCount() {

                    const count = document.querySelectorAll(
                        '.role-permission-item input[type="checkbox"]:checked'
                    ).length;


                    if (selectedCount) {

                        selectedCount.textContent = count;

                    }


                    if (selectedCountTop) {

                        selectedCountTop.textContent = count;

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Select All
                |--------------------------------------------------------------------------
                */

                if (selectAllButton) {

                    selectAllButton.addEventListener(
                        'click',
                        function () {

                            checkboxes.forEach(function (checkbox) {

                                checkbox.checked = true;

                            });


                            updateSelectedCount();

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Clear All
                |--------------------------------------------------------------------------
                */

                if (clearAllButton) {

                    clearAllButton.addEventListener(
                        'click',
                        function () {

                            checkboxes.forEach(function (checkbox) {

                                checkbox.checked = false;

                            });


                            updateSelectedCount();

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Individual Checkbox
                |--------------------------------------------------------------------------
                */

                checkboxes.forEach(function (checkbox) {

                    checkbox.addEventListener(
                        'change',
                        updateSelectedCount
                    );

                });


                /*
                |--------------------------------------------------------------------------
                | Initial Count
                |--------------------------------------------------------------------------
                */

                updateSelectedCount();

            });

        </script>

    @endpush

@endsection
