@extends('backend.layouts.backend')

@section('title', 'Create Permission')

@section('content')

    <section class="permission-create-page">

        {{-- =========================================================
        Page Header
        ========================================================== --}}
        <div class="permission-create-page__header">

            <div class="permission-create-page__header-content">

                <div class="permission-create-page__heading">

                <span class="permission-create-page__eyebrow">
                    ACCESS CONTROL
                </span>

                    <h1>
                        Create Permission
                    </h1>

                    <p>
                        Create a new system permission and define its access scope.
                    </p>

                </div>


                <div class="permission-create-page__actions">

                    <a
                        href="{{ route('permissions') }}"
                        class="permission-secondary-btn"
                    >

                        <i class="ri-arrow-left-line"></i>

                        <span>
                        Back to Permissions
                    </span>

                    </a>

                </div>

            </div>

        </div>


        {{-- =========================================================
        Create Permission Card
        ========================================================== --}}
        <div class="permission-create-card">

            {{-- =====================================================
            Card Header
            ====================================================== --}}
            <div class="permission-create-card__header">

                <div class="permission-create-card__icon">

                    <i class="ri-key-2-line"></i>

                </div>

                <div>

                    <h2>
                        Permission Information
                    </h2>

                    <p>
                        Enter the basic information for this permission.
                    </p>

                </div>

            </div>


            {{-- =====================================================
            Form
            ====================================================== --}}
            <form
                action="{{ route('permission-store') }}"
                method="POST"
                class="permission-create-form"
            >

                @csrf


                {{-- =================================================
                Permission Name
                ================================================== --}}
                <div class="permission-create-form__group">

                    <label for="name">

                        Permission Name

                        <span>
                        *
                    </span>

                    </label>


                    <div class="permission-create-form__input">

                        <i class="ri-key-2-line"></i>

                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="e.g. Manage Users"
                            maxlength="150"
                            autocomplete="off"
                            autofocus
                            required
                        >

                    </div>


                    <p class="permission-create-form__help">
                        Use a clear and meaningful name that describes what
                        this permission allows a user to do.
                    </p>

                </div>


                {{-- =================================================
                Permission Description
                ================================================== --}}
                <div class="permission-create-form__group">

                    <label for="description">
                        Description
                    </label>


                    <div class="permission-create-form__textarea">

                        <i class="ri-file-text-line"></i>

                        <textarea
                            id="description"
                            name="description"
                            rows="5"
                            maxlength="500"
                            placeholder="Describe what this permission allows..."
                        >{{ old('description') }}</textarea>

                    </div>


                    <p class="permission-create-form__help">
                        Add an optional description to explain the purpose
                        of this permission.
                    </p>

                </div>


                {{-- =================================================
                Slug Information
                ================================================== --}}
                <div class="permission-create-info">

                    <div class="permission-create-info__icon">

                        <i class="ri-information-line"></i>

                    </div>


                    <div class="permission-create-info__content">

                        <h3>
                            Permission Slug
                        </h3>

                        <p>
                            The permission slug will be generated automatically
                            from the permission name. You don't need to enter it manually.
                        </p>

                    </div>

                </div>


                {{-- =================================================
                Form Actions
                ================================================== --}}
                <div class="permission-create-form__footer">

                    <a
                        href="{{ route('permissions') }}"
                        class="permission-cancel-btn"
                    >

                        <i class="ri-close-line"></i>

                        <span>
                        Cancel
                    </span>

                    </a>


                    <button
                        type="submit"
                        class="permission-submit-btn"
                    >

                        <i class="ri-add-line"></i>

                        <span>
                        Create Permission
                    </span>

                    </button>

                </div>

            </form>

        </div>

    </section>

@endsection
