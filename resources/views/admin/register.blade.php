@extends('layout.base')

@section('content')
<div class="flex items-center justify-center bg-[#18082f]">
    <form method="post" action="{{ route('admin.register') }}" class="w-full max-w-md lg:max-w-2xl p-4 bg-[#18082f] rounded-lg shadow-lg space-y-4 backdrop-blur-lg bg-white/10">
        @csrf

        <h2 class="text-2xl font-semibold text-center text-white">Admin Registration</h2>

        <!-- Name -->
        <div class="flex flex-col">
            <label for="username" class="text-white mb-1">Username</label>
            <input id="username" type="text" name="username" value="{{ old('username') }}" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
            @error('username')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email -->
        <div class="flex flex-col">
            <label for="email" class="text-white mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
            @error('email')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="flex flex-col">
            <label for="password" class="text-white mb-1">Password</label>
            <input id="password" type="password" name="password" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
            @error('password')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="flex flex-col">
            <label for="password_confirmation" class="text-white mb-1">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
            @error('password_confirmation')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Admin Password -->
        <div class="flex flex-col">
            <label for="access_code" class="text-white mb-1">Access Code</label>
            <input id="access_code" type="password" name="access_code" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
            @error('access_code_error')
                <span class="text-red-500 text-sm font-semibold mt-1">{{ $message }}</span>
            @enderror
        </div>

        <!-- Register Button -->
        <div>
            <button type="submit" class="w-full p-3 bg-[#ef6002] text-white font-semibold rounded hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-700">
                Register
            </button>
        </div>
    </form>
</div>
@endsection
