<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalendarController;


Route::get('/', function () {
    return auth()->check() ? redirect()->route('calendar.index') : redirect()->route('home');
})->name('home');
Route::get('login', [AuthController::class, 'loginForm'])->name('home');  // 'home' - для входа
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'registerForm'])->name('registerForm');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::get('/calendar', [CalendarController::class, 'getEvents'])->name('calendar.index')->middleware('auth');
Route::get('/calendar/{date}', [CalendarController::class, 'getEventsByDate'])->name('calendar.date')->middleware('auth');
Route::post('/calendar/add', [CalendarController::class, 'addUserEvent'])->name('calendar.add')->middleware('auth');
Route::put('/calendar/update/{id}', [CalendarController::class, 'updateEvent'])->name('calendar.update')->middleware('auth');
Route::get('/profile', [CalendarController::class, 'getUserProfile'])->name('user.profile')->middleware('auth');
