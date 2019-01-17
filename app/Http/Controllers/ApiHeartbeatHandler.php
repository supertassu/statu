<?php

namespace App\Http\Controllers;

use App\Monitor;
use App\MonitorCallback;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiHeartbeatHandler extends Controller
{
    public function handleHeartbeat(Request $request) {
        $key = $request->input('key');

        if (!$key || empty($key)) {
            return response()->json(['error' => 'Missing GET param `key`'], 400);
        }

        $monitorId = $request->input('monitor');

        if (!$monitorId || empty($monitorId)) {
            return response()->json(['error' => 'Missing GET param `monitor`'], 400);
        }

        $monitor = Monitor::find($monitorId);

        if (!$monitor) {
            return response()->json(['error' => 'Monitor not found'], 404);
        }

        $callback = MonitorCallback::where('monitor_id', $monitor->id)->first();

        if (!$callback) {
            return response()->json(['error' => 'This monitor does not support heartbeats.'], 412);
        }

        if ($callback->key !== $key) {
            return response()->json(['error' => 'Invalid key'], 403);
        }

        $callback->last_callback = Carbon::now()->toIso8601String();
        $callback->save();

        return response()->json(['success' => true]);
    }
}
