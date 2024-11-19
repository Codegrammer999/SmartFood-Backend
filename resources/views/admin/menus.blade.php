@extends('layout.base')

@section('content')

    <form action="{{ route('admin.create-menu') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name">
        <input type="text" name="category" placeholder="Category">
        <input type="text" name="description" placeholder="Description">
        <input type="file" name="image" placeholder="Image">
        <input type="number" name="price" placeholder="Price">
        <input type="number" name="priceOff" placeholder="PriceOff">
        <button>Add Menu</button>
    </form>
    
@endsection

