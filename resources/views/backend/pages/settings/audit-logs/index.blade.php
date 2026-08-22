@extends('backend.layouts.backend')

@section('title', 'Audit Logs')

@section('content')

    <div class="audit-logs-page">

        {{-- =========================================================
            Page Header
        ========================================================== --}}
        <div class="audit-header">

            <div class="audit-header-content">

                <div class="audit-header-text">

                    <h1>
                        Audit Logs
                    </h1>

                    <p>
                        Track important activities and changes made across the system.
                    </p>

                </div>

            </div>

        </div>


        {{-- =========================================================
            Summary
        ========================================================== --}}
        <div class="audit-summary">

            <div class="summary-card">

                <div class="summary-icon">
                    <i class="ri-file-list-3-line"></i>
                </div>

                <div class="summary-content">

                <span>
                    Total Activities
                </span>

                    <strong>
                        1,248
                    </strong>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon success">
                    <i class="ri-login-circle-line"></i>
                </div>

                <div class="summary-content">

                <span>
                    Login Activities
                </span>

                    <strong>
                        386
                    </strong>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon warning">
                    <i class="ri-edit-line"></i>
                </div>

                <div class="summary-content">

                <span>
                    Changes
                </span>

                    <strong>
                        742
                    </strong>

                </div>

            </div>


            <div class="summary-card">

                <div class="summary-icon danger">
                    <i class="ri-error-warning-line"></i>
                </div>

                <div class="summary-content">

                <span>
                    Failed Activities
                </span>

                    <strong>
                        120
                    </strong>

                </div>

            </div>

        </div>


        {{-- =========================================================
            Filters
        ========================================================== --}}
        <div class="audit-card">

            <div class="audit-card-header">

                <div>

                    <h2>
                        Activity Logs
                    </h2>

                    <p>
                        Search and filter system activities.
                    </p>

                </div>

            </div>


            <div class="audit-filter-body">

                <div class="audit-filter-grid">

                    {{-- Search --}}
                    <div class="filter-field search-field">

                        <label for="audit_search">
                            Search
                        </label>

                        <div class="search-input">

                            <i class="ri-search-line"></i>

                            <input
                                type="text"
                                id="audit_search"
                                placeholder="Search by user, action or description..."
                            >

                        </div>

                    </div>


                    {{-- User --}}
                    <div class="filter-field">

                        <label for="audit_user">
                            User
                        </label>

                        <select
                            id="audit_user"
                            class="filter-control"
                        >

                            <option value="">
                                All Users
                            </option>

                            <option value="admin">
                                Admin User
                            </option>

                            <option value="client">
                                Demo Client
                            </option>

                        </select>

                    </div>


                    {{-- Module --}}
                    <div class="filter-field">

                        <label for="audit_module">
                            Module
                        </label>

                        <select
                            id="audit_module"
                            class="filter-control"
                        >

                            <option value="">
                                All Modules
                            </option>

                            <option value="ecommerce">
                                Ecommerce
                            </option>

                            <option value="smart-buy">
                                Smart Buy
                            </option>

                            <option value="users">
                                Users
                            </option>

                            <option value="settings">
                                Settings
                            </option>

                            <option value="payments">
                                Payments
                            </option>

                        </select>

                    </div>


                    {{-- Action --}}
                    <div class="filter-field">

                        <label for="audit_action">
                            Action
                        </label>

                        <select
                            id="audit_action"
                            class="filter-control"
                        >

                            <option value="">
                                All Actions
                            </option>

                            <option value="created">
                                Created
                            </option>

                            <option value="updated">
                                Updated
                            </option>

                            <option value="deleted">
                                Deleted
                            </option>

                            <option value="login">
                                Login
                            </option>

                            <option value="logout">
                                Logout
                            </option>

                            <option value="payment">
                                Payment
                            </option>

                        </select>

                    </div>


                    {{-- Date --}}
                    <div class="filter-field">

                        <label for="audit_date">
                            Date
                        </label>

                        <select
                            id="audit_date"
                            class="filter-control"
                        >

                            <option value="">
                                All Time
                            </option>

                            <option value="today">
                                Today
                            </option>

                            <option value="7">
                                Last 7 Days
                            </option>

                            <option value="30">
                                Last 30 Days
                            </option>

                            <option value="90">
                                Last 90 Days
                            </option>

                        </select>

                    </div>


                    {{-- Filter Button --}}
                    <div class="filter-action">

                        <button
                            type="button"
                            class="filter-button"
                        >

                            <i class="ri-filter-3-line"></i>

                            Filter

                        </button>

                    </div>

                </div>

            </div>

        </div>


        {{-- =========================================================
            Logs Table
        ========================================================== --}}
        <div class="audit-card logs-card">

            <div class="logs-card-header">

                <div>

                    <h2>
                        Recent Activities
                    </h2>

                    <p>
                        Showing the latest system activities.
                    </p>

                </div>


                <button
                    type="button"
                    class="export-button"
                >

                    <i class="ri-download-2-line"></i>

                    Export

                </button>

            </div>


            <div class="table-wrapper">

                <table class="audit-table">

                    <thead>

                    <tr>

                        <th>
                            User
                        </th>

                        <th>
                            Action
                        </th>

                        <th>
                            Module
                        </th>

                        <th>
                            Description
                        </th>

                        <th>
                            IP Address
                        </th>

                        <th>
                            Date
                        </th>

                        <th>
                            Action
                        </th>

                    </tr>

                    </thead>


                    <tbody>

                    {{-- Row 1 --}}
                    <tr>

                        <td>

                            <div class="user-info">

                                <div class="user-avatar">
                                    AU
                                </div>

                                <div>

                                    <strong>
                                        Admin User
                                    </strong>

                                    <span>
                                        admin@gmail.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="action-badge created">
                                Created
                            </span>

                        </td>


                        <td>

                            <span class="module-badge">
                                Ecommerce
                            </span>

                        </td>


                        <td>

                            <span class="description">
                                Created a new product.
                            </span>

                        </td>


                        <td>
                            192.168.1.10
                        </td>


                        <td>

                            <span class="date">
                                Aug 17, 2026
                            </span>

                            <small>
                                10:42 AM
                            </small>

                        </td>


                        <td>

                            <a
                                href="{{ route('settings-audit-log-details', 123) }}"
                                class="view-log"
                                title="View Details"
                            >
                                <i class="ri-eye-line"></i>
                            </a>

                        </td>

                    </tr>


                    {{-- Row 2 --}}
                    <tr>

                        <td>

                            <div class="user-info">

                                <div class="user-avatar client">
                                    DC
                                </div>

                                <div>

                                    <strong>
                                        Demo Client
                                    </strong>

                                    <span>
                                        client@gmail.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="action-badge updated">
                                Updated
                            </span>

                        </td>


                        <td>

                            <span class="module-badge">
                                Smart Buy
                            </span>

                        </td>


                        <td>

                            <span class="description">
                                Updated Smart Buy request.
                            </span>

                        </td>


                        <td>
                            192.168.1.24
                        </td>


                        <td>

                            <span class="date">
                                Aug 17, 2026
                            </span>

                            <small>
                                09:35 AM
                            </small>

                        </td>


                        <td>

                            <a
                                href="{{ route('settings-audit-log-details', 123) }}"
                                class="view-log"
                                title="View Details"
                            >
                                <i class="ri-eye-line"></i>
                            </a>

                        </td>

                    </tr>


                    {{-- Row 3 --}}
                    <tr>

                        <td>

                            <div class="user-info">

                                <div class="user-avatar">
                                    AU
                                </div>

                                <div>

                                    <strong>
                                        Admin User
                                    </strong>

                                    <span>
                                        admin@gmail.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="action-badge login">
                                Login
                            </span>

                        </td>


                        <td>

                            <span class="module-badge">
                                Users
                            </span>

                        </td>


                        <td>

                            <span class="description">
                                Admin logged into the dashboard.
                            </span>

                        </td>


                        <td>
                            192.168.1.10
                        </td>


                        <td>

                            <span class="date">
                                Aug 17, 2026
                            </span>

                            <small>
                                08:54 AM
                            </small>

                        </td>


                        <td>

                            <a
                                href="{{ route('settings-audit-log-details', 123) }}"
                                class="view-log"
                                title="View Details"
                            >
                                <i class="ri-eye-line"></i>
                            </a>

                        </td>

                    </tr>


                    {{-- Row 4 --}}
                    <tr>

                        <td>

                            <div class="user-info">

                                <div class="user-avatar">
                                    AU
                                </div>

                                <div>

                                    <strong>
                                        Admin User
                                    </strong>

                                    <span>
                                        admin@gmail.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="action-badge payment">
                                Payment
                            </span>

                        </td>


                        <td>

                            <span class="module-badge">
                                Payments
                            </span>

                        </td>


                        <td>

                            <span class="description">
                                Payment marked as successful.
                            </span>

                        </td>

                        <td>
                            192.168.1.10
                        </td>


                        <td>

                            <span class="date">
                                Aug 16, 2026
                            </span>

                            <small>
                                05:22 PM
                            </small>

                        </td>


                        <td>

                            <a
                                href="{{ route('settings-audit-log-details', 123) }}"
                                class="view-log"
                                title="View Details"
                            >
                                <i class="ri-eye-line"></i>
                            </a>

                        </td>

                    </tr>


                    {{-- Row 5 --}}
                    <tr>

                        <td>

                            <div class="user-info">

                                <div class="user-avatar">
                                    AU
                                </div>

                                <div>

                                    <strong>
                                        Admin User
                                    </strong>

                                    <span>
                                        admin@gmail.com
                                    </span>

                                </div>

                            </div>

                        </td>


                        <td>

                            <span class="action-badge updated">
                                Updated
                            </span>

                        </td>


                        <td>

                            <span class="module-badge">
                                Settings
                            </span>

                        </td>


                        <td>

                            <span class="description">
                                Updated ecommerce settings.
                            </span>

                        </td>

                        <td>
                            192.168.1.10
                        </td>


                        <td>

                            <span class="date">
                                Aug 16, 2026
                            </span>

                            <small>
                                03:18 PM
                            </small>

                        </td>


                        <td>

                            <a
                                href="{{ route('settings-audit-log-details', 123) }}"
                                class="view-log"
                                title="View Details"
                            >
                                <i class="ri-eye-line"></i>
                            </a>

                        </td>

                    </tr>

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            <div class="logs-pagination">

            <span class="pagination-info">
                Showing 1–5 of 1,248 activities
            </span>

                <div class="pagination-buttons">

                    <button
                        type="button"
                        disabled
                    >
                        <i class="ri-arrow-left-s-line"></i>
                    </button>

                    <button
                        type="button"
                        class="active"
                    >
                        1
                    </button>

                    <button type="button">
                        2
                    </button>

                    <button type="button">
                        3
                    </button>

                    <span>
                    ...
                </span>

                    <button type="button">
                        250
                    </button>

                    <button type="button">

                        <i class="ri-arrow-right-s-line"></i>

                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
