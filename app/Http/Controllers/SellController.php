<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sell;
use Illuminate\Support\Facades\DB;

class SellController extends Controller
{
    public function index()
    {
        $selling = DB::table('sells')
            ->join('products', 'sells.product_id', '=', 'products.id')
            ->join('users', 'sells.user_id', '=', 'users.id')
            ->select('sells.*', 'products.*', 'users.name as user_name')
            ->get();
        return view('sell', compact('selling'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'total' => 'required',
            'alamat' => 'required',
        ]);

        Sell::create($data);

        return redirect('tq')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function status(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);
    
        // Update data produk
        $sell = Sell::findOrFail($data['id']);
        $sell->fill($data);
        $sell->save();

        return redirect()->route('sell.index')->with('success', 'Produk berhasil diperbarui.');
    }
}
