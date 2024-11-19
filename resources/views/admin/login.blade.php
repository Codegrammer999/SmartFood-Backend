@extends('layout.base')

@section('content')
<div class="flex items-center justify-center pt-8 bg-[#18082f]">
    <form method="post" action="{{ route('admin.login') }}" class="w-full max-w-md lg:max-w-2xl p-4 bg-[#18082f] rounded-lg shadow-lg space-y-4 backdrop-blur-lg bg-white/10">
        @csrf

        <h2 class="text-2xl font-semibold text-center text-white">Admin Login</h2>

        <div class="flex flex-col">
            <label for="username" class="text-white mb-1">Username</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
            @error('username')
                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col">
            <label for="password" class="text-white mb-1">Password</label>
            <input id="password" type="password" name="password" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
            @error('password')
                <span class="text-red-600 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        @error('invalid')
            <p class="text-red-600 text-center">{{ $message }}</p>
        @enderror

        <div>
            <button type="submit" class="w-full p-3 bg-[#ef6002] text-white font-semibold rounded hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-700">
                Login
            </button>
        </div>
    </form>
</div>
@endsection
