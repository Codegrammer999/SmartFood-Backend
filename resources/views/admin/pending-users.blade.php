@extends('layout.base')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h2 class="text-2xl font-semibold text-white mb-6">Pending Users</h2>

        <!-- Display a message if no users are found -->
        @if($users->isEmpty())
            <div class="bg-white/10 text-white p-4 rounded-md text-center">
                <p>No unconfirmed users found.</p>
            </div>
        @else
            <!-- User Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($users as $user)
                    <div class="bg-white/10 backdrop-blur-lg p-4 rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                        <div class="flex flex-col items-center space-y-4">

                            <!-- User Info -->
                            <div class="text-center">
                                <h3 class="text-lg font-semibold text-white">{{ $user->name }}</h3>
                                <p class="text-sm">{{ $user->username }}</p>
                                <p class="text-sm">{{ $user->email }}</p>
                                <p class="text-sm">Joined: {{ $user->created_at->format('M d, Y') }}</p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-center space-x-4 mt-4">
                                <a href="{{ $user->payment_receipt ?? 'receipt/empty' }}" class="p-2 bg-[#ef6002] text-white rounded-md hover:bg-opacity-80 transition duration-300">
                                    View Receipt
                                </a>

                                <form action="{{ route('users.confirm', $user->id) }}" method="post">
                                    @csrf
                                    <button onclick="confirmUser(event)" type="submit" class="p-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition duration-300">
                                        Confirm
                                    </button>
                                </form>

                                <form action="{{ route('admin.rejectUser', $user->id) }}" method="post">
                                    @csrf
                                    <button onclick="rejectUser(event)" type="submit" class="p-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition duration-300">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $users->links('pagination::tailwind') }}
            </div>
        @endif
    </div>
@endsection

<script>
    const rejectUser = (e) => {
        if (!confirm('Are you sure you want to reject this user?')) {
            e.preventDefault()
        }
    }

    const confirmUser = (e) => {
        if (!confirm('Are you sure you want to confirm this user?')) {
            e.preventDefault()
        }
    }
</script>
