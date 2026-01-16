<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Museum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MuseumManagementController extends Controller
{
    public function index()
    {
        $museums = Museum::latest('created_at')->get();
        return view('admin.museum.index', compact('museums'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('museum', 'public');
        }

        Museum::create($data);
        return back()->with('success', 'Museum berhasil ditambahkan!');
    }

    public function update(Request $request, Museum $museum)
    {
        $data = $request->all();
        if ($request->hasFile('foto')) {
            if ($museum->foto)
                Storage::disk('public')->delete($museum->foto);
            $data['foto'] = $request->file('foto')->store('museum', 'public');
        }

        $museum->update($data);
        return back()->with('success', 'Data Museum diperbarui!');
    }

    public function destroy(Museum $museum)
    {
        if ($museum->foto)
            Storage::disk('public')->delete($museum->foto);
        $museum->delete();
        return back()->with('success', 'Museum dihapus!');
    }
}