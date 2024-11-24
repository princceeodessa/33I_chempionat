<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
</head>
<body>
<h2>Авторизация</h2>

<form action="{{ route('login') }}" method="POST">
    @csrf
    <label for="email">Электронная почта</label>
    <input type="email" name="email" required><br>

    <label for="password">Пароль</label>
    <input type="password" name="password" required><br>

    <button type="submit">Войти</button>
</form>
<p>Нет аккаунта? <a href="{{ route('registerForm') }}">Зарегистрироваться</a></p>
@if($errors->any())
    <p>{{ $errors->first() }}</p>
@endif
</body>
</html>
