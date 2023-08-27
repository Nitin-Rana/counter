<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\CounterUpdated;
use App\Models\Counter;

use App\Http\Controllers\CounterController;

Route::get('/welcome', function () {
    return response()->json(['message' => 'Welcome to the API!']);
});
// Route::post('/increase-counter', [CounterController::class, 'increaseCounter']);

Route::post('/increase-counter', function () {
    try {
        // Try to find an existing counter record
        $counter = Counter::first();

        if (!$counter) {
            // If no record exists, create a new one
            $counter = new Counter();
        }

        // Update the counter
        $counter->count += 1;
        $counter->save();

        // Broadcast the updated value
        event(new CounterUpdated($counter));

        return response()->json(['message' => 'Counter updated successfully']);
    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
});
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
