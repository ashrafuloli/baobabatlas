@extends('backend.layouts.backend')

@section('title', 'Attribute Details')

@section('content')

    <div class="attribute-details-page">

        {{-- PAGE HEADER --}}
        <div class="attribute-details-header">

            <div class="attribute-details-header__content">

                <span class="attribute-details-header__eyebrow">
                    Ecommerce / Attributes
                </span>

                <h1 class="attribute-details-header__title">
                    Attribute Details
                </h1>

                <p class="attribute-details-header__description">
                    View the attribute information and its available values.
                </p>

            </div>

            <div class="attribute-details-header__actions">

                <a
                    href="{{ route('admin-attributes') }}"
                    class="attribute-details-back"
                >
                    <i class="ri-arrow-left-line"></i>
                    <span>Back to Attributes</span>
                </a>

                <a
                    href="{{ route('admin-attributes.edit', $attribute) }}"
                    class="attribute-details-edit"
                >
                    <i class="ri-edit-line"></i>
                    <span>Edit Attribute</span>
                </a>

            </div>

        </div>


        {{-- ATTRIBUTE OVERVIEW --}}
        <div class="attribute-details-overview">

            {{-- ATTRIBUTE INFORMATION --}}
            <section class="attribute-details-card">

                <div class="attribute-details-card__header">

                    <div class="attribute-details-card__heading">

                        <div class="attribute-details-card__icon">
                            <i class="ri-price-tag-3-line"></i>
                        </div>

                        <div>

                            <h2 class="attribute-details-card__title">
                                Attribute Information
                            </h2>

                            <p class="attribute-details-card__description">
                                Basic information about this product attribute.
                            </p>

                        </div>

                    </div>


                    <span
                        class="attribute-details-status {{ $attribute->status ? 'is-active' : 'is-inactive' }}"
                    >

                        <span class="attribute-details-status__dot"></span>

                        {{ $attribute->status ? 'Active' : 'Inactive' }}

                    </span>

                </div>


                <div class="attribute-details-card__body">

                    <div class="attribute-details-info-grid">

                        {{-- NAME --}}
                        <div class="attribute-details-info">

                            <span class="attribute-details-info__label">
                                Attribute Name
                            </span>

                            <strong class="attribute-details-info__value">
                                {{ $attribute->name }}
                            </strong>

                        </div>


                        {{-- SLUG --}}
                        <div class="attribute-details-info">

                            <span class="attribute-details-info__label">
                                Slug
                            </span>

                            <strong class="attribute-details-info__value attribute-details-info__value--code">
                                {{ $attribute->slug }}
                            </strong>

                        </div>


                        {{-- SORT ORDER --}}
                        <div class="attribute-details-info">

                            <span class="attribute-details-info__label">
                                Sort Order
                            </span>

                            <strong class="attribute-details-info__value">
                                {{ $attribute->sort_order }}
                            </strong>

                        </div>


                        {{-- TOTAL VALUES --}}
                        <div class="attribute-details-info">

                            <span class="attribute-details-info__label">
                                Total Values
                            </span>

                            <strong class="attribute-details-info__value">
                                {{ $attribute->values->count() }}
                            </strong>

                        </div>


                        {{-- CREATED --}}
                        <div class="attribute-details-info">

                            <span class="attribute-details-info__label">
                                Created
                            </span>

                            <strong class="attribute-details-info__value">
                                {{ $attribute->created_at?->format('M d, Y') ?? '—' }}
                            </strong>

                        </div>


                        {{-- UPDATED --}}
                        <div class="attribute-details-info">

                            <span class="attribute-details-info__label">
                                Last Updated
                            </span>

                            <strong class="attribute-details-info__value">
                                {{ $attribute->updated_at?->format('M d, Y') ?? '—' }}
                            </strong>

                        </div>

                    </div>

                </div>

            </section>


            {{-- ATTRIBUTE VALUES --}}
            <section class="attribute-details-card">

                <div class="attribute-details-card__header">

                    <div class="attribute-details-card__heading">

                        <div class="attribute-details-card__icon attribute-details-card__icon--values">
                            <i class="ri-list-check-2"></i>
                        </div>

                        <div>

                            <h2 class="attribute-details-card__title">
                                Attribute Values
                            </h2>

                            <p class="attribute-details-card__description">
                                Values available for this attribute.
                            </p>

                        </div>

                    </div>


                    <span class="attribute-details-count">
                        {{ $attribute->values->count() }}
                        {{ $attribute->values->count() === 1 ? 'Value' : 'Values' }}
                    </span>

                </div>


                <div class="attribute-details-card__body">

                    @if ($attribute->values->isNotEmpty())

                        <div class="attribute-details-values">

                            <div class="attribute-details-values__head">

                                <span>
                                    #
                                </span>

                                <span>
                                    Label
                                </span>

                                <span>
                                    Value
                                </span>

                                <span>
                                    Slug
                                </span>

                                <span>
                                    Status
                                </span>

                            </div>


                            @foreach (
                                $attribute->values->sortBy('sort_order') as $index => $value
                            )

                                <div class="attribute-details-value-row">

                                    {{-- NUMBER --}}
                                    <div class="attribute-details-value-number">
                                        {{ $index + 1 }}
                                    </div>


                                    {{-- LABEL --}}
                                    <div class="attribute-details-value-content">

                                        <span class="attribute-details-value-content__label">
                                            Label
                                        </span>

                                        <strong>
                                            {{ $value->label }}
                                        </strong>

                                    </div>


                                    {{-- VALUE --}}
                                    <div class="attribute-details-value-content">

                                        <span class="attribute-details-value-content__label">
                                            Value
                                        </span>

                                        <strong>
                                            {{ $value->value }}
                                        </strong>

                                    </div>


                                    {{-- SLUG --}}
                                    <div class="attribute-details-value-content">

                                        <span class="attribute-details-value-content__label">
                                            Slug
                                        </span>

                                        <strong class="attribute-details-value-content__code">
                                            {{ $value->slug }}
                                        </strong>

                                    </div>


                                    {{-- STATUS --}}
                                    <div>

                                        <span
                                            class="attribute-details-value-status {{ $value->status ? 'is-active' : 'is-inactive' }}"
                                        >

                                            <span class="attribute-details-value-status__dot"></span>

                                            {{ $value->status ? 'Active' : 'Inactive' }}

                                        </span>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                    @else

                        <div class="attribute-details-empty">

                            <div class="attribute-details-empty__icon">
                                <i class="ri-list-check-2"></i>
                            </div>

                            <h3>
                                No Values Added
                            </h3>

                            <p>
                                This attribute does not have any values yet.
                            </p>

                            <a
                                href="{{ route('admin-attributes.edit', $attribute) }}"
                                class="attribute-details-empty__button"
                            >
                                <i class="ri-add-line"></i>
                                Add Values
                            </a>

                        </div>

                    @endif

                </div>

            </section>


            {{-- VALUE INFORMATION --}}
            @if ($attribute->values->isNotEmpty())

                <section class="attribute-details-card">

                    <div class="attribute-details-card__header">

                        <div class="attribute-details-card__heading">

                            <div class="attribute-details-card__icon attribute-details-card__icon--info">
                                <i class="ri-information-line"></i>
                            </div>

                            <div>

                                <h2 class="attribute-details-card__title">
                                    Value Information
                                </h2>

                                <p class="attribute-details-card__description">
                                    How attribute values are used throughout the store.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="attribute-details-card__body">

                        <div class="attribute-details-value-info">

                            <div class="attribute-details-value-info__item">

                                <div class="attribute-details-value-info__icon">
                                    <i class="ri-code-line"></i>
                                </div>

                                <div>

                                    <strong>
                                        Value
                                    </strong>

                                    <p>
                                        Used internally by the system for products,
                                        variants, filtering, and other application logic.
                                    </p>

                                </div>

                            </div>


                            <div class="attribute-details-value-info__item">

                                <div class="attribute-details-value-info__icon">
                                    <i class="ri-text"></i>
                                </div>

                                <div>

                                    <strong>
                                        Label
                                    </strong>

                                    <p>
                                        Customer-facing text displayed when selecting
                                        this attribute on the storefront.
                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>

                </section>

            @endif

        </div>


        {{-- PAGE ACTIONS --}}
        <div class="attribute-details-actions">

            <a
                href="{{ route('admin-attributes') }}"
                class="attribute-details-actions__back"
            >
                <i class="ri-arrow-left-line"></i>
                Back to Attributes
            </a>

            <a
                href="{{ route('admin-attributes.edit', $attribute) }}"
                class="attribute-details-actions__edit"
            >
                <i class="ri-edit-line"></i>
                Edit Attribute
            </a>

        </div>

    </div>

@endsection
