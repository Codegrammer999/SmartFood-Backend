@extends('layout.base')

@section('content')
    <div class="flex justify-between items-baseline p-4">
        <h2 class="font-semibold text-2xl">Pending codes</h2>

        <button onclick="goback()" class="px-4 py-2 rounded bg-[#ef6002]"> &leftarrow; Back</button>
    </div>

    <div class="pb-8 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @if ($codes->isEmpty())
                <div class="bg-white/10 text-white p-4 rounded-md text-center">
                    <p>No unconfirmed codes found.</p>
                </div>
            @else
                @foreach ($codes as $code)
                    <div class="bg-white/10 border border-white/20 p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                            <h3 class="text-lg font-semibold text-white truncate mb-2">
                                {{ $code->code }}
                            </h3>

                        <div class="text-sm text-gray-300 space-y-1">
                            <p><span class="font-bold">Value: {{ $code->value }}</span></p>
                            <p>
                                <span class="font-bold">Status: </span>
                                <span class="px-2 py-1 rounded text-xs font-semibold bg-red-600 text-white">{{ $code->status }}</span>
                            </p>
                            <p><span class="font-bold">Expires At:</span> {{ $code->expires_at }}</p>
                        </div>

                        <form action="{{ route('admin.activate-code', $code->id) }}" method="POST" class="mt-4">
                            @csrf
                            <button class="w-full bg-[#ef6002] text-white text-sm font-medium py-2 rounded hover:bg-[#d24e01] transition duration-200">Activate code</button>
                        </form>
                    </div>
                @endforeach

                <div class="mt-6">
                    {{ $codes->links('pagination::tailwind') }}
                </div>
            @endif
        </div>
    </div>
@endsection

<script>
    const goback = () => {
        history.back()
    }
</script>
