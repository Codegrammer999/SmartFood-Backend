@extends('layout.base')

@section('content')
<button onclick="back()" class="px-4 py-2 bg-[#ef6002] hover:bg-[#ef6102d8] text-white m-2 rounded-md">&leftarrow; Back</button>
<div class="bg-white/10 backdrop-blur-lg p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
    <div class="text-white space-y-2">
        <p><span class="font-semibold">Name:</span> {{ $user->name }}</p>
        <p><span class="font-semibold">Userame:</span> {{ $user->username }}</p>
        <p><span class="font-semibold">Email:</span> {{ $user->email }}</p>
        @if ($user->mainWallet)
        <p><span class="font-semibold">Main Wallet balance:</span> ₦{{ number_format($user->mainWallet->balance, 2) }}</p>
        @else
        <p><span class="font-semibold">Main Wallet balance:</span> ₦0.00</p>
        @endif
        @if ($user->bonusWallet)
        <p><span class="font-semibold">Bonus Wallet balance:</span> ₦{{ number_format($user->bonusWallet->balance, 2) }}</p>
        @else
        <p><span class="font-semibold">Bonus Wallet balance:</span> ₦0.00</p>
        @endif
        <p><span class="font-semibold">Joined:</span> {{ $user->created_at->format('M d, Y') }}</p>
        @if ($user->payment_receipt)
        <p><span class="font-semibold">Registration Payment:</span> <a class="text-sm font-bold underline text-[#ef6002]" href="{{ $user->payment_receipt}}">View payment</a> </p>
        @endif
        <p><span class="font-semibold">Status:</span>
            <span class="text-yellow-400 uppercase">{{ $user->registration_status }}</span>
        </p>
    </div>
</div>
@endsection

<script>
    const back = () => {
        history.back()
    }
</script>

