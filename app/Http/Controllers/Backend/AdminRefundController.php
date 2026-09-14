<?php

declare(strict_types=1);

namespace App\Http\Controllers\Backend;

use App\Actions\Refund\ApproveRefundRequest;
use App\Actions\Refund\RefundOrder;
use App\Actions\Refund\RejectRefundRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\RefundRequestActionRequest;
use App\Http\Requests\Backend\UpdateRefundDeductionRequest;
use App\Models\Refund;
use App\Models\RefundRequest;
use DomainException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

final class AdminRefundController extends Controller
{
    /**
     * Display all refund requests.
     */
    public function index(
        Request $request,
    ): View {
        $query = RefundRequest::query()
            ->with([
                'order.user',
                'requester',
                'approver',
                'refund',
            ]);

        if ($request->filled('search')) {
            $search = trim(
                (string) $request->input('search'),
            );

            $query->where(
                function (Builder $builder) use (
                    $search,
                ): void {
                    $builder
                        ->whereHas(
                            'order',
                            function (
                                Builder $orderQuery,
                            ) use ($search): void {
                                $orderQuery->where(
                                    function (
                                        Builder $query,
                                    ) use ($search): void {
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
                                            );
                                    },
                                );
                            },
                        )
                        ->orWhereHas(
                            'requester',
                            function (
                                Builder $userQuery,
                            ) use ($search): void {
                                $userQuery->where(
                                    'name',
                                    'like',
                                    "%{$search}%",
                                );
                            },
                        );
                },
            );
        }

        if ($request->filled('status')) {
            $query->where(
                'status',
                (string) $request->input('status'),
            );
        }

        $refundRequests = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $statuses = [
            RefundRequest::STATUS_PENDING,
            RefundRequest::STATUS_APPROVED,
            RefundRequest::STATUS_REJECTED,
        ];

        $stats = [
            'total' => RefundRequest::query()->count(),

            'pending' => RefundRequest::query()
                ->where(
                    'status',
                    RefundRequest::STATUS_PENDING,
                )
                ->count(),

            'approved' => RefundRequest::query()
                ->where(
                    'status',
                    RefundRequest::STATUS_APPROVED,
                )
                ->count(),

            'rejected' => RefundRequest::query()
                ->where(
                    'status',
                    RefundRequest::STATUS_REJECTED,
                )
                ->count(),

            'refunded' => RefundRequest::query()
                ->whereHas(
                    'refund',
                    function (Builder $builder): void {
                        $builder->where(
                            'status',
                            Refund::STATUS_SUCCEEDED,
                        );
                    },
                )
                ->count(),
        ];

