<?php
// routes/api.php
use App\Http\Controllers\Api\CartController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/cart/add/{book}', [CartController::class, 'add']);
    Route::delete('/cart/remove/{book}', [CartController::class, 'remove']);
    Route::get('/cart/count', [CartController::class, 'count']);
});
