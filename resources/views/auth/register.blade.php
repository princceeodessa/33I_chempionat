<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
</head>
<body>
<h2>Регистрация</h2>

<form action="{{ route('register') }}" method="POST">
    @csrf
    <label for="username">Имя пользователя</label>
    <input type="text" name="username" required><br>

    <label for="email">Электронная почта</label>
    <input type="email" name="email" required><br>

    <label for="password">Пароль</label>
    <input type="password" name="password" required><br>

    <label for="password_confirmation">Подтверждение пароля</label>
    <input type="password" name="password_confirmation" required><br>

    <button type="submit">Зарегистрироваться</button>
</form>
<p>Уже есть аккаунт? <a href="{{ route('home') }}">Войти</a></p>
@if(session('message'))
    <p>{{ session('message') }}</p>
@endif
</body>
</html>
