<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Register Page</title>
    <style>
        body {
            background-color: black;
            color: white;
        }
    </style>
</head>
<body>
    <form action="/register" method="post">
        @csrf
        <input type="text" name="name">
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <input type="password" name="password_confirmation" placeholder="Confirm Password">
        <button>Login</button>

        @if ($errors->any())
        @foreach ($errors->all() as $error)
        {{ $error }}
        @endforeach
        @endif
    </form>
</body>
</html>
