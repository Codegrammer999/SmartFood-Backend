@extends('layout.base')

@section('content')
<div>
    <a class="bg-[#ef6002] text-white py-2 px-6 rounded-md" href="{{ route('admin.show-menu')}}">New &plus;</a>

    <div class="text-white">
        @forelse ($menus as $menu)
            <p>{{ $menu->name }}</p>
        @empty
            <p class="text-center p-10 text-lg opacity-70">No groceries found</p>
        @endforelse
    </div>
</div>
@endsection
