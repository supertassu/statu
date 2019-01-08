<?php

namespace App\Http\Controllers;

use App\Incident;

class ApiIncidentController extends Controller
{
    public function index() {
        return Incident::all();
    }

    public function show($id) {
        return Incident::find($id);
    }

}
