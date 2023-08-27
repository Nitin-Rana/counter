<?php

namespace App\Http\Controllers;
use App\Events\CounterUpdated;
use App\Models\Counter;

use Illuminate\Http\Request;

class CounterController extends Controller
{
    public function increaseCounter()
    {
        $counter = Counter::firstOrFail();
        $counter->count += 1;
        $counter->save();

        // Broadcast the updated value
        event(new CounterUpdated($counter));

        return response()->json(['message' => 'Counter updated successfully']);
    }
}
