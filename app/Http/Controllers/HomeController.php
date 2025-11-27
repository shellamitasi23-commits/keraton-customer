<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Data Area Wisata (Sesuai gambar Home.jpg)
        $areas = [
            [
                'title' => 'Museum Keraton',
                'desc' => 'Perpaduan gaya arsitektur Jawa, Islam, dan Tiongkok yang mencerminkan akulturasi budaya.',
                'image' => 'images/bangunan-museum.jpg'
            ],
            [
                'title' => 'Museum AI',
                'desc' => 'Teknologi modern yang menghidupkan kembali sejarah masa lalu dengan interaktif.',
                'image' => 'images/museum-AI.png'
            ],
            [
                'title' => 'Dalem Agung',
                'desc' => 'Bangunan utama tempat tinggal Sultan yang penuh dengan nilai sejarah.',
                'image' => 'images/dalem-agung.jpg'
            ],
        ];

        return view('pages.home', compact('areas'));
    }
}