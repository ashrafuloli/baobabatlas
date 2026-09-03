@extends('backend.layouts.backend')

@section('title', 'Attributes')

@section('content')

    <div class="attribute-index-page">

        {{-- PAGE HEADER --}}
        <div class="attribute-index-page__header">

            <div>

                <span class="attribute-index-page__eyebrow">
                    Ecommerce / Attributes
                </span>

                <h1>
                    Attributes
                </h1>

                <p>
                    Manage product attributes and their available values.
                </p>

            </div>

            <a
                href="{{ route('admin-attributes.create') }}"
                class="attribute-index-page__add-btn"
            >

                <i class="ri-add-line"></i>

                Add Attribute

            </a>

        </div>


        {{-- STATS --}}
        <div class="attribute-index-stats">

            {{-- TOTAL --}}
            <div class="attribute-index-stat-card">

                <div class="attribute-index-stat-card__icon">

                    <i class="ri-list-settings-line"></i>

                </div>

                <div class="attribute-index-stat-card__content">

                    <span>
                        Total Attributes
                    </span>

                    <strong>
                        {{ $totalAttributes }}
                    </strong>

                </div>

            </div>


            {{-- ACTIVE --}}
            <div class="attribute-index-stat-card">

                <div class="attribute-index-stat-card__icon">

                    <i class="ri-checkbox-circle-line"></i>

                </div>

                <div class="attribute-index-stat-card__content">

                    <span>
                        Active
                    </span>

                    <strong>
                        {{ $activeAttributes }}
                    </strong>

                </div>

            </div>


            {{-- INACTIVE --}}
            <div class="attribute-index-stat-card">

                <div class="attribute-index-stat-card__icon">

                    <i class="ri-close-circle-line"></i>

                </div>

                <div class="attribute-index-stat-card__content">

                    <span>
                        Inactive
                    </span>

                    <strong>
                        {{ $inactiveAttributes }}
                    </strong>

                </div>

            </div>


            {{-- VALUES --}}
            <div class="attribute-index-stat-card">

                <div class="attribute-index-stat-card__icon">

                    <i class="ri-checkbox-multiple-line"></i>

                </div>

                <div class="attribute-index-stat-card__content">

                    <span>
                        Total Values
                    </span>

                    <strong>
                        {{ $totalValues }}
                    </strong>

                </div>

            </div>

        </div>


        {{-- TABLE CARD --}}
        <div class="attribute-index-card">

            <div class="attribute-index-card__header">

                <div>

                    <h4>
                        All Attributes
                    </h4>

                    <p>
                        View and manage all product attributes.
                    </p>

                </div>

            </div>


            {{-- TABLE --}}
            <div class="attribute-index-table-wrapper">

                <table class="attribute-index-table">

                    <thead>

                    <tr>

                        <th>
                            #
                        </th>

                        <th>
                            Attribute
                        </th>

                        <th>
                            Values
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Sort Order
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

                    @forelse($attributes as $attribute)

                        <tr>

                            {{-- NUMBER --}}
                            <td>

                                    <span class="attribute-index-number">
                                        {{ $loop->iteration }}
                                    </span>

                            </td>


                            {{-- ATTRIBUTE --}}
                            <td>

                                <div class="attribute-index-name">

                                    <div class="attribute-index-name__icon">

                                        <i class="ri-list-check-3"></i>

                                    </div>

                                    <div>

                                        <strong>
                                            {{ $attribute->name }}
                                        </strong>

                                        <span>
                                                {{ $attribute->slug }}
                                            </span>

                                    </div>

                                </div>

                            </td>


                            {{-- VALUES --}}
                            <td>

                                    <span class="attribute-index-values">

                                        {{ $attribute->values_count }}

                                        {{ $attribute->values_count === 1 ? 'Value' : 'Values' }}

                                    </span>

                            </td>


                            {{-- STATUS --}}
                            <td>

                                @if($attribute->status)

                                    <span class="attribute-index-status attribute-index-status--active">

                                            <i class="ri-checkbox-circle-fill"></i>

                                            Active

                                        </span>

                                @else

                                    <span class="attribute-index-status attribute-index-status--inactive">

                                            <i class="ri-close-circle-fill"></i>

                                            Inactive

                                        </span>

                                @endif

                            </td>


                            {{-- SORT ORDER --}}
                            <td>

                                    <span class="attribute-index-sort">
                                        {{ $attribute->sort_order }}
                                    </span>

                            </td>


                            {{-- CREATED --}}
                            <td>

                                    <span class="attribute-index-date">
                                        {{ $attribute->created_at?->format('M d, Y') }}
                                    </span>

                            </td>


                            {{-- ACTIONS --}}
                            <td>

                                <div class="attribute-index-actions">

                                    {{-- VIEW --}}
                                    <a
                                        href="{{ route('admin-attributes.show', $attribute->id) }}"
                                        class="attribute-index-action attribute-index-action--view"
                                        title="View Attribute"
                                    >

                                        <i class="ri-eye-line"></i>

                                    </a>


                                    {{-- EDIT --}}
                                    <a
                                        href="{{ route('admin-attributes.edit', $attribute->id) }}"
                                        class="attribute-index-action attribute-index-action--edit"
                                        title="Edit Attribute"
                                    >

                                        <i class="ri-edit-line"></i>

                                    </a>


                                    {{-- DELETE --}}
                                    <form
                                        action="{{ route('admin-attributes.destroy', $attribute->id) }}"
                                        method="POST"
                                        class="attribute-index-delete-form"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="attribute-index-action attribute-index-action--delete"
                                            title="Delete Attribute"
                                        >

                                            <i class="ri-delete-bin-line"></i>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="7"
                                class="attribute-index-empty"
                            >

                                <div class="attribute-index-empty__content">

                                    <div class="attribute-index-empty__icon">

                                        <i class="ri-list-settings-line"></i>

                                    </div>

                                    <h4>
                                        No Attributes Found
                                    </h4>

                                    <p>
                                        Start by creating your first product attribute.
                                    </p>

                                    <a
                                        href="{{ route('admin-attributes.create') }}"
                                        class="attribute-index-empty__btn"
                                    >

                                        <i class="ri-add-line"></i>

                                        Add Attribute

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

@endsection


@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const page =
                document.querySelector('.attribute-index-page');

            if (!page) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | DELETE CONFIRMATION
            |--------------------------------------------------------------------------
            */

            const deleteForms =
                page.querySelectorAll(
                    '.attribute-index-delete-form'
                );


            deleteForms.forEach(function (form) {

                form.addEventListener(
                    'submit',
                    function (event) {

                        const confirmed =
                            window.confirm(
                                'Are you sure you want to delete this attribute? All values belonging to this attribute will also be deleted.'
                            );


                        if (!confirmed) {
                            event.preventDefault();
                        }

                    }
                );

            });

        });

    </script>

@endpush
