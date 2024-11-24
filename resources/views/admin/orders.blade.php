@extends('layout.base')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold text-white mb-6">Orders</h2>

    @error('error')
        {{ $message }}
    @enderror

    @if($pendingOrders->isEmpty())
        <!-- No Orders Found -->
        <div class="bg-gray-800 text-white p-4 rounded-md text-center">
            <p>No orders found.</p>
        </div>
    @else
        <!-- Orders List -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($pendingOrders as $order)
                <div class="bg-white/10 backdrop-blur-lg p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <div class="text-white space-y-2">
                        <!-- Order Details -->
                        <p><span class="font-semibold">Item name:</span> {{ $order->menu_name }} <a class="text-sm font-bold underline text-[#ef6002]" href="{{ route('admin.menu',  $order->menu_id) }}">See Details</a></p>
                        <p><span class="font-semibold">Quantity:</span> {{ $order->quantity }}</p>
                        <p><span class="font-semibold">Total Price:</span> ₦{{ number_format($order->total_price, 2) }}</p>
                        <p><span class="font-semibold">Order Date:</span> {{ $order->created_at->format('M d, Y') }}</p>
                        <p><span class="font-semibold">Payment:</span> <a class="text-sm font-bold underline text-[#ef6002]" href="{{ $order->payment_receipt }}">View payment</a> </p>
                        <p><span class="font-semibold">Status:</span>
                            <span class="text-yellow-400 uppercase">{{ $order->status }}</span>
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-col mt-4 space-y-2">
                        <!-- View Owner -->
                        <a href="{{ route('admin.viewOrderOwner', $order->id) }}"
                           class="text-center bg-[#ef6002] text-white py-2 rounded-md hover:bg-opacity-80 transition duration-300">
                            View user
                        </a>

                        <!-- Confirm Order -->
                        <form action="{{ route('admin.confirmOrder', $order->id) }}" method="POST">
                            @csrf

                            <button onclick="confirmOrder(event)" type="submit"
                                    class="w-full bg-green-500 text-white py-2 rounded-md hover:bg-green-600 transition duration-300">
                                Confirm Order
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $pendingOrders->links('pagination::tailwind') }}
        </div>
    @endif
</div>
@endsection

<script>
const confirmOrder = (e) => {
    if (!confirm('Are you sure you want to confirm this order?')) {
        e.preventDefault()
    }
}
</script>
