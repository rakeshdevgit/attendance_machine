<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::middleware('api')->group(function () {
    Route::post('/essl/push', function (Request $request) {

        // Log raw data
        Log::info('ESSL Push', $request->all());

        DB::table('attendances')->insert([
            'device_id' => $request->deviceid ?? '',
            'employee_code' => $request->cardno ?? '',
            'punch_time' => $request->timestamp ?? now(),
            'status' => $request->status ?? '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['status' => 'OK']);
    });
});
