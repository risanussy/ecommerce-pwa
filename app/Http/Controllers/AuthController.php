<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import model User
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Menggunakan tampilan login
    }
    
    public function showRegistrationForm()
    {
        return view('auth.register'); // Menggunakan tampilan pendaftaran
    }
    
    public function register(Request $request)
    {
        // Validasi data
        $this->validate($request, [
            'name' => 'required',
            'nik' => 'required',
            'role' => 'required',
            'alamat' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    
        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'nik' => $request->nik,
            'role' => $request->role,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Enkripsi password
        ]);
    
        // Login user setelah pendaftaran
        Auth::login($user);
    
        // Redirect ke halaman yang sesuai
        return redirect('/');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('nik', 'password');
    
        if (Auth::attempt($credentials)) {
            // Jika berhasil login
    
            if (Auth::check()) {
                // Cek apakah pengguna yang login adalah admin atau manager
                if (Auth::user()->role == 'admin') {
                    return redirect('/admin/sell'); // Jika admin atau manager, arahkan ke /admin/sell
                } else if (Auth::user()->role == 'manager') {
                    return redirect('/admin/sell'); // Jika admin atau manager, arahkan ke /admin/sell
                } else {
                    return redirect('/'); // Jika bukan admin atau manager, arahkan ke halaman utama
                }
            } else {
                // Tambahkan penanganan jika pengguna tidak login
                return redirect('/');
            }
            
        } else {
            // Jika gagal login
            return back()->withErrors(['message' => 'Invalid credentials']);
        }
    }
    
    public function logout(Request $request)
    {
        Auth::logout(); // Keluar (logout) pengguna
        $request->session()->invalidate(); // Memadamkan sesi
        $request->session()->regenerateToken(); // Membuat token sesi baru
    
        return redirect('/'); // Redirect ke halaman login setelah keluar
    }

    public function showUserName()
    {
        $usersDatas = DB::table('users')
            ->select('users.*')
            ->where('name', '!=', 'admin')
            ->get();
    
        return view('list', ['usersDatas' => $usersDatas]);
    }

    public function profil()
    {
        return view('profil');
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'no_hp' => 'required',
            'alamat' => 'required',
            'foto' => 'image',
        ]);

        // Jika ada foto baru, simpan ke folder public/product
        if($request->hasFile('foto')){
            $image = $request->file('foto');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile'), $imageName);
            $data['foto'] = $imageName;
        }

        // Update data produk
        $profil = User::findOrFail($id);
        $profil->update($data);

        return redirect()->route('profil')->with('success', 'Produk berhasil diperbarui.');
    }
}