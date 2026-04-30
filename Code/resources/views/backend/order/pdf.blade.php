@php 
$points=DB::table('carts')->where('order_id', $order->id)->pluck('points')->first(); 
 
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invoice #{{ $order->order_number }}</title>
<style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Poppins', 'Segoe UI', Arial, sans-serif; }
    
    body {
        background: #f3f4f7;
        padding: 40px;
        color: #333;
    }

    .invoice-wrapper {
        max-width: 850px;
        background: #fff;
        margin: auto;
        border-left: 8px solid #E50914;
        box-shadow: 0 5px 30px rgba(0,0,0,0.08);
        border-radius: 6px;
        padding: 40px 50px;
    }

    /* Header */
    .header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding-bottom: 20px;
        border-bottom: 2px solid #e0e0e0;
        margin-bottom: 30px;
    }
    .company h1 {
        color: #E50914;
        font-size: 28px;
        margin-bottom: 4px;
    }
    .company p {
        font-size: 13px;
        color: #666;
        line-height: 1.4;
    }

    .invoice-info {
        text-align: right;
    }
    .invoice-info h2 {
        font-size: 26px;
        color: #E50914;
        margin-bottom: 5px;
    }
    .invoice-info p {
        font-size: 13px;
        color: #444;
    }
    .status {margin-top: 10px;}
       .status span {
        color: #E50914;
        font-weight: 800;
        font-size: 15px;
    }
    /* Details */
    .details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        flex-wrap: wrap;
       
    }
    .details .box {
        width: 48%;
    }
    .details h3{
        color: #E50914;
        font-size: 15px;
        border-bottom: 1px solid #e0e0e0;
        padding-bottom: 5px;
        margin-bottom: 10px;
    }
    .details p {
        font-size: 13px;
        color: #444;
        margin-bottom: 4px;
    }

    /* Table */
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 35px;
    }
    table th {
        background: #E50914;
        color: #fff;
        padding: 10px;
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.4px;
    }
    table td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        font-size: 13px;
    }
    tr:nth-child(even) {
        background: #f9fafc;
    }
    .text-right { text-align: right; }

    /* Totals */
    .totals {
        width: 300px;
        float: right;
        margin-top: 20px;
    }
    .totals td {
        padding: 8px;
        font-size: 14px;
        border-bottom: 1px solid #eee;
    }
    .totals td:last-child {
        text-align: right;
        font-weight: 600;
    }
    .totals tr:last-child td {
        border-top: 2px solid #E50914;
        font-size: 16px;
        color: #E50914;
    }

    /* Note & Footer */
    .note {
        margin-top: 60px;
        font-size: 13px;
        color: #666;
        line-height: 1.6;
        background: #f9fafc;
        border-left: 3px solid #E50914;
        padding: 10px 15px;
        border-radius: 4px;
    }

    .footer {
        text-align: center;
        margin-top: 40px;
        font-size: 13px;
        color: #777;
        border-top: 1px solid #e0e0e0;
        padding-top: 15px;
    }

    /* Print styles */
    @media print {
        body { background: none; padding: 0; }
        .invoice-wrapper { box-shadow: none; border: none; border-left: none; }
    }
</style>
</head>
<body>

<div class="invoice-wrapper">

    <!-- Header -->
    <div class="header">
        <div class="company">
            <h1>{{ env('APP_NAME') }}</h1>
            <p>{{ env('APP_ADDRESS') }}</p>
            <p>Email: {{ env('APP_EMAIL') }}</p>
        </div>
        <div class="invoice-info">
            <h2>INVOICE</h2>
            <p>Invoice <strong>#{{ $order->order_number }}</strong></p>
            <p>Date: {{ $order->created_at->format('d M Y') }}</p>
            <p class="status">Payment status: <span>{{ $order->payment_status }}</span></p>
        </div>
    </div>

    <!-- Details -->
    <div class="details">
        <div class="box">
            <h3>Bill To</h3>
            <p><strong>{{ $order->first_name }} {{ $order->last_name }}</strong></p>
            <p>{{ $order->address1 }} {{ $order->address2 }}</p>
            <p>{{ $order->country }}</p>
            <p>Phone: {{ $order->phone }}</p>
            <p>Email: {{ $order->email }}</p>
        </div>
        
    </div>

    <!-- Table -->
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Qty</th>
                <th class="text-right">Unit Price</th>
                <th class="text-right">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->cart_info as $cart)
                @php 
                    $product = DB::table('products')->select('title')->where('id', $cart->product_id)->first();
                    $currency = match($order->currency) {
                        'USD' => '$',
                        'JPY' => '¥',
                        'HKD' => 'HK$',
                        default => '$',
                    };
                    if($order->currency == "JPY") {
                        $price = number_format($cart->price_jp, 0);
                        $total = number_format($cart->amount_jp, 0);
                    } elseif($order->currency == "HKD") {
                        $price = number_format($cart->price_hk, 2);
                        $total = number_format($cart->amount_hk, 2);
                    } else {
                        $price = number_format($cart->price, 2);
                        $total = number_format($cart->amount, 2);
                    }
                @endphp
                <tr>
                    <td>{{ $product->title ?? 'Points' }}</td>
                    <td>{{ $cart->points }} Points </td>
                    <td class="text-right">{{ $currency }} {{ $price }}</td>
                    <td class="text-right">{{ $currency }} {{ $total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Totals -->
    <table class="totals">
        <!--
        <tr>
            <td>Subtotal:</td>
            <td>{{ $currency }} {{ number_format($order->total_amount, $order->currency=='JPY' ? 0 : 2) }}</td>
        </tr>
        -->
        <tr>
            <td><strong>Total:</strong></td>
            <td><strong>{{ $currency }} {{ number_format($order->total_amount, $order->currency=='JPY' ? 0 : 2) }}</strong></td>
        </tr>
    </table>

    <div style="clear: both;"></div>

    <!-- Note -->
    <!--
    <div class="note">
        <p><strong>Note:</strong> All purchased services are a one-time redemption unless stated otherwise. 
        Redeemable at any of our store locations.</p>
    </div>
    -->

    <!-- Footer -->
    <div class="footer">
        <p>Thank you for your business!</p>
        <p>For support: <strong>{{ env('APP_EMAIL') }}</strong> | {{ url('/') }}</p>
    </div>

</div>
</body>
</html>
