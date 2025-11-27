<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketTransaction;
use App\Models\Order; // <--- Tambahkan Model Order
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();

        // 1. Ambil Data Tiket
        $tickets = TicketTransaction::where('user_id', $user_id)
            ->where('status', 'paid')
            ->with('ticket_category')
            ->latest()
            ->get();

        // 2. Ambil Data Merchandise (Order) - BARU
        $orders = Order::where('user_id', $user_id)
            ->where('status', 'paid')
            ->with('items.product') // Load detail barangnya
            ->latest()
            ->get();

        return view('pages.profile.index', compact('tickets', 'orders'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            // 1. Hapus foto lama jika ada (biar server gak penuh)
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // 2. Simpan foto baru
            $path = $request->file('avatar')->store('avatars', 'public');

            // 3. Update database
            $user->update(['avatar' => $path]);
        }

        return back()->with('success', 'Foto profil berhasil diperbarui!');
    }
}