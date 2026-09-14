<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >
    <title>
        Order #{{ $order->order_number }}
    </title>

    <style>
        @media print {
            .no-print {
                display: none !important;
            }

            body {
                margin: 0;
            }
        }

        body {
            margin: 0;
            padding: 40px;
            font-family: Arial, sans-serif;
            color: #111;
            background: #fff;
        }

        .print-page {
            max-width: 900px;
            margin: 0 auto;
        }

        .print-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .print-title {
            font-size: 24px;
            font-weight: 700;
        }

        .print-meta {
            margin-top: 8px;
            color: #666;
            font-size: 14px;
        }

        .print-section {
            margin-top: 25px;
        }

        .print-section h2 {
            margin: 0 0 12px;
            font-size: 16px;
        }

        .print-table {
            width: 100%;
            border-collapse: collapse;
        }

        .print-table th,
        .print-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
            font-size: 14px;
        }

        .print-table th {
            background: #f5f5f5;
        }

        .print-total {
            margin-top: 20px;
            margin-left: auto;
            width: 300px;
        }

        .print-total-row {
            display: flex;
            justify-content: space-between;
            padding: 6px 0;
        }

        .print-total-row--grand {
            margin-top: 8px;
            padding-top: 12px;
            border-top: 2px solid #111;
            font-weight: 700;
            font-size: 16px;
        }

        .print-button {
            margin-bottom: 30px;
            padding: 10px 18px;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="print-page">

    <button
        type="button"
        class="print-button no-print"
        onclick="window.print()"
    >
        Print Order
    </button>

    <header class="print-header">
        <div>
            <div class="print-title">
                Order #{{ $order->order_number }}
            </div>

            <div class="print-meta">
                {{ $order->created_at?->format('M d, Y h:i A') }}
            </div>
        </div>

        <div>
            <strong>
                {{ ucfirst($order->status) }}
            </strong>
        </div>
    </header>

    <section class="print-section">
        <h2>Customer</h2>

        <p>
            {{ $order->customer_name }}
        </p>

        @if ($order->customer_email)
            <p>
                {{ $order->customer_email }}
            </p>
        @endif
    </section>

    <section class="print-section">
        <h2>Order Items</h2>

        <table class="print-table">
            <thead>
            <tr>
                <th>Product</th>
                <th>SKU</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Total</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>
                        {{ $item->product_name }}
                    </td>

                    <td>
                        {{ $item->sku ?: '—' }}
                    </td>

                    <td>
                        {{ $item->quantity }}
                    </td>

                    <td>
                        ${{ number_format((float) $item->unit_price, 2) }}
                    </td>

                    <td>
                        ${{ number_format((float) $item->line_total, 2) }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </section>

    <div class="print-total">
        <div class="print-total-row">
            <span>Subtotal</span>
            <strong>
                ${{ number_format((float) $order->subtotal, 2) }}
            </strong>
        </div>

        <div class="print-total-row">
            <span>Discount</span>
            <strong>
                -${{ number_format((float) $order->discount, 2) }}
            </strong>
        </div>

        <div class="print-total-row">
            <span>Shipping</span>
            <strong>
                ${{ number_format((float) $order->shipping, 2) }}
            </strong>
        </div>

        <div class="print-total-row">
            <span>Tax</span>
            <strong>
                ${{ number_format((float) $order->tax, 2) }}
            </strong>
        </div>

        <div class="print-total-row print-total-row--grand">
            <span>Total</span>
            <strong>
                ${{ number_format((float) $order->total, 2) }}
            </strong>
        </div>
    </div>

</div>

</body>
</html>
