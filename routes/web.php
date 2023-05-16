<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\FriendRequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LobbyController;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('web');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // Send friend request
    Route::post('/friend-request/{receiver}', [FriendRequestController::class, 'sendFriendRequest'])->name('friend-request.send');

    // Accept friend request
    Route::post('/friend-request/{sender}/accept', [FriendRequestController::class, 'acceptFriendRequest'])->name('friend-request.accept');

    // Reject friend request
    Route::post('/friend-request/{sender}/reject', [FriendRequestController::class, 'rejectFriendRequest'])->name('friend-request.reject');

    // Index & Join Lobby
    Route::get('/', [LobbyController::class, 'index'])->name('lobby.index');
    Route::post('/join', [LobbyController::class, 'join'])->name('lobby.join');

    // Create Lobby
    Route::post('/create-lobby', [LobbyController::class, 'create'])->name('lobby.create');

    // Leave lobby
    Route::post('/lobby/leave', [LobbyController::class, 'leave'])->name('lobby.leave')->middleware('auth');
});
