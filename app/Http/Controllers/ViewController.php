<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ViewController extends Controller
{
    /**
     * @param Request $request
     * @return \Response
     */
    public function index(Request $request) {
        $theme = $request->query('theme') ? $request->query('theme') : config('statu.default-theme', 'light');

        if (!in_array($theme, ['light', 'dark'])) {
            $theme = config('statu.default-theme', 'light');
        }

        return view('welcome', ['theme' => $theme]);
    }
}
