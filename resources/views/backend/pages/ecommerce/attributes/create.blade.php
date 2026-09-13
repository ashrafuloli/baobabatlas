@extends('backend.layouts.backend')

@section('title', 'Create Attribute')

@section('content')

    <div class="attribute-create-page">

        {{-- PAGE HEADER --}}
        <div class="attribute-create-page__header">

            <div>

                <span class="attribute-create-page__eyebrow">
                    Ecommerce / Attributes
                </span>

                <h1>
                    Create Attribute
                </h1>

                <p>
                    Create a product attribute and add its available values.
                </p>

            </div>

            <a
                href="{{ route('admin-attributes') }}"
                class="attribute-create-page__back-btn"
            >

                <i class="ri-arrow-left-line"></i>

                Back to Attributes

            </a>

        </div>


        {{-- FORM --}}
        <form
            action="{{ route('admin-attributes.store') }}"
            method="POST"
            class="attribute-create-form"
        >

            @csrf


            {{-- ATTRIBUTE INFORMATION --}}
            <div class="attribute-create-card">

                <div class="attribute-create-card__header">

                    <div>

                        <h4>
                            Attribute Information
                        </h4>

                        <p>
                            Add the basic information for this product attribute.
                        </p>

                    </div>

                </div>


                <div class="attribute-create-card__body">

                    <div class="attribute-create-grid">

                        {{-- NAME --}}
                        <div class="attribute-create-field">

                            <label for="name">

                                Attribute Name

                                <span>*</span>

                            </label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                placeholder="e.g. Color"
                            >

                            @error('name')

                            <div class="attribute-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Use a clear name such as Color, Size, Storage, or Material.
                            </small>

                        </div>


                        {{-- SLUG --}}
                        <div class="attribute-create-field">

                            <label for="slug">
                                Slug
                            </label>

                            <input
                                type="text"
                                id="slug"
                                name="slug"
                                value="{{ old('slug') }}"
                                placeholder="e.g. color"
                                data-manual="{{ old('slug') ? 'true' : 'false' }}"
                            >

                            @error('slug')

                            <div class="attribute-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Leave blank to generate automatically from the attribute name.
                            </small>

                        </div>


                        {{-- SORT ORDER --}}
                        <div class="attribute-create-field">

                            <label for="sort_order">
                                Sort Order
                            </label>

                            <input
                                type="number"
                                id="sort_order"
                                name="sort_order"
                                value="{{ old('sort_order', 0) }}"
                                min="0"
                            >

                            @error('sort_order')

                            <div class="attribute-create-error">
                                {{ $message }}
                            </div>

                            @enderror

                            <small>
                                Lower numbers appear first.
                            </small>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ATTRIBUTE VALUES --}}
            <div class="attribute-create-card">

                <div class="attribute-create-card__header">

                    <div>

                        <h4>
                            Attribute Values
                        </h4>

                        <p>
                            Add the values that can be selected for this attribute.
                        </p>

                    </div>

                    <button
                        type="button"
                        class="attribute-create-add-value"
                        id="addAttributeValue"
                    >

                        <i class="ri-add-line"></i>

                        Add Value

                    </button>

                </div>


                <div class="attribute-create-card__body">

                    <div
                        class="attribute-create-values"
                        id="attributeValues"
                    >

                        @php
                            $oldValues = old('values', [
                                [
                                    'value' => '',
                                    'label' => '',
                                ],
                            ]);
                        @endphp

                        @foreach($oldValues as $index => $item)

                            <div class="attribute-create-value-row">

                                {{-- NUMBER --}}
                                <div class="attribute-create-value-number">

                                    {{ $index + 1 }}

                                </div>

                                {{-- LABEL --}}
                                <div class="attribute-create-field">

                                    <label for="label-{{ $index }}">

                                        Label

                                    </label>

                                    <input
                                        type="text"
                                        id="label-{{ $index }}"
                                        name="values[{{ $index }}][label]"
                                        value="{{ $item['label'] ?? '' }}"
                                        placeholder="e.g. Black"
                                    >

                                    @error("values.{$index}.label")

                                    <div class="attribute-create-error">
                                        {{ $message }}
                                    </div>

                                    @enderror

                                </div>

                                {{-- VALUE --}}
                                <div class="attribute-create-field">

                                    <label for="value-{{ $index }}">

                                        Value

                                    </label>

                                    <input
                                        type="text"
                                        id="value-{{ $index }}"
                                        name="values[{{ $index }}][value]"
                                        value="{{ $item['value'] ?? '' }}"
                                        placeholder="e.g. black"
                                    >

                                    @error("values.{$index}.value")

                                    <div class="attribute-create-error">
                                        {{ $message }}
                                    </div>

                                    @enderror

                                </div>


                                {{-- REMOVE --}}
                                <button
                                    type="button"
                                    class="attribute-create-remove-value"
                                    title="Remove Value"
                                    aria-label="Remove Value"
                                >

                                    <i class="ri-delete-bin-line"></i>

                                </button>

                            </div>

                        @endforeach

                    </div>


                    @error('values')

                    <div class="attribute-create-error">
                        {{ $message }}
                    </div>

                    @enderror


                    <div class="attribute-create-values-hint">

                        <i class="ri-information-line"></i>

                        <span>
                            Value is used internally, while Label is displayed to customers.
                            For example, use "black" as the value and "Black" as the label.
                        </span>

                    </div>

                </div>

            </div>


            {{-- ATTRIBUTE SETTINGS --}}
            <div class="attribute-create-card">

                <div class="attribute-create-card__header">

                    <div>

                        <h4>
                            Attribute Settings
                        </h4>

                        <p>
                            Configure the visibility of this attribute.
                        </p>

                    </div>

                </div>


                <div class="attribute-create-card__body">

                    <div class="attribute-create-settings">

                        <div class="attribute-create-setting">

                            <div class="attribute-create-setting__content">

                                <div class="attribute-create-setting__icon">

                                    <i class="ri-checkbox-circle-line"></i>

                                </div>

                                <div>

                                    <strong>
                                        Attribute Status
                                    </strong>

                                    <span>
                                        Make this attribute available when creating products and variants.
                                    </span>

                                </div>

                            </div>


                            <label class="attribute-create-switch">

                                <input
                                    type="checkbox"
                                    name="status"
                                    value="1"
                                    {{ old('status', true) ? 'checked' : '' }}
                                >

                                <span></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- FORM ACTIONS --}}
            <div class="attribute-create-actions">

                <a
                    href="{{ route('admin-attributes') }}"
                    class="attribute-create-actions__cancel"
                >
                    Cancel
                </a>


                <button
                    type="submit"
                    class="attribute-create-actions__submit"
                >

                    <i class="ri-save-line"></i>

                    Create Attribute

                </button>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const page =
                document.querySelector('.attribute-create-page');

            if (!page) {
                return;
            }


            /*
            |--------------------------------------------------------------------------
            | AUTO SLUG
            |--------------------------------------------------------------------------
            */

            const nameInput =
                page.querySelector('#name');

            const slugInput =
                page.querySelector('#slug');


            if (nameInput && slugInput) {

                nameInput.addEventListener(
                    'input',
                    function () {

                        if (
                            slugInput.dataset.manual === 'true'
                        ) {
                            return;
                        }

                        slugInput.value =
                            this.value
                                .toLowerCase()
                                .trim()
                                .replace(/[^a-z0-9]+/g, '-')
                                .replace(/^-+|-+$/g, '');

                    }
                );


                slugInput.addEventListener(
                    'input',
                    function () {

                        this.dataset.manual =
                            this.value.trim().length > 0
                                ? 'true'
                                : 'false';

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | ATTRIBUTE VALUES
            |--------------------------------------------------------------------------
            */

            const valuesContainer =
                page.querySelector('#attributeValues');

            const addValueButton =
                page.querySelector('#addAttributeValue');


            function updateValueNumbers() {

                if (!valuesContainer) {
                    return;
                }


                const rows =
                    valuesContainer.querySelectorAll(
                        '.attribute-create-value-row'
                    );


                rows.forEach(
                    function (row, index) {

                        const number =
                            row.querySelector(
                                '.attribute-create-value-number'
                            );


                        if (number) {

                            number.textContent =
                                index + 1;

                        }


                        const valueInput =
                            row.querySelector(
                                'input[name*="[value]"]'
                            );


                        const labelInput =
                            row.querySelector(
                                'input[name*="[label]"]'
                            );


                        if (valueInput) {

                            valueInput.id =
                                'value-' + index;

                            valueInput.name =
                                'values[' +
                                index +
                                '][value]';

                        }


                        if (labelInput) {

                            labelInput.id =
                                'label-' + index;

                            labelInput.name =
                                'values[' +
                                index +
                                '][label]';

                        }

                    }
                );

            }


            function createValueRow() {

                if (!valuesContainer) {
                    return;
                }


                const row =
                    document.createElement('div');


                row.className =
                    'attribute-create-value-row';


                row.innerHTML = `
                    <div class="attribute-create-value-number"></div>

                    <div class="attribute-create-field">

                        <label>
                            Label
                        </label>

                        <input
                            type="text"
                            name="values[][label]"
                            placeholder="e.g. Black"
                        >

                    </div>

                    <div class="attribute-create-field">

                        <label>
                            Value
                        </label>

                        <input
                            type="text"
                            name="values[][value]"
                            placeholder="e.g. black"
                        >

                    </div>

                    <button
                        type="button"
                        class="attribute-create-remove-value"
                        title="Remove Value"
                        aria-label="Remove Value"
                    >

                        <i class="ri-delete-bin-line"></i>

                    </button>
                `;


                valuesContainer.appendChild(row);

                updateValueNumbers();


                const valueInput =
                    row.querySelector(
                        'input[name*="[value]"]'
                    );


                valueInput?.focus();

            }


            if (addValueButton) {

                addValueButton.addEventListener(
                    'click',
                    function () {

                        createValueRow();

                    }
                );

            }


            if (valuesContainer) {

                valuesContainer.addEventListener(
                    'click',
                    function (event) {

                        const removeButton =
                            event.target.closest(
                                '.attribute-create-remove-value'
                            );


                        if (!removeButton) {
                            return;
                        }


                        const rows =
                            valuesContainer.querySelectorAll(
                                '.attribute-create-value-row'
                            );


                        /*
                        |--------------------------------------------------------------------------
                        | Keep at least one value field
                        |--------------------------------------------------------------------------
                        */

                        if (rows.length <= 1) {

                            const valueInput =
                                rows[0]?.querySelector(
                                    'input[name*="[value]"]'
                                );


                            const labelInput =
                                rows[0]?.querySelector(
                                    'input[name*="[label]"]'
                                );


                            if (valueInput) {
                                valueInput.value = '';
                            }


                            if (labelInput) {
                                labelInput.value = '';
                            }


                            valueInput?.focus();

                            return;

                        }


                        removeButton
                            .closest(
                                '.attribute-create-value-row'
                            )
                            ?.remove();


                        updateValueNumbers();

                    }
                );

            }


            /*
            |--------------------------------------------------------------------------
            | FORM SUBMIT
            |--------------------------------------------------------------------------
            */

            const form =
                page.querySelector(
                    '.attribute-create-form'
                );


            if (form) {

                form.addEventListener(
                    'submit',
                    function (event) {

                        const submitButton =
                            form.querySelector(
                                '.attribute-create-actions__submit'
                            );


                        if (
                            submitButton &&
                            submitButton.disabled
                        ) {

                            event.preventDefault();

                            return;

                        }


                        if (submitButton) {

                            submitButton.disabled = true;


                            submitButton.innerHTML = `
                                <i class="ri-loader-4-line"></i>
                                Creating...
                            `;

                        }

                    }
                );

            }


            updateValueNumbers();

        });

    </script>

@endpush
