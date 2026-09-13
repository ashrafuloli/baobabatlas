@extends('backend.layouts.backend')

@section('title', 'Promo Codes')

@section('content')

    <div class="promo-code-list-page">

        <div class="promo-code-list-page__header">
            <div class="promo-code-list-page__heading">
                <span class="promo-code-list-page__eyebrow">
                    E-commerce
                </span>

                <h1 class="promo-code-list-page__title">
                    Promo Codes
                </h1>

                <p class="promo-code-list-page__description">
                    Create and manage discount codes for your products.
                </p>
            </div>

            <a
                href="{{ route('admin-coupons.create') }}"
                class="promo-code-list-page__create-btn"
            >
                <i class="ri-add-line"></i>
                <span>Create Promo Code</span>
            </a>
        </div>


        <div class="promo-code-list-page__card">

            <div class="promo-code-list-page__toolbar">

                <div class="promo-code-list-page__search">
                    <i class="ri-search-line"></i>

                    <input
                        type="search"
                        class="promo-code-list-page__search-input"
                        placeholder="Search promo code..."
                        autocomplete="off"
                        data-coupon-search
                    >
                </div>

                <div class="promo-code-list-page__filters">

                    <select
                        class="promo-code-list-page__filter"
                        data-coupon-type
                    >
                        <option value="">All discount types</option>
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed</option>
                    </select>

                    <select
                        class="promo-code-list-page__filter"
                        data-coupon-status
                    >
                        <option value="">All status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>

                </div>

            </div>


            <div class="promo-code-list-page__table-wrap">

                <table class="promo-code-list-page__table">

                    <thead>
                    <tr>
                        <th>Promo Code</th>
                        <th>Discount</th>
                        <th>Minimum Order</th>
                        <th>Products</th>
                        <th>Validity</th>
                        <th>Status</th>
                        <th class="promo-code-list-page__action-column">
                            Action
                        </th>
                    </tr>
                    </thead>

                    <tbody data-coupon-list>

                    @forelse($coupons as $coupon)

                        <tr
                            data-coupon-row
                            data-code="{{ strtolower($coupon->code) }}"
                            data-type="{{ $coupon->discount_type }}"
                            data-status="{{ $coupon->is_active ? 'active' : 'inactive' }}"
                        >

                            <td>
                                <div class="promo-code-list-page__code">
                                    <span class="promo-code-list-page__code-icon">
                                        <i class="ri-price-tag-3-line"></i>
                                    </span>

                                    <div>
                                        <strong>
                                            {{ $coupon->code }}
                                        </strong>

                                        <small>
                                            Created
                                            {{ $coupon->created_at?->format('M d, Y') }}
                                        </small>
                                    </div>
                                </div>
                            </td>


                            <td>
                                <span class="promo-code-list-page__discount">
                                    @if($coupon->discount_type === 'percentage')
                                        {{ number_format((float) $coupon->discount_value, 2) }}%
                                    @else
                                        ${{ number_format((float) $coupon->discount_value, 2) }}
                                    @endif
                                </span>
                            </td>


                            <td>
                                <span class="promo-code-list-page__amount">
                                    @if((float) $coupon->minimum_amount > 0)
                                        ${{ number_format((float) $coupon->minimum_amount, 2) }}
                                    @else
                                        No minimum
                                    @endif
                                </span>
                            </td>


                            <td>
                                @if($coupon->products_count > 0)
                                    <span class="promo-code-list-page__scope promo-code-list-page__scope--products">
                                        <i class="ri-shopping-bag-3-line"></i>
                                        {{ $coupon->products_count }}
                                        {{ $coupon->products_count === 1 ? 'Product' : 'Products' }}
                                    </span>
                                @else
                                    <span class="promo-code-list-page__scope promo-code-list-page__scope--all">
                                        <i class="ri-global-line"></i>
                                        All Products
                                    </span>
                                @endif
                            </td>


                            <td>
                                <div class="promo-code-list-page__validity">

                                    @if($coupon->starts_at || $coupon->expires_at)

                                        <span>
                                            {{ $coupon->starts_at?->format('M d, Y') ?? 'Immediately' }}
                                        </span>

                                        <i class="ri-arrow-right-line"></i>

                                        <span>
                                            {{ $coupon->expires_at?->format('M d, Y') ?? 'No expiry' }}
                                        </span>

                                    @else

                                        <span class="promo-code-list-page__no-expiry">
                                            No expiry

                                        </span>

                                    @endif

                                </div>
                            </td>


                            <td>
                                @if($coupon->is_active)
                                    <span class="promo-code-list-page__status promo-code-list-page__status--active">
                                        <span></span>
                                        Active
                                    </span>
                                @else
                                    <span class="promo-code-list-page__status promo-code-list-page__status--inactive">
                                        <span></span>
                                        Inactive
                                    </span>
                                @endif
                            </td>


                            <td>
                                <div class="promo-code-list-page__actions">

                                        <a
                                            href="{{ route('admin-coupons.edit', $coupon) }}"
                                            class="promo-code-list-page__action promo-code-list-page__action--edit"
                                            aria-label="Edit {{ $coupon->code }}"
                                            title="Edit"
                                        >
                                            <i class="ri-edit-line"></i>
                                        </a>

                                    <form
                                        action="{{ route('admin-coupons.destroy', $coupon) }}"
                                        method="POST"
                                        class="promo-code-list-page__delete-form"
                                        data-delete-form
                                        data-coupon-code="{{ $coupon->code }}"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="promo-code-list-page__action promo-code-list-page__action--delete"
                                            aria-label="Delete {{ $coupon->code }}"
                                            title="Delete"
                                        >
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr data-empty-row>
                            <td colspan="7">
                                <div class="promo-code-list-page__empty">

                                    <div class="promo-code-list-page__empty-icon">
                                        <i class="ri-coupon-3-line"></i>
                                    </div>

                                    <h3>
                                        No promo codes found
                                    </h3>

                                    <p>
                                        Create your first promo code to start offering discounts.
                                    </p>

                                    <a
                                        href="{{ route('admin-coupons.create') }}"
                                        class="promo-code-list-page__empty-btn"
                                    >
                                        <i class="ri-add-line"></i>
                                        Create Promo Code
                                    </a>

                                </div>
                            </td>
                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>


            @if($coupons->hasPages())

                <div class="promo-code-list-page__pagination">
                    {{ $coupons->links() }}
                </div>

            @endif

        </div>

    </div>

