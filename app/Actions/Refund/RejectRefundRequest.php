<?php

declare(strict_types=1);

namespace App\Actions\Refund;

use App\Models\RefundRequest;
use App\Models\User;
use DomainException;
use Illuminate\Support\Facades\DB;

final class RejectRefundRequest
{
    /**
     * Reject a pending refund request.
     */
    public function execute(
        RefundRequest $refundRequest,
        User $admin,
        ?string $adminNote = null
    ): RefundRequest {
        return DB::transaction(function () use (
            $refundRequest,
            $admin,
            $adminNote
        ): RefundRequest {
            $refundRequest = RefundRequest::query()
                ->lockForUpdate()
                ->findOrFail($refundRequest->id);

            if (! $refundRequest->isPending()) {
                throw new DomainException(
                    'This refund request can no longer be rejected.'
                );
            }

            $refundRequest->update([
                'status' => RefundRequest::STATUS_REJECTED,
                'approved_by' => $admin->id,
                'approved_at' => now(),
                'admin_note' => $adminNote !== null
                    ? trim($adminNote)
                    : null,
            ]);

            return $refundRequest->refresh();
        });
    }
}
