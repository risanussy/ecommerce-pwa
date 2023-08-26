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
            <th scope="row">{{ $loop->index + 1 }}</th>
            <td>{{ $sell->user_name }}</td>
            <td>{{ $sell->alamat }}</td>
            <td>{{ $sell->nama }}</td>
            <td>Rp. {{ number_format($sell->total, 0, ',', '.') }}</td>
            <td>
                <span class="badge rounded-pill text-bg-warning pea">{{ $sell->status }}</span>
                <input type="hidden" class="hid" value="{{ $sell->id }}" >
            </td>
            <td>
                <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Action
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <button class="dropdown-item" onclick="cs({{ $loop->index }}, 'Process')">Process</button>
                    </li>
                    <li>
                        <button class="dropdown-item" onclick="cs({{ $loop->index }}, 'Done')">Done</button>
                    </li>
                    <li>
                        <button class="dropdown-item" onclick="cs({{ $loop->index }}, 'Canceled')">Canceled</button>
                    </li>
                </ul>
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

    let cs = (id, status) => {
        let test = document.querySelectorAll('.pea')
        test[id].innerHTML = status;
    }
</script>
@endsection
