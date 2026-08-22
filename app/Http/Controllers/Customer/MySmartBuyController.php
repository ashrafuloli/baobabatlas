<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\SmartBuyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MySmartBuyController extends Controller
{
    /**
     * Show the Smart Buy request form.
     */
    public function create()
    {
        return view(
            'backend.pages.my-smart-buy.create'
        );
    }


    /**
     * Store a new Smart Buy request.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            /*
            |--------------------------------------------------------------------------
            | Customer Information
            |--------------------------------------------------------------------------
            */

            'first_name' => [
                'required',
                'string',
                'max:255',
            ],

            'last_name' => [
                'required',
                'string',
                'max:255',
            ],

            'phone' => [
                'required',
                'string',
                'max:50',
            ],

            'email' => [
                'required',
                'email',
                'max:255',
            ],


            /*
            |--------------------------------------------------------------------------
            | Delivery Information
            |--------------------------------------------------------------------------
            */

            'country' => [
                'required',
                'string',
                'max:255',
            ],

            'city' => [
                'required',
                'string',
                'max:255',
            ],

            'zip_code' => [
                'nullable',
                'string',
                'max:50',
            ],

            'delivery_address' => [
                'required',
                'string',
            ],


            /*
            |--------------------------------------------------------------------------
            | Smart Buy Items
            |--------------------------------------------------------------------------
            */

            'items' => [
                'required',
                'array',
                'min:1',
            ],

            'items.*.product_url' => [
                'required',
                'url',
                'max:2048',
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

            'items.*.size' => [
                'nullable',
                'string',
                'max:255',
            ],

            'items.*.color' => [
                'nullable',
                'string',
                'max:255',
            ],

            'items.*.product_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'items.*.notes' => [
                'nullable',
                'string',
            ],

        ]);


        $smartBuyRequest = DB::transaction(
            function () use ($validated) {

                /*
                |--------------------------------------------------------------------------
                | Generate Request Number
                |--------------------------------------------------------------------------
                */

                $lastRequest = SmartBuyRequest::latest(
                    'id'
                )->first();

                $nextId = $lastRequest
                    ? $lastRequest->id + 1
                    : 1;

                $requestNumber = 'SB-' . str_pad(
                        $nextId,
                        6,
                        '0',
                        STR_PAD_LEFT
                    );


                /*
                |--------------------------------------------------------------------------
                | Create Smart Buy Request
                |--------------------------------------------------------------------------
                */

                $smartBuyRequest = SmartBuyRequest::create([

                    'user_id' => auth()->id(),

                    'request_number' => $requestNumber,

                    'first_name' => $validated['first_name'],

                    'last_name' => $validated['last_name'],

                    'phone' => $validated['phone'],

                    'email' => $validated['email'],

                    'country' => $validated['country'],

                    'city' => $validated['city'],

                    'zip_code' => $validated['zip_code'] ?? null,

                    'delivery_address' =>
                        $validated['delivery_address'],

                    'status' => 'pending',

                ]);


                /*
                |--------------------------------------------------------------------------
                | Create Smart Buy Items
                |--------------------------------------------------------------------------
                */

                foreach ($validated['items'] as $item) {

                    $productImage = null;


                    /*
                    |--------------------------------------------------------------------------
                    | Upload Product Image
                    |--------------------------------------------------------------------------
                    */

                    if (
                        isset($item['product_image'])
                        && $item['product_image']
                    ) {
                        $productImage = $item['product_image']->store(
                            'smart-buy/products',
                            'public'
                        );
                    }


                    /*
                    |--------------------------------------------------------------------------
                    | Create Item
                    |--------------------------------------------------------------------------
                    */

                    $smartBuyRequest
                        ->items()
                        ->create([

                            'product_url' =>
                                $item['product_url'],

                            'product_name' =>
                                $item['product_name'],

                            'quantity' =>
                                $item['quantity'],

                            'size' =>
                                $item['size'] ?? null,

                            'color' =>
                                $item['color'] ?? null,

                            'product_image' =>
                                $productImage,

                            'notes' =>
                                $item['notes'] ?? null,

                        ]);
                }

                return $smartBuyRequest;
            }
        );


        return redirect()
            ->route(
                'my-smart-buy-details',
                $smartBuyRequest->id
            )
            ->with(
                'success',
                'Your Smart Buy request has been submitted successfully.'
            );
    }

    /**
     * Show a Smart Buy request details.
     */
    public function details($id)
    {
        $smartBuyRequest = SmartBuyRequest::with([
            'items',
        ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view(
            'backend.pages.my-smart-buy.details',
            compact('smartBuyRequest')
        );
    }
}
