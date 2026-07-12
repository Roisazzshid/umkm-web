<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Special check for UMKM status
            if ($user->role === 'umkm') {
                $store = $user->store;
                if ($store) {
                    if ($store->status === 'Menunggu') {
                        Auth::logout();
                        return redirect()->route('login', ['status' => 'menunggu']);
                    } elseif ($store->status === 'Nonaktif') {
                        Auth::logout();
                        return redirect()->route('login', ['status' => 'ditolak']);
                    }
                }
            }

            return $this->redirectBasedOnRole($user);
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->onlyInput('username');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function registerUmkm(Request $request)
    {
        $request->validate([
            'nama_umkm' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email_usaha' => 'required|email|unique:users,email|max:255',
            'nomor_wa' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'alamat_toko' => 'required|string',
            'deskripsi_usaha' => 'required|string',
            'logo_umkm' => 'nullable|image|max:2048',
        ]);

        $user = User::create([
            'name' => $request->nama_pemilik,
            'username' => $request->username,
            'email' => $request->email_usaha,
            'password' => Hash::make($request->password),
            'role' => 'umkm',
            'phone' => $request->nomor_wa,
            'address' => $request->alamat_toko,
        ]);

        $logoPath = null;
        if ($request->hasFile('logo_umkm')) {
            $logoPath = $request->file('logo_umkm')->store('logos', 'public');
        }

        Store::create([
            'user_id' => $user->id,
            'name' => $request->nama_umkm,
            'owner_name' => $request->nama_pemilik,
            'phone' => $request->nomor_wa,
            'address' => $request->alamat_toko,
            'description' => $request->deskripsi_usaha,
            'logo' => $logoPath,
            'status' => 'Menunggu',
        ]);

        return response()->json(['success' => true]);
    }

    public function registerCustomer(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'nomor_wa' => 'required|string|max:20',
            'alamat' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer',
            'phone' => $request->nomor_wa,
            'address' => $request->alamat,
        ]);

        return response()->json(['success' => true]);
    }


    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'umkm') {
            return redirect()->route('umkm.dashboard');
        } else {
            return redirect()->route('home');
        }
    }
}
