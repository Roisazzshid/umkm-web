<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class UmkmController extends Controller
{
    public function index(Request $request)
    {
        $stores = Store::orderBy('created_at', 'desc')->get();
        return view('admin.umkm.index', compact('stores'));
    }

    public function show($id)
    {
        $store = Store::findOrFail($id);
        return view('admin.umkm.verifikasi', compact('store'));
    }

    public function verify(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $action = $request->input('action'); // setujui, tolak, nonaktif, aktifkan

        $status = 'Menunggu';
        if ($action === 'setujui' || $action === 'aktifkan') {
            $status = 'Aktif';
        } elseif ($action === 'tolak') {
            $status = 'Nonaktif'; // treated as rejected/inactive
        } elseif ($action === 'nonaktif') {
            $status = 'Nonaktif';
        }

        $store->update(['status' => $status]);

        return redirect()->route('admin.umkm.index', ['berhasil' => $action]);
    }
}
