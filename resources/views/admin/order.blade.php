<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orders</title>
</head>
<body style="text-align: center">
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Menu Item</th>
                <th>Price</th>
                <th>Payment Receipt</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pendingOrders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user }}</td>
                <td>{{ $order->menu }}</td>
                <td>{{ $order->total_price }}</td>
                <td><a href="{{ asset('storage/' . $order->payment_receipt) }}">View Payment</a></td>
                <td>{{ $order->status }}</td>

                <form action="/confirm-order" method="post">
                    @csrf
                    <input type="text" name="order_id" value="{{ $order->id }}" hidden>
                    <button>Confirm Order</button>
                </form>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        @if (@session('success'))
        <div>{{ session('success') }}</div>
        @endif

        @if (@session('error'))
        <div class="text-red-500">{{ session('error') }}</div>
        @endif
    </div>
</body>
</html>
