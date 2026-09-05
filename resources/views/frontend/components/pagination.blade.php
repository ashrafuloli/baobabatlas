@if ($paginator->hasPages())
    <nav
        class="common-pagination"
        aria-label="Pagination"
    >
        <div class="common-pagination__info">
            Showing
            <strong>{{ $paginator->firstItem() }}</strong>
            to
            <strong>{{ $paginator->lastItem() }}</strong>
            of
            <strong>{{ $paginator->total() }}</strong>
            results
        </div>

        <div class="common-pagination__links">
            {{-- Previous --}}
            @if ($paginator->onFirstPage())
                <span
                    class="common-pagination__link common-pagination__link--disabled"
                    aria-disabled="true"
                >
                    <i class="ri-arrow-left-s-line"></i>
                </span>
            @else
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    class="common-pagination__link"
                    rel="prev"
                    aria-label="Previous"
                >
                    <i class="ri-arrow-left-s-line"></i>
                </a>
            @endif

            {{-- Pages --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="common-pagination__dots">
                        {{ $element }}
                    </span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span
                                class="common-pagination__link common-pagination__link--active"
                                aria-current="page"
                            >
                                {{ $page }}
                            </span>
                        @else
                            <a
                                href="{{ $url }}"
                                class="common-pagination__link"
                                aria-label="Go to page {{ $page }}"
                            >
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next --}}
            @if ($paginator->hasMorePages())
                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    class="common-pagination__link"
                    rel="next"
                    aria-label="Next"
                >
                    <i class="ri-arrow-right-s-line"></i>
                </a>
            @else
                <span
                    class="common-pagination__link common-pagination__link--disabled"
                    aria-disabled="true"
                >
                    <i class="ri-arrow-right-s-line"></i>
                </span>
            @endif
        </div>
    </nav>
@endif
