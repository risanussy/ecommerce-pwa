<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index()
    {
        $chats = DB::table('chats')
            ->join('users', 'chats.user_id', '=', 'users.id')
            ->where('chats.admin', 0) // Tambahkan kondisi untuk status
            ->select('chats.*', 'users.id as uid', 'users.name as user_name')
            ->get();

        return view('chat', compact('chats'));
    }

    public function show($id)
    {
        // Mendapatkan pengguna aktif
        $userId = $id;
        // Menampilkan chat dari pengguna aktif dan "admin"
    
        $chats = DB::table('chats')
            ->where('user_id', $userId)
            ->select('chats.*')
            ->get();
    
        return response()->json([
            'message' => 'Data chat berhasil diambil',
            'id' => $userId,
            'data' => $chats,
        ], 200);
    }
    
    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'pesan' => 'required',
            'admin' => 'required',
            'user_id' => 'required|exists:users,id',
        ]);

        // Buat pesan baru
        $chat = Chat::create($data);

        return response()->json([
            'message' => 'Pesan berhasil disimpan',
            'data' => $chat,
        ], 201);
    }
}
