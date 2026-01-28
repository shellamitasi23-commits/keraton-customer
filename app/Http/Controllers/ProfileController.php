<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketTransaction;
use App\Models\Order;
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

        return view('customer.pages.profile.index', compact('tickets', 'orders'));
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        // Cek apakah ada file avatar atau data profile lainnya
        if ($request->hasFile('avatar')) {
            $request->validate([
                'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // 1. Hapus foto lama jika ada
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // 2. Simpan foto baru
            $path = $request->file('avatar')->store('avatars', 'public');

            // 3. Update database
            $user->update(['avatar' => $path]);

            return redirect()->route('profile.index')->with('success', 'Foto profil berhasil diupdate!');
        }

        // Update data profil (nama, email, phone)
        if ($request->has('name') || $request->has('email') || $request->has('phone')) {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'required|string|max:20',
            ]);

            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Profil berhasil diupdate!'
                ]);
            }

            return redirect()->route('profile.index')->with('success', 'Profil berhasil diupdate!');
        }

        return back();
    }
}
