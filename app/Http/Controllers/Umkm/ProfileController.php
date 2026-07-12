<?php

namespace App\Http\Controllers\Umkm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        return view('umkm.profil', compact('store'));
    }

    public function update(Request $request)
    {
        $store = Auth::user()->store;

        $request->validate([
            'nama_toko' => 'required|string|max:255',
            'wa_toko' => 'required|string|max:20',
            'alamat_toko' => 'required|string',
            'deskripsi_toko' => 'required|string',
            'logo_toko' => 'nullable|image|max:2048',
        ]);

        $logoPath = $store->logo;
        if ($request->hasFile('logo_toko')) {
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            $logoPath = $request->file('logo_toko')->store('logos', 'public');
        }

        $store->update([
            'name' => $request->nama_toko,
            'phone' => $request->wa_toko,
            'address' => $request->alamat_toko,
            'description' => $request->deskripsi_toko,
            'logo' => $logoPath,
        ]);

        return response()->json(['success' => true]);
    }
}
