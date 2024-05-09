<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notif;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotifController extends Controller
{
    public function index()
    {
        $notif = DB::table('notif')
            ->join('users', 'notif.user_id', '=', 'users.id')
            ->where('notif.admin', 0) // Tambahkan kondisi untuk status
            ->select('notif.*', 'users.id as uid', 'users.name as user_name')
            ->get();
    
        return response()->json([
            'message' => 'Data notif berhasil diambil',
            'data' => $notif,
        ], 200);
    }

    public function show($id)
    {
        // Mendapatkan pengguna aktif
        $userId = $id;
        // Menampilkan chat dari pengguna aktif dan "admin"
    
        $notif = DB::table('notif')
            ->where('user_id', $userId)
            ->select('notif.*')
            ->get();
    
        return response()->json([
            'message' => 'Data notif berhasil diambil',
            'id' => $userId,
            'data' => $notif,
        ], 200);
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'pesan' => 'required',
            'status' => 'required',
            'admin' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        // Buat pesan baru
        $notif = Notif::create($data);

        return response()->json([
            'message' => 'Notif berhasil disimpan',
            'data' => $notif,
        ], 201);
    }
}
