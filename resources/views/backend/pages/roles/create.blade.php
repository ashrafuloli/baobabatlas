@extends('backend.layouts.backend')

@section('title', 'Create Role')

@section('content')

    <section class="role-create-page">

        {{-- =========================================================
        Page Header
        ========================================================== --}}
        <div class="role-create-page__header">

            <div class="role-create-page__header-content">

                <div class="role-create-page__heading">

                <span class="role-create-page__eyebrow">
                    ACCESS CONTROL
                </span>

                    <h1>
                        Create Role
                    </h1>

                    <p>
                        Create a new user role and configure access permissions.
                    </p>

                </div>


                <div class="role-create-page__actions">

                    <a
                        href="{{ route('roles') }}"
                        class="role-secondary-btn"
                    >

                        <i class="ri-arrow-left-line"></i>

                        <span>
                        Back to Roles
                    </span>

                    </a>

                </div>

            </div>

        </div>


        {{-- =========================================================
        Create Role Card
        ========================================================== --}}
        <div class="role-create-card">

            {{-- =====================================================
            Card Header
            ====================================================== --}}
            <div class="role-create-card__header">

                <div class="role-create-card__icon">

                    <i class="ri-shield-user-line"></i>

                </div>

                <div>

                    <h2>
                        Role Information
                    </h2>

                    <p>
                        Enter the basic information for this role.
                    </p>

                </div>

            </div>


            {{-- =====================================================
            Form
            ====================================================== --}}
            <form
                action="{{ route('role-store') }}"
                method="POST"
                class="role-create-form"
            >

                @csrf


                {{-- =================================================
                Role Name
                ================================================== --}}
                <div class="role-create-form__group">

                    <label for="name">
                        Role Name
                        <span>*</span>
                    </label>

                    <div class="role-create-form__input">

                        <i class="ri-shield-user-line"></i>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="e.g. Administrator"
                            maxlength="100"
                            autocomplete="off"
                            autofocus
                            required
                        >

                    </div>


                    <p class="role-create-form__help">
                        Choose a clear and meaningful name for this role.
                    </p>

                </div>


                {{-- =================================================
                Slug Information
                ================================================== --}}
                <div class="role-create-info">

                    <div class="role-create-info__icon">

                        <i class="ri-information-line"></i>

                    </div>

                    <div class="role-create-info__content">

                        <h3>
                            Role Slug
                        </h3>

                        <p>
                            The role slug will be generated automatically from
                            the role name. You don't need to enter it manually.
                        </p>

                    </div>

                </div>


                {{-- =================================================
                Form Actions
                ================================================== --}}
                <div class="role-create-form__footer">

                    <a
                        href="{{ route('roles') }}"
                        class="role-cancel-btn"
                    >

                        <i class="ri-close-line"></i>

                        <span>
                        Cancel
                    </span>

                    </a>


                    <button
                        type="submit"
                        class="role-submit-btn"
                    >

                        <i class="ri-add-line"></i>

                        <span>
                        Create Role
                    </span>

                    </button>

                </div>

            </form>

        </div>

    </section>

@endsection
