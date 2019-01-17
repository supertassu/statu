<?php

namespace App\Http\Controllers;

use App\Monitor;
use Illuminate\Http\Request;

class ApiMonitorController extends Controller
{

    public function update(Request $request, $id) {
        $apiKey = $request->input('api-key');

        if (!$apiKey || empty($apiKey)) {
            return response()->json(['error' => 'Missing GET param `api-key`'], 400);
        }

        if (!in_array($apiKey, config('statu.api-keys'))) {
            return response()->json(['error' => 'Invalid API key'], 403);
        }

        $state = $request->input('state');

        if (!$state || empty($state)) {
            return response()->json(['error' => 'Missing GET param `state`'], 400);
        }

        $state = filter_var($state, FILTER_VALIDATE_BOOLEAN);

        $monitor = Monitor::find($id);

        if (!$monitor) {
            return response()->json(['error' => 'Monitor not found'], 404);
        }

        $monitor->last_status = $state;
        $monitor->save();

        return $monitor;
    }

}
