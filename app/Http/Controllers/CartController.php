<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $cartItems = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->where('cart_items.user_id', $userId)
            ->where('cart_items.status', 1) // Tambahkan kondisi untuk status
            ->select('products.*', 'cart_items.*')
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
        // Validasi data
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
        ]);

        // Tambahkan status ke data
        $data['status'] = 1;
        $data['jumlah'] = 1;

        // Cek apakah item dengan product_id sudah ada di keranjang
        $existingCartItem = CartItem::where('product_id', $data['product_id'])
            ->where('user_id', $data['user_id'])
            ->where('status', 1)
            ->first();

        if ($existingCartItem) {
            // Jika sudah ada, tambahkan jumlah
            $existingCartItem->jumlah += 1;
            $existingCartItem->save();
        } else {
            // Jika belum ada, tambahkan item baru ke keranjang
            CartItem::create($data);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function destroy($id)
    {
        // Temukan item keranjang belanja berdasarkan ID
        $cartItem = CartItem::find($id);

        // Pastikan item ditemukan sebelum menghapusnya
        if ($cartItem) {
            // Periksa status sebelum menghapus
            if ($cartItem->status == 1) {
                // Ubah status menjadi 0
                $cartItem->status = 0;
                $cartItem->save();

                return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dari keranjang.');
            } else {
                return redirect()->route('cart.index')->with('error', 'Item tidak dapat dihapus karena status bukan 1.');
            }
        }

        // Jika item tidak ditemukan, Anda dapat mengarahkannya ke halaman yang sesuai
        return redirect()->route('cart.index')->with('error', 'Item tidak ditemukan.');
    }
}