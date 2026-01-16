<?php

namespace App\Http\Controllers;

use App\Models\Museum;
use Illuminate\Http\Request;

class MuseumController extends Controller
{
    public function index()
    {
        // Mengambil data yang baru di-CRUD Admin dari database
        $museums = Museum::all();

        return view('customer.pages.museum', compact('museums'));
    }
}