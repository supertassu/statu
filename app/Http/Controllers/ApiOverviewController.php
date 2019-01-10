<?php

namespace App\Http\Controllers;

use App\Category;
use App\Maintenance;
use App\Monitor;
use App\Incident;

class ApiOverviewController extends Controller
{
    public function index() {
        return [
            'categories' => Category::all(),
            'incidents' => Incident::all(),
            'maintenances' => Maintenance::all(),
            'monitors' => Monitor::all()
        ];
    }
}
