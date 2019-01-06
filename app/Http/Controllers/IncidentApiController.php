<?php

namespace App\Http\Controllers;

use App\Incident;
use Illuminate\Http\Request;

class IncidentApiController extends Controller
{
    public function index()
    {
        return Incident::all();
    }

    public function show($id) {
        return Incident::find($id);
    }

}
