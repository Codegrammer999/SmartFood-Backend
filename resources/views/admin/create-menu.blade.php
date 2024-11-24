@extends('layout.base')

@section('content')
<div class="flex items-center justify-center bg-[#18082f]">
    <form method="post" action="{{ route('admin.create-menu') }}" enctype="multipart/form-data" class="w-full max-w-md lg:max-w-2xl p-4 bg-[#18082f] rounded-lg shadow-lg space-y-4 backdrop-blur-lg bg-white/10">
        @csrf

        <h2 class="text-2xl font-semibold text-center text-white">Add new menu</h2>

        <div class="flex flex-col">
            <label for="name" class="text-white mb-1">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
            @error('name')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col">
            <select name="category" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
                <option value="" selected>Select a category</option>
                <option value="Drinks">Drinks</option>
                <option value="Cooked Food">Cooked Food</option>
                <option value="Raw Food">Raw Food</option>
                <option value="Frozen Foods">Frozen Foods</option>
                <option value="Vegetables">Vegetables</option>
                <option value="Fruits">Fruits</option>
            </select>
            @error('category')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col">
            <label for="price" class="text-white mb-1">Price</label>
            <input id="price" type="number" value="{{ old('price') }}" name="price" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
            @error('price')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col">
            <label for="priceOff" class="text-white mb-1">Discount</label>
            <input id="priceOff" type="number" value="{{ old('priceOff') }}" name="priceOff" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
            @error('priceOff')
                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex flex-col">
            <label for="image" class="text-white mb-1">Image</label>
            <input id="image" type="file" name="image" required class="p-3 rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]">
            @error('image')
                <span class="text-red-500 text-sm font-semibold mt-1">{{ $message }}</span>
            @enderror
        </div>


        <div class="flex flex-col">
            <label for="description" class="text-white mb-1">Description</label>
            <textarea id="description" name="description" value="{{ old('description') }}" required class="h-40 p-2 w-full rounded bg-[#18082f] border border-gray-600 text-white focus:outline-none focus:ring-2 focus:ring-[#ef6002]"></textarea>
            @error('description')
                <span class="text-red-500 text-sm font-semibold mt-1">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <button type="submit" class="w-full p-3 bg-[#ef6002] text-white font-semibold rounded hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-orange-700">
                Add
            </button>
        </div>
    </form>
</div>
@endsection
