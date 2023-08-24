@extends('admin')

@section('dashboard')
<div class="mt-5">
    <h3 class="mb-2">Penjualan</h3>
    <table class="table">
    <thead>
        <tr>
        <th scope="col">#</th>
        <th scope="col">Nama</th>
        <th scope="col">Alamat</th>
        <th scope="col">Barang</th>
        <th scope="col">Harga</th>
        <th scope="col">Status</th>
        <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
        <tr>
        <th scope="row">1</th>
        <td>User</td>
        <td>Jl. Alamat</td>
        <td>Barang</td>
        <td>1.000</td>
        <td>
            <span class="badge rounded-pill text-bg-warning">Proccess</span></td>
        <td>
            <button class="btn btn-outline-success">Action</button>
        </td>
        </tr>
    </tbody>
    </table>
</div>

<script>
    document.querySelector(".sell").classList.add("active")
    document.querySelector(".product").classList.remove("active")
</script>
@endsection