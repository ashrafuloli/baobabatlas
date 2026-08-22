@extends('backend.layouts.backend')

@section('title', 'Role Details')

@section('content')

    <section class="role-details-page">

        {{-- =========================================================
        Page Header
        ========================================================== --}}
        <div class="role-details-page__header">

            <div class="role-details-page__header-content">

                <div class="role-details-page__heading">

                <span class="role-details-page__eyebrow">
                    ACCESS CONTROL
                </span>

                    <h1>
                        Role Details
                    </h1>

                    <p>
                        View role information, assigned users, and permissions.
                    </p>

                </div>


                {{-- =================================================
                Header Actions
                ================================================== --}}
                <div class="role-details-page__actions">

                    {{-- Back to Roles --}}
                    <a
                        href="{{ route('roles') }}"
                        class="role-details-secondary-btn"
                    >

                        <i class="ri-arrow-left-line"></i>

                        <span>
                        Back to Roles
                    </span>

                    </a>


                    {{-- Manage Permissions --}}
                    <a
                        href="{{ route('role-permissions', $role) }}"
                        class="role-details-permissions-btn"
                    >

                        <i class="ri-key-2-line"></i>

                        <span>
                        Manage Permissions
                    </span>

                    </a>


                    {{-- Edit Role --}}
                    <a
                        href="{{ route('role-edit', $role) }}"
                        class="role-details-primary-btn"
                    >

                        <i class="ri-edit-line"></i>

                        <span>
                        Edit Role
                    </span>

                    </a>

                </div>

            </div>

        </div>


        {{-- =========================================================
        Role Overview
        ========================================================== --}}
        <div class="role-details-overview">


            {{-- =====================================================
            Role Identity
            ====================================================== --}}
            <div class="role-details-card role-details-card--identity">

                <div class="role-details-identity">

                    <div class="role-details-identity__icon">

                        <i class="ri-shield-user-line"></i>

                    </div>


                    <div class="role-details-identity__content">

                    <span>
                        ROLE
                    </span>

                        <h2>
                            {{ $role->name }}
                        </h2>

                        <code>
                            {{ $role->slug }}
                        </code>

                    </div>

                </div>

            </div>


            {{-- =====================================================
            Users
            ====================================================== --}}
            <div class="role-details-card">

                <div class="role-details-stat">

                    <div class="role-details-stat__icon role-details-stat__icon--users">

                        <i class="ri-group-line"></i>

                    </div>


                    <div class="role-details-stat__content">

                    <span>
                        Assigned Users
                    </span>

                        <strong>
                            {{ $role->users_count }}
                        </strong>

                        <small>
                            {{ \Illuminate\Support\Str::plural('user', $role->users_count) }}
                        </small>

                    </div>

                </div>

            </div>


            {{-- =====================================================
            Permissions
            ====================================================== --}}
            <div class="role-details-card">

                <div class="role-details-stat">

                    <div class="role-details-stat__icon role-details-stat__icon--permissions">

                        <i class="ri-key-2-line"></i>

                    </div>


                    <div class="role-details-stat__content">

                    <span>
                        Permissions
                    </span>

                        <strong>
                            {{ $role->permissions_count }}
                        </strong>

                        <small>
                            {{ \Illuminate\Support\Str::plural('permission', $role->permissions_count) }}
                        </small>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
        Main Content
        ========================================================== --}}
        <div class="role-details-grid">


            {{-- =====================================================
            Role Information
            ====================================================== --}}
            <div class="role-details-card role-details-card--information">

                <div class="role-details-card__header">

                    <div>

                        <h2>
                            Role Information
                        </h2>

                        <p>
                            Basic information about this role.
                        </p>

                    </div>

                </div>


                <div class="role-details-information">


                    {{-- Role Name --}}
                    <div class="role-details-information__item">

                    <span>
                        Role Name
                    </span>

                        <strong>
                            {{ $role->name }}
                        </strong>

                    </div>


                    {{-- Role Slug --}}
                    <div class="role-details-information__item">

                    <span>
                        Role Slug
                    </span>

                        <code>
                            {{ $role->slug }}
                        </code>

                    </div>


                    {{-- Created --}}
                    <div class="role-details-information__item">

                    <span>
                        Created At
                    </span>

                        <strong>
                            {{ $role->created_at?->format('d M Y, h:i A') }}
                        </strong>

                    </div>


                    {{-- Updated --}}
                    <div class="role-details-information__item">

                    <span>
                        Last Updated
                    </span>

                        <strong>
                            {{ $role->updated_at?->format('d M Y, h:i A') }}
                        </strong>

                    </div>


                </div>

            </div>



            {{-- =====================================================
            Permissions
            ====================================================== --}}
            <div class="role-details-card role-details-card--permissions">

                <div class="role-details-card__header">

                    <div>

                        <h2>
                            Permissions
                        </h2>

                        <p>
                            Permissions currently assigned to this role.
                        </p>

                    </div>


                    <span class="role-details-count">
                    {{ $role->permissions_count }}
                </span>

                </div>


                @if($role->permissions->count())

                    <div class="role-permissions-list">

                        @foreach($role->permissions as $permission)

                            <div class="role-permission-item">

                                <div class="role-permission-item__icon">

                                    <i class="ri-key-2-line"></i>

                                </div>


                                <div class="role-permission-item__content">

                                    <strong>
                                        {{ $permission->name }}
                                    </strong>

                                    <code>
                                        {{ $permission->slug }}
                                    </code>


                                    @if($permission->description)

                                        <p>
                                            {{ $permission->description }}
                                        </p>

                                    @endif

                                </div>

                            </div>

                        @endforeach

                    </div>


                    {{-- Manage Permissions Footer --}}
                    <div class="role-details-permissions-footer">

                        <div class="role-details-permissions-footer__info">

                            <i class="ri-information-line"></i>

                            <span>
                            Manage the permissions assigned to this role.
                        </span>

                        </div>


                        <a
                            href="{{ route('role-permissions', $role) }}"
                            class="role-details-manage-permissions-btn"
                        >

                            <i class="ri-settings-3-line"></i>

                            <span>
                            Manage Permissions
                        </span>

                        </a>

                    </div>

                @else

                    <div class="role-details-empty">

                        <div class="role-details-empty__icon">

                            <i class="ri-key-2-line"></i>

                        </div>

                        <h3>
                            No Permissions Assigned
                        </h3>

                        <p>
                            This role doesn't have any permissions assigned yet.
                        </p>


                        <a
                            href="{{ route('role-permissions', $role) }}"
                            class="role-details-empty__action"
                        >

                            <i class="ri-key-2-line"></i>

                            <span>
                            Assign Permissions
                        </span>

                        </a>

                    </div>

                @endif

            </div>

        </div>



        {{-- =========================================================
        Assigned Users
        ========================================================== --}}
        <div class="role-details-card role-details-card--users">

            <div class="role-details-card__header">

                <div>

                    <h2>
                        Assigned Users
                    </h2>

                    <p>
                        Users currently assigned to this role.
                    </p>

                </div>


                <span class="role-details-count">
                {{ $role->users_count }}
            </span>

            </div>


            @if($role->users->count())

                <div class="role-users-table-wrapper">

                    <table class="role-users-table">

                        <thead>

                        <tr>

                            <th>
                                User
                            </th>

                            <th>
                                Email
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

                        @foreach($role->users as $user)

                            <tr>


                                {{-- User --}}
                                <td>

                                    <div class="role-user-profile">

                                        <div class="role-user-profile__avatar">

                                            @if($user->profile_image)

                                                <img
                                                    src="{{ asset($user->profile_image) }}"
                                                    alt="{{ $user->name }}"
                                                >

                                            @else

                                                <span>

                                                {{ strtoupper(
                                                    substr($user->first_name, 0, 1) .
                                                    substr($user->last_name ?? '', 0, 1)
                                                ) }}

                                            </span>

                                            @endif

                                        </div>


                                        <div class="role-user-profile__info">

                                            <strong>
                                                {{ $user->name }}
                                            </strong>

                                        </div>

                                    </div>

                                </td>


                                {{-- Email --}}
                                <td>

                                <span class="role-user-email">
                                    {{ $user->email }}
                                </span>

                                </td>


                                {{-- Status --}}
                                <td>

                                <span
                                    class="role-user-status role-user-status--{{ $user->status }}"
                                >
                                    {{ ucfirst($user->status) }}
                                </span>

                                </td>


                                {{-- Created --}}
                                <td>

                                <span class="role-user-date">
                                    {{ $user->created_at?->format('d M Y') }}
                                </span>

                                </td>


                                {{-- Action --}}
                                <td>

                                    <a
                                        href="{{ route('user-details', $user) }}"
                                        class="role-user-view-btn"
                                        title="View User"
                                    >

                                        <i class="ri-eye-line"></i>

                                    </a>

                                </td>


                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="role-details-empty">

                    <div class="role-details-empty__icon">

                        <i class="ri-group-line"></i>

                    </div>

                    <h3>
                        No Users Assigned
                    </h3>

                    <p>
                        No users are currently assigned to this role.
                    </p>

                    <a
                        href="{{ route('user-create') }}"
                        class="role-details-empty__action"
                    >

                        <i class="ri-user-add-line"></i>

                        <span>
                        Create User
                    </span>

                    </a>

                </div>

            @endif

        </div>


    </section>

@endsection
