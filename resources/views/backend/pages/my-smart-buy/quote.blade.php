@extends('backend.layouts.backend')

@section('title', 'Smart Buy Quote')

@section('content')

    <div class="my-smart-buy-quote">

        {{-- ==========================================================
        | Page Header
        =========================================================== --}}
        <div class="page-header">

            <div class="page-header-left">

                <a
                    href="{{ route('my-smart-buy.details', $smartBuy->id) }}"
                    class="back-btn"
                >
                    <i class="ri-arrow-left-line"></i>
                </a>


                <div class="page-header-content">

                    <span class="page-label">
                        Smart Buy Request
                    </span>

                    <h1>
                        Quote {{ $quote->quote_number ?? $smartBuy->request_number }}
                    </h1>

                </div>

            </div>


            <div class="quote-status">

                <i class="ri-file-list-3-line"></i>

                <span>
                    {{ ucfirst(str_replace('_', ' ', $quote->status)) }}
                </span>

            </div>

        </div>


        {{-- ==========================================================
        | Main Layout
        =========================================================== --}}
        <div class="quote-layout">


            {{-- ======================================================
            | Main Content
            ======================================================= --}}
            <div class="quote-main-content">


                {{-- Quote Summary --}}
                <div class="quote-card">

                    <div class="card-header">

                        <div class="card-title">

                            <div class="card-icon">
                                <i class="ri-file-text-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Quote Summary
                                </h2>

                                <p>
                                    Review the quote details before making your decision.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="quote-summary-grid">


                        <div class="summary-item">

                            <span>
                                Quote Number
                            </span>

                            <strong>
                                {{ $quote->quote_number ?? 'N/A' }}
                            </strong>

                        </div>


                        <div class="summary-item">

                            <span>
                                Quote Date
                            </span>

                            <strong>
                                {{ $quote->created_at?->format('M d, Y') ?? 'N/A' }}
                            </strong>

                        </div>


                        <div class="summary-item">

                            <span>
                                Valid Until
                            </span>

                            <strong>

                                @if ($quote->expires_at)

                                    {{ $quote->expires_at->format('M d, Y') }}

                                @else

                                    Not specified

                                @endif

                            </strong>

                        </div>


                        <div class="summary-item">

                            <span>
                                Status
                            </span>

                            <strong class="status-text status-{{ $quote->status }}">

                                {{ ucfirst(str_replace('_', ' ', $quote->status)) }}

                            </strong>

                        </div>


                    </div>

                </div>


                {{-- ==================================================
                | Requested Products
                =================================================== --}}
                <div class="quote-card">

                    <div class="card-header">

                        <div class="card-title">

                            <div class="card-icon">
                                <i class="ri-shopping-bag-3-line"></i>
                            </div>

                            <div>

                                <h2>
                                    Requested Products
                                </h2>

                                <p>
                                    Products included in this Smart Buy request.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="products-list">

                        @forelse ($quote->quoteItems as $quoteItem)

                            @php

                                $item =
                                    $quoteItem->smartBuyItem;

                                $productName =
                                    $quoteItem->product_name
                                    ?? $item?->product_name
                                    ?? 'Product';

                                $quantity =
                                    $quoteItem->quantity
                                    ?? $item?->quantity
                                    ?? 1;

                                $itemTotal =
                                    $quoteItem->total_price
                                    ?? (
                                        (float) ($quoteItem->unit_price ?? 0)
                                        *
                                        (int) $quantity
                                    );

                            @endphp


                            <div class="product-item">


                                {{-- Product Image --}}
                                <div class="product-image">

                                    @if ( $item && !empty($item->product_image))

                                        <img
                                            src="{{ asset($item->product_image) }}"
                                            alt="{{ $productName }}"
                                        >

                                    @else

                                        <div class="product-placeholder">

                                            <i class="ri-image-line"></i>

                                        </div>

                                    @endif

                                </div>


                                {{-- Product Information --}}
                                <div class="product-info">

                                    <h3>
                                        {{ $productName }}
                                    </h3>


                                    @if (
                                        $item
                                        &&
                                        !empty($item->product_url)
                                    )

                                        <a
                                            href="{{ $item->product_url }}"
                                            target="_blank"
                                            rel="noopener noreferrer"
                                            class="product-link"
                                        >

                                            <i class="ri-external-link-line"></i>

                                            <span>
                                                View Product
                                            </span>

                                        </a>

                                    @endif


                                    <div class="product-meta">


                                        @if (
                                            $item
                                            &&
                                            !empty($item->color)
                                        )

                                            <div class="meta-item">

                                                <i class="ri-palette-line"></i>

                                                <span>

                                                    Color:

                                                    <strong>
                                                        {{ $item->color }}
                                                    </strong>

                                                </span>

                                            </div>

                                        @endif


                                        @if (
                                            $item
                                            &&
                                            !empty($item->size)
                                        )

                                            <div class="meta-item">

                                                <i class="ri-ruler-line"></i>

                                                <span>

                                                    Size:

                                                    <strong>
                                                        {{ $item->size }}
                                                    </strong>

                                                </span>

                                            </div>

                                        @endif


                                        <div class="meta-item">

                                            <i class="ri-shopping-cart-line"></i>

                                            <span>

                                                Quantity:

                                                <strong>
                                                    {{ $quantity }}
                                                </strong>

                                            </span>

                                        </div>


                                    </div>


                                    @if (
                                        $quoteItem->notes
                                        ||
                                        ($item && $item->notes)
                                    )

                                        <div class="product-notes">

                                            <i class="ri-information-line"></i>

                                            <span>

                                                {{
                                                    $quoteItem->notes
                                                    ?? $item?->notes
                                                }}

                                            </span>

                                        </div>

                                    @endif

                                </div>


                                {{-- Product Price --}}
                                <div class="product-price">

                                    <span>
                                        Unit Price
                                    </span>

                                    <strong>
                                        ${{ number_format((float) ($quoteItem->unit_price ?? 0), 2) }}
                                    </strong>


                                    <div class="product-price-total">

                                        <span>
                                            Item Total
                                        </span>

                                        <strong>
                                            ${{ number_format((float) $itemTotal, 2) }}
                                        </strong>

                                    </div>

                                </div>


                            </div>

                        @empty

                            <div class="empty-state">

                                <i class="ri-shopping-bag-line"></i>

                                <p>
                                    No products found.
                                </p>

                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- ==================================================
                | Quote Notes
                =================================================== --}}
                @if ($quote->notes)

                    <div class="quote-card quote-notes-card">

                        <div class="card-header">

                            <div class="card-title">

                                <div class="card-icon">

                                    <i class="ri-sticky-note-line"></i>

                                </div>


                                <div>

                                    <h2>
                                        Additional Notes
                                    </h2>

                                    <p>
                                        Information provided with your quote.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="quote-notes">

                            {{ $quote->notes }}

                        </div>

                    </div>

                @endif


            </div>


            {{-- ======================================================
            | Sidebar
            ======================================================= --}}
            <aside class="quote-sidebar">


                {{-- Quote Details --}}
                <div class="quote-card price-card">

                    <div class="card-header">

                        <div class="card-title">

                            <div class="card-icon">

                                <i class="ri-calculator-line"></i>

                            </div>


                            <div>

                                <h2>
                                    Quote Details
                                </h2>

                                <p>
                                    Price breakdown.
                                </p>

                            </div>

                        </div>

                    </div>


                    <div class="price-breakdown">


                        <div class="price-row">

                            <span>
                                Product Cost
                            </span>

                            <strong>

                                ${{ number_format((float) ($quote->product_total ?? 0), 2) }}

                            </strong>

                        </div>


                        @if ((float) ($quote->service_fee ?? 0) > 0)

                            <div class="price-row">

                                <span>
                                    Service Fee
                                </span>

                                <strong>

                                    ${{ number_format((float) $quote->service_fee, 2) }}

                                </strong>

                            </div>

                        @endif


                        @if ((float) ($quote->shipping_fee ?? 0) > 0)

                            <div class="price-row">

                                <span>
                                    Shipping Fee
                                </span>

                                <strong>

                                    ${{ number_format((float) $quote->shipping_fee, 2) }}

                                </strong>

                            </div>

                        @endif


                        <div class="price-divider"></div>


                        <div class="price-total">

                            <span>
                                Total Amount
                            </span>

                            <strong>

                                ${{ number_format((float) ($quote->total_amount ?? 0), 2) }}

                            </strong>

                        </div>


                    </div>

                </div>


                {{-- ==================================================
                | Quote Actions
                =================================================== --}}
                @if ($smartBuy->status === 'quote_sent')

                    <div class="quote-card quote-action-card">

                        <div class="card-header">

                            <div class="card-title">

                                <div class="card-icon">

                                    <i class="ri-checkbox-circle-line"></i>

                                </div>


                                <div>

                                    <h2>
                                        Your Decision
                                    </h2>

                                    <p>
                                        Accept or reject this quote.
                                    </p>

                                </div>

                            </div>

                        </div>


                        <div class="quote-actions">

                            @if(
                                $quote->status !== 'expired'
                            )
                                {{-- Accept Quote --}}
                                <form
                                    action="{{ route('my-smart-buy.quote.accept', $smartBuy->id) }}"
                                    method="POST"
                                    data-accept-form
                                >

                                    @csrf


                                    <button
                                        type="submit"
                                        class="quote-btn quote-btn-success"
                                    >

                                        <i class="ri-checkbox-circle-line"></i>

                                        <span>
                                        Accept Quote
                                    </span>

                                    </button>

                                </form>

                                {{-- Reject Quote --}}
                                <button
                                    type="button"
                                    class="quote-btn quote-btn-danger"
                                    data-show-reject
                                >

                                    <i class="ri-close-circle-line"></i>

                                    <span>
                                    Reject Quote
                                </span>

                                </button>

                            @else
                                <form
                                    action="{{ route( 'my-smart-buy.quote.request-extension', $smartBuy->id) }}"
                                    method="POST"
                                >
                                    @csrf

                                    <button type="submit" class="quote-btn quote-btn-primary">

                                        <i class="ri-time-line"></i>

                                        <span>
                                            Request Quote Extension
                                        </span>

                                    </button>

                                </form>
                            @endif

                        </div>


                        {{-- Reject Form --}}
                        <div
                            class="reject-quote-box"
                            data-reject-box
                            @if ($errors->has('reason'))
                                style="display: block;"
                            @else
                                style="display: none;"
                            @endif
                        >

                            <form
                                action="{{ route('my-smart-buy.quote.reject', $smartBuy->id) }}"
                                method="POST"
                                data-reject-form
                            >

                                @csrf


                                <div class="form-group">

                                    <label for="reason">

                                        <span>
                                            Reason for rejection
                                        </span>

                                        <small>
                                            Optional
                                        </small>

                                    </label>


                                    <textarea
                                        id="reason"
                                        name="reason"
                                        rows="4"
                                        placeholder="Tell us why you are rejecting this quote..."
                                    >{{ old('reason', $quote->notes ?? '') }}</textarea>


                                    @error('reason')

                                    <small class="text-danger">

                                        {{ $message }}

                                    </small>

                                    @enderror

                                </div>


                                <div class="reject-form-actions">


                                    <button
                                        type="button"
                                        class="quote-btn quote-btn-light"
                                        data-cancel-reject
                                    >

                                        <i class="ri-arrow-go-back-line"></i>

                                        <span>
                                            Cancel
                                        </span>

                                    </button>


                                    <button
                                        type="submit"
                                        class="quote-btn quote-btn-danger"
                                    >

                                        <i class="ri-close-circle-line"></i>

                                        <span>
                                            Confirm Rejection
                                        </span>

                                    </button>


                                </div>

                            </form>

                        </div>

                    </div>

                @elseif ($smartBuy->status === 'quote_accepted' || $smartBuy->status === 'payment_pending')

                    <div class="quote-card quote-decision-card accepted">

                        <i class="ri-checkbox-circle-fill"></i>

                        <div>

                            <h3>
                                Quote Accepted
                            </h3>

                            <p>
                                You have accepted this quote.
                            </p>

                        </div>

                    </div>

                    <div class="quote-card quote-action-card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="card-icon">
                                    <i class="fa-solid fa-credit-card"></i>
                                </div>

                                <div>

                                    <h2>
                                        Payment Required
                                    </h2>

                                    <p>
                                        Your quote has been accepted. Please proceed with payment to continue your Smart
                                        Buy request.
                                    </p>

                                </div>
                            </div>

                        </div>

                        <div class="quote-actions">
                            <a href="{{ route('my-smart-buy.payment', $smartBuy->id) }}"
                               class="quote-btn quote-btn-success">
                                <i class="fa-solid fa-credit-card"></i>
                                <span>Make Payment</span>
                            </a>
                        </div>
                    </div>

                @elseif ($smartBuy->status === 'quote_rejected')

                    <div class="quote-card quote-decision-card rejected">

                        <i class="ri-close-circle-fill"></i>

                        <div>

                            <h3>
                                Quote Rejected
                            </h3>

                            <p>
                                You have rejected this quote.
                            </p>

                        </div>

                    </div>

                @elseif ($smartBuy->status === 'quote_extension_requested')

                    <div class="quote-card quote-decision-card rejected">

                        <i class="ri-time-line"></i>

                        <div>

                            <h3>
                                Quote Extension Requested
                            </h3>

                            <p>
                                Your quote extension request is pending.
                            </p>

                        </div>

                    </div>
                @endif


                {{-- Help --}}
                <div class="help-card">

                    <div class="help-icon">

                        <i class="ri-question-line"></i>

                    </div>


                    <h3>
                        Need Help?
                    </h3>

                    <p>
                        If you have questions about this quote, please contact our support team.
                    </p>

                </div>


            </aside>

        </div>

    </div>

