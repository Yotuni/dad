<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemoryGameController extends Controller
{
    public function index()
    {
        return view('vue.lobby');
    }
}
