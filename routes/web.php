<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PortfolioController;

// ---- Landing / SaaS home ----
Route::livewire('/', 'pages::landing')->name('home');

// ---- Auth ----
Route::livewire('/login',            'pages::login')->name('login');
Route::livewire('/register',         'pages::register')->name('register');
Route::livewire('/forgot-password',  'pages::forgot-password')->name('forgot-password');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// ---- Authenticated dashboard ----
Route::livewire('/dashboard', 'pages::dashboard')
    ->middleware('auth')
    ->name('dashboard');

// ---- Admin panel ----
Route::livewire('/admin', 'pages::admin')
    ->middleware(['auth', 'admin'])
    ->name('admin');

Route::livewire('/analytics', 'pages::analytics')
    ->middleware('auth')
    ->name('analytics');

// ---- Public portfolio by username ----
Route::get('/u/{username}', [PortfolioController::class, 'show'])
    ->name('portfolio.public');
