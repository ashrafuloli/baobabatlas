@extends('backend.layouts.backend')

@section('title', 'Smart Buy Settings')

@section('content')

    <div class="settings-smart-buy-page">

        {{-- =========================================================
            Page Header
        ========================================================== --}}
        <div class="settings-header">

            <div class="settings-header-text">

                <h1>
                    Smart Buy Settings
                </h1>

                <p>
                    Manage Smart Buy requests, quotes, payments and shipment preferences.
                </p>

            </div>

        </div>


        <form
            action="#"
            method="POST"
            class="settings-form"
        >

            @csrf


            {{-- =====================================================
                Smart Buy Status
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-global-line"></i>
                        </div>

                        <div>

                            <h2>
                                Smart Buy Status
                            </h2>

                            <p>
                                Control the availability of the Smart Buy service.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="preference-list">

                        {{-- Smart Buy Enabled --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Enable Smart Buy
                                </h3>

                                <p>
                                    Allow customers to create new Smart Buy requests.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="smart_buy_enabled"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- New Requests --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Accept New Requests
                                </h3>

                                <p>
                                    Allow customers to submit new requests while Smart Buy is active.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="accept_new_requests"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Request Settings
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-file-list-3-line"></i>
                        </div>

                        <div>

                            <h2>
                                Request Settings
                            </h2>

                            <p>
                                Configure how Smart Buy requests are handled.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="settings-grid">

                        {{-- Request Number Prefix --}}
                        <div class="form-group">

                            <label for="request_prefix">
                                Request Number Prefix
                            </label>

                            <input
                                type="text"
                                id="request_prefix"
                                name="request_prefix"
                                class="form-control"
                                value="SB-"
                                maxlength="10"
                                placeholder="SB-"
                            >

                        </div>


                        {{-- Request Expiration --}}
                        <div class="form-group">

                            <label for="request_expiration">
                                Request Expiration
                            </label>

                            <select
                                id="request_expiration"
                                name="request_expiration"
                                class="form-control"
                            >

                                <option value="7">
                                    7 Days
                                </option>

                                <option value="14" selected>
                                    14 Days
                                </option>

                                <option value="30">
                                    30 Days
                                </option>

                                <option value="60">
                                    60 Days
                                </option>

                            </select>

                        </div>


                        {{-- Minimum Request Value --}}
                        <div class="form-group">

                            <label for="minimum_request_value">
                                Minimum Request Value
                            </label>

                            <input
                                type="number"
                                id="minimum_request_value"
                                name="minimum_request_value"
                                class="form-control"
                                value="0"
                                min="0"
                                step="0.01"
                            >

                        </div>


                        {{-- Maximum Request Value --}}
                        <div class="form-group">

                            <label for="maximum_request_value">
                                Maximum Request Value
                            </label>

                            <input
                                type="number"
                                id="maximum_request_value"
                                name="maximum_request_value"
                                class="form-control"
                                value="0"
                                min="0"
                                step="0.01"
                            >

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Quote Settings
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-price-tag-3-line"></i>
                        </div>

                        <div>

                            <h2>
                                Quote Settings
                            </h2>

                            <p>
                                Configure how customer quotes are managed.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="settings-grid">

                        {{-- Quote Validity --}}
                        <div class="form-group">

                            <label for="quote_validity">
                                Quote Validity
                            </label>

                            <select
                                id="quote_validity"
                                name="quote_validity"
                                class="form-control"
                            >

                                <option value="3">
                                    3 Days
                                </option>

                                <option value="7" selected>
                                    7 Days
                                </option>

                                <option value="14">
                                    14 Days
                                </option>

                                <option value="30">
                                    30 Days
                                </option>

                            </select>

                        </div>


                        {{-- Quote Currency --}}
                        <div class="form-group">

                            <label for="quote_currency">
                                Quote Currency
                            </label>

                            <select
                                id="quote_currency"
                                name="quote_currency"
                                class="form-control"
                            >

                                <option value="USD" selected>
                                    USD — US Dollar
                                </option>

                                <option value="EUR">
                                    EUR — Euro
                                </option>

                                <option value="GBP">
                                    GBP — British Pound
                                </option>

                                <option value="GNF">
                                    GNF — Guinean Franc
                                </option>

                            </select>

                        </div>


                        {{-- Quote Approval --}}
                        <div class="form-group full-width">

                            <div class="inline-setting">

                                <div>

                                    <h3>
                                        Customer Quote Approval
                                    </h3>

                                    <p>
                                        Require customers to accept a quote before proceeding to payment.
                                    </p>

                                </div>

                                <label class="switch">

                                    <input
                                        type="checkbox"
                                        name="quote_approval_required"
                                        value="1"
                                        checked
                                    >

                                    <span class="slider"></span>

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Payment Settings
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-bank-card-line"></i>
                        </div>

                        <div>

                            <h2>
                                Payment Settings
                            </h2>

                            <p>
                                Configure payment behaviour after quote acceptance.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="preference-list">

                        {{-- Payment Required --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Payment Required
                                </h3>

                                <p>
                                    Require customers to complete payment after accepting a quote.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="payment_required"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Full Payment --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Full Payment
                                </h3>

                                <p>
                                    Require the full quoted amount before the request can proceed.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="full_payment_required"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Payment Deadline --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Payment Deadline
                                </h3>

                                <p>
                                    Automatically expire the request when payment is not completed within the allowed period.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="payment_deadline"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Shipment Settings
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-truck-line"></i>
                        </div>

                        <div>

                            <h2>
                                Shipment Settings
                            </h2>

                            <p>
                                Configure shipment and tracking behaviour.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="settings-grid">

                        {{-- Shipment Status --}}
                        <div class="form-group">

                            <label for="shipment_status">
                                Shipment Tracking
                            </label>

                            <select
                                id="shipment_status"
                                name="shipment_status"
                                class="form-control"
                            >

                                <option value="enabled" selected>
                                    Enabled
                                </option>

                                <option value="disabled">
                                    Disabled
                                </option>

                            </select>

                        </div>


                        {{-- Default Carrier --}}
                        <div class="form-group">

                            <label for="default_carrier">
                                Default Carrier
                            </label>

                            <select
                                id="default_carrier"
                                name="default_carrier"
                                class="form-control"
                            >

                                <option value="manual" selected>
                                    Manual
                                </option>

                                <option value="dhl">
                                    DHL
                                </option>

                                <option value="fedex">
                                    FedEx
                                </option>

                                <option value="ups">
                                    UPS
                                </option>

                            </select>

                        </div>


                        {{-- Tracking --}}
                        <div class="form-group full-width">

                            <div class="inline-setting">

                                <div>

                                    <h3>
                                        Customer Tracking
                                    </h3>

                                    <p>
                                        Allow customers to view shipment tracking information from their Smart Buy request.
                                    </p>

                                </div>

                                <label class="switch">

                                    <input
                                        type="checkbox"
                                        name="customer_tracking"
                                        value="1"
                                        checked
                                    >

                                    <span class="slider"></span>

                                </label>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Notification Settings
            ====================================================== --}}
            <div class="settings-card">

                <div class="settings-card-header">

                    <div class="settings-card-heading">

                        <div class="settings-card-icon">
                            <i class="ri-notification-3-line"></i>
                        </div>

                        <div>

                            <h2>
                                Notifications
                            </h2>

                            <p>
                                Configure Smart Buy customer notifications.
                            </p>

                        </div>

                    </div>

                </div>


                <div class="settings-card-body">

                    <div class="preference-list">

                        {{-- Request Created --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Request Created
                                </h3>

                                <p>
                                    Notify customers when their Smart Buy request has been successfully submitted.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="notify_request_created"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Quote Ready --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Quote Ready
                                </h3>

                                <p>
                                    Notify customers when a quote is available for review.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="notify_quote_ready"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Payment --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Payment Confirmation
                                </h3>

                                <p>
                                    Notify customers after their Smart Buy payment is completed.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="notify_payment"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>


                        {{-- Shipment --}}
                        <div class="preference-item">

                            <div class="preference-content">

                                <h3>
                                    Shipment Updates
                                </h3>

                                <p>
                                    Notify customers when their Smart Buy shipment status changes.
                                </p>

                            </div>

                            <label class="switch">

                                <input
                                    type="checkbox"
                                    name="notify_shipment"
                                    value="1"
                                    checked
                                >

                                <span class="slider"></span>

                            </label>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Actions
            ====================================================== --}}
            <div class="settings-actions">

                <button
                    type="reset"
                    class="cancel-button"
                >
                    Cancel
                </button>

                <button
                    type="submit"
                    class="save-button"
                >

                    <i class="ri-save-line"></i>

                    Save Changes

                </button>

            </div>

        </form>

    </div>

@endsection
