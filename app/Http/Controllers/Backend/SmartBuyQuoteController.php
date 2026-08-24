<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyQuote;
use App\Models\SmartBuyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SmartBuyQuoteController extends Controller
{
    /**
     * Show create quote page.
     */
    public function create(
        SmartBuyRequest $smartBuy
    ) {
        $smartBuy->load([
            'user',
            'items',
            'latestQuote.quoteItems.smartBuyItem',
        ]);


        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Quote
        |--------------------------------------------------------------------------
        */

        if ($smartBuy->latestQuote) {

            return redirect()
                ->route(
                    'smart-buy.quote.show',
                    $smartBuy->latestQuote->id
                )
                ->with(
                    'error',
                    'A quote already exists for this Smart Buy request.'
                );

        }


        return view(
            'backend.pages.smart-buy.quote-create',
            compact(
                'smartBuy'
            )
        );
    }


    /**
     * Store Smart Buy Quote.
     */
    public function store(
        Request $request,
        SmartBuyRequest $smartBuy
    ) {
        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Quote
        |--------------------------------------------------------------------------
        */

        $smartBuy->load(
            'latestQuote'
        );


        if ($smartBuy->latestQuote) {

            return redirect()
                ->route(
                    'smart-buy.quote.show',
                    $smartBuy->latestQuote->id
                )
                ->with(
                    'error',
                    'A quote already exists for this Smart Buy request.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.smart_buy_item_id' => [
                'required',
                'integer',
                'exists:smart_buy_items,id',
            ],

            'items.*.product_name' => [
                'required',
                'string',
                'max:255',
            ],

            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'items.*.unit_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'items.*.notes' => [
                'nullable',
                'string',
            ],

            'service_fee' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'shipping_fee' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'currency' => [
                'nullable',
                'string',
                'max:10',
            ],

            'notes' => [
                'nullable',
                'string',
            ],

            'expires_at' => [
                'nullable',
                'date',
                'after_or_equal:today',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        |
        | Make sure every submitted item belongs to
        | the current Smart Buy request.
        |
        */

        $submittedItemIds = collect(
            $validated['items']
        )
            ->pluck(
                'smart_buy_item_id'
            )
            ->map(
                fn ($id) => (int) $id
            )
            ->unique()
            ->values();


        $validItemIds = $smartBuy
            ->items()
            ->whereIn(
                'id',
                $submittedItemIds
            )
            ->pluck(
                'id'
            )
            ->map(
                fn ($id) => (int) $id
            )
            ->unique()
            ->values();


        if (
            $submittedItemIds->count()
            !==
            $validItemIds->count()
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'One or more submitted products do not belong to this Smart Buy request.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Create Quote
        |--------------------------------------------------------------------------
        */

        $quote = DB::transaction(
            function () use (
                $validated,
                $smartBuy
            ) {

                /*
                |--------------------------------------------------------------------------
                | Calculate Product Total
                |--------------------------------------------------------------------------
                */

                $productTotal = 0;


                foreach (
                    $validated['items']
                    as $item
                ) {

                    $productTotal +=

                        (float) $item['unit_price']

                        *

                        (int) $item['quantity'];

                }


                /*
                |--------------------------------------------------------------------------
                | Additional Fees
                |--------------------------------------------------------------------------
                */

                $serviceFee =

                    (float) (
                        $validated['service_fee']
                        ?? 0
                    );


                $shippingFee =

                    (float) (
                        $validated['shipping_fee']
                        ?? 0
                    );


                /*
                |--------------------------------------------------------------------------
                | Calculate Grand Total
                |--------------------------------------------------------------------------
                */

                $totalAmount =

                    $productTotal

                    +

                    $serviceFee

                    +

                    $shippingFee;


                /*
                |--------------------------------------------------------------------------
                | Generate Quote Number
                |--------------------------------------------------------------------------
                */

                $nextId =

                    (
                        SmartBuyQuote::max('id')
                        ?? 0
                    )

                    +

                    1;


                $quoteNumber =

                    'SQ-'

                    .

                    str_pad(
                        (string) $nextId,
                        6,
                        '0',
                        STR_PAD_LEFT
                    );


                /*
                |--------------------------------------------------------------------------
                | Create Quote
                |--------------------------------------------------------------------------
                */

                $quote = SmartBuyQuote::create([

                    'smart_buy_request_id' =>
                        $smartBuy->id,

                    'quote_number' =>
                        $quoteNumber,

                    'product_total' =>
                        $productTotal,

                    'service_fee' =>
                        $serviceFee,

                    'shipping_fee' =>
                        $shippingFee,

                    'total_amount' =>
                        $totalAmount,

                    'currency' =>
                        $validated['currency']
                        ?? 'USD',

                    'status' =>
                        SmartBuyQuote::STATUS_SENT,

                    'notes' =>
                        $validated['notes']
                        ?? null,

                    'sent_at' =>
                        now(),

                    'expires_at' =>
                        $validated['expires_at']
                        ?? null,

                    'created_by' =>
                        auth()->id(),

                ]);


                /*
                |--------------------------------------------------------------------------
                | Create Quote Items
                |--------------------------------------------------------------------------
                */

                foreach (
                    $validated['items']
                    as $item
                ) {

                    $quantity =

                        (int) $item['quantity'];


                    $unitPrice =

                        (float) $item['unit_price'];


                    $totalPrice =

                        $quantity

                        *

                        $unitPrice;


                    $quote
                        ->items()
                        ->create([

                            'smart_buy_item_id' =>
                                $item['smart_buy_item_id'],

                            'product_name' =>
                                $item['product_name'],

                            'quantity' =>
                                $quantity,

                            'unit_price' =>
                                $unitPrice,

                            'total_price' =>
                                $totalPrice,

                            'notes' =>
                                $item['notes']
                                ?? null,

                        ]);

                }


                /*
                |--------------------------------------------------------------------------
                | Update Smart Buy Status
                |--------------------------------------------------------------------------
                */

                $smartBuy->update([

                    'status' =>
                        'quote_sent',

                    'quoted_at' =>
                        now(),

                ]);


                return $quote;

            }
        );


        return redirect()
            ->route(
                'smart-buy.quote.show',
                $quote->id
            )
            ->with(
                'success',
                'Smart Buy quote created successfully.'
            );
    }


    /**
     * Show quote.
     */
    public function show(
        SmartBuyQuote $quote
    ) {
        $quote->load([

            'smartBuyRequest.user',

            'smartBuyRequest.items',

            'quoteItems.smartBuyItem',

            'creator',

        ]);


        return view(
            'backend.pages.smart-buy.quote-show',
            compact(
                'quote'
            )
        );
    }

    /**
     * Show edit quote page.
     */
    public function edit(
        SmartBuyQuote $quote
    ) {
        $quote->load([

            'smartBuyRequest.user',

            'smartBuyRequest.items',

            'quoteItems.smartBuyItem',

        ]);


        $smartBuy =
            $quote->smartBuyRequest;


        if (!$smartBuy) {

            return redirect()
                ->route('smart-buy.index')
                ->with(
                    'error',
                    'Smart Buy request not found.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Editing Accepted Quote
        |--------------------------------------------------------------------------
        |
        | Rejected quotes can be edited and sent again.
        |
        */

        if (
            $quote->status ===
            SmartBuyQuote::STATUS_ACCEPTED
        ) {

            return redirect()
                ->route(
                    'smart-buy.quote.show',
                    $quote->id
                )
                ->with(
                    'error',
                    'An accepted quote can no longer be edited.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Get Existing Quote Items By Smart Buy Item ID
        |--------------------------------------------------------------------------
        */

        $quoteItems =
            $quote
                ->quoteItems
                ->keyBy(
                    'smart_buy_item_id'
                );


        return view(
            'backend.pages.smart-buy.quote-edit',
            compact(
                'quote',
                'smartBuy',
                'quoteItems'
            )
        );
    }


    /**
     * Update Smart Buy Quote.
     */
    public function update(
        Request $request,
        SmartBuyQuote $quote
    ) {
        $quote->load([

            'smartBuyRequest.items',

            'quoteItems',

        ]);


        $smartBuy =
            $quote->smartBuyRequest;


        if (!$smartBuy) {

            return redirect()
                ->route('smart-buy.index')
                ->with(
                    'error',
                    'Smart Buy request not found.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Prevent Editing Accepted Quote
        |--------------------------------------------------------------------------
        |
        | Rejected and expired quotes can be updated.
        |
        */

        if (
            $quote->status ===
            SmartBuyQuote::STATUS_ACCEPTED
        ) {

            return back()
                ->with(
                    'error',
                    'An accepted quote can no longer be edited.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

        $validated =
            $request->validate([

                'items' => [
                    'required',
                    'array',
                    'min:1',
                ],

                'items.*.smart_buy_item_id' => [
                    'required',
                    'integer',
                    'exists:smart_buy_items,id',
                ],

                'items.*.product_name' => [
                    'required',
                    'string',
                    'max:255',
                ],

                'items.*.quantity' => [
                    'required',
                    'integer',
                    'min:1',
                ],

                'items.*.unit_price' => [
                    'required',
                    'numeric',
                    'min:0',
                ],

                'items.*.notes' => [
                    'nullable',
                    'string',
                ],

                'service_fee' => [
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'shipping_fee' => [
                    'nullable',
                    'numeric',
                    'min:0',
                ],

                'currency' => [
                    'nullable',
                    'string',
                    'max:10',
                ],

                'notes' => [
                    'nullable',
                    'string',
                ],

                'expires_at' => [
                    'nullable',
                    'date',
                    'after_or_equal:today',
                ],

            ]);


        /*
        |--------------------------------------------------------------------------
        | Security Check
        |--------------------------------------------------------------------------
        |
        | Make sure every submitted item belongs to
        | the current Smart Buy request.
        |
        */

        $submittedItemIds =
            collect(
                $validated['items']
            )
                ->pluck(
                    'smart_buy_item_id'
                )
                ->map(
                    fn ($id) => (int) $id
                )
                ->unique()
                ->values();


        $validItemIds =
            $smartBuy
                ->items()
                ->whereIn(
                    'id',
                    $submittedItemIds
                )
                ->pluck(
                    'id'
                )
                ->map(
                    fn ($id) => (int) $id
                )
                ->unique()
                ->values();


        if (
            $submittedItemIds->count()
            !==
            $validItemIds->count()
        ) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    'One or more submitted products do not belong to this Smart Buy request.'
                );

        }


        /*
        |--------------------------------------------------------------------------
        | Update Quote
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $validated,
                $quote,
                $smartBuy
            ) {

                /*
                |--------------------------------------------------------------------------
                | Calculate Product Total
                |--------------------------------------------------------------------------
                */

                $productTotal = 0;


                foreach (
                    $validated['items']
                    as $item
                ) {

                    $productTotal +=

                        (float) $item['unit_price']

                        *

                        (int) $item['quantity'];

                }


                /*
                |--------------------------------------------------------------------------
                | Additional Fees
                |--------------------------------------------------------------------------
                */

                $serviceFee =

                    (float) (
                        $validated['service_fee']
                        ?? 0
                    );


                $shippingFee =

                    (float) (
                        $validated['shipping_fee']
                        ?? 0
                    );


                /*
                |--------------------------------------------------------------------------
                | Calculate Grand Total
                |--------------------------------------------------------------------------
                */

                $totalAmount =

                    $productTotal

                    +

                    $serviceFee

                    +

                    $shippingFee;


                /*
                |--------------------------------------------------------------------------
                | Update Quote
                |--------------------------------------------------------------------------
                |
                | After admin updates the quote, it is sent
                | again to the customer for review.
                |
                */

                $quote->update([

                    'product_total' =>
                        $productTotal,

                    'service_fee' =>
                        $serviceFee,

                    'shipping_fee' =>
                        $shippingFee,

                    'total_amount' =>
                        $totalAmount,

                    'currency' =>
                        $validated['currency']
                        ?? $quote->currency
                            ?? 'USD',

                    'notes' =>
                        $validated['notes']
                        ?? null,

                    'expires_at' =>
                        $validated['expires_at']
                        ?? null,


                    /*
                    |--------------------------------------------------------------------------
                    | Re-send Quote
                    |--------------------------------------------------------------------------
                    */

                    'status' =>
                        SmartBuyQuote::STATUS_SENT,

                    'sent_at' =>
                        now(),


                    /*
                    |--------------------------------------------------------------------------
                    | Reset Previous Decision
                    |--------------------------------------------------------------------------
                    */

                    'accepted_at' =>
                        null,

                    'rejected_at' =>
                        null,

                ]);


                /*
                |--------------------------------------------------------------------------
                | Existing Quote Items
                |--------------------------------------------------------------------------
                */

                $existingQuoteItems =
                    $quote
                        ->quoteItems()
                        ->get()
                        ->keyBy(
                            'smart_buy_item_id'
                        );


                $submittedIds = [];


                /*
                |--------------------------------------------------------------------------
                | Update / Create Quote Items
                |--------------------------------------------------------------------------
                */

                foreach (
                    $validated['items']
                    as $item
                ) {

                    $smartBuyItemId =

                        (int)
                        $item['smart_buy_item_id'];


                    $submittedIds[] =
                        $smartBuyItemId;


                    $quantity =

                        (int)
                        $item['quantity'];


                    $unitPrice =

                        (float)
                        $item['unit_price'];


                    $totalPrice =

                        $quantity

                        *

                        $unitPrice;


                    /*
                    |--------------------------------------------------------------------------
                    | Update Existing Quote Item
                    |--------------------------------------------------------------------------
                    */

                    if (
                        $existingQuoteItems->has(
                            $smartBuyItemId
                        )
                    ) {

                        $existingQuoteItems
                            ->get(
                                $smartBuyItemId
                            )
                            ->update([

                                'product_name' =>
                                    $item['product_name'],

                                'quantity' =>
                                    $quantity,

                                'unit_price' =>
                                    $unitPrice,

                                'total_price' =>
                                    $totalPrice,

                                'notes' =>
                                    $item['notes']
                                    ?? null,

                            ]);

                    } else {

                        /*
                        |--------------------------------------------------------------------------
                        | Create New Quote Item
                        |--------------------------------------------------------------------------
                        */

                        $quote
                            ->items()
                            ->create([

                                'smart_buy_item_id' =>
                                    $smartBuyItemId,

                                'product_name' =>
                                    $item['product_name'],

                                'quantity' =>
                                    $quantity,

                                'unit_price' =>
                                    $unitPrice,

                                'total_price' =>
                                    $totalPrice,

                                'notes' =>
                                    $item['notes']
                                    ?? null,

                            ]);

                    }

                }


                /*
                |--------------------------------------------------------------------------
                | Remove Quote Items Not Submitted
                |--------------------------------------------------------------------------
                */

                $quote
                    ->items()
                    ->whereNotIn(
                        'smart_buy_item_id',
                        $submittedIds
                    )
                    ->delete();


                /*
                |--------------------------------------------------------------------------
                | Update Smart Buy Request Status
                |--------------------------------------------------------------------------
                |
                | This removes statuses such as:
                |
                | - quote_rejected
                | - quote_extension_requested
                |
                | and makes the quote available to the customer again.
                |
                */

                $smartBuy->update([

                    'status' =>
                        'quote_sent',

                ]);

            }
        );


        return redirect()
            ->route(
                'smart-buy.quote.show',
                $quote->id
            )
            ->with(
                'success',
                'Smart Buy quote updated and sent to the customer successfully.'
            );
    }
}
