@extends('backend.layouts.backend')

@section('title', 'User Details')

@section('content')

    @php
        /*
        |--------------------------------------------------------------------------
        | Current Role
        |--------------------------------------------------------------------------
        |
        | Application-level rule:
        | One user has one role.
        |
        */

        $userRole = $user->roles->first();

        $roleName = $userRole?->name ?? 'No Role';

        $roleSlug = $userRole?->slug ?? null;
    @endphp


    <div class="user-details-page">


        {{-- =========================================================
        Page Header
        ========================================================== --}}
        <div class="user-details-page__header">


            <div class="user-details-page__heading">


                <span class="user-details-page__eyebrow">
                    USERS / USER DETAILS
                </span>


                {{-- =================================================
                Profile Header
                ================================================== --}}
                <div class="user-details-profile">


                    {{-- Avatar --}}
                    <div class="user-details-profile__avatar">

                        @if($user->profile_image)

                            <img
                                src="{{ asset($user->profile_image) }}"
                                alt="{{ $user->name }}"
                            >

                        @else

                            {{ strtoupper(
                                substr($user->first_name, 0, 1) .
                                substr($user->last_name ?? '', 0, 1)
                            ) }}

                        @endif

                    </div>


                    {{-- Profile Content --}}
                    <div class="user-details-profile__content">


                        <div class="user-details-profile__title">

                            <h1>
                                {{ $user->name }}
                            </h1>


                            <span class="user-details-status user-details-status--{{ $user->status }}">

                                <span></span>

                                {{ ucfirst($user->status) }}

                            </span>

                        </div>


                        <p>

                            {{ $roleName }}

                            <span>·</span>

                            Joined {{ $user->created_at?->format('F Y') }}

                        </p>


                    </div>

                </div>


            </div>


            {{-- =================================================
            Header Actions
            ================================================== --}}
            <div class="user-details-page__actions">


                <a
                    href="{{ route('users') }}"
                    class="user-details-back-btn"
                >

                    <i class="ri-arrow-left-line"></i>

                    <span>
                        Back to Users
                    </span>

                </a>


                <a
                    href="{{ route('user-edit', $user->id) }}"
                    class="user-details-edit-btn"
                >

                    <i class="ri-edit-line"></i>

                    <span>
                        Edit User
                    </span>

                </a>


            </div>


        </div>



        {{-- =========================================================
        User Summary
        ========================================================== --}}
        <div class="user-details-summary">


            {{-- User ID --}}
            <div class="user-details-summary__item">

                <span>
                    User ID
                </span>

                <strong>
                    #{{ str_pad($user->id, 5, '0', STR_PAD_LEFT) }}
                </strong>

            </div>


            {{-- Role --}}
            <div class="user-details-summary__item">

                <span>
                    Role
                </span>

                <strong>
                    {{ $roleName }}
                </strong>

            </div>


            {{-- Email Status --}}
            <div class="user-details-summary__item">

                <span>
                    Email Status
                </span>

                <strong class="{{ $user->email_verified_at ? 'is-active' : 'is-inactive' }}">

                    {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}

                </strong>

            </div>


            {{-- Joined --}}
            <div class="user-details-summary__item">

                <span>
                    Joined
                </span>

                <strong>
                    {{ $user->created_at?->format('d M Y') }}
                </strong>

            </div>


        </div>



        {{-- =========================================================
        Main Layout
        ========================================================== --}}
        <div class="user-details-layout">


            {{-- =====================================================
            Main Content
            ====================================================== --}}
            <div class="user-details-main">


                {{-- =================================================
                Contact Information
                ================================================== --}}
                <div class="user-details-card">


                    <div class="user-details-card__header">

                        <div>

                            <h2>
                                Contact Information
                            </h2>

                            <p>
                                Personal and communication details.
                            </p>

                        </div>

                        <i class="ri-contacts-line"></i>

                    </div>


                    <div class="user-details-info-grid">


                        {{-- Full Name --}}
                        <div class="user-details-info-item">

                            <div class="user-details-info-item__icon">

                                <i class="ri-user-line"></i>

                            </div>


                            <div>

                                <span>
                                    Full Name
                                </span>

                                <strong>
                                    {{ $user->name }}
                                </strong>

                            </div>

                        </div>


                        {{-- Email --}}
                        <div class="user-details-info-item">

                            <div class="user-details-info-item__icon">

                                <i class="ri-mail-line"></i>

                            </div>


                            <div>

                                <span>
                                    Email Address
                                </span>

                                <strong>
                                    {{ $user->email }}
                                </strong>

                            </div>

                        </div>


                        {{-- Phone --}}
                        <div class="user-details-info-item">

                            <div class="user-details-info-item__icon">

                                <i class="ri-phone-line"></i>

                            </div>


                            <div>

                                <span>
                                    Phone Number
                                </span>

                                <strong>
                                    {{ $user->phone ?: 'Not provided' }}
                                </strong>

                            </div>

                        </div>


                        {{-- Address --}}
                        <div class="user-details-info-item">

                            <div class="user-details-info-item__icon">

                                <i class="ri-map-pin-line"></i>

                            </div>


                            <div>

                                <span>
                                    Address
                                </span>

                                <strong>
                                    {{ $user->address ?: 'Not provided' }}
                                </strong>

                            </div>

                        </div>


                    </div>


                </div>



                {{-- =================================================
                Account Information
                ================================================== --}}
                <div class="user-details-card">


                    <div class="user-details-card__header">

                        <div>

                            <h2>
                                Account Information
                            </h2>

                            <p>
                                Current account configuration and status.
                            </p>

                        </div>

                        <i class="ri-shield-user-line"></i>

                    </div>


                    <div class="user-details-company-grid">


                        {{-- User ID --}}
                        <div>

                            <span>
                                User ID
                            </span>

                            <strong>
                                #{{ $user->id }}
                            </strong>

                        </div>


                        {{-- Role --}}
                        <div>

                            <span>
                                Role
                            </span>

                            <strong>
                                {{ $roleName }}
                            </strong>

                        </div>


                        {{-- Account Status --}}
                        <div>

                            <span>
                                Account Status
                            </span>

                            <strong class="is-{{ $user->status }}">
                                {{ ucfirst($user->status) }}
                            </strong>

                        </div>


                        {{-- Email Verification --}}
                        <div>

                            <span>
                                Email Verification
                            </span>

                            <strong class="{{ $user->email_verified_at ? 'is-active' : 'is-inactive' }}">

                                {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}

                            </strong>

                        </div>


                        {{-- Created At --}}
                        <div>

                            <span>
                                Created At
                            </span>

                            <strong>
                                {{ $user->created_at?->format('d F Y') }}
                            </strong>

                        </div>


                        {{-- Last Updated --}}
                        <div>

                            <span>
                                Last Updated
                            </span>

                            <strong>
                                {{ $user->updated_at?->format('d F Y') }}
                            </strong>

                        </div>


                    </div>


                </div>



                {{-- =================================================
                Profile Information
                ================================================== --}}
                <div class="user-details-card">


                    <div class="user-details-card__header">

                        <div>

                            <h2>
                                Profile Information
                            </h2>

                            <p>
                                User profile and account details.
                            </p>

                        </div>

                        <i class="ri-user-settings-line"></i>

                    </div>


                    <div class="user-details-profile-info">


                        <div class="user-details-profile-info__avatar">

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


                        <div class="user-details-profile-info__content">

                            <strong>
                                {{ $user->name }}
                            </strong>

                            <span>
                                {{ $user->email }}
                            </span>

                            <small>
                                {{ $roleName }} account
                            </small>

                        </div>


                    </div>


                </div>


            </div>



            {{-- =====================================================
            Sidebar
            ====================================================== --}}
            <div class="user-details-sidebar">


                {{-- =================================================
                Account Status
                ================================================== --}}
                <div class="user-details-card">


                    <div class="user-details-card__header">

                        <div>

                            <h2>
                                Account Status
                            </h2>

                            <p>
                                Current account state.
                            </p>

                        </div>

                    </div>


                    <div class="user-details-account">


                        {{-- Account Status --}}
                        <div>

                            <span>
                                Account Status
                            </span>

                            <strong class="is-{{ $user->status }}">
                                {{ ucfirst($user->status) }}
                            </strong>

                        </div>


                        {{-- Email --}}
                        <div>

                            <span>
                                Email Verified
                            </span>

                            <strong class="{{ $user->email_verified_at ? 'is-active' : 'is-inactive' }}">

                                {{ $user->email_verified_at ? 'Verified' : 'Not Verified' }}

                            </strong>

                        </div>


                        {{-- Portal Access --}}
                        <div>

                            <span>
                                Portal Access
                            </span>

                            <strong class="{{ $user->status === 'active' ? 'is-active' : 'is-inactive' }}">

                                {{ $user->status === 'active' ? 'Allowed' : 'Restricted' }}

                            </strong>

                        </div>


                        {{-- Member Since --}}
                        <div>

                            <span>
                                Member Since
                            </span>

                            <strong>
                                {{ $user->created_at?->format('d M Y') }}
                            </strong>

                        </div>


                    </div>


                </div>



                {{-- =================================================
                Role & Access
                ================================================== --}}
                <div class="user-details-card">


                    <div class="user-details-card__header">

                        <div>

                            <h2>
                                Role & Access
                            </h2>

                            <p>
                                Assigned user role.
                            </p>

                        </div>

                    </div>


                    <div class="user-details-permissions">


                        {{-- Current Role --}}
                        <div>

                            <span class="user-details-permission-icon user-details-permission-icon--success">

                                <i class="ri-shield-check-line"></i>

                            </span>

                            <span>

                                {{ $roleName }}

                                @if($roleName !== 'No Role')
                                    Access
                                @endif

                            </span>

                        </div>


                        {{-- Role Status --}}
                        @if($userRole)

                            <div>

                                <span class="user-details-permission-icon user-details-permission-icon--success">

                                    <i class="ri-check-line"></i>

                                </span>

                                <span>
                                    Role Assigned
                                </span>

                            </div>

                        @else

                            <div>

                                <span class="user-details-permission-icon">

                                    <i class="ri-information-line"></i>

                                </span>

                                <span>
                                    No Role Assigned
                                </span>

                            </div>

                        @endif


                    </div>


                </div>



                {{-- =================================================
                Account Timeline
                ================================================== --}}
                <div class="user-details-card">


                    <div class="user-details-card__header">

                        <div>

                            <h2>
                                Account Timeline
                            </h2>

                            <p>
                                Important account dates.
                            </p>

                        </div>

                    </div>


                    <div class="user-details-activity">


                        {{-- Account Created --}}
                        <div class="user-details-activity__item">

                            <span class="user-details-activity__dot"></span>

                            <div>

                                <strong>
                                    Account Created
                                </strong>

                                <span>
                                    {{ $user->created_at?->format('d M Y · h:i A') }}
                                </span>

                            </div>

                        </div>


                        {{-- Email Verified --}}
                        @if($user->email_verified_at)

                            <div class="user-details-activity__item">

                                <span class="user-details-activity__dot"></span>

                                <div>

                                    <strong>
                                        Email Verified
                                    </strong>

                                    <span>
                                        {{ $user->email_verified_at->format('d M Y · h:i A') }}
                                    </span>

                                </div>

                            </div>

                        @endif


                        {{-- Profile Updated --}}
                        <div class="user-details-activity__item">

                            <span class="user-details-activity__dot"></span>

                            <div>

                                <strong>
                                    Profile Updated
                                </strong>

                                <span>
                                    {{ $user->updated_at?->format('d M Y · h:i A') }}
                                </span>

                            </div>

                        </div>


                    </div>


                </div>



                {{-- =================================================
                Account Security
                ================================================== --}}
                <div class="user-details-security">


                    <div class="user-details-security__icon">

                        <i class="ri-shield-check-line"></i>

                    </div>


                    <div>

                        <span>
                            Account Security
                        </span>

                        <strong>
                            {{ $user->status === 'active' ? 'Active' : 'Attention Required' }}
                        </strong>

                        <p>
                            Account is currently
                            {{ $user->status === 'active'
                                ? 'active and accessible.'
                                : 'not fully active.'
                            }}
                        </p>

                    </div>


                </div>


            </div>


        </div>


    </div>

@endsection
