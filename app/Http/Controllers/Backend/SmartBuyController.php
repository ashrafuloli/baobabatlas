<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyRequest;
use Illuminate\Http\Request;

class SmartBuyController extends Controller
{
    /**
     * Display all Smart Buy requests.
     */
    public function index(Request $request)
    {
        $query = SmartBuyRequest::query()
            ->with([

                'user',

                'items',

                'quote',

                'latestQuote',

                'payment',

                'shipment',

            ]);


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(
                function ($q) use ($search) {

                    $q->where(
                        'request_number',
                        'like',
                        "%{$search}%"
                    )

                        ->orWhere(
                            'first_name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'last_name',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'email',
                            'like',
                            "%{$search}%"
                        )

                        ->orWhere(
                            'city',
                            'like',
                            "%{$search}%"
                        );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Status Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('status')
            &&
            $request->status !== 'all'
        ) {

            $query->where(
                'status',
                $request->status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Country Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('country')
            &&
            $request->country !== 'all'
        ) {

            $query->where(
                'country',
                $request->country
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Date Filter
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('date')
            &&
            $request->date !== 'all'
        ) {

            switch (
            $request->date
            ) {

                case 'today':

                    $query->whereDate(
                        'created_at',
                        today()
                    );

                    break;


                case 'week':

                    $query->whereBetween(
                        'created_at',
                        [
                            now()->startOfWeek(),
                            now()->endOfWeek(),
                        ]
                    );

                    break;


                case 'month':

                    $query
                        ->whereMonth(
                            'created_at',
                            now()->month
                        )
                        ->whereYear(
                            'created_at',
                            now()->year
                        );

                    break;

            }

        }


        $smartBuys = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();


        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $totalRequests =
            SmartBuyRequest::count();


        $pendingRequests =
            SmartBuyRequest::where(
                'status',
                'pending'
            )->count();


        $awaitingPayment =
            SmartBuyRequest::whereIn(
                'status',
                [
                    'quote_accepted',
                    'payment_pending',
                ]
            )->count();


        $inProgress =
            SmartBuyRequest::whereIn(
                'status',
                [
                    'quote_sent',
                    'payment_completed',
                    'product_purchased',
                    'in_transit',
                ]
            )->count();


        $countries =
            SmartBuyRequest::query()
                ->select('country')
                ->whereNotNull('country')
                ->distinct()
                ->orderBy('country')
                ->pluck('country');


        return view(
            'backend.pages.smart-buy.index',
            compact(
                'smartBuys',
                'totalRequests',
                'pendingRequests',
                'awaitingPayment',
                'inProgress',
                'countries'
            )
        );
    }


    /**
     * Display Smart Buy request.
     */
    /**
     * Display Smart Buy request.
     */
    /**
     * Display Smart Buy request.
     */
    /**
     * Display Smart Buy request.
     */
    /**
     * Display Smart Buy request.
     */
    /**
     * Display Smart Buy request.
     */
    /**
     * Display Smart Buy request details.
     */
    public function show(
        SmartBuyRequest $smartBuy
    ) {
        $smartBuy->load([
            'user',
            'items',
            'quote.quoteItems.smartBuyItem',
            'latestQuote.quoteItems.smartBuyItem',
            'payment',
            'shipment',
        ]);

        return view(
            'backend.pages.smart-buy.details',
            compact('smartBuy')
        );
    }


    /**
     * Manually update Smart Buy request status.
     */
    public function updateStatus(
        Request $request,
        SmartBuyRequest $smartBuy
    ) {
        $validated = $request->validate([

            'status' => [

                'required',

                'in:pending,quote_sent,quote_accepted,quote_rejected,payment_pending,payment_completed,product_purchased,in_transit,completed,cancelled',

            ],

        ]);


        $smartBuy->update([

            'status' =>
                $validated['status'],

        ]);


        return back()->with(
            'success',
            'Smart Buy request status updated successfully.'
        );
    }
}
