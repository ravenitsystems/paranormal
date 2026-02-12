<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/search', function () {
    return view('welcome');
});

Route::get('/api/user', function () {
    $user = auth()->user();
    if (!$user) {
        return response()->json(['user' => null]);
    }
    return response()->json([
        'user' => [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ],
    ]);
});
