@extends('backend.layouts.backend')

@section('title', 'Edit Attribute')

@section('content')

    <div class="attribute-edit-page">

        {{-- PAGE HEADER --}}
        <div class="attribute-edit-header">

            <div class="attribute-edit-header__content">

                <span class="attribute-edit-header__eyebrow">
                    Ecommerce / Attributes
                </span>

                <h1 class="attribute-edit-header__title">
                    Edit Attribute
                </h1>

                <p class="attribute-edit-header__description">
                    Update the attribute information and manage its available values.
                </p>

            </div>

            <a
                href="{{ route('admin-attributes') }}"
                class="attribute-edit-back"
            >
                <i class="ri-arrow-left-line"></i>
                <span>Back to Attributes</span>
            </a>

        </div>


        {{-- FORM --}}
        <form
            action="{{ route('admin-attributes.update', $attribute) }}"
            method="POST"
            class="attribute-edit-form"
        >

            @csrf
            @method('PUT')


            {{-- ATTRIBUTE INFORMATION --}}
            <section class="attribute-edit-card">

                <div class="attribute-edit-card__header">

                    <div>

                        <h2 class="attribute-edit-card__title">
                            Attribute Information
                        </h2>

                        <p class="attribute-edit-card__description">
                            Update the basic information for this product attribute.
                        </p>

                    </div>

                </div>


                <div class="attribute-edit-card__body">

                    <div class="attribute-edit-fields">


                        {{-- ATTRIBUTE NAME --}}
                        <div class="attribute-edit-field">

                            <label
                                for="name"
                                class="attribute-edit-field__label"
                            >
                                Attribute Name
                                <span>*</span>
                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name', $attribute->name) }}"
                                placeholder="e.g. Color"
                                class="attribute-edit-field__input @error('name') is-invalid @enderror"
                            >

                            @error('name')
                            <div class="attribute-edit-field__error">
                                {{ $message }}
                            </div>
                            @enderror

                            <small class="attribute-edit-field__hint">
                                Use a clear name such as Color, Size, Storage, or Material.
                            </small>

                        </div>


                        {{-- SLUG --}}
                        <div class="attribute-edit-field">

                            <label
                                for="slug"
                                class="attribute-edit-field__label"
                            >
                                Slug
                            </label>

                            <input
                                type="text"
                                id="slug"
                                name="slug"
                                value="{{ old('slug', $attribute->slug) }}"
                                placeholder="e.g. color"
                                class="attribute-edit-field__input @error('slug') is-invalid @enderror"
                            >

                            @error('slug')
                            <div class="attribute-edit-field__error">
                                {{ $message }}
                            </div>
                            @enderror

                            <small class="attribute-edit-field__hint">
                                Use a unique URL-friendly slug for this attribute.
                            </small>

                        </div>


                        {{-- SORT ORDER --}}
                        <div class="attribute-edit-field">

                            <label
                                for="sort_order"
                                class="attribute-edit-field__label"
                            >
                                Sort Order
                            </label>

                            <input
                                type="number"
                                id="sort_order"
                                name="sort_order"
                                value="{{ old('sort_order', $attribute->sort_order) }}"
                                min="0"
                                class="attribute-edit-field__input @error('sort_order') is-invalid @enderror"
                            >

                            @error('sort_order')
                            <div class="attribute-edit-field__error">
                                {{ $message }}
                            </div>
                            @enderror

                            <small class="attribute-edit-field__hint">
                                Lower numbers appear first.
                            </small>

                        </div>

                    </div>

                </div>

            </section>


            {{-- ATTRIBUTE VALUES --}}
            <section class="attribute-edit-card">

                <div class="attribute-edit-card__header">

                    <div>

                        <h2 class="attribute-edit-card__title">
                            Attribute Values
                        </h2>

                        <p class="attribute-edit-card__description">
                            Manage the values that can be selected for this attribute.
                        </p>

                    </div>

                    <button
                        type="button"
                        class="attribute-edit-add-value"
                        id="addAttributeValue"
                    >
                        <i class="ri-add-line"></i>
                        <span>Add Value</span>
                    </button>

                </div>


                <div class="attribute-edit-card__body">

                    @php
                        $oldValues = old('values');

                        if ($oldValues === null) {
                            $oldValues = $attribute->values
                                ->sortBy('sort_order')
                                ->map(function ($item) {
                                    return [
                                        'value' => $item->value,
                                        'label' => $item->label,
                                    ];
                                })
                                ->values()
                                ->toArray();
                        }

                        if (empty($oldValues)) {
                            $oldValues = [
                                [
                                    'value' => '',
                                    'label' => '',
                                ],
                            ];
                        }
                    @endphp


                    <div
                        class="attribute-edit-values"
                        id="attributeValues"
                    >

                        @foreach ($oldValues as $index => $item)

                            <div class="attribute-edit-value-row">

                                {{-- NUMBER --}}
                                <div class="attribute-edit-value-number">
                                    {{ $index + 1 }}
                                </div>


                                {{-- LABEL --}}
                                <div class="attribute-edit-value-field">

                                    <label
                                        for="label-{{ $index }}"
                                        class="attribute-edit-field__label"
                                    >
                                        Label
                                    </label>

                                    <input
                                        type="text"
                                        id="label-{{ $index }}"
                                        name="values[{{ $index }}][label]"
                                        value="{{ $item['label'] ?? '' }}"
                                        placeholder="e.g. Black"
                                        class="attribute-edit-field__input @error("values.{$index}.label") is-invalid @enderror"
                                    >

                                    @error("values.{$index}.label")
                                    <div class="attribute-edit-field__error">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>


                                {{-- VALUE --}}
                                <div class="attribute-edit-value-field">

                                    <label
                                        for="value-{{ $index }}"
                                        class="attribute-edit-field__label"
                                    >
                                        Value
                                    </label>

                                    <input
                                        type="text"
                                        id="value-{{ $index }}"
                                        name="values[{{ $index }}][value]"
                                        value="{{ $item['value'] ?? '' }}"
                                        placeholder="e.g. black"
                                        class="attribute-edit-field__input @error("values.{$index}.value") is-invalid @enderror"
                                    >

                                    @error("values.{$index}.value")
                                    <div class="attribute-edit-field__error">
                                        {{ $message }}
                                    </div>
                                    @enderror

                                </div>


                                {{-- REMOVE --}}
                                <button
                                    type="button"
                                    class="attribute-edit-remove-value"
                                    title="Remove Value"
                                    aria-label="Remove Value"
                                >
                                    <i class="ri-delete-bin-line"></i>
                                </button>

                            </div>

                        @endforeach

                    </div>


                    @error('values')
                    <div class="attribute-edit-field__error attribute-edit-values-error">
                        {{ $message }}
                    </div>
                    @enderror


                    <div class="attribute-edit-values-hint">

                        <i class="ri-information-line"></i>

                        <p>
                            <strong>Value</strong> is used internally, while
                            <strong>Label</strong> is displayed to customers.
                            For example, use <strong>"black"</strong> as the value
                            and <strong>"Black"</strong> as the label.
                        </p>

                    </div>

                </div>

            </section>


            {{-- ATTRIBUTE SETTINGS --}}
            <section class="attribute-edit-card">

                <div class="attribute-edit-card__header">

                    <div>

                        <h2 class="attribute-edit-card__title">
                            Attribute Settings
                        </h2>

                        <p class="attribute-edit-card__description">
                            Configure the visibility of this attribute.
                        </p>

                    </div>

                </div>


                <div class="attribute-edit-card__body">

                    <div class="attribute-edit-setting">

                        <div class="attribute-edit-setting__content">

                            <div class="attribute-edit-setting__icon">
                                <i class="ri-checkbox-circle-line"></i>
                            </div>

                            <div class="attribute-edit-setting__text">

                                <strong>
                                    Attribute Status
                                </strong>

                                <span>
                                    Make this attribute available when creating products and variants.
                                </span>

                            </div>

                        </div>


                        <label class="attribute-edit-switch">

                            <input
                                type="checkbox"
                                name="status"
                                value="1"
                                {{ old('status', $attribute->status) ? 'checked' : '' }}
                            >

                            <span class="attribute-edit-switch__slider"></span>

                        </label>

                    </div>

                </div>

            </section>


            {{-- FORM ACTIONS --}}
            <div class="attribute-edit-actions">

                <a
                    href="{{ route('admin-attributes') }}"
                    class="attribute-edit-actions__cancel"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="attribute-edit-actions__submit"
                >
                    <i class="ri-save-line"></i>
                    <span>Update Attribute</span>
                </button>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const page = document.querySelector('.attribute-edit-page');

            if (!page) {
                return;
            }


            const form = page.querySelector('.attribute-edit-form');
            const valuesContainer = page.querySelector('#attributeValues');
            const addValueButton = page.querySelector('#addAttributeValue');


            /*
            |--------------------------------------------------------------------------
            | UPDATE VALUE ROW NUMBERS & NAMES
            |--------------------------------------------------------------------------
            */

            function updateValueRows() {

                if (!valuesContainer) {
                    return;
                }

                const rows = valuesContainer.querySelectorAll(
                    '.attribute-edit-value-row'
                );

                rows.forEach(function (row, index) {

                    const number = row.querySelector(
                        '.attribute-edit-value-number'
                    );

                    const labelInput = row.querySelector(
                        '.attribute-edit-label-input'
                    );

                    const valueInput = row.querySelector(
                        '.attribute-edit-value-input'
                    );

                    const label = row.querySelector(
                        '.attribute-edit-label'
                    );

                    const value = row.querySelector(
                        '.attribute-edit-value-label'
                    );


                    if (number) {
                        number.textContent = index + 1;
                    }


                    if (labelInput) {
                        labelInput.id = 'label-' + index;
                        labelInput.name =
                            'values[' + index + '][label]';
                    }


                    if (valueInput) {
                        valueInput.id = 'value-' + index;
                        valueInput.name =
                            'values[' + index + '][value]';
                    }


                    if (label) {
                        label.setAttribute(
                            'for',
                            'label-' + index
                        );
                    }


                    if (value) {
                        value.setAttribute(
                            'for',
                            'value-' + index
                        );
                    }

                });

            }


            /*
            |--------------------------------------------------------------------------
            | CREATE VALUE ROW
            |--------------------------------------------------------------------------
            */

            function createValueRow() {

                if (!valuesContainer) {
                    return;
                }


                const row = document.createElement('div');

                row.className = 'attribute-edit-value-row';

                row.innerHTML = `
                <div class="attribute-edit-value-number"></div>

                <div class="attribute-edit-value-field">

                    <label
                        class="attribute-edit-field__label attribute-edit-label"
                    >
                        Label
                    </label>

                    <input
                        type="text"
                        class="attribute-edit-field__input attribute-edit-label-input"
                        placeholder="e.g. Black"
                    >

                </div>

                <div class="attribute-edit-value-field">

                    <label
                        class="attribute-edit-field__label attribute-edit-value-label"
                    >
                        Value
                    </label>

                    <input
                        type="text"
                        class="attribute-edit-field__input attribute-edit-value-input"
                        placeholder="e.g. black"
                    >

                </div>

                <button
                    type="button"
                    class="attribute-edit-remove-value"
                    title="Remove Value"
                    aria-label="Remove Value"
                >
                    <i class="ri-delete-bin-line"></i>
                </button>
            `;


                valuesContainer.appendChild(row);

                updateValueRows();


                const labelInput = row.querySelector(
                    '.attribute-edit-label-input'
                );

                labelInput?.focus();

            }


            /*
            |--------------------------------------------------------------------------
            | ADD VALUE
            |--------------------------------------------------------------------------
            */

            addValueButton?.addEventListener(
                'click',
                function () {
                    createValueRow();
                }
            );


            /*
            |--------------------------------------------------------------------------
            | REMOVE VALUE
            |--------------------------------------------------------------------------
            */

            valuesContainer?.addEventListener(
                'click',
                function (event) {

                    const removeButton = event.target.closest(
                        '.attribute-edit-remove-value'
                    );

                    if (!removeButton) {
                        return;
                    }


                    const rows = valuesContainer.querySelectorAll(
                        '.attribute-edit-value-row'
                    );


                    if (rows.length === 1) {

                        const labelInput = rows[0].querySelector(
                            '.attribute-edit-label-input'
                        );

                        const valueInput = rows[0].querySelector(
                            '.attribute-edit-value-input'
                        );


                        if (labelInput) {
                            labelInput.value = '';
                        }

                        if (valueInput) {
                            valueInput.value = '';
                        }

                        labelInput?.focus();

                        return;
                    }


                    removeButton
                        .closest('.attribute-edit-value-row')
                        ?.remove();

                    updateValueRows();

                }
            );


            /*
            |--------------------------------------------------------------------------
            | FORM SUBMIT
            |--------------------------------------------------------------------------
            */

            form?.addEventListener(
                'submit',
                function (event) {

                    const submitButton = form.querySelector(
                        '.attribute-edit-actions__submit'
                    );


                    if (!submitButton) {
                        return;
                    }


                    if (submitButton.disabled) {

                        event.preventDefault();

                        return;
                    }


                    submitButton.disabled = true;

                    submitButton.innerHTML = `
                    <i class="ri-loader-4-line"></i>
                    <span>Updating...</span>
                `;

                }
            );


            updateValueRows();

        });

    </script>

@endpush
