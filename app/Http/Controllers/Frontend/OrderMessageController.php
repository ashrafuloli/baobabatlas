<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Actions\Order\SendOrderMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\OrderMessageRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;

final class OrderMessageController extends Controller
{
    public function store(
        OrderMessageRequest $request,
        Order $order,
        SendOrderMessage $sendOrderMessage
    ): RedirectResponse {
        if ($order->user_id !== $request->user()->id) {
            return redirect()
                ->back()
                ->with('error', 'You are not authorized to message about this order.');
        }

        $sendOrderMessage->execute(
            order: $order,
            user: $request->user(),
            data: $request->validated(),
        );

        return redirect()
            ->back()
            ->with('success', 'Your message has been sent successfully.');
    }
}
