@extends('backend.layouts.backend')

@section('title', 'Permissions')

@section('content')

    <section class="permission-page">

        {{-- =========================================================
        Page Header
        ========================================================== --}}
        <div class="permission-page__header">

            <div class="permission-page__heading">

            <span class="permission-page__eyebrow">
                ACCESS CONTROL
            </span>

                <h1>
                    Permissions
                </h1>

                <p>
                    Manage system permissions and control access across roles.
                </p>

            </div>


            <div class="permission-page__actions">

                <a
                    href="{{ route('permission-create') }}"
                    class="permission-primary-btn"
                >

                    <i class="ri-add-line"></i>

                    <span>
                    Add Permission
                </span>

                </a>

            </div>

        </div>


        {{-- =========================================================
        Permission Table Card
        ========================================================== --}}
        <div class="permission-card">

            {{-- =====================================================
            Card Header
            ====================================================== --}}
            <div class="permission-card__header">

                <div class="permission-card__title">

                    <div class="permission-card__icon">

                        <i class="ri-key-2-line"></i>

                    </div>

                    <div>

                        <h2>
                            All Permissions
                        </h2>

                        <p>
                            View and manage available system permissions.
                        </p>

                    </div>

                </div>


                <div class="permission-card__count">

                <span>
                    {{ $permissions->total() }}
                </span>

                    <small>
                        {{ \Illuminate\Support\Str::plural('permission', $permissions->total()) }}
                    </small>

                </div>

            </div>


            {{-- =====================================================
            Table
            ====================================================== --}}
            @if($permissions->count())

                <div class="permission-table-wrapper">

                    <table class="permission-table">

                        <thead>

                        <tr>

                            <th>
                                Permission
                            </th>

                            <th>
                                Slug
                            </th>

                            <th>
                                Description
                            </th>

                            <th>
                                Roles
                            </th>

                            <th>
                                Created
                            </th>

                            <th class="permission-table__actions-column">
                                Actions
                            </th>

                        </tr>

                        </thead>


                        <tbody>

                        @foreach($permissions as $permission)

                            <tr>

                                {{-- =================================
                                Permission
                                ================================== --}}
                                <td>

                                    <div class="permission-name">

                                        <div class="permission-name__icon">

                                            <i class="ri-key-2-line"></i>

                                        </div>


                                        <div class="permission-name__content">

                                            <strong>
                                                {{ $permission->name }}
                                            </strong>

                                            <span>
                                            ID #{{ $permission->id }}
                                        </span>

                                        </div>

                                    </div>

                                </td>


                                {{-- =================================
                                Slug
                                ================================== --}}
                                <td>

                                    <code class="permission-slug">
                                        {{ $permission->slug }}
                                    </code>

                                </td>


                                {{-- =================================
                                Description
                                ================================== --}}
                                <td>

                                    @if($permission->description)

                                        <span class="permission-description">

                                        {{ \Illuminate\Support\Str::limit(
                                            $permission->description,
                                            70
                                        ) }}

                                    </span>

                                    @else

                                        <span class="permission-description permission-description--empty">
                                        No description
                                    </span>

                                    @endif

                                </td>


                                {{-- =================================
                                Roles Count
                                ================================== --}}
                                <td>

                                <span class="permission-role-count">

                                    <i class="ri-shield-user-line"></i>

                                    {{ $permission->roles_count }}

                                </span>

                                </td>


                                {{-- =================================
                                Created
                                ================================== --}}
                                <td>

                                <span class="permission-date">

                                    {{ $permission->created_at?->format('d M Y') }}

                                </span>

                                </td>


                                {{-- =================================
                                Actions
                                ================================== --}}
                                <td>

                                    <div class="permission-actions">

                                        {{-- View --}}
                                        <a
                                            href="{{ route('permission-details', $permission) }}"
                                            class="permission-action permission-action--view"
                                            title="View Permission"
                                        >

                                            <i class="ri-eye-line"></i>

                                        </a>


                                        {{-- Edit --}}
                                        <a
                                            href="{{ route('permission-edit', $permission) }}"
                                            class="permission-action permission-action--edit"
                                            title="Edit Permission"
                                        >

                                            <i class="ri-edit-line"></i>

                                        </a>


                                        {{-- Delete --}}
                                        <form
                                            action="{{ route('permission-destroy', $permission) }}"
                                            method="POST"
                                            class="permission-delete-form"
                                        >

                                            @csrf

                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="permission-action permission-action--delete"
                                                title="Delete Permission"
                                                onclick="return confirm('Are you sure you want to delete this permission?')"
                                            >

                                                <i class="ri-delete-bin-line"></i>

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>


                {{-- =================================================
                Pagination
                ================================================== --}}
                @if($permissions->hasPages())

                    <div class="permission-pagination">

                        {{ $permissions->links() }}

                    </div>

                @endif

            @else

                {{-- =================================================
                Empty State
                ================================================== --}}
                <div class="permission-empty">

                    <div class="permission-empty__icon">

                        <i class="ri-key-2-line"></i>

                    </div>

                    <h3>
                        No Permissions Found
                    </h3>

                    <p>
                        There are no permissions available yet.
                        Create your first permission to get started.
                    </p>


                    <a
                        href="{{ route('permission-create') }}"
                        class="permission-primary-btn"
                    >

                        <i class="ri-add-line"></i>

                        <span>
                        Create Permission
                    </span>

                    </a>

                </div>

            @endif

        </div>

    </section>

@endsection
