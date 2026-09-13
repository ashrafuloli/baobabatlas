@extends('frontend.layouts.frontend')

@section('contents')
    <div class="my-wishlist-page">

        <!--================================
            Wishlist Header
        =================================-->

        <section class="my-wishlist-page__section">

            <div class="container">

                <div class="my-wishlist-page__header">

                    <div class="my-wishlist-page__header-content">

                        <span class="my-wishlist-page__eyebrow">
                            My Account
                        </span>

                        <h1 class="my-wishlist-page__title">
                            My Wishlist
                        </h1>

                        <p class="my-wishlist-page__description">
                            Save your favorite products and easily
                            add them to your cart whenever you're ready.
                        </p>

                    </div>

                    <a
                        href="{{ url('/shop') }}"
                        class="my-wishlist-page__continue-btn"
                    >
                        <i class="ri-arrow-left-line"></i>
                        <span>Continue Shopping</span>
                    </a>

                </div>


                <!--================================
                    Wishlist Content
                =================================-->

                <div class="my-wishlist-page__content">

                    <div class="my-wishlist-page__topbar">

                        <div class="my-wishlist-page__count">

                            <strong class="wishlist-count">
                                {{ $items->count() }}
                            </strong>

                            <span>
                                {{ $items->count() === 1 ? 'Item' : 'Items' }}
                                in Wishlist
                            </span>

                        </div>

                        <button
                            type="button"
                            class="my-wishlist-page__clear-btn"
                            @disabled($items->isEmpty())
                        >
                            <i class="ri-delete-bin-line"></i>
                            <span>Clear Wishlist</span>
                        </button>

                    </div>


                    <!--================================
                        Wishlist Products
                    =================================-->

                    <div
                        class="product-grid related"
                        @if ($items->isEmpty()) hidden @endif
                    >

                        @foreach ($items as $item)

                            @php
                                $product = $item->product;

                                $primaryImage = $product?->images
                                    ?->firstWhere('is_primary', true);

                                $productImage = $primaryImage
                                    ?? $product?->images?->first();

                                $image = $productImage?->image
                                    ?? $product?->thumbnail
                                    ?? 'assets/img/products/placeholder.png';

                                $imageUrl = str_starts_with($image, 'http')
                                    ? $image
                                    : asset($image);

                                $productUrl = route(
                                    'shop.details',
                                    $product->slug,
                                );
                            @endphp

                            @if ($product)

                                <article
                                    class="product-card"
                                    data-wishlist-item
                                    data-product-id="{{ $product->id }}"
                                    data-toggle-url="{{ route('wishlist.toggle', ['product' => $product]) }}"
                                >

                                    <div class="product-image">

                                        <button
                                            type="button"
                                            class="wishlist is-active"
                                            aria-label="Remove {{ $product->name }} from wishlist"
                                            title="Remove from wishlist"
                                            data-wishlist-toggle
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            aria-pressed="true"
                                        >
                                            <i class="ri-heart-fill"></i>
                                        </button>

                                        <a
                                            href="{{ $productUrl }}"
                                            aria-label="{{ $product->name }}"
                                        >
                                            <img
                                                src="{{ $imageUrl }}"
                                                alt="{{ $product->name }}"
                                                loading="lazy"
                                            >
                                        </a>

                                    </div>


                                    <div class="product-content">

                                        <h4>
                                            <a href="{{ $productUrl }}">
                                                {{ $product->name }}
                                            </a>
                                        </h4>

                                        @if ($product->variants->isNotEmpty())

                                            @php
                                                $lowestPrice = $product->variants
                                                    ->where('status', true)
                                                    ->min('price');
                                            @endphp

                                            @if ($lowestPrice !== null)

                                                <strong class="product-price">
                                                    ${{ number_format((float) $lowestPrice, 2) }}
                                                </strong>

                                            @endif

                                        @else

                                            @if (isset($product->price))

                                                <strong class="product-price">
                                                    ${{ number_format((float) $product->price, 2) }}
                                                </strong>

                                            @endif

                                        @endif

                                    </div>

                                </article>

                            @endif

                        @endforeach

                    </div>


                    <!--================================
                        Empty Wishlist
                    =================================-->

                    <div
                        class="my-wishlist-page__empty"
                        @if ($items->isNotEmpty()) hidden @endif
                    >

                        <div class="my-wishlist-page__empty-icon">
                            <i class="ri-heart-3-line"></i>
                        </div>

                        <h2>
                            Your Wishlist is Empty
                        </h2>

                        <p>
                            You haven't added any products
                            to your wishlist yet.
                        </p>

                        <a
                            href="{{ url('/shop') }}"
                            class="my-wishlist-page__empty-btn"
                        >
                            Explore Products
                        </a>

                    </div>

                </div>

            </div>

        </section>

    </div>
