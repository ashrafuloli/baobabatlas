@extends('backend.layouts.backend')

@section('title', 'Permission Details')

@section('content')

    <section class="permission-details-page">

        {{-- =========================================================
        Page Header
        ========================================================== --}}
        <div class="permission-details-page__header">

            <div class="permission-details-page__heading">

            <span class="permission-details-page__eyebrow">
                ACCESS CONTROL
            </span>

                <h1>
                    Permission Details
                </h1>

                <p>
                    View permission information and assigned roles.
                </p>

            </div>


            <div class="permission-details-page__actions">

                <a
                    href="{{ route('permissions') }}"
                    class="permission-details-secondary-btn"
                >

                    <i class="ri-arrow-left-line"></i>

                    <span>
                    Back to Permissions
                </span>

                </a>


                <a
                    href="{{ route('permission-edit', $permission) }}"
                    class="permission-details-primary-btn"
                >

                    <i class="ri-edit-line"></i>

                    <span>
                    Edit Permission
                </span>

                </a>

            </div>

        </div>


        {{-- =========================================================
        Overview
        ========================================================== --}}
        <div class="permission-details-overview">

            {{-- =====================================================
            Permission Identity
            ====================================================== --}}
            <div class="permission-details-card permission-details-card--identity">

                <div class="permission-details-identity">

                    <div class="permission-details-identity__icon">

                        <i class="ri-key-2-line"></i>

                    </div>


                    <div class="permission-details-identity__content">

                    <span>
                        PERMISSION
                    </span>

                        <h2>
                            {{ $permission->name }}
                        </h2>

                        <code>
                            {{ $permission->slug }}
                        </code>

                    </div>

                </div>

            </div>


            {{-- =====================================================
            Roles Count
            ====================================================== --}}
            <div class="permission-details-card permission-details-stat">

                <div class="permission-details-stat__icon permission-details-stat__icon--roles">

                    <i class="ri-shield-user-line"></i>

                </div>


                <div class="permission-details-stat__content">

                <span>
                    Assigned Roles
                </span>

                    <strong>
                        {{ $permission->roles->count() }}
                    </strong>

                    <small>
                        roles using this permission
                    </small>

                </div>

            </div>


            {{-- =====================================================
            Created Date
            ====================================================== --}}
            <div class="permission-details-card permission-details-stat">

                <div class="permission-details-stat__icon permission-details-stat__icon--date">

                    <i class="ri-calendar-line"></i>

                </div>


                <div class="permission-details-stat__content">

                <span>
                    Created
                </span>

                    <strong>
                        {{ $permission->created_at?->format('d M') }}
                    </strong>

                    <small>
                        {{ $permission->created_at?->format('Y') }}
                    </small>

                </div>

            </div>

        </div>


        {{-- =========================================================
        Main Details Grid
        ========================================================== --}}
        <div class="permission-details-grid">

            {{-- =====================================================
            Permission Information
            ====================================================== --}}
            <div class="permission-details-card">

                <div class="permission-details-card__header">

                    <div>

                        <h2>
                            Permission Information
                        </h2>

                        <p>
                            Basic information about this permission.
                        </p>

                    </div>

                </div>


                <div class="permission-details-information">

                    {{-- Name --}}
                    <div class="permission-details-information__item">

                    <span>
                        Permission Name
                    </span>

                        <strong>
                            {{ $permission->name }}
                        </strong>

                    </div>


                    {{-- Slug --}}
                    <div class="permission-details-information__item">

                    <span>
                        Permission Slug
                    </span>

                        <code>
                            {{ $permission->slug }}
                        </code>

                    </div>


                    {{-- Description --}}
                    <div class="permission-details-information__item permission-details-information__item--description">

                    <span>
                        Description
                    </span>

                        @if($permission->description)

                            <p>
                                {{ $permission->description }}
                            </p>

                        @else

                            <strong class="permission-details-muted">
                                No description provided.
                            </strong>

                        @endif

                    </div>


                    {{-- Created --}}
                    <div class="permission-details-information__item">

                    <span>
                        Created At
                    </span>

                        <strong>
                            {{ $permission->created_at?->format('d M Y, h:i A') }}
                        </strong>

                    </div>


                    {{-- Updated --}}
                    <div class="permission-details-information__item">

                    <span>
                        Last Updated
                    </span>

                        <strong>
                            {{ $permission->updated_at?->format('d M Y, h:i A') }}
                        </strong>

                    </div>

                </div>

            </div>


            {{-- =====================================================
            Assigned Roles
            ====================================================== --}}
            <div class="permission-details-card">

                <div class="permission-details-card__header">

                    <div>

                        <h2>
                            Assigned Roles
                        </h2>

                        <p>
                            Roles that currently have this permission.
                        </p>

                    </div>


                    <span class="permission-details-count">
                    {{ $permission->roles->count() }}
                </span>

                </div>


                @if($permission->roles->count())

                    <div class="permission-roles-list">

                        @foreach($permission->roles as $role)

                            <div class="permission-role-item">

                                <div class="permission-role-item__icon">

                                    <i class="ri-shield-user-line"></i>

                                </div>


                                <div class="permission-role-item__content">

                                    <strong>
                                        {{ $role->name }}
                                    </strong>

                                    <code>
                                        {{ $role->slug }}
                                    </code>

                                </div>


                                <a
                                    href="{{ route('role-details', $role) }}"
                                    class="permission-role-item__action"
                                    title="View Role"
                                >

                                    <i class="ri-arrow-right-line"></i>

                                </a>

                            </div>

                        @endforeach

                    </div>

                @else

                    <div class="permission-details-empty">

                        <div class="permission-details-empty__icon">

                            <i class="ri-shield-line"></i>

                        </div>

                        <h3>
                            No Roles Assigned
                        </h3>

                        <p>
                            This permission is not currently assigned to any role.
                        </p>

                    </div>

                @endif

            </div>

        </div>


        {{-- =========================================================
        Danger Zone
        ========================================================== --}}
        <div class="permission-details-danger">

            <div class="permission-details-danger__content">

                <div class="permission-details-danger__icon">

                    <i class="ri-delete-bin-line"></i>

                </div>


                <div>

                    <h2>
                        Delete Permission
                    </h2>

                    <p>
                        Permanently delete this permission from the system.
                        This action cannot be undone.
                    </p>

                </div>

            </div>


            <form
                action="{{ route('permission-destroy', $permission) }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete this permission?')"
            >

                @csrf

                @method('DELETE')

                <button
                    type="submit"
                    class="permission-details-delete-btn"
                >

                    <i class="ri-delete-bin-line"></i>

                    <span>
                    Delete Permission
                </span>

                </button>

            </form>

        </div>

    </section>

@endsection
