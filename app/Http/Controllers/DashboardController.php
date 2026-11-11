<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function mahasiswa()
    {
        return view('dashboard.mahasiswa');
    }

    public function staff()
    {
        return view('dashboard.staff');
    }
}