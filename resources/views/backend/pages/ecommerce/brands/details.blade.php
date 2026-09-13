@extends('backend.layouts.backend')

@section('title', 'Brand Details')

@section('content')
    <div class="brand-details-page">
        <div class="brand-details-page__header">
            <div class="brand-details-page__header-content">
                <div class="brand-details-page__eyebrow">
                    <i class="ri-price-tag-3-line"></i>
                    Brand Management
                </div>

                <div class="brand-details-page__title-row">
                    <div>
                        <h1>Brand Details</h1>
                        <p>View brand information, status, SEO details and quick actions.</p>
                    </div>

                    <div class="brand-details-page__actions">
                        <a
                            href="{{ route('admin-brands') }}"
                            class="brand-details-page__action brand-details-page__action--light"
                        >
                            <i class="ri-arrow-left-line"></i>
                            <span>Back</span>
                        </a>

                        <a
                            href="{{ route('admin-brands.edit', $brand) }}"
                            class="brand-details-page__action brand-details-page__action--primary"
                        >
                            <i class="ri-edit-line"></i>
                            <span>Edit Brand</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="brand-details-page__content">
            <div class="brand-details-page__main">
                {{-- Brand Overview --}}
                <div class="brand-details-page__card brand-details-page__overview">
                    <div class="brand-details-page__card-header">
                        <div>
                            <h2>Brand Overview</h2>
                            <p>Basic information about this brand.</p>
                        </div>

                        @if ($brand->status)
                            <span class="brand-details-page__badge brand-details-page__badge--success">
                                <i class="ri-checkbox-circle-line"></i>
                                Active
                            </span>
                        @else
                            <span class="brand-details-page__badge brand-details-page__badge--danger">
                                <i class="ri-close-circle-line"></i>
                                Inactive
                            </span>
                        @endif
                    </div>

                    <div class="brand-details-page__overview-body">
                        <div class="brand-details-page__logo">
                            @if ($brand->logo)
                                <img
                                    src="{{ asset($brand->logo) }}"
                                    alt="{{ $brand->name }}"
                                    data-brand-logo
                                >
                            @else
                                <div class="brand-details-page__logo-placeholder">
                                    <i class="ri-price-tag-3-line"></i>
                                </div>
                            @endif
                        </div>

                        <div class="brand-details-page__brand-info">
                            <h3>{{ $brand->name }}</h3>

                            <div class="brand-details-page__slug">
                                <span>Slug</span>
                                <code>{{ $brand->slug }}</code>
                            </div>

                            @if ($brand->description)
                                <div class="brand-details-page__description">
                                    <span class="brand-details-page__label">Description</span>
                                    <p>{{ $brand->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Description --}}
                @if ($brand->description)
                    <div class="brand-details-page__card">
                        <div class="brand-details-page__card-header">
                            <div>
                                <h2>Description</h2>
                                <p>Full brand description.</p>
                            </div>
                        </div>

                        <div class="brand-details-page__text">
                            {!! nl2br(e($brand->description)) !!}
                        </div>
                    </div>
                @endif

                {{-- SEO --}}
                <div class="brand-details-page__card">
                    <div class="brand-details-page__card-header">
                        <div>
                            <h2>SEO Information</h2>
                            <p>Search engine optimization information for this brand.</p>
                        </div>

                        <i class="ri-seo-line brand-details-page__card-icon"></i>
                    </div>

                    <div class="brand-details-page__seo">
                        <div class="brand-details-page__seo-item">
                            <span class="brand-details-page__label">Meta Title</span>

                            <div class="brand-details-page__seo-value">
                                {{ $brand->meta_title ?: 'Not provided' }}
                            </div>
                        </div>

                        <div class="brand-details-page__seo-item">
                            <span class="brand-details-page__label">Meta Description</span>

                            <div class="brand-details-page__seo-value">
                                {{ $brand->meta_description ?: 'Not provided' }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Record Information --}}
                <div class="brand-details-page__card">
                    <div class="brand-details-page__card-header">
                        <div>
                            <h2>Record Information</h2>
                            <p>System information for this brand.</p>
                        </div>
                    </div>

                    <div class="brand-details-page__record-grid">
                        <div class="brand-details-page__record-item">
                            <span>Brand ID</span>
                            <strong>#{{ $brand->id }}</strong>
                        </div>

                        <div class="brand-details-page__record-item">
                            <span>Sort Order</span>
                            <strong>{{ $brand->sort_order }}</strong>
                        </div>

                        <div class="brand-details-page__record-item">
                            <span>Created</span>
                            <strong>{{ $brand->created_at?->format('d M Y, h:i A') }}</strong>
                        </div>

                        <div class="brand-details-page__record-item">
                            <span>Last Updated</span>
                            <strong>{{ $brand->updated_at?->format('d M Y, h:i A') }}</strong>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="brand-details-page__sidebar">
                {{-- Status --}}
                <div class="brand-details-page__card">
                    <div class="brand-details-page__card-header">
                        <div>
                            <h2>Brand Status</h2>
                            <p>Current brand settings.</p>
                        </div>
                    </div>

                    <div class="brand-details-page__status-list">
                        <div class="brand-details-page__status-item">
                            <div class="brand-details-page__status-icon">
                                <i class="ri-toggle-line"></i>
                            </div>

                            <div>
                                <span>Status</span>

                                <strong class="{{ $brand->status ? 'is-success' : 'is-danger' }}">
                                    {{ $brand->status ? 'Active' : 'Inactive' }}
                                </strong>
                            </div>
                        </div>

                        <div class="brand-details-page__status-item">
                            <div class="brand-details-page__status-icon">
                                <i class="ri-star-line"></i>
                            </div>

                            <div>
                                <span>Featured</span>

                                <strong class="{{ $brand->featured ? 'is-success' : 'is-muted' }}">
                                    {{ $brand->featured ? 'Yes' : 'No' }}
                                </strong>
                            </div>
                        </div>

                        <div class="brand-details-page__status-item">
                            <div class="brand-details-page__status-icon">
                                <i class="ri-sort-asc"></i>
                            </div>

                            <div>
                                <span>Sort Order</span>
                                <strong>{{ $brand->sort_order }}</strong>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="brand-details-page__card">
                    <div class="brand-details-page__card-header">
                        <div>
                            <h2>Quick Actions</h2>
                            <p>Manage this brand quickly.</p>
                        </div>
                    </div>

                    <div class="brand-details-page__quick-actions">
                        <a
                            href="{{ route('admin-brands.edit', $brand) }}"
                            class="brand-details-page__quick-action"
                        >
                            <span class="brand-details-page__quick-action-icon">
                                <i class="ri-edit-line"></i>
                            </span>

                            <span class="brand-details-page__quick-action-content">
                                <strong>Edit Brand</strong>
                                <small>Update brand information</small>
                            </span>

                            <i class="ri-arrow-right-s-line"></i>
                        </a>

                        <a
                            href="{{ route('admin-brands') }}"
                            class="brand-details-page__quick-action"
                        >
                            <span class="brand-details-page__quick-action-icon">
                                <i class="ri-list-check-2"></i>
                            </span>

                            <span class="brand-details-page__quick-action-content">
                                <strong>All Brands</strong>
                                <small>View all brands</small>
                            </span>

                            <i class="ri-arrow-right-s-line"></i>
                        </a>
                    </div>
                </div>

                {{-- Delete --}}
                <div class="brand-details-page__card brand-details-page__danger-card">
                    <div class="brand-details-page__danger-content">
                        <div class="brand-details-page__danger-icon">
                            <i class="ri-delete-bin-line"></i>
                        </div>

                        <div>
                            <h3>Delete Brand</h3>
                            <p>
                                This action cannot be undone. Make sure this brand is no longer needed.
                            </p>
                        </div>
                    </div>

                    <form
                        action="{{ route('admin-brands.destroy', $brand) }}"
                        method="POST"
                        data-delete-brand-form
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="brand-details-page__delete-button">
                            <i class="ri-delete-bin-line"></i>
                            Delete Brand
                        </button>
                    </form>
                </div>
            </aside>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const page = document.querySelector('.brand-details-page');

            if (!page) {
                return;
            }

            const logo = page.querySelector('[data-brand-logo]');

            if (logo) {
                logo.addEventListener('error', () => {
                    const placeholder = document.createElement('div');

                    placeholder.className = 'brand-details-page__logo-placeholder';
                    placeholder.innerHTML = '<i class="ri-price-tag-3-line"></i>';

                    logo.replaceWith(placeholder);
                });
            }

            const deleteForm = page.querySelector('[data-delete-brand-form]');

            if (deleteForm) {
                deleteForm.addEventListener('submit', (event) => {
                    const confirmed = window.confirm(
                        'Are you sure you want to delete this brand? This action cannot be undone.'
                    );

                    if (!confirmed) {
                        event.preventDefault();
                    }
                });
            }

            const quickActions = page.querySelectorAll(
                '.brand-details-page__quick-action'
            );

            quickActions.forEach((action) => {
                action.addEventListener('mouseenter', () => {
                    action.classList.add('is-hovered');
                });

                action.addEventListener('mouseleave', () => {
                    action.classList.remove('is-hovered');
                });
            });
        });
    </script>
@endsection
