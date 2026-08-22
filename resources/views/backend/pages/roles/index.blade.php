@extends('backend.layouts.backend')

@section('title', 'Roles')

@section('content')

    <section class="roles-page">

        {{-- =========================================================
        Page Header
        ========================================================== --}}
        <div class="roles-page__header">

            <div class="roles-page__header-content">

                <div class="roles-page__heading">

                <span class="roles-page__eyebrow">
                    ACCESS CONTROL
                </span>

                    <h1>
                        Roles
                    </h1>

                    <p>
                        Manage user roles and control access across the platform.
                    </p>

                </div>


                <div class="roles-page__actions">

                    <a
                        href="{{ route('role-create') }}"
                        class="roles-primary-btn"
                    >

                        <i class="ri-add-line"></i>

                        <span>
                        Add Role
                    </span>

                    </a>

                </div>

            </div>

        </div>


        {{-- =========================================================
        Flash Messages
        ========================================================== --}}

        @if(session('success'))

            <div class="roles-alert roles-alert--success">

                <i class="ri-checkbox-circle-line"></i>

                <span>
                {{ session('success') }}
            </span>

            </div>

        @endif


        @if(session('error'))

            <div class="roles-alert roles-alert--danger">

                <i class="ri-error-warning-line"></i>

                <span>
                {{ session('error') }}
            </span>

            </div>

        @endif


        {{-- =========================================================
        Validation Errors
        ========================================================== --}}

        @if($errors->any())

            <div class="roles-alert roles-alert--danger">

                <i class="ri-error-warning-line"></i>

                <div>

                    @foreach($errors->all() as $error)

                        <div>
                            {{ $error }}
                        </div>

                    @endforeach

                </div>

            </div>

        @endif


        {{-- =========================================================
        Statistics
        ========================================================== --}}

        <div class="roles-stats">

            {{-- Total Roles --}}
            <div class="role-stat-card">

                <div class="role-stat-card__icon role-stat-card__icon--total">

                    <i class="ri-shield-user-line"></i>

                </div>

                <div class="role-stat-card__content">

                <span>
                    Total Roles
                </span>

                    <strong>
                        {{ $roles->total() }}
                    </strong>

                    <small>
                        All available roles
                    </small>

                </div>

            </div>


            {{-- Roles With Users --}}
            <div class="role-stat-card">

                <div class="role-stat-card__icon role-stat-card__icon--users">

                    <i class="ri-group-line"></i>

                </div>

                <div class="role-stat-card__content">

                <span>
                    Assigned Roles
                </span>

                    <strong>
                        {{ $roles->filter(fn ($role) => $role->users_count > 0)->count() }}
                    </strong>

                    <small>
                        Roles currently in use
                    </small>

                </div>

            </div>


            {{-- Roles With Permissions --}}
            <div class="role-stat-card">

                <div class="role-stat-card__icon role-stat-card__icon--permissions">

                    <i class="ri-key-2-line"></i>

                </div>

                <div class="role-stat-card__content">

                <span>
                    Configured Roles
                </span>

                    <strong>
                        {{ $roles->filter(fn ($role) => $role->permissions_count > 0)->count() }}
                    </strong>

                    <small>
                        Roles with permissions
                    </small>

                </div>

            </div>


            {{-- Empty Roles --}}
            <div class="role-stat-card">

                <div class="role-stat-card__icon role-stat-card__icon--empty">

                    <i class="ri-user-unfollow-line"></i>

                </div>

                <div class="role-stat-card__content">

                <span>
                    Unassigned Roles
                </span>

                    <strong>
                        {{ $roles->filter(fn ($role) => $role->users_count === 0)->count() }}
                    </strong>

                    <small>
                        Available for assignment
                    </small>

                </div>

            </div>

        </div>


        {{-- =========================================================
        Roles Table Card
        ========================================================== --}}

        <div class="roles-table-card">

            {{-- =====================================================
            Card Header
            ====================================================== --}}
            <div class="roles-table-card__header">

                <div class="roles-table-card__heading">

                    <h2>
                        All Roles
                    </h2>

                    <p>
                        View and manage all available roles and permissions.
                    </p>

                </div>


                <div class="roles-table-card__tools">

                <span class="roles-count">

                    {{ $roles->total() }}

                    {{ \Illuminate\Support\Str::plural('role', $roles->total()) }}

                </span>

                </div>

            </div>


            {{-- =====================================================
            Table
            ====================================================== --}}

            @if($roles->count())

                <div class="roles-table-wrapper">

                    <table class="roles-table">

                        <thead>

                        <tr>

                            <th>
                                Role
                            </th>

                            <th>
                                Slug
                            </th>

                            <th>
                                Users
                            </th>

                            <th>
                                Permissions
                            </th>

                            <th>
                                Created
                            </th>

                            <th>
                                Actions
                            </th>

                        </tr>

                        </thead>


                        <tbody>

                        @foreach($roles as $role)

                            <tr>

                                {{-- =================================================
                                Role
                                ================================================== --}}
                                <td>

                                    <div class="role-profile">

                                        <div class="role-profile__icon">

                                            <i class="ri-shield-user-line"></i>

                                        </div>


                                        <div class="role-profile__info">

                                            <a
                                                href="{{ route('role-details', $role) }}"
                                                class="role-profile__name"
                                            >
                                                {{ $role->name }}
                                            </a>

                                            <span>
                                            User Role
                                        </span>

                                        </div>

                                    </div>

                                </td>


                                {{-- =================================================
                                Slug
                                ================================================== --}}
                                <td>

                                    <code class="role-slug">
                                        {{ $role->slug }}
                                    </code>

                                </td>


                                {{-- =================================================
                                Users
                                ================================================== --}}
                                <td>

                                <span class="role-count role-count--users">

                                    <i class="ri-group-line"></i>

                                    <strong>
                                        {{ $role->users_count }}
                                    </strong>

                                    <small>
                                        {{ \Illuminate\Support\Str::plural('user', $role->users_count) }}
                                    </small>

                                </span>

                                </td>


                                {{-- =================================================
                                Permissions
                                ================================================== --}}
                                <td>

                                <span class="role-count role-count--permissions">

                                    <i class="ri-key-2-line"></i>

                                    <strong>
                                        {{ $role->permissions_count }}
                                    </strong>

                                    <small>
                                        {{ \Illuminate\Support\Str::plural('permission', $role->permissions_count) }}
                                    </small>

                                </span>

                                </td>


                                {{-- =================================================
                                Created
                                ================================================== --}}
                                <td>

                                <span class="role-date">

                                    {{ $role->created_at?->format('d M Y') }}

                                </span>

                                </td>


                                {{-- =================================================
                                Actions
                                ================================================== --}}
                                <td>

                                    <div class="role-actions">

                                        {{-- View --}}
                                        <a
                                            href="{{ route('role-details', $role) }}"
                                            class="role-view-btn"
                                            title="View Role"
                                            aria-label="View Role"
                                        >

                                            <i class="ri-eye-line"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('role-edit', $role) }}"
                                            class="role-edit-btn"
                                            title="Edit Role"
                                            aria-label="Edit Role"
                                        >

                                            <i class="ri-edit-line"></i>

                                        </a>


                                        {{-- Delete --}}
                                        @if($role->users_count === 0)

                                            <form
                                                action="{{ route('role-destroy', $role) }}"
                                                method="POST"
                                                class="role-delete-form"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="role-delete-btn"
                                                    data-confirm-delete
                                                    data-role-name="{{ $role->name }}"
                                                    title="Delete Role"
                                                    aria-label="Delete Role"
                                                >

                                                    <i class="ri-delete-bin-line"></i>

                                                </button>

                                            </form>

                                        @else

                                            <button
                                                type="button"
                                                class="role-delete-btn role-delete-btn--disabled"
                                                title="Role has assigned users"
                                                aria-label="Role has assigned users"
                                                disabled
                                            >

                                                <i class="ri-delete-bin-line"></i>

                                            </button>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- =====================================================
                Pagination
                ====================================================== --}}

                @if($roles->hasPages())

                    <div class="roles-table-card__footer">

                        <div class="roles-pagination-info">

                            Showing

                            <strong>
                                {{ $roles->firstItem() }}
                            </strong>

                            to

                            <strong>
                                {{ $roles->lastItem() }}
                            </strong>

                            of

                            <strong>
                                {{ $roles->total() }}
                            </strong>

                            roles

                        </div>


                        <div class="roles-pagination">

                            {{ $roles->withQueryString()->links() }}

                        </div>

                    </div>

                @endif


            @else

                {{-- =====================================================
                Empty State
                ====================================================== --}}

                <div class="roles-empty">

                    <div class="roles-empty__content">

                        <div class="roles-empty__icon">

                            <i class="ri-shield-user-line"></i>

                        </div>


                        <h3>
                            No Roles Found
                        </h3>


                        <p>
                            You haven't created any roles yet.
                            Create your first role to start managing access.
                        </p>


                        <a
                            href="{{ route('role-create') }}"
                            class="roles-primary-btn"
                        >

                            <i class="ri-add-line"></i>

                            <span>
                            Create First Role
                        </span>

                        </a>

                    </div>

                </div>

            @endif

        </div>

    </section>


    {{-- =============================================================
    Delete Confirmation
    ============================================================= --}}

    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                document
                    .querySelectorAll('[data-confirm-delete]')
                    .forEach(function (button) {

                        button.addEventListener('click', function (event) {

                            event.preventDefault();

                            const form = this.closest('form');

                            const roleName =
                                this.dataset.roleName || 'this role';


                            /*
                            |--------------------------------------------------------------------------
                            | SweetAlert
                            |--------------------------------------------------------------------------
                            */

                            if (typeof Swal !== 'undefined') {

                                Swal.fire({

                                    title: 'Delete Role?',

                                    text:
                                        `Are you sure you want to delete "${roleName}"? This action cannot be undone.`,

                                    icon: 'warning',

                                    showCancelButton: true,

                                    confirmButtonText: 'Yes, Delete',

                                    cancelButtonText: 'Cancel',

                                    reverseButtons: true,

                                    focusCancel: true,

                                    customClass: {

                                        confirmButton:
                                            'swal-delete-confirm',

                                        cancelButton:
                                            'swal-delete-cancel'

                                    }

                                }).then(function (result) {

                                    if (result.isConfirmed) {

                                        form.submit();

                                    }

                                });

                                return;
                            }


                            /*
                            |--------------------------------------------------------------------------
                            | Fallback Confirmation
                            |--------------------------------------------------------------------------
                            */

                            if (
                                confirm(
                                    `Are you sure you want to delete "${roleName}"?`
                                )
                            ) {

                                form.submit();

                            }

                        });

                    });

            });

        </script>

    @endpush

@endsection
