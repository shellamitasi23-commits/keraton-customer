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
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'nama.required' => 'Nama museum wajib diisi',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'foto.image' => 'File harus berupa gambar',
            'foto.max' => 'Ukuran foto maksimal 2MB'
        ]);

        try {
            $data = [
                'nama' => $validated['nama'],
                'deskripsi' => $validated['deskripsi'],
            ];

            if ($request->hasFile('foto')) {
                $data['foto'] = $request->file('foto')->store('museum', 'public');
            }

            Museum::create($data);

            return back()->with('success', 'Museum berhasil ditambahkan!');

        } catch (\Exception $e) {
            \Log::error('Museum creation error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menambahkan museum: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Museum $museum)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        try {
            $data = [
                'nama' => $validated['nama'],
                'deskripsi' => $validated['deskripsi'],
            ];

            if ($request->hasFile('foto')) {
                // Hapus foto lama
                if ($museum->foto && Storage::disk('public')->exists($museum->foto)) {
                    Storage::disk('public')->delete($museum->foto);
                }
                $data['foto'] = $request->file('foto')->store('museum', 'public');
            }

            $museum->update($data);

            return back()->with('success', 'Data Museum berhasil diperbarui!');

        } catch (\Exception $e) {
            \Log::error('Museum update error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui museum: ' . $e->getMessage());
        }
    }
    public function show(Museum $museum)
    {
        return view('admin.museum.show', compact('museum'));
    }
    public function destroy(Museum $museum)
    {
        try {
            if ($museum->foto && Storage::disk('public')->exists($museum->foto)) {
                Storage::disk('public')->delete($museum->foto);
            }

            $museum->delete();

            return back()->with('success', 'Museum berhasil dihapus!');

        } catch (\Exception $e) {
            \Log::error('Museum delete error: ' . $e->getMessage());
            return back()->with('error', 'Gagal menghapus museum: ' . $e->getMessage());
        }
    }
}