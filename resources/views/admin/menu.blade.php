@extends('layout.base')

@section('content')
<button onclick="back()" class="px-4 py-2 bg-[#ef6002] hover:bg-[#ef6102d8] text-white m-2 rounded-md">&leftarrow; Back</button>
<div class="bg-white/10 backdrop-blur-lg p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
    <div class="text-white flex items-center space-x-4 justify-center space-y-2 max-w-fit">
        <img src="{{ '/storage/' . $menu->image }}" alt="{{ $menu->description }}" class="max-w-xl h-40 sm:h-60 rounded">
        <div>
            <p><span class="font-semibold">Name:</span> {{ $menu->name }}</p>
            <p><span class="font-semibold">Category:</span> {{ $menu->category }}</p>
            <p><span class="font-semibold">Price:</span> ₦{{ number_format($menu->price, 2) }}</p>
            @if ($menu->priceOff)
            <p><span class="font-semibold">Discount:</span> ₦{{ number_format($menu->priceOff, 2) }}</p>
            @endif
            <p><span class="font-semibold">Added:</span> {{ $menu->created_at->format('M d, Y') }}</p>
            <p><span class="font-semibold">Description:</span>
                <span class="text-yellow-400 font-sm">{{ $menu->description }}</span>
            </p>
        </div>
    </div>
</div>
@endsection

<script>
    const back = () => {
        history.back()
    }
</script>

