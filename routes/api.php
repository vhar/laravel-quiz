<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', function (Request $request) {

    $user = \App\Models\User::where(
        'email',
        $request->email
    )->first();

    if (!$user || !\Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'Invalid credentials'
        ], 401);
    }

    $token = $user->createToken('api-token')->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user
    ]);
});

Route::post('/logout', function (Request $request) {

    $request->user()
        ->currentAccessToken()
        ->delete();

    return response()->json([
        'message' => 'Logged out'
    ]);
})
    ->middleware('auth:sanctum');