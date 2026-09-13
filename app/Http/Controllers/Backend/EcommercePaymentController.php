<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\RefundRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class EcommercePaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Payment Overview
    |--------------------------------------------------------------------------
    */

    public function index(Request $request): View
    {
        $payments = $this->paymentQuery($request)
            ->with([
                'user',
                'refunds',
            ])
            ->paginate(15)
            ->withQueryString();

        return view(
            'backend.pages.ecommerce.payments.index',
            [
                'payments' => $payments,
                'stats' => $this->paymentStats(),
            ],
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Payment Details
    |--------------------------------------------------------------------------
    */

    public function show(Order $order): View
    {
        $order->load([
            'user',
            'items.product',
            'items.variant',
            'shipment',
            'refundRequests.requester',
            'refundRequests.approver',
            'refundRequests.refund',
            'refunds.refundRequest',
        ]);

        return view(
            'backend.pages.ecommerce.payments.show',
            [
                'order' => $order,
            ],
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Refund Requests
    |--------------------------------------------------------------------------
    */

    public function refundRequests(Request $request): View
    {
        $refundRequests = $this->refundRequestQuery($request)
            ->with([
                'order',
                'requester',
                'approver',
                'refund',
            ])
            ->paginate(15)
            ->withQueryString();

        return view(
            'backend.pages.ecommerce.payments.refund-requests',
            [
                'refundRequests' => $refundRequests,
                'stats' => $this->refundRequestStats(),
            ],
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Refund Request Details
    |--------------------------------------------------------------------------
    */

    public function showRefundRequest(
        RefundRequest $refundRequest,
    ): View {
        $refundRequest->load([
            'order.user',
            'order.items.product',
            'order.items.variant',
            'requester',
            'approver',
            'refund',
        ]);

        return view(
            'backend.pages.ecommerce.payments.refund-request-show',
            [
                'refundRequest' => $refundRequest,
            ],
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Approve Refund Request
    |--------------------------------------------------------------------------
    */

    public function approveRefund(
        Request $request,
        RefundRequest $refundRequest,
    ): RedirectResponse {
        if (!$refundRequest->isPending()) {
            return back()->with(
                'error',
                'This refund request can no longer be approved.',
            );
        }

        $adminId = $request->user()?->id;

        $refundRequest->update([
            'status' => RefundRequest::STATUS_APPROVED,
            'approved_by' => $adminId,
            'approved_at' => now(),
            'admin_note' => $request->input('admin_note'),
        ]);

        $refundRequest->order->update([
            'refund_status' => Order::REFUND_STATUS_APPROVED,
        ]);

        return redirect()
            ->route(
                'admin-ecommerce-payment-refund-request-show',
                ['refundRequest' => $refundRequest],
            )
            ->with(
                'success',
                'Refund request approved successfully.',
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Reject Refund Request
    |--------------------------------------------------------------------------
    */

    public function rejectRefund(
        Request $request,
        RefundRequest $refundRequest,
    ): RedirectResponse {
        if (!$refundRequest->isPending()) {
            return back()->with(
                'error',
                'This refund request can no longer be rejected.',
            );
        }

        $adminId = $request->user()?->id;

        $refundRequest->update([
            'status' => RefundRequest::STATUS_REJECTED,
            'approved_by' => $adminId,
            'approved_at' => now(),
            'admin_note' => $request->input('admin_note'),
        ]);

        $refundRequest->order->update([
            'refund_status' => Order::REFUND_STATUS_REJECTED,
        ]);

        return redirect()
            ->route(
                'admin-ecommerce-payment-refund-request-show',
                ['refundRequest' => $refundRequest],
            )
            ->with(
                'success',
                'Refund request rejected successfully.',
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Payment Query
    |--------------------------------------------------------------------------
    */

    private function paymentQuery(Request $request): Builder
    {
        $query = Order::query()
            ->with([
                'user',
            ])
            ->orderByDesc('id');

        $search = trim(
            (string) $request->input('search'),
        );

        if ($search !== '') {
            $query->where(function (Builder $query) use (
                $search,
            ): void {
                $query
                    ->where(
                        'order_number',
                        'like',
                        "%{$search}%",
                    )
                    ->orWhere(
                        'email',
                        'like',
                        "%{$search}%",
                    )
                    ->orWhere(
                        'first_name',
                        'like',
                        "%{$search}%",
                    )
                    ->orWhere(
                        'last_name',
                        'like',
                        "%{$search}%",
                    )
                    ->orWhere(
                        'stripe_payment_intent_id',
                        'like',
                        "%{$search}%",
                    )
                    ->orWhere(
                        'stripe_checkout_session_id',
                        'like',
                        "%{$search}%",
                    );
            });
        }

        $paymentStatus = $request->input('payment_status');

        if (
            $paymentStatus !== null
            && $paymentStatus !== ''
        ) {
            $query->where(
                'payment_status',
                $paymentStatus,
            );
        }

        $gateway = trim(
            (string) $request->input('payment_gateway'),
        );

        if ($gateway !== '') {
            $query->where(
                'payment_gateway',
                $gateway,
            );
        }

        $refundStatus = $request->input('refund_status');

        if (
            $refundStatus !== null
            && $refundStatus !== ''
        ) {
            $query->where(
                'refund_status',
                $refundStatus,
            );
        }

        $dateFrom = $request->input('date_from');

        if (
            is_string($dateFrom)
            && $dateFrom !== ''
        ) {
            $query->whereDate(
                'created_at',
                '>=',
                $dateFrom,
            );
        }

        $dateTo = $request->input('date_to');

        if (
            is_string($dateTo)
            && $dateTo !== ''
        ) {
            $query->whereDate(
                'created_at',
                '<=',
                $dateTo,
            );
        }

        return $query;
    }


    /*
    |--------------------------------------------------------------------------
    | Payment Statistics
    |--------------------------------------------------------------------------
    */

    /**
     * @return array<string, int|float>
     */
    private function paymentStats(): array
    {
        return [
            'totalPayments' => Order::query()->count(),

            'paidPayments' => Order::query()
                ->where(
                    'payment_status',
                    Order::PAYMENT_STATUS_PAID,
                )
                ->count(),

            'pendingPayments' => Order::query()
                ->where(
                    'payment_status',
                    Order::PAYMENT_STATUS_PENDING,
                )
                ->count(),

            'failedPayments' => Order::query()
                ->where(
                    'payment_status',
                    Order::PAYMENT_STATUS_FAILED,
                )
                ->count(),

            'refundedPayments' => Order::query()
                ->where(
                    'refund_status',
                    Order::REFUND_STATUS_REFUNDED,
                )
                ->count(),

            'paidRevenue' => (float) Order::query()
                ->where(
                    'payment_status',
                    Order::PAYMENT_STATUS_PAID,
                )
                ->sum('total'),
        ];
    }


    /*
    |--------------------------------------------------------------------------
    | Refund Request Query
    |--------------------------------------------------------------------------
    */

    private function refundRequestQuery(
        Request $request,
    ): Builder {
        $query = RefundRequest::query()
            ->with([
                'order',
                'requester',
            ])
            ->latest();

        $search = trim(
            (string) $request->input('search'),
        );

        if ($search !== '') {
            $query->where(function (Builder $query) use (
                $search,
            ): void {
                $query
                    ->whereHas(
                        'order',
                        function (
                            Builder $orderQuery
                        ) use ($search): void {
                            $orderQuery
                                ->where(
                                    'order_number',
                                    'like',
                                    "%{$search}%",
                                )
                                ->orWhere(
                                    'email',
                                    'like',
                                    "%{$search}%",
                                )
                                ->orWhere(
                                    'first_name',
                                    'like',
                                    "%{$search}%",
                                )
                                ->orWhere(
                                    'last_name',
                                    'like',
                                    "%{$search}%",
                                );
                        },
                    )
                    ->orWhere(
                        'reason',
                        'like',
                        "%{$search}%",
                    );
            });
        }

        $status = $request->input('status');

        if (
            $status !== null
            && $status !== ''
        ) {
            $query->where(
                'status',
                $status,
            );
        }

        return $query;
    }


    /*
    |--------------------------------------------------------------------------
    | Refund Request Statistics
    |--------------------------------------------------------------------------
    */

    /**
     * @return array<string, int|float>
     */
    private function refundRequestStats(): array
    {
        $query = RefundRequest::query();

        return [
            'total' => (clone $query)->count(),

            'pending' => (clone $query)
                ->where(
                    'status',
                    RefundRequest::STATUS_PENDING,
                )
                ->count(),

            'approved' => (clone $query)
                ->where(
                    'status',
                    RefundRequest::STATUS_APPROVED,
                )
                ->count(),

            'rejected' => (clone $query)
                ->where(
                    'status',
                    RefundRequest::STATUS_REJECTED,
                )
                ->count(),

            'requestedAmount' => (float) (clone $query)
                ->whereIn(
                    'status',
                    [
                        RefundRequest::STATUS_PENDING,
                        RefundRequest::STATUS_APPROVED,
                    ],
                )
                ->sum('amount'),

            'deductionAmount' => (float) (clone $query)
                ->whereIn(
                    'status',
                    [
                        RefundRequest::STATUS_PENDING,
                        RefundRequest::STATUS_APPROVED,
                    ],
                )
                ->sum('deduction_amount'),
        ];
    }
}