@endsection


@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const page = document.querySelector('.promo-code-list-page');

            if (!page) {
                return;
            }

            const searchInput = page.querySelector('[data-coupon-search]');
            const typeFilter = page.querySelector('[data-coupon-type]');
            const statusFilter = page.querySelector('[data-coupon-status]');
            const rows = Array.from(page.querySelectorAll('[data-coupon-row]'));

            const showMessage = function (message, type = 'error') {
                if (
                    window.AppToast &&
                    typeof window.AppToast.fire === 'function'
                ) {
                    window.AppToast.fire({
                        icon: type,
                        title: message
                    });

                    return;
                }

                console[type === 'error' ? 'error' : 'log'](message);
            };

            const filterCoupons = function () {
                const search = (searchInput?.value || '')
                    .trim()
                    .toLowerCase();

                const type = typeFilter?.value || '';
                const status = statusFilter?.value || '';

                rows.forEach(function (row) {
                    const code = row.dataset.code || '';
                    const rowType = row.dataset.type || '';
                    const rowStatus = row.dataset.status || '';

                    const matchesSearch =
                        !search || code.includes(search);

                    const matchesType =
                        !type || rowType === type;

                    const matchesStatus =
                        !status || rowStatus === status;

                    row.hidden = !(
                        matchesSearch &&
                        matchesType &&
                        matchesStatus
                    );
                });
            };

            searchInput?.addEventListener('input', filterCoupons);
            typeFilter?.addEventListener('change', filterCoupons);
            statusFilter?.addEventListener('change', filterCoupons);


            page.addEventListener('submit', async function (event) {
                const form = event.target.closest('[data-delete-form]');

                if (!form) {
                    return;
                }

                event.preventDefault();

                const couponCode =
                    form.dataset.couponCode || 'this promo code';

                let confirmed = false;

                if (
                    window.Swal &&
                    typeof window.Swal.fire === 'function'
                ) {
                    const result = await window.Swal.fire({
                        icon: 'warning',
                        title: 'Delete promo code?',
                        text: `"${couponCode}" will be permanently deleted.`,
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete',
                        cancelButtonText: 'Cancel',
                        reverseButtons: true
                    });

                    confirmed = result.isConfirmed;
                } else {
                    confirmed = window.confirm(
                        `Delete "${couponCode}"?`
                    );
                }

                if (!confirmed) {
                    return;
                }

                const button = form.querySelector(
                    'button[type="submit"]'
                );

                if (button) {
                    button.disabled = true;

                    button.innerHTML =
                        '<i class="ri-loader-4-line ri-spin"></i>';
                }

                form.submit();
            });
        });
    </script>

@endpush
