<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
</head>
<body>
    <form action="/create-menu" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="name">
        <input type="text" name="category" placeholder="Category">
        <input type="text" name="description" placeholder="Description">
        <input type="file" name="image" placeholder="Image">
        <input type="number" name="price" placeholder="Price">
        <input type="number" name="priceOff" placeholder="PriceOff">
        <button>Add Menu</button>
    </form>

    <form action="/logout" method="post">
        @csrf
        <button>Logout</button>
    </form>

    @if ($errors->any())
    @foreach ($errors->all() as $error)
    {{ $error }}
    @endforeach
    @endif
</body>
</html>