@endsection


@push('scripts')
    <script>
        (function () {

            const initWishlist = function () {

                const wishlistPage =
                    document.querySelector('.my-wishlist-page');

                if (!wishlistPage) {
                    return;
                }


                /*
                =====================================
                    Elements
                =====================================
                */

                const productGrid =
                    wishlistPage.querySelector(
                        '.product-grid.related'
                    );

                const countElement =
                    wishlistPage.querySelector(
                        '.wishlist-count'
                    );

                const countLabel =
                    countElement?.nextElementSibling;

                const emptyState =
                    wishlistPage.querySelector(
                        '.my-wishlist-page__empty'
                    );

                const clearButton =
                    wishlistPage.querySelector(
                        '.my-wishlist-page__clear-btn'
                    );


                /*
                =====================================
                    Helpers
                =====================================
                */

                const getProductCards = function () {

                    if (!productGrid) {
                        return [];
                    }

                    return Array.from(
                        productGrid.querySelectorAll(
                            '[data-wishlist-item]'
                        )
                    );

                };


                const getCsrfToken = function () {

                    return document
                        .querySelector(
                            'meta[name="csrf-token"]'
                        )
                        ?.getAttribute('content') || '';

                };


                const updateWishlistButton = function (
                    button,
                    wishlisted
                ) {

                    if (!button) {
                        return;
                    }

                    button.classList.toggle(
                        'is-active',
                        wishlisted
                    );

                    button.setAttribute(
                        'aria-pressed',
                        wishlisted ? 'true' : 'false'
                    );

                    const productName =
                        button.dataset.productName || 'Product';

                    button.setAttribute(
                        'aria-label',
                        wishlisted
                            ? `Remove ${productName} from wishlist`
                            : `Add ${productName} to wishlist`
                    );

                    button.setAttribute(
                        'title',
                        wishlisted
                            ? 'Remove from wishlist'
                            : 'Add to wishlist'
                    );

                    const icon =
                        button.querySelector('i');

                    if (icon) {

                        icon.classList.toggle(
                            'ri-heart-fill',
                            wishlisted
                        );

                        icon.classList.toggle(
                            'ri-heart-line',
                            !wishlisted
                        );

                    }

                };


                const updateWishlistState = function () {

                    const productCards =
                        getProductCards();

                    const count =
                        productCards.length;


                    /*
                    =================================
                        Update Count
                    =================================
                    */

                    if (countElement) {

                        countElement.textContent =
                            count;

                    }


                    /*
                    =================================
                        Update Count Label
                    =================================
                    */

                    if (countLabel) {

                        countLabel.textContent =
                            count === 1
                                ? 'Item in Wishlist'
                                : 'Items in Wishlist';

                    }


                    /*
                    =================================
                        Product Grid
                    =================================
                    */

                    if (productGrid) {

                        productGrid.hidden =
                            count === 0;

                    }


                    /*
                    =================================
                        Empty State
                    =================================
                    */

                    if (emptyState) {

                        emptyState.hidden =
                            count !== 0;

                    }


                    /*
                    =================================
                        Clear Button
                    =================================
                    */

                    if (clearButton) {

                        clearButton.disabled =
                            count === 0;

                        clearButton.hidden =
                            count === 0;

                    }

                };


                const showMessage = function (
                    message,
                    type = 'error'
                ) {

                    if (
                        window.AppToast &&
                        typeof window.AppToast.fire === 'function'
                    ) {

                        window.AppToast.fire({
                            icon: type,
                            title: message,
                        });

                        return;
                    }

                    if (
                        type === 'success'
                    ) {

                        console.log(message);

                        return;
                    }

                    console.error(message);

                };


                const sendRequest = async function (
                    url,
                    options = {}
                ) {

                    if (!url) {

                        throw new Error(
                            'Wishlist URL is missing.'
                        );

                    }


                    const response =
                        await fetch(url, {
                            ...options,
                            headers: {
                                'Accept':
                                    'application/json',
                                'X-Requested-With':
                                    'XMLHttpRequest',
                                ...(options.headers || {}),
                            },
                        });


                    /*
                    =================================
                        Authentication / Session
                    =================================
                    */

                    if (
                        response.status === 401
                    ) {

                        window.location.href =
                            '{{ route('login') }}';

                        throw new Error(
                            'Please login to manage your wishlist.'
                        );

                    }


                    if (
                        response.status === 419
                    ) {

                        throw new Error(
                            'Your session has expired. Please refresh the page and try again.'
                        );

                    }


                    const contentType =
                        response.headers.get(
                            'content-type'
                        ) || '';

                    let data = null;


                    /*
                    =================================
                        Parse JSON Safely
                    =================================
                    */

                    if (
                        contentType.includes(
                            'application/json'
                        )
                    ) {

                        try {

                            data =
                                await response.json();

                        } catch (error) {

                            data = null;

                        }

                    }


                    if (!response.ok) {

                        throw new Error(
                            data?.message ||
                            'Something went wrong. Please try again.'
                        );

                    }


                    if (!data) {

                        throw new Error(
                            'Invalid response from the server.'
                        );

                    }


                    return data;

                };


                /*
                =====================================
                    Remove Product
                =====================================
                */

                const removeProduct = async function (
                    productCard,
                    button
                ) {

                    const toggleUrl =
                        productCard.dataset.toggleUrl;

                    const productId =
                        Number(
                            productCard.dataset.productId
                        );


                    if (
                        !toggleUrl ||
                        button.disabled
                    ) {

                        return;

                    }


                    button.disabled = true;

                    productCard.classList.add(
                        'is-removing'
                    );


                    try {

                        const data =
                            await sendRequest(
                                toggleUrl,
                                {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type':
                                            'application/json',
                                        'X-CSRF-TOKEN':
                                            getCsrfToken(),
                                    },
                                }
                            );


                        /*
                        =================================
                            Updated API Response
                        =================================
                        */

                        if (
                            data.success === true &&
                            data.wishlisted === false
                        ) {

                            updateWishlistButton(
                                button,
                                false
                            );


                            /*
                            Remove Card
                            */

                            productCard.remove();


                            /*
                            Update Page State
                            */

                            updateWishlistState();


                            /*
                            Notify Other Wishlist UI
                            */

                            window.dispatchEvent(
                                new CustomEvent(
                                    'wishlist:updated',
                                    {
                                        detail: {
                                            productId:
                                            productId,
                                            wishlisted:
                                                false,
                                        },
                                    }
                                )
                            );


                            showMessage(
                                data.message ||
                                'Product removed from your wishlist.',
                                'success'
                            );

                        } else {

                            productCard.classList.remove(
                                'is-removing'
                            );

                            showMessage(
                                data.message ||
                                'Unable to remove this product from your wishlist.'
                            );

                        }

                    } catch (error) {

                        productCard.classList.remove(
                            'is-removing'
                        );

                        showMessage(
                            error.message ||
                            'Unable to update your wishlist.'
                        );

                    } finally {

                        if (
                            document.body.contains(button)
                        ) {

                            button.disabled =
                                false;

                        }

                    }

                };


                /*
                =====================================
                    Wishlist Heart
                =====================================
                */

                wishlistPage.addEventListener(
                    'click',
                    function (event) {

                        const wishlistButton =
                            event.target.closest(
                                '[data-wishlist-toggle]'
                            );


                        if (
                            !wishlistButton ||
                            !wishlistPage.contains(
                                wishlistButton
                            )
                        ) {

                            return;

                        }


                        const productCard =
                            wishlistButton.closest(
                                '[data-wishlist-item]'
                            );


                        if (!productCard) {

                            return;

                        }


                        event.preventDefault();
                        event.stopPropagation();


                        removeProduct(
                            productCard,
                            wishlistButton
                        );

                    }
                );


                /*
                =====================================
                    Clear Wishlist
                =====================================
                */

                if (clearButton) {

                    clearButton.addEventListener(
                        'click',
                        async function () {

                            const productCards =
                                getProductCards();


                            if (
                                productCards.length === 0 ||
                                clearButton.disabled
                            ) {

                                return;

                            }


                            /*
                            =================================
                                Confirmation
                            =================================
                            */

                            const confirmed =
                                window.Swal
                                    ? await Swal.fire({
                                        icon: 'warning',
                                        title: 'Clear Wishlist?',
                                        text: 'All products will be removed from your wishlist.',
                                        showCancelButton: true,
                                        confirmButtonText: 'Yes, clear it',
                                        cancelButtonText: 'Cancel',
                                    })
                                    : {
                                        isConfirmed:
                                            window.confirm(
                                                'Remove all products from your wishlist?'
                                            ),
                                    };


                            if (
                                !confirmed.isConfirmed
                            ) {

                                return;

                            }


                            const originalHtml =
                                clearButton.innerHTML;


                            clearButton.disabled =
                                true;


                            clearButton.innerHTML =
                                '<i class="ri-loader-4-line ri-spin"></i>' +
                                '<span>Clearing...</span>';


                            try {

                                /*
                                =================================
                                    Send Remove Requests
                                =================================
                                */

                                const requests =
                                    productCards.map(
                                        function (
                                            productCard
                                        ) {

                                            const url =
                                                productCard
                                                    .dataset
                                                    .toggleUrl;

                                            return sendRequest(
                                                url,
                                                {
                                                    method: 'POST',
                                                    headers: {
                                                        'Content-Type':
                                                            'application/json',
                                                        'X-CSRF-TOKEN':
                                                            getCsrfToken(),
                                                    },
                                                }
                                            );

                                        }
                                    );


                                const results =
                                    await Promise.allSettled(
                                        requests
                                    );


                                let removedCount = 0;


                                /*
                                =================================
                                    Process Results
                                =================================
                                */

                                results.forEach(
                                    function (
                                        result,
                                        index
                                    ) {

                                        if (
                                            result.status !==
                                            'fulfilled'
                                        ) {

                                            return;

                                        }


                                        const data =
                                            result.value;


                                        if (
                                            data.success === true &&
                                            data.wishlisted === false
                                        ) {

                                            const productCard =
                                                productCards[index];


                                            const productId =
                                                Number(
                                                    productCard
                                                        ?.dataset
                                                        .productId
                                                );


                                            productCard?.remove();

                                            removedCount++;


                                            /*
                                            Notify Other Wishlist UI
                                            */

                                            window.dispatchEvent(
                                                new CustomEvent(
                                                    'wishlist:updated',
                                                    {
                                                        detail: {
                                                            productId:
                                                            productId,
                                                            wishlisted:
                                                                false,
                                                        },
                                                    }
                                                )
                                            );

                                        }

                                    }
                                );


                                updateWishlistState();


                                if (
                                    removedCount > 0
                                ) {

                                    showMessage(
                                        removedCount ===
                                        productCards.length
                                            ? 'Wishlist cleared successfully.'
                                            : `${removedCount} product(s) removed from your wishlist.`,
                                        'success'
                                    );

                                } else {

                                    showMessage(
                                        'Unable to clear your wishlist.'
                                    );

                                }

                            } catch (error) {

                                showMessage(
                                    error.message ||
                                    'Unable to clear your wishlist.'
                                );

                            } finally {

                                clearButton.innerHTML =
                                    originalHtml;

                                updateWishlistState();

                            }

                        }
                    );

                }


                /*
                =====================================
                    Initial State
                =====================================
                */

                getProductCards().forEach(
                    function (productCard) {

                        const button =
                            productCard.querySelector(
                                '[data-wishlist-toggle]'
                            );

                        if (!button) {
                            return;
                        }

                        updateWishlistButton(
                            button,
                            true
                        );

                    }
                );


                updateWishlistState();

            };


            /*
            =====================================
                Initialize
            =====================================
            */

            if (
                document.readyState === 'loading'
            ) {

                document.addEventListener(
                    'DOMContentLoaded',
                    initWishlist
                );

            } else {

                initWishlist();

            }

        })();
    </script>
@endpush
