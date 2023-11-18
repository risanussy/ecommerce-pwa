<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $cartItems = DB::table('transactions')
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.user_id', $userId)
            ->where('transactions.status', 1) // Tambahkan kondisi untuk status
            ->select('products.*', 'transactions.*')
            ->get();

        return view('cart', compact('cartItems'));
    }

    public function sell()
    {
        $selling = DB::table('transactions')
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->where('transactions.status', 2) // Tambahkan kondisi untuk status
            ->select('products.*', 'transactions.*', 'users.*', 'users.name as user_name', 'transactions.id as pid')
            ->get();

        return view('sell', compact('selling'));
    }

    public function kirim($id)
    {
        $this->updateProcess($id, 2); // Update process menjadi 2 (Dikirimkan)

        return redirect()->route('cart.sell')->with('success', 'Penjualan berhasil dikirimkan.');
    }

    public function selesai($id)
    {
        $this->updateProcess($id, 3); // Update process menjadi 3 (Selesai)

        return redirect()->route('cart.sell')->with('success', 'Penjualan berhasil diselesaikan.');
    }

    public function canceled($id)
    {
        $this->updateProcess($id, 0); // Update process menjadi 0 (Canceled)

        return redirect()->route('cart.sell')->with('success', 'Penjualan berhasil dibatalkan.');
    }

    // Fungsi untuk mengupdate status di database
    private function updateProcess($id, $process)
    {
        $transaction = Transaction::findOrFail($id);

        if ($transaction) {
            $transaction->process = $process;
            $transaction->save();
        }
    }
    
    public function show($id)
    {
        $cartItems = Transaction::findOrFail($id);
    
        return view('pay', compact('cartItems'));
    }

    public function buy(Request $request)
    {
        // Validasi data
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'total' => 'required',
        ]);

        // Tambahkan status ke data
        $data['status'] = 2;
        $data['quantity'] = 1;
        $data['process'] = 1;

        // Jika belum ada, tambahkan item baru ke keranjang
        Transaction::create($data);

        return redirect('tq')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
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
        $data['total'] = 0;
        $data['quantity'] = 1;
        $data['process'] = 0;

        // Cek apakah item dengan product_id sudah ada di keranjang
        $existingCartItem = Transaction::where('product_id', $data['product_id'])
            ->where('user_id', $data['user_id'])
            ->where('status', 1)
            ->first();

        if ($existingCartItem) {
            // Jika sudah ada, tambahkan total
            $existingCartItem->quantity += 1;
            $existingCartItem->save();
        } else {
            // Jika belum ada, tambahkan item baru ke keranjang
            Transaction::create($data);
        }

        return redirect()->route('cart.index')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function destroy($id)
    {
        // Temukan item keranjang belanja berdasarkan ID
        $cartItem = Transaction::find($id);

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