@extends('backend.layouts.backend')

@section('title', 'Create Promo Code')

@section('content')

    <div class="promo-code-create-page">

        <div class="promo-code-create-page__header">
            <div class="promo-code-create-page__heading">
            <span class="promo-code-create-page__eyebrow">
                E-commerce
            </span>

                <h1 class="promo-code-create-page__title">
                    Create Promo Code
                </h1>

                <p class="promo-code-create-page__description">
                    Create a discount code and choose which products it can be used on.
                </p>
            </div>

            <a
                href="{{ route('admin-coupons') }}"
                class="promo-code-create-page__back-btn"
            >
                <i class="ri-arrow-left-line"></i>
                <span>Back to Promo Codes</span>
            </a>
        </div>


        <form
            action="{{ route('admin-coupons.store') }}"
            method="POST"
            class="promo-code-create-page__form"
            data-coupon-form
        >
            @csrf

            <div class="promo-code-create-page__layout">

                {{-- Main Content --}}
                <div class="promo-code-create-page__main">

                    {{-- Basic Information --}}
                    <div class="promo-code-create-page__card">

                        <div class="promo-code-create-page__card-header">
                            <div>
                                <h2>Basic Information</h2>
                                <p>
                                    Set the promo code and discount details.
                                </p>
                            </div>
                        </div>

                        <div class="promo-code-create-page__card-body">

                            <div class="promo-code-create-page__field">
                                <label for="code">
                                    Promo Code
                                    <span>*</span>
                                </label>

                                <div class="promo-code-create-page__input-wrap">
                                    <i class="ri-price-tag-3-line"></i>

                                    <input
                                        type="text"
                                        id="code"
                                        name="code"
                                        value="{{ old('code') }}"
                                        placeholder="e.g. SAVE20"
                                        maxlength="50"
                                        autocomplete="off"
                                        required
                                    >
                                </div>

                                @error('code')
                                <span class="promo-code-create-page__error">
                                    {{ $message }}
                                </span>
                                @enderror

                                <small>
                                    Customers will enter this code at checkout.
                                </small>
                            </div>


                            <div class="promo-code-create-page__row">

                                <div class="promo-code-create-page__field">
                                    <label for="discount_type">
                                        Discount Type
                                        <span>*</span>
                                    </label>

                                    <select
                                        id="discount_type"
                                        name="discount_type"
                                        required
                                        data-discount-type
                                    >
                                        <option value="percentage"
                                            @selected(old('discount_type', 'percentage') === 'percentage')>
                                            Percentage
                                        </option>

                                        <option value="fixed"
                                            @selected(old('discount_type') === 'fixed')>
                                            Fixed Amount
                                        </option>
                                    </select>

                                    @error('discount_type')
                                    <span class="promo-code-create-page__error">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>


                                <div class="promo-code-create-page__field">
                                    <label for="discount_value">
                                        Discount Value
                                        <span>*</span>
                                    </label>

                                    <div class="promo-code-create-page__input-wrap">
                                    <span
                                        class="promo-code-create-page__input-prefix"
                                        data-discount-symbol
                                    >
                                        %
                                    </span>

                                        <input
                                            type="number"
                                            id="discount_value"
                                            name="discount_value"
                                            value="{{ old('discount_value') }}"
                                            placeholder="20"
                                            min="0.01"
                                            step="0.01"
                                            required
                                        >
                                    </div>

                                    @error('discount_value')
                                    <span class="promo-code-create-page__error">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>

                            </div>


                            <div class="promo-code-create-page__row">

                                <div class="promo-code-create-page__field">
                                    <label for="minimum_amount">
                                        Minimum Order Amount
                                    </label>

                                    <div class="promo-code-create-page__input-wrap">
                                    <span class="promo-code-create-page__input-prefix">
                                        $
                                    </span>

                                        <input
                                            type="number"
                                            id="minimum_amount"
                                            name="minimum_amount"
                                            value="{{ old('minimum_amount', '0') }}"
                                            placeholder="0.00"
                                            min="0"
                                            step="0.01"
                                        >
                                    </div>

                                    @error('minimum_amount')
                                    <span class="promo-code-create-page__error">
                                        {{ $message }}
                                    </span>
                                    @enderror

                                    <small>
                                        Leave at 0 if there is no minimum order requirement.
                                    </small>
                                </div>


                                <div
                                    class="promo-code-create-page__field"
                                    data-maximum-discount-field
                                >
                                    <label for="maximum_discount">
                                        Maximum Discount
                                    </label>

                                    <div class="promo-code-create-page__input-wrap">
                                    <span class="promo-code-create-page__input-prefix">
                                        $
                                    </span>

                                        <input
                                            type="number"
                                            id="maximum_discount"
                                            name="maximum_discount"
                                            value="{{ old('maximum_discount') }}"
                                            placeholder="No limit"
                                            min="0"
                                            step="0.01"
                                        >
                                    </div>

                                    @error('maximum_discount')
                                    <span class="promo-code-create-page__error">
                                        {{ $message }}
                                    </span>
                                    @enderror

                                    <small>
                                        Maximum amount that can be discounted.
                                    </small>
                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Product Applicability --}}
                    <div class="promo-code-create-page__card">

                        <div class="promo-code-create-page__card-header">
                            <div>
                                <h2>Product Applicability</h2>
                                <p>
                                    Choose which products can use this promo code.
                                </p>
                            </div>
                        </div>

                        <div class="promo-code-create-page__card-body">

                            <div class="promo-code-create-page__scope-options">

                                <label
                                    class="promo-code-create-page__scope-option"
                                    data-scope-option
                                >
                                    <input
                                        type="radio"
                                        name="product_scope"
                                        value="all"
                                        @checked(old('product_scope', 'all') === 'all')
                                        data-product-scope
                                    >

                                    <span class="promo-code-create-page__radio"></span>

                                    <span class="promo-code-create-page__scope-content">
                                    <strong>
                                        All Products
                                    </strong>

                                    <small>
                                        This promo code can be used on every product.
                                    </small>
                                </span>

                                </label>


                                <label
                                    class="promo-code-create-page__scope-option"
                                    data-scope-option
                                >
                                    <input
                                        type="radio"
                                        name="product_scope"
                                        value="selected"
                                        @checked(old('product_scope') === 'selected')
                                        data-product-scope
                                    >

                                    <span class="promo-code-create-page__radio"></span>

                                    <span class="promo-code-create-page__scope-content">
                                    <strong>
                                        Selected Products
                                    </strong>

                                    <small>
                                        Apply this promo code only to selected products.
                                    </small>
                                </span>

                                </label>

                            </div>


                            <div
                                class="promo-code-create-page__products"
                                data-products-wrapper
                            >

                                <div class="promo-code-create-page__products-header">
                                    <div>
                                        <h3>Select Products</h3>
                                        <span data-selected-count>
                                        0 products selected
                                    </span>
                                    </div>

                                    <button
                                        type="button"
                                        class="promo-code-create-page__select-all"
                                        data-select-all
                                    >
                                        Select All
                                    </button>
                                </div>


                                <div class="promo-code-create-page__product-search">
                                    <i class="ri-search-line"></i>

                                    <input
                                        type="search"
                                        placeholder="Search products..."
                                        autocomplete="off"
                                        data-product-search
                                    >
                                </div>


                                <div class="promo-code-create-page__product-list">

                                    @forelse($products as $product)

                                        <label
                                            class="promo-code-create-page__product"
                                            data-product
                                            data-product-name="{{ strtolower($product->name) }}"
                                            data-product-sku="{{ strtolower($product->sku ?? '') }}"
                                        >

                                            <input
                                                type="checkbox"
                                                name="product_ids[]"
                                                value="{{ $product->id }}"
                                                data-product-checkbox
                                                @checked(
                                                    in_array(
                                                        $product->id,
                                                        old('product_ids', []),
                                                        true
                                                    )
                                                )
                                            >

                                            <span class="promo-code-create-page__checkbox">
                                            <i class="ri-check-line"></i>
                                        </span>


                                            <div class="promo-code-create-page__product-image">

                                                @if($product->thumbnail)
                                                    <img
                                                        src="{{ asset($product->thumbnail) }}"
                                                        alt="{{ $product->name }}"
                                                    >
                                                @else
                                                    <i class="ri-image-line"></i>
                                                @endif

                                            </div>


                                            <div class="promo-code-create-page__product-info">

                                                <strong>
                                                    {{ $product->name }}
                                                </strong>

                                                <span>
                                                {{ $product->sku ?: 'No SKU' }}
                                            </span>

                                            </div>


                                            <div class="promo-code-create-page__product-price">
                                                ${{ number_format((float) $product->price, 2) }}
                                            </div>

                                        </label>

                                    @empty

                                        <div class="promo-code-create-page__products-empty">
                                            <i class="ri-shopping-bag-3-line"></i>

                                            <strong>
                                                No products available
                                            </strong>

                                            <span>
                                            Add an active product before assigning products to a promo code.
                                        </span>
                                        </div>

                                    @endforelse

                                </div>

                                <div
                                    class="promo-code-create-page__search-empty"
                                    data-search-empty
                                >
                                    <i class="ri-search-line"></i>
                                    <span>No matching products found.</span>
                                </div>

                            </div>


                            @error('product_ids')
                            <span class="promo-code-create-page__error">
                                {{ $message }}
                            </span>
                            @enderror

                            @error('product_ids.*')
                            <span class="promo-code-create-page__error">
                                {{ $message }}
                            </span>
                            @enderror

                        </div>

                    </div>


                    {{-- Schedule --}}
                    <div class="promo-code-create-page__card">

                        <div class="promo-code-create-page__card-header">
                            <div>
                                <h2>Schedule</h2>
                                <p>
                                    Control when this promo code can be used.
                                </p>
                            </div>
                        </div>

                        <div class="promo-code-create-page__card-body">

                            <div class="promo-code-create-page__row">

                                <div class="promo-code-create-page__field">
                                    <label for="starts_at">
                                        Start Date
                                    </label>

                                    <div class="promo-code-create-page__input-wrap">
                                        <i class="ri-calendar-line"></i>

                                        <input
                                            type="datetime-local"
                                            id="starts_at"
                                            name="starts_at"
                                            value="{{ old('starts_at') }}"
                                        >
                                    </div>

                                    @error('starts_at')
                                    <span class="promo-code-create-page__error">
                                        {{ $message }}
                                    </span>
                                    @enderror

                                    <small>
                                        Leave empty to make the code available immediately.
                                    </small>
                                </div>


                                <div class="promo-code-create-page__field">
                                    <label for="expires_at">
                                        Expiry Date
                                    </label>

                                    <div class="promo-code-create-page__input-wrap">
                                        <i class="ri-calendar-close-line"></i>

                                        <input
                                            type="datetime-local"
                                            id="expires_at"
                                            name="expires_at"
                                            value="{{ old('expires_at') }}"
                                        >
                                    </div>

                                    @error('expires_at')
                                    <span class="promo-code-create-page__error">
                                        {{ $message }}
                                    </span>
                                    @enderror

                                    <small>
                                        Leave empty if the promo code never expires.
                                    </small>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Sidebar --}}
                <aside class="promo-code-create-page__sidebar">

                    {{-- Usage --}}
                    <div class="promo-code-create-page__card">

                        <div class="promo-code-create-page__card-header">
                            <div>
                                <h2>Usage Limits</h2>
                                <p>
                                    Optional redemption limits.
                                </p>
                            </div>
                        </div>

                        <div class="promo-code-create-page__card-body">

                            <div class="promo-code-create-page__field">
                                <label for="usage_limit">
                                    Total Usage Limit
                                </label>

                                <input
                                    type="number"
                                    id="usage_limit"
                                    name="usage_limit"
                                    value="{{ old('usage_limit') }}"
                                    placeholder="Unlimited"
                                    min="1"
                                    step="1"
                                >

                                @error('usage_limit')
                                <span class="promo-code-create-page__error">
                                    {{ $message }}
                                </span>
                                @enderror

                                <small>
                                    Maximum number of times this code can be used.
                                </small>
                            </div>


                            <div class="promo-code-create-page__field">
                                <label for="per_user_limit">
                                    Per User Limit
                                </label>

                                <input
                                    type="number"
                                    id="per_user_limit"
                                    name="per_user_limit"
                                    value="{{ old('per_user_limit') }}"
                                    placeholder="Unlimited"
                                    min="1"
                                    step="1"
                                >

                                @error('per_user_limit')
                                <span class="promo-code-create-page__error">
                                    {{ $message }}
                                </span>
                                @enderror

                                <small>
                                    Maximum uses allowed for one customer.
                                </small>
                            </div>

                        </div>

                    </div>


                    {{-- Status --}}
                    <div class="promo-code-create-page__card">

                        <div class="promo-code-create-page__card-header">
                            <div>
                                <h2>Status</h2>
                                <p>
                                    Control promo code availability.
                                </p>
                            </div>
                        </div>

                        <div class="promo-code-create-page__card-body">

                            <label class="promo-code-create-page__switch">

                                <input
                                    type="hidden"
                                    name="is_active"
                                    value="0"
                                >

                                <input
                                    type="checkbox"
                                    name="is_active"
                                    value="1"
                                    @checked(old('is_active', true))
                                    data-status-toggle
                                >

                                <span class="promo-code-create-page__switch-slider"></span>

                                <span class="promo-code-create-page__switch-content">
                                <strong data-status-label>
                                    Active
                                </strong>

                                <small data-status-description>
                                    Customers can use this promo code.
                                </small>
                            </span>

                            </label>

                            @error('is_active')
                            <span class="promo-code-create-page__error">
                                {{ $message }}
                            </span>
                            @enderror

                        </div>

                    </div>


                    {{-- Form Actions --}}
                    <div class="promo-code-create-page__actions">

                        <a
                            href="{{ route('admin-coupons') }}"
                            class="promo-code-create-page__cancel-btn"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="promo-code-create-page__submit-btn"
                            data-submit-button
                        >
                            <i class="ri-save-line"></i>
                            <span>Create Promo Code</span>
                        </button>

                    </div>

                </aside>

            </div>

        </form>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const page = document.querySelector('.promo-code-create-page');

            if (!page) {
                return;
            }

            const form = page.querySelector('[data-coupon-form]');
            const discountType = page.querySelector('[data-discount-type]');
            const discountSymbol = page.querySelector('[data-discount-symbol]');
            const maximumDiscountField = page.querySelector(
                '[data-maximum-discount-field]'
            );

            const scopeInputs = page.querySelectorAll(
                '[data-product-scope]'
            );

            const productsWrapper = page.querySelector(
                '[data-products-wrapper]'
            );

            const productSearch = page.querySelector(
                '[data-product-search]'
            );

            const products = Array.from(
                page.querySelectorAll('[data-product]')
            );

            const checkboxes = Array.from(
                page.querySelectorAll('[data-product-checkbox]')
            );

            const selectAllButton = page.querySelector(
                '[data-select-all]'
            );

            const selectedCount = page.querySelector(
                '[data-selected-count]'
            );

            const searchEmpty = page.querySelector(
                '[data-search-empty]'
            );

            const statusToggle = page.querySelector(
                '[data-status-toggle]'
            );

            const statusLabel = page.querySelector(
                '[data-status-label]'
            );

            const statusDescription = page.querySelector(
                '[data-status-description]'
            );

            const submitButton = page.querySelector(
                '[data-submit-button]'
            );


            const updateDiscountType = function () {
                const type = discountType?.value || 'percentage';

                if (discountSymbol) {
                    discountSymbol.textContent =
                        type === 'percentage' ? '%' : '$';
                }

                if (maximumDiscountField) {
                    maximumDiscountField.hidden =
                        type !== 'percentage';
                }
            };


            const updateSelectedCount = function () {
                const count = checkboxes.filter(
                    checkbox => checkbox.checked
                ).length;

                if (selectedCount) {
                    selectedCount.textContent =
                        `${count} ${count === 1 ? 'product' : 'products'} selected`;
                }

                if (selectAllButton) {
                    const visibleProducts = products.filter(
                        product => !product.hidden
                    );

                    const visibleCheckboxes = visibleProducts
                        .map(product =>
                            product.querySelector('[data-product-checkbox]')
                        )
                        .filter(Boolean);

                    const allSelected =
                        visibleCheckboxes.length > 0 &&
                        visibleCheckboxes.every(
                            checkbox => checkbox.checked
                        );

                    selectAllButton.textContent =
                        allSelected ? 'Deselect All' : 'Select All';
                }
            };


            const filterProducts = function () {
                const search = (
                    productSearch?.value || ''
                )
                    .trim()
                    .toLowerCase();

                let visibleCount = 0;

                products.forEach(function (product) {
                    const name =
                        product.dataset.productName || '';

                    const sku =
                        product.dataset.productSku || '';

                    const matches =
                        !search ||
                        name.includes(search) ||
                        sku.includes(search);

                    product.hidden = !matches;

                    if (matches) {
                        visibleCount++;
                    }
                });

                if (searchEmpty) {
                    searchEmpty.hidden =
                        visibleCount !== 0 || products.length === 0;
                }

                updateSelectedCount();
            };


            const updateProductScope = function () {
                const selectedScope = page.querySelector(
                    '[data-product-scope]:checked'
                )?.value || 'all';

                if (!productsWrapper) {
                    return;
                }

                productsWrapper.hidden =
                    selectedScope !== 'selected';

                if (selectedScope === 'all') {
                    checkboxes.forEach(function (checkbox) {
                        checkbox.checked = false;
                    });
                }

                updateSelectedCount();
            };


            const updateStatus = function () {
                const active = statusToggle?.checked ?? true;

                if (statusLabel) {
                    statusLabel.textContent =
                        active ? 'Active' : 'Inactive';
                }

                if (statusDescription) {
                    statusDescription.textContent =
                        active
                            ? 'Customers can use this promo code.'
                            : 'Customers cannot use this promo code.';
                }
            };


            discountType?.addEventListener(
                'change',
                updateDiscountType
            );

            scopeInputs.forEach(function (input) {
                input.addEventListener(
                    'change',
                    updateProductScope
                );
            });

            productSearch?.addEventListener(
                'input',
                filterProducts
            );


            checkboxes.forEach(function (checkbox) {
                checkbox.addEventListener(
                    'change',
                    updateSelectedCount
                );
            });


            selectAllButton?.addEventListener(
                'click',
                function () {
                    const visibleProducts = products.filter(
                        product => !product.hidden
                    );

                    const visibleCheckboxes = visibleProducts
                        .map(product =>
                            product.querySelector('[data-product-checkbox]')
                        )
                        .filter(Boolean);

                    const allSelected =
                        visibleCheckboxes.length > 0 &&
                        visibleCheckboxes.every(
                            checkbox => checkbox.checked
                        );

                    visibleCheckboxes.forEach(function (checkbox) {
                        checkbox.checked = !allSelected;
                    });

                    updateSelectedCount();
                }
            );


            statusToggle?.addEventListener(
                'change',
                updateStatus
            );


            form?.addEventListener(
                'submit',
                function () {
                    if (!submitButton) {
                        return;
                    }

                    submitButton.disabled = true;

                    submitButton.innerHTML =
                        '<i class="ri-loader-4-line ri-spin"></i>' +
                        '<span>Creating...</span>';
                }
            );


            updateDiscountType();
            updateProductScope();
            updateSelectedCount();
            updateStatus();
        });
    </script>

@endpush
