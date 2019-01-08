<?php

namespace App\Http\Controllers;

use App\Monitor;

class ApiMonitorController extends Controller
{
    public function index() {
        return Monitor::all();
    }

    public function show($id) {
        return Monitor::find($id);
    }

}