@endsection


@push('scripts')

    <script>

        (function () {

            const initMySmartBuyQuote = function () {

                const quotePage =
                    document.querySelector(
                        '.my-smart-buy-quote'
                    );


                if (!quotePage) {
                    return;
                }


                const showRejectButton =
                    quotePage.querySelector(
                        '[data-show-reject]'
                    );


                const rejectBox =
                    quotePage.querySelector(
                        '[data-reject-box]'
                    );


                const cancelRejectButton =
                    quotePage.querySelector(
                        '[data-cancel-reject]'
                    );


                const acceptForm =
                    quotePage.querySelector(
                        '[data-accept-form]'
                    );


                const rejectForm =
                    quotePage.querySelector(
                        '[data-reject-form]'
                    );


                /*
                |--------------------------------------------------------------------------
                | Show Reject Form
                |--------------------------------------------------------------------------
                */

                if (
                    showRejectButton
                    &&
                    rejectBox
                ) {

                    showRejectButton.addEventListener(
                        'click',
                        function () {

                            rejectBox.style.display =
                                'block';


                            showRejectButton.style.display =
                                'none';


                            const textarea =
                                rejectBox.querySelector(
                                    'textarea'
                                );


                            textarea?.focus();

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Cancel Reject
                |--------------------------------------------------------------------------
                */

                if (
                    cancelRejectButton
                    &&
                    rejectBox
                    &&
                    showRejectButton
                ) {

                    cancelRejectButton.addEventListener(
                        'click',
                        function () {

                            rejectBox.style.display =
                                'none';


                            showRejectButton.style.display =
                                'inline-flex';

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Accept Confirmation
                |--------------------------------------------------------------------------
                */

                if (acceptForm) {

                    acceptForm.addEventListener(
                        'submit',
                        function (event) {

                            const confirmed =
                                window.confirm(
                                    'Are you sure you want to accept this quote?'
                                );


                            if (!confirmed) {

                                event.preventDefault();

                            }

                        }
                    );

                }


                /*
                |--------------------------------------------------------------------------
                | Reject Confirmation
                |--------------------------------------------------------------------------
                */

                if (rejectForm) {

                    rejectForm.addEventListener(
                        'submit',
                        function (event) {

                            const confirmed =
                                window.confirm(
                                    'Are you sure you want to reject this quote?'
                                );


                            if (!confirmed) {

                                event.preventDefault();

                            }

                        }
                    );

                }

            };


            if (
                document.readyState === 'loading'
            ) {

                document.addEventListener(
                    'DOMContentLoaded',
                    initMySmartBuyQuote
                );

            } else {

                initMySmartBuyQuote();

            }

        })();

    </script>

@endpush
