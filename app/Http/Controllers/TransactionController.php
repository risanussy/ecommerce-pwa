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

    public function resi()
    {
        $userId = Auth::id();

        $cartItems = DB::table('transactions')
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.user_id', $userId)
            ->where('transactions.status', 2) // Tambahkan kondisi untuk status
            ->select('products.*', 'transactions.*')
            ->get();

        return view('resi', compact('cartItems'));
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
        $product = DB::table('transactions')
            ->join('products', 'transactions.product_id', '=', 'products.id')
            ->where('transactions.id', $id)
            ->where('transactions.status', 1)
            ->select('products.*', 'transactions.*', 'transactions.id as tid')
            ->first(); // Menggunakan first() untuk mendapatkan satu objek
        
        if (!$product) {
            // Handle jika transaksi tidak ditemukan, bisa redirect atau berikan response yang sesuai.
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan.');
        }
        $userData = Auth::user()->alamat;

        return view('pay', compact('product', 'userData'));
    }

    public function buy(Request $request)
    {
        // Validasi data
        $data = $request;
        
        // Cek apakah item dengan product_id sudah ada di keranjang
        $existingCartItem = Transaction::where('id', $data['transaction_id'])
            ->first();

        // var_dump($existingCartItem);
        if ($existingCartItem) {
            // Validasi data
            $update = $request->validate([
                'total' => 'required'
            ]);
            // Jika sudah ada, tambahkan total
            $existingCartItem->process = 1;
            $existingCartItem->status = 2;
            $existingCartItem->total = $update['total'];
            $existingCartItem->save();
        } else {
            // Validasi data
            $create = $request->validate([
                'product_id' => 'required|exists:products,id',
                'user_id' => 'required|exists:users,id',
                'total' => 'required',
            ]);
            // Set default values
            $create['status'] = 2;
            $create['quantity'] = 1;
            $create['process'] = 1;
            // Jika belum ada, tambahkan item baru ke keranjang
            Transaction::create($create);
        }

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

        return redirect('/')->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function buyAll(Request $request, $id)
    {
        $userId = $id;
        $selectedItems = $request->selectedItems;
        $totals = $request->total;

        try {
            // Ambil semua item yang sesuai dengan user_id dan status 1
            $existingCartItems = Transaction::where('user_id', $userId)
                ->join('products', 'transactions.product_id', '=', 'products.id')
                ->where('status', 1)
                ->select('products.*', 'transactions.*', 'transactions.id as tid')
                ->get();

            foreach ($selectedItems as $index) {
                // Pastikan indeks benar-benar valid
                if ($index < count($existingCartItems)) {
                    // Ambil item berdasarkan indeks
                    $cartItem = $existingCartItems[$index];

                    // Ubah status item menjadi 0
                    $cartItem->status = 2;
                    $cartItem->process = 1;
                    $cartItem->total = $totals + ($cartItem->quantity * $cartItem->harga);
                    $cartItem->save();

                    // Lakukan sesuatu setelah item diubah status
                }
            }

            return response()->json(['message' => 'Semua item berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus item.'], 500);
        }
    }

    public function deleteAll(Request $request, $id)
    {
        $userId = $id;
        $selectedItems = $request->selectedItems;

        try {
            // Ambil semua item yang sesuai dengan user_id dan status 1
            $existingCartItems = Transaction::where('user_id', $userId)
                ->where('status', 1)
                ->get();

            foreach ($selectedItems as $index) {
                // Pastikan indeks benar-benar valid
                if ($index < count($existingCartItems)) {
                    // Ambil item berdasarkan indeks
                    $cartItem = $existingCartItems[$index];

                    // Ubah status item menjadi 0
                    $cartItem->status = 0;
                    $cartItem->save();

                    // Lakukan sesuatu setelah item diubah status
                }
            }

            return response()->json(['message' => 'Semua item berhasil dihapus.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus item.'], 500);
        }
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