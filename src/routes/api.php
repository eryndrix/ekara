<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    /** @var \App\Account\Domain\User|null $user */
    $user = $request->user();

    return response()->json([
        'id' => $user?->id->value(),
        'email' => (string) $user?->email,
        'first_name' => $user?->firstName,
        'last_name' => $user?->lastName,
    ]);
})->middleware('auth:sanctum');
