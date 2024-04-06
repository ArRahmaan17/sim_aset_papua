<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PenyusutanController extends Controller
{
    public function index()
    {
        return view('layout.penyusutan.index');
    }
}
