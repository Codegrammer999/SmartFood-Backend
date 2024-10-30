<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Login Page</title>
    <style>
        body {
            background-color: black
        }
    </style>
</head>
<body class="bg-blue-500">
    <form action="/login" method="post">
        @csrf
        <input type="email" name="email" placeholder="Email">
        <input type="password" name="password" placeholder="Password">
        <button>Login</button>
    </form>
</body>
</html>
