<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MuseumController extends Controller
{
    public function index()
    {
        // Data Koleksi Museum (Sesuai gambar Museum.jpg)
        $collections = [
            ['name' => 'Kereta Singa Barong', 'desc' => 'Kereta kencana pusaka kesultanan yang ditarik oleh 4 kerbau bule.', 'image' => 'singa-barong.jpg'],
            ['name' => 'Gamelan Sekaten', 'desc' => 'Perangkat gamelan sakral yang hanya ditabuh pada perayaan Maulid Nabi.', 'image' => 'gong-sekati.jpg'],
            ['name' => 'Lukisan Prabu Siliwangi', 'desc' => 'Lukisan legendaris yang mata objeknya seolah mengikuti arah pandang kita.', 'image' => 'lukisan.jpg'],
            ['name' => 'Tombak Pusaka', 'desc' => 'Senjata pusaka peninggalan para prajurit keraton masa lampau.', 'image' => 'tombak-pusaka.jpg'],
            ['name' => 'Keramik Tiongkok', 'desc' => 'Koleksi piring dan guci hadiah dari kekaisaran China masa lampau.', 'image' => 'keramik-tiongkok.png'],
            ['name' => 'Baju Zirah', 'desc' => 'Pakaian perang yang digunakan panglima perang kesultanan Cirebon.', 'image' => 'baju-zirah.jpg'],
        ];

        return view('pages.museum', compact('collections'));
    }
}