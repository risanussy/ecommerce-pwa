<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->join('users', 'cart_items.user_id', '=', 'users.id')
            ->select( 'products.*', 'cart_items.*','users.name as user_name')
            ->get();
        return view('cart', compact('cartItems'));
    }
    
    public function show($id)
    {
        $cartItems = CartItem::findOrFail($id);
    
        return view('pay', compact('cartItems'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
        ]);

        CartItem::create($data);

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function destroy($id)
    {
        // Temukan item keranjang belanja berdasarkan ID
        $cartItem = CartItem::find($id);

        // Pastikan item ditemukan sebelum menghapusnya
        if ($cartItem) {
            $cartItem->delete();

            return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        // Jika item tidak ditemukan, Anda dapat mengarahkannya ke halaman yang sesuai
        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan.');
    }
}