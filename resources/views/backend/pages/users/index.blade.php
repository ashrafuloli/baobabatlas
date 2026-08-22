@extends('backend.layouts.backend')

@section('title', 'All Users')

@section('content')

    <section class="users-page">

        {{-- =========================================================
        Page Header
        ========================================================== --}}
        <div class="users-page__header">

            <div class="users-page__header-content">

                <div class="users-page__heading">

                <span class="users-page__eyebrow">
                    USERS & TEAM
                </span>

                    <h1>
                        All Users
                    </h1>

                    <p>
                        Manage users, roles, account status, and access.
                    </p>

                </div>


                <div class="users-page__actions">

                    <button
                        type="button"
                        class="users-filter-btn"
                        id="usersFilterToggle"
                    >

                        <i class="ri-filter-3-line"></i>

                        <span>
                        Filter
                    </span>

                    </button>


                    <a
                        href="{{ route('user-create') }}"
                        class="users-primary-btn"
                    >

                        <i class="ri-user-add-line"></i>

                        <span>
                        Add User
                    </span>

                    </a>

                </div>

            </div>

        </div>


        {{-- =========================================================
        Statistics
        ========================================================== --}}
        <div class="users-stats">

            {{-- Total Users --}}
            <div class="user-stat-card">

                <div class="user-stat-card__icon user-stat-card__icon--total">

                    <i class="ri-team-line"></i>

                </div>


                <div class="user-stat-card__content">

                <span>
                    Total Users
                </span>

                    <strong>
                        {{ $totalUsers }}
                    </strong>

                    <small>
                        All registered users
                    </small>

                </div>

            </div>


            {{-- Active Users --}}
            <div class="user-stat-card">

                <div class="user-stat-card__icon user-stat-card__icon--active">

                    <i class="ri-user-follow-line"></i>

                </div>


                <div class="user-stat-card__content">

                <span>
                    Active Users
                </span>

                    <strong>
                        {{ $activeUsers }}
                    </strong>

                    <small>
                        {{ $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0 }}%
                        of all users
                    </small>

                </div>

            </div>


            {{-- Administrators --}}
            <div class="user-stat-card">

                <div class="user-stat-card__icon user-stat-card__icon--admins">

                    <i class="ri-shield-user-line"></i>

                </div>


                <div class="user-stat-card__content">

                <span>
                    Administrators
                </span>

                    <strong>
                        {{ $adminUsers }}
                    </strong>

                    <small>
                        Users with admin role
                    </small>

                </div>

            </div>


            {{-- Staff --}}
            <div class="user-stat-card">

                <div class="user-stat-card__icon user-stat-card__icon--online">

                    <i class="ri-user-settings-line"></i>

                </div>


                <div class="user-stat-card__content">

                <span>
                    Staff
                </span>

                    <strong>
                        {{ $staffUsers }}
                    </strong>

                    <small>
                        Users with staff role
                    </small>

                </div>

            </div>

        </div>


        {{-- =========================================================
        Filters
        ========================================================== --}}
        <div
            class="users-filter-panel"
            id="usersFilterPanel"
        >

            <form
                action="{{ route('users') }}"
                method="GET"
            >

                <div class="row g-3 align-items-end">

                    {{-- =================================================
                    Search
                    ================================================== --}}
                    <div class="col-xl-5 col-lg-5">

                        <div class="users-filter-group">

                            <label for="search">
                                Search Users
                            </label>


                            <div class="users-filter-input">

                                <i class="ri-search-line"></i>

                                <input
                                    type="text"
                                    id="search"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search by name or email..."
                                >

                            </div>

                        </div>

                    </div>


                    {{-- =================================================
                    Role
                    ================================================== --}}
                    <div class="col-xl-3 col-lg-3 col-md-6">

                        <div class="users-filter-group">

                            <label for="role">
                                Role
                            </label>


                            <select
                                name="role"
                                id="role"
                            >

                                <option value="">
                                    All Roles
                                </option>


                                @foreach($roles as $role)

                                    <option
                                        value="{{ $role->slug }}"
                                        {{ request('role') === $role->slug ? 'selected' : '' }}
                                    >
                                        {{ $role->name }}
                                    </option>

                                @endforeach

                            </select>

                        </div>

                    </div>


                    {{-- =================================================
                    Status
                    ================================================== --}}
                    <div class="col-xl-2 col-lg-2 col-md-6">

                        <div class="users-filter-group">

                            <label for="status">
                                Status
                            </label>


                            <select
                                name="status"
                                id="status"
                            >

                                <option value="">
                                    All Status
                                </option>

                                <option
                                    value="active"
                                    {{ request('status') === 'active' ? 'selected' : '' }}
                                >
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    {{ request('status') === 'inactive' ? 'selected' : '' }}
                                >
                                    Inactive
                                </option>

                                <option
                                    value="suspended"
                                    {{ request('status') === 'suspended' ? 'selected' : '' }}
                                >
                                    Suspended
                                </option>

                            </select>

                        </div>

                    </div>


                    {{-- =================================================
                    Filter Button
                    ================================================== --}}
                    <div class="col-xl-2 col-lg-2">

                        <button
                            type="submit"
                            class="users-filter-submit"
                        >

                            <i class="ri-filter-3-line"></i>

                            <span>
                            Apply Filter
                        </span>

                        </button>

                    </div>

                </div>

            </form>

        </div>


        {{-- =========================================================
        Users Table
        ========================================================== --}}
        <div class="users-table-card">

            {{-- =====================================================
            Table Header
            ====================================================== --}}
            <div class="users-table-card__header">

                <div class="users-table-card__heading">

                    <h2>
                        Team Members
                    </h2>

                    <p>
                        View and manage all users in your organization.
                    </p>

                </div>


                <div class="users-table-card__tools">

                <span class="users-count">

                    {{ $users->total() }}

                    {{ $users->total() === 1 ? 'user' : 'users' }}

                </span>

                </div>

            </div>


            {{-- =====================================================
            Table
            ====================================================== --}}
            <div class="users-table-wrapper">

                <table class="users-table">

                    <thead>

                    <tr>

                        <th>
                            User
                        </th>

                        <th>
                            Role
                        </th>

                        <th>
                            Phone
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Joined
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                    </thead>


                    <tbody>

                    @forelse($users as $user)

                        <tr>

                            {{-- =================================================
                            User
                            ================================================== --}}
                            <td>

                                <div class="user-profile">

                                    <div class="user-profile__avatar">

                                        @if($user->profile_image)

                                            <img
                                                src="{{ asset($user->profile_image) }}"
                                                alt="{{ $user->name }}"
                                            >

                                        @else

                                            {{ strtoupper(substr($user->first_name, 0, 1)) }}{{ strtoupper(substr($user->last_name ?? '', 0, 1)) }}

                                        @endif

                                    </div>


                                    <div class="user-profile__info">

                                        <strong>
                                            {{ $user->name }}
                                        </strong>

                                        <span>
                                        {{ $user->email }}
                                    </span>

                                    </div>

                                </div>

                            </td>


                            {{-- =================================================
                            Roles
                            ================================================== --}}
                            <td>

                                @if($user->roles->count())

                                    <div class="user-roles">

                                        @foreach($user->roles as $role)

                                            @php

                                                $roleClass = match($role->slug) {

                                                    'admin' =>
                                                        'user-role--admin',

                                                    'staff' =>
                                                        'user-role--staff',

                                                    'client' =>
                                                        'user-role--client',

                                                    default =>
                                                        'user-role--default',

                                                };

                                            @endphp


                                            <span
                                                class="user-role {{ $roleClass }}"
                                            >

                                            {{ $role->name }}

                                        </span>

                                        @endforeach

                                    </div>

                                @else

                                    <span class="user-role user-role--default">

                                    No Role

                                </span>

                                @endif

                            </td>


                            {{-- =================================================
                            Phone
                            ================================================== --}}
                            <td>

                            <span class="user-phone">

                                {{ $user->phone ?: '—' }}

                            </span>

                            </td>


                            {{-- =================================================
                            Status
                            ================================================== --}}
                            <td>

                                @php

                                    $statusClass = match($user->status) {

                                        'active' =>
                                            'user-status--active',

                                        'inactive' =>
                                            'user-status--inactive',

                                        'suspended' =>
                                            'user-status--suspended',

                                        default =>
                                            'user-status--default',

                                    };

                                @endphp


                                <span
                                    class="user-status {{ $statusClass }}"
                                >

                                <span></span>

                                {{ ucfirst($user->status) }}

                            </span>

                            </td>


                            {{-- =================================================
                            Joined
                            ================================================== --}}
                            <td>

                            <span class="user-date">

                                {{ $user->created_at?->format('d M Y') }}

                            </span>

                            </td>


                            {{-- =================================================
                            Actions
                            ================================================== --}}
                            <td>

                                <div class="user-actions">

                                    {{-- View --}}
                                    <a
                                        href="{{ route('user-details', $user) }}"
                                        class="user-view-btn"
                                        aria-label="View {{ $user->name }}"
                                        title="View User"
                                    >

                                        <i class="ri-eye-line"></i>

                                    </a>


                                    {{-- Edit --}}
                                    <a
                                        href="{{ route('user-edit', $user) }}"
                                        class="user-edit-btn"
                                        aria-label="Edit {{ $user->name }}"
                                        title="Edit User"
                                    >

                                        <i class="ri-edit-line"></i>

                                    </a>


                                    {{-- Delete --}}
                                    @if(auth()->id() !== $user->id)

                                        <form
                                            action="{{ route('user-destroy', $user) }}"
                                            method="POST"
                                            class="user-delete-form"
                                        >

                                            @csrf

                                            @method('DELETE')


                                            <button
                                                type="submit"
                                                class="user-delete-btn"
                                                data-confirm-delete
                                                data-user-name="{{ $user->name }}"
                                                aria-label="Delete {{ $user->name }}"
                                                title="Delete User"
                                            >

                                                <i class="ri-delete-bin-line"></i>

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        {{-- =================================================
                        Empty State
                        ================================================== --}}
                        <tr>

                            <td
                                colspan="6"
                                class="users-empty"
                            >

                                <div class="users-empty__content">

                                    <div class="users-empty__icon">

                                        <i class="ri-user-search-line"></i>

                                    </div>


                                    <h3>
                                        No Users Found
                                    </h3>


                                    <p>
                                        There are no users matching your current filters.
                                    </p>


                                    <a
                                        href="{{ route('users') }}"
                                        class="users-primary-btn"
                                    >

                                        <i class="ri-refresh-line"></i>

                                        <span>
                                        Clear Filters
                                    </span>

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            {{-- =====================================================
            Pagination
            ====================================================== --}}
            @if($users->hasPages())

                <div class="users-table-card__footer">

                    <div class="users-pagination-info">

                        Showing

                        <strong>
                            {{ $users->firstItem() }}
                        </strong>

                        to

                        <strong>
                            {{ $users->lastItem() }}
                        </strong>

                        of

                        <strong>
                            {{ $users->total() }}
                        </strong>

                        users

                    </div>


                    <div class="users-pagination">

                        {{ $users->withQueryString()->links() }}

                    </div>

                </div>

            @endif

        </div>

    </section>


    {{-- =============================================================
    Filter Toggle + Delete Confirmation
    ============================================================= --}}
    @push('scripts')

        <script>

            document.addEventListener('DOMContentLoaded', function () {

                /*
                |--------------------------------------------------------------------------
                | Filter Toggle
                |--------------------------------------------------------------------------
                */

                const filterToggle =
                    document.getElementById('usersFilterToggle');

                const filterPanel =
                    document.getElementById('usersFilterPanel');


                if (filterToggle && filterPanel) {

                    filterToggle.addEventListener('click', function () {

                        filterPanel.classList.toggle('is-open');

                    });

                }


                /*
                |--------------------------------------------------------------------------
                | Delete Confirmation
                |--------------------------------------------------------------------------
                */

                document
                    .querySelectorAll('[data-confirm-delete]')
                    .forEach(function (button) {

                        button.addEventListener(
                            'click',
                            function (event) {

                                event.preventDefault();


                                const form =
                                    this.closest('form');


                                const userName =
                                    this.dataset.userName || 'this user';


                                /*
                                |--------------------------------------------------------------------------
                                | SweetAlert Fallback
                                |--------------------------------------------------------------------------
                                */

                                if (typeof Swal === 'undefined') {

                                    if (
                                        confirm(
                                            `Are you sure you want to delete ${userName}?`
                                        )
                                    ) {

                                        form.submit();

                                    }

                                    return;
                                }


                                /*
                                |--------------------------------------------------------------------------
                                | SweetAlert
                                |--------------------------------------------------------------------------
                                */

                                Swal.fire({

                                    title: 'Delete User?',

                                    text:
                                        `Are you sure you want to delete ${userName}? This action cannot be undone.`,

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
                                            'swal-delete-cancel',

                                    }

                                }).then(function (result) {

                                    if (result.isConfirmed) {

                                        form.submit();

                                    }

                                });

                            }
                        );

                    });

            });

        </script>

    @endpush

@endsection
