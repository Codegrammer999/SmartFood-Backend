@extends('layout.base')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
    <!-- Total Users -->
    <div class="bg-white/10 p-4 rounded-lg shadow-md text-center">
        <h2 class="text-xl font-semibold mb-2">Total Users</h2>
        <p class="text-4xl font-bold text-[#ef6002]">{{ $data['total_users'] }}</p>
        <span class="text-sm text-gray-300">Active users in the system</span>
    </div>

    <div class="bg-white/10 p-4 rounded-lg shadow-md text-center">
        <h2 class="text-xl font-semibold mb-2">Pending Users</h2>
        <p class="text-4xl font-bold text-[#ef6002]">{{ $data['pending_users'] }}</p>
        <span class="text-sm text-gray-300">Users account waiting for confirmation.</span>

        <div class="text-right">
            <a href="{{ route('admin.pending-users') }}" class="p-2 text-[#ef6002]">See more</a>
        </div>
    </div>

    <!-- Total Orders -->
    <div class="bg-white/10 p-4 rounded-lg shadow-md text-center">
        <h2 class="text-xl font-semibold mb-2">Total Orders</h2>
        <p class="text-4xl font-bold text-[#ef6002]">{{ $data['total_orders'] }}</p>
        <span class="text-sm text-gray-300">Orders processed</span>
    </div>

    <!-- Total Revenue -->
    <div class="bg-white/10 p-4 rounded-lg shadow-md text-center">
        <h2 class="text-xl font-semibold mb-2">Total Revenue</h2>
        <p class="text-4xl font-bold text-[#ef6002]">{{ number_format($data['total_revenue'], 2) }}</p>
        <span class="text-sm text-gray-300">Revenue generated</span>
    </div>

    <!-- Pending Orders -->
    <div class="bg-white/10 p-4 rounded-lg shadow-md text-center">
        <h2 class="text-xl font-semibold mb-2">Pending Orders</h2>
        <p class="text-4xl font-bold text-[#ef6002]">{{ $data['pending_orders'] }}</p>
        <span class="text-sm text-gray-300">Orders awaiting approval</span>

        <div class="text-right">
            <a href="{{ route('admin.orders') }}" class="p-2 text-[#ef6002]">See more</a>
        </div>
    </div>

    <div class="bg-white/10 p-4 rounded-lg shadow-md text-center">
        <h2 class="text-xl font-semibold mb-2">Total Menus</h2>
        <p class="text-4xl font-bold text-[#ef6002]">{{ $data['total_menus'] }}</p>
        <span class="text-sm text-gray-300">Menus added</span>
    </div>
</div>

<!-- Charts and Tables -->
<div class="mt-8 grid grid-cols-1 xl:grid-cols-2 gap-6">
    <!-- Recent Orders -->
    <div class="bg-white/10 p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-semibold mb-4">Recent Orders</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-400">
                <thead class="text-gray-300 uppercase bg-white/20">
                    <tr>
                        <th class="py-2 px-4">Order ID</th>
                        <th class="py-2 px-4">Customer</th>
                        <th class="py-2 px-4">Amount</th>
                        <th class="py-2 px-4">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-white/10">
                        <td class="py-2 px-4">#1234</td>
                        <td class="py-2 px-4">John Doe</td>
                        <td class="py-2 px-4">$50</td>
                        <td class="py-2 px-4 text-[#ef6002]">Pending</td>
                    </tr>
                    <tr class="border-b border-white/10">
                        <td class="py-2 px-4">#1235</td>
                        <td class="py-2 px-4">Jane Smith</td>
                        <td class="py-2 px-4">$120</td>
                        <td class="py-2 px-4 text-green-500">Completed</td>
                    </tr>
                    <tr class="border-b border-white/10">
                        <td class="py-2 px-4">#1236</td>
                        <td class="py-2 px-4">Emily Brown</td>
                        <td class="py-2 px-4">$80</td>
                        <td class="py-2 px-4 text-red-500">Cancelled</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
