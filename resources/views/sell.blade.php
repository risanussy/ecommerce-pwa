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
        <th scope="col">Total</th>
        <th scope="col"></th>
        </tr>
    </thead>
    <tbody>
    @if ($selling->isEmpty())
        <tr>
            <td style="text-align: center" colspan="7">
            <i>
                Belum ada penjualan
            </i>
            </td>
        </tr>
    @else
    @foreach ($selling as $sell)
        <tr>
        <th scope="row">1</th>
        <td>{{ $sell->user_name }}</td>
        <td>{{ $sell->alamat }}</td>
        <td>{{ $sell->nama }}</td>
        <td>Rp. {{ number_format($sell->total, 0, ',', '.') }}</td>
        <td>
            <span class="badge rounded-pill text-bg-warning">Proccess</span>
        </td>
        <td>
            <button class="btn btn-outline-success">Action</button>
        </td>
        </tr>
    @endforeach
    @endif
    </tbody>
    </table>
</div>

<script>
    document.querySelector(".sell").classList.add("active")
    document.querySelector(".product").classList.remove("active")
</script>
@endsection