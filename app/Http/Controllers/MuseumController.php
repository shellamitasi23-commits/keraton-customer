<?php

namespace App\Http\Controllers;

use App\Models\Museum;
use Illuminate\Http\Request;

class MuseumController extends Controller
{
    public function index()
    {
        $museums = Museum::latest('created_at')->get();
        return view('customer.pages.museum', compact('museums'));
        // SESUAIKAN dengan path view Anda
        // Kalau view ada di customer/museum.blade.php
    }
}