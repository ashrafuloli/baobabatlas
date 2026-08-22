@extends('backend.layouts.backend')

@section('title', 'Audit Log Details')

@section('content')

    <div class="audit-details-page">

        {{-- =========================================================
            Page Header
        ========================================================== --}}
        <div class="details-header">

            <div class="details-header-left">

                <a
                    href="{{ url()->previous() }}"
                    class="back-button"
                >
                    <i class="ri-arrow-left-line"></i>
                    Back to Audit Logs
                </a>

                <div class="details-title">

                    <div class="details-title-icon">
                        <i class="ri-file-search-line"></i>
                    </div>

                    <div>

                        <h1>
                            Audit Log Details
                        </h1>

                        <p>
                            Review the complete information about this activity.
                        </p>

                    </div>

                </div>

            </div>


            <div class="details-header-action">

            <span class="action-badge updated">
                Updated
            </span>

            </div>

        </div>


        {{-- =========================================================
            Main Content
        ========================================================== --}}
        <div class="details-layout">

            {{-- =====================================================
                Activity Overview
            ====================================================== --}}
            <div class="details-main">

                <div class="details-card">

                    <div class="details-card-header">

                        <div>

                            <h2>
                                Activity Overview
                            </h2>

                            <p>
                                Basic information about this activity.
                            </p>

                        </div>

                    </div>


                    <div class="details-card-body">

                        <div class="info-grid">

                            <div class="info-item">

                            <span class="info-label">
                                Action
                            </span>

                                <div class="info-value">
                                <span class="action-badge updated">
                                    Updated
                                </span>
                                </div>

                            </div>


                            <div class="info-item">

                            <span class="info-label">
                                Module
                            </span>

                                <div class="info-value">

                                <span class="module-badge">
                                    Smart Buy
                                </span>

                                </div>

                            </div>


                            <div class="info-item">

                            <span class="info-label">
                                Activity
                            </span>

                                <strong class="info-value">
                                    Smart Buy Request Updated
                                </strong>

                            </div>


                            <div class="info-item">

                            <span class="info-label">
                                Log ID
                            </span>

                                <strong class="info-value">
                                    #AUD-001248
                                </strong>

                            </div>


                            <div class="info-item">

                            <span class="info-label">
                                Date & Time
                            </span>

                                <strong class="info-value">
                                    Aug 17, 2026 · 09:35 AM
                                </strong>

                            </div>


                            <div class="info-item">

                            <span class="info-label">
                                IP Address
                            </span>

                                <strong class="info-value">
                                    192.168.1.24
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    Description
                ================================================== --}}
                <div class="details-card">

                    <div class="details-card-header">

                        <div>

                            <h2>
                                Description
                            </h2>

                            <p>
                                Details of what happened during this activity.
                            </p>

                        </div>

                    </div>


                    <div class="details-card-body">

                        <div class="description-box">

                            <div class="description-icon">
                                <i class="ri-information-line"></i>
                            </div>

                            <div>

                                <h3>
                                    Smart Buy request was updated
                                </h3>

                                <p>
                                    The Smart Buy request information was updated by the customer.
                                    The activity was successfully recorded in the system audit log.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    Changes
                ================================================== --}}
                <div class="details-card">

                    <div class="details-card-header">

                        <div>

                            <h2>
                                Changes
                            </h2>

                            <p>
                                Values changed during this activity.
                            </p>

                        </div>

                    </div>


                    <div class="details-card-body no-padding">

                        <div class="changes-table-wrapper">

                            <table class="changes-table">

                                <thead>

                                <tr>

                                    <th>
                                        Field
                                    </th>

                                    <th>
                                        Previous Value
                                    </th>

                                    <th>
                                        New Value
                                    </th>

                                </tr>

                                </thead>

                                <tbody>

                                <tr>

                                    <td>
                                        Request Status
                                    </td>

                                    <td>
                                        <span class="old-value">
                                            Pending
                                        </span>
                                    </td>

                                    <td>
                                        <span class="new-value">
                                            Processing
                                        </span>
                                    </td>

                                </tr>


                                <tr>

                                    <td>
                                        Delivery Address
                                    </td>

                                    <td>
                                        Conakry, Guinea
                                    </td>

                                    <td>
                                        Kindia, Guinea
                                    </td>

                                </tr>


                                <tr>

                                    <td>
                                        Updated At
                                    </td>

                                    <td>
                                        Aug 17, 2026 · 09:20 AM
                                    </td>

                                    <td>
                                        Aug 17, 2026 · 09:35 AM
                                    </td>

                                </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                    Technical Information
                ================================================== --}}
                <div class="details-card">

                    <div class="details-card-header">

                        <div>

                            <h2>
                                Technical Information
                            </h2>

                            <p>
                                Request and system information related to this activity.
                            </p>

                        </div>

                    </div>


                    <div class="details-card-body">

                        <div class="technical-grid">

                            <div class="technical-item">

                            <span>
                                Request Method
                            </span>

                                <strong>
                                    POST
                                </strong>

                            </div>


                            <div class="technical-item">

                            <span>
                                IP Address
                            </span>

                                <strong>
                                    192.168.1.24
                                </strong>

                            </div>


                            <div class="technical-item">

                            <span>
                                User Agent
                            </span>

                                <strong>
                                    Chrome / macOS
                                </strong>

                            </div>


                            <div class="technical-item">

                            <span>
                                Session ID
                            </span>

                                <strong>
                                    #SES-839204
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =====================================================
                Sidebar
            ====================================================== --}}
            <aside class="details-sidebar">

                {{-- User --}}
                <div class="details-card">

                    <div class="details-card-header">

                        <div>

                            <h2>
                                Performed By
                            </h2>

                        </div>

                    </div>


                    <div class="details-card-body">

                        <div class="performed-user">

                            <div class="user-avatar">
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


                        <div class="sidebar-info">

                            <div>

                            <span>
                                Role
                            </span>

                                <strong>
                                    Client
                                </strong>

                            </div>


                            <div>

                            <span>
                                User ID
                            </span>

                                <strong>
                                    #USR-00024
                                </strong>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Related Resource --}}
                <div class="details-card">

                    <div class="details-card-header">

                        <div>

                            <h2>
                                Related Resource
                            </h2>

                        </div>

                    </div>


                    <div class="details-card-body">

                        <div class="resource-box">

                            <div class="resource-icon">
                                <i class="ri-shopping-bag-3-line"></i>
                            </div>

                            <div>

                            <span>
                                Smart Buy Request
                            </span>

                                <strong>
                                    #SB-001024
                                </strong>

                            </div>

                        </div>


                        <a
                            href="#"
                            class="resource-link"
                        >

                            View Smart Buy Request

                            <i class="ri-arrow-right-line"></i>

                        </a>

                    </div>

                </div>


                {{-- Status --}}
                <div class="details-card">

                    <div class="details-card-header">

                        <div>

                            <h2>
                                Log Status
                            </h2>

                        </div>

                    </div>


                    <div class="details-card-body">

                        <div class="status-box">

                            <span class="status-dot"></span>

                            <div>

                                <strong>
                                    Recorded
                                </strong>

                                <span>
                                This activity has been successfully recorded.
                            </span>

                            </div>

                        </div>

                    </div>

                </div>

            </aside>

        </div>

    </div>

@endsection
