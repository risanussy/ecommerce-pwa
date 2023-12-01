@extends('admin')

@section('dashboard')
<div class="mt-5">
    <div class="row mb-3">
        <div class="col">
            <h3 class="mb-2">Produk</h3>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col d-flex justify-content-end">
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addProductModal">
                Tambah Product
            </button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="table-responsive over">
              <table class="table align-middle">
              <thead>
                  <tr>
                  <th scope="col">#</th>
                  <th scope="col">Barang</th>
                  <th scope="col">Gambar</th>
                  <th scope="col">Harga</th>
                  <th scope="col">Deskripsi</th>
                  <th scope="col"></th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($products as $product)
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{ $product->nama }}</td>
                    <td>
                        <div class="d-flex justify-content-center align-items-center overflow-hidden" style="width: 60px; height: 60px">
                        <img src="{{ asset('product/'.$product->foto) }}" class="card-img-top" height="100%">
                        </div>
                    </td>
                    <td>{{ $product->harga }}</td>
                    <td class="w-25 text-justify">{{ $product->deskripsi }}</td>
                    <td>                        
                        <!-- Form Hapus -->
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
              </tbody>
              </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Tambah Produk Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Produk</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="mb-3">
                        <label for="harga" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto Produk</label>
                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-success">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.querySelector(".sell").classList.remove("active")
    document.querySelector(".product").classList.add("active")
    document.querySelector(".users").classList.remove("active")
    document.querySelector(".chat").classList.remove("active")
</script>
@endsection