        return view(
            'backend.pages.ecommerce.orders.refunds',
            compact(
                'refundRequests',
                'statuses',
                'stats',
            ),
        );
    }

    /**
     * Display a single refund request.
     */
    public function show(
        RefundRequest $refundRequest,
    ): View {
        $refundRequest->load([
            'order.user',
            'order.items.product',
            'order.items.variant.values.attribute',
            'requester',
            'approver',
            'refund',
        ]);

        return view(
            'backend.pages.ecommerce.orders.refund-details',
            compact('refundRequest'),
        );
    }

    /**
     * Update the optional refund deduction.
     */
    public function updateDeduction(
        UpdateRefundDeductionRequest $request,
        RefundRequest $refundRequest,
    ): RedirectResponse {
        try {
            DB::transaction(
                function () use (
                    $request,
                    $refundRequest,
                ): void {
                    $refundRequest = RefundRequest::query()
                        ->whereKey($refundRequest->id)
                        ->lockForUpdate()
                        ->firstOrFail();

                    /*
                     * Deduction can only be changed after approval
                     * and before the Stripe refund is created.
                     */
                    if (
                        $refundRequest->status
                        !== RefundRequest::STATUS_APPROVED
                    ) {
                        throw new RuntimeException(
                            'Only an approved refund request can be updated.',
                        );
                    }

                    /*
                     * Once a Refund record exists, the refund amount
                     * is permanently locked for Stripe processing.
                     */
                    if ($refundRequest->refund()->exists()) {
                        throw new RuntimeException(
                            'The refund has already been created and cannot be modified.',
                        );
                    }

                    $deductionAmount = round(
                        (float) (
                            $request->validated(
                                'deduction_amount',
                            ) ?? 0
                        ),
                        2,
                    );

                    $refundAmount = round(
                        (float) $refundRequest->amount,
                        2,
                    );

                    if ($deductionAmount < 0) {
                        throw ValidationException::withMessages([
                            'deduction_amount' => [
                                'The deduction amount cannot be negative.',
                            ],
                        ]);
                    }

                    if ($deductionAmount > $refundAmount) {
                        throw ValidationException::withMessages([
                            'deduction_amount' => [
                                'The deduction amount cannot exceed the refundable amount of $'
                                . number_format(
                                    $refundAmount,
                                    2,
                                )
                                . '.',
                            ],
                        ]);
                    }

                    $refundRequest->update([
                        'deduction_amount' => $deductionAmount,
                        'deduction_reason' => $request->validated(
                            'deduction_reason',
                        ),
                    ]);
                },
            );

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Refund deduction updated successfully.',
                );
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (
        DomainException | RuntimeException $exception
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    $exception->getMessage(),
                );
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Unable to update the refund deduction. Please try again.',
                );
        }
    }

    /**
     * Approve a refund request.
     */
    public function approve(
        RefundRequest $refundRequest,
        ApproveRefundRequest $approveRefundRequest,
    ): RedirectResponse {
        try {
            $approveRefundRequest->execute(
                refundRequest: $refundRequest,
                approvedBy: (int) auth()->id(),
            );

            return redirect()
                ->back()
                ->with(
                    'success',
                    'Refund request approved successfully. '
                    . 'Order has been cancelled.',
                );
        } catch (ValidationException $exception) {
            throw $exception;
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Unable to approve the refund request. Please try again.',
                );
        }
    }

    /**
     * Reject a refund request.
     */
    public function reject(
        RefundRequestActionRequest $request,
        RefundRequest $refundRequest,
        RejectRefundRequest $rejectRefundRequest,
    ): RedirectResponse {
        try {
            $rejectRefundRequest->execute(
                refundRequest: $refundRequest,
                admin: $request->user(),
                adminNote: $request->validated('admin_note'),
            );

            return redirect()
                ->back()
                ->with(
                    'success',
                    'The refund request has been rejected successfully.',
                );
        } catch (DomainException $exception) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    $exception->getMessage(),
                );
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Unable to reject the refund request. Please try again.',
                );
        }
    }

    /**
     * Process an approved refund through Stripe.
     */
    public function refund(
        RefundRequest $refundRequest,
        RefundOrder $refundOrder,
    ): RedirectResponse {
        try {
            $refund = $refundOrder->execute(
                refundRequest: $refundRequest,
            );

            return match ($refund->status) {
                Refund::STATUS_SUCCEEDED => redirect()
                    ->back()
                    ->with(
                        'success',
                        'The refund has been processed successfully through Stripe.',
                    ),

                Refund::STATUS_PENDING => redirect()
                    ->back()
                    ->with(
                        'warning',
                        'The Stripe refund is currently pending.',
                    ),

                Refund::STATUS_FAILED => redirect()
                    ->back()
                    ->with(
                        'error',
                        'The Stripe refund failed. You can retry the refund.',
                    ),

                Refund::STATUS_CANCELED => redirect()
                    ->back()
                    ->with(
                        'warning',
                        'The Stripe refund was canceled.',
                    ),

                default => redirect()
                    ->back()
                    ->with(
                        'warning',
                        'The Stripe refund was created with status: '
                        . ucfirst($refund->status)
                        . '.',
                    ),
            };
        } catch (
        DomainException | RuntimeException $exception
        ) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    $exception->getMessage(),
                );
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->back()
                ->with(
                    'error',
                    'Unable to process the refund. Please try again.',
                );
        }
    }
}
