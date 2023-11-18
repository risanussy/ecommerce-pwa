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
            <th scope="col">Process</th>
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
            <td>Rp. {{ number_format($sell->harga, 0, ',', '.') }}</td>
            <td>Rp. {{ number_format($sell->total, 0, ',', '.') }}</td>
            <td>
                @if ($sell->process == 1)
                    <span class="badge rounded-pill text-bg-warning pea">Konfirmasi</span>
                @elseif ($sell->process == 0)
                    <span class="badge rounded-pill text-bg-danger pea">Canceled</span>
                @elseif ($sell->process == 2)
                    <span class="badge rounded-pill text-bg-info pea">Dikirimkan</span>
                @elseif ($sell->process == 3)
                    <span class="badge rounded-pill text-bg-success pea">Selesai</span>
                @endif
                <input type="hidden" class="hid" value="{{ $sell->id }}">
            </td>
            <td>
                <div class="btn-group">
                    <button class="btn btn-primary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        @if ($sell->process == 1)
                            <li>
                                <form method="post" action="{{ route('sell.kirim', $sell->pid) }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Kirim</button>
                                </form>
                            </li>
                        @elseif ($sell->process == 2)
                            <li>
                                <form method="post" action="{{ route('sell.selesai', $sell->pid) }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Selesai</button>
                                </form>
                            </li>
                        @endif
                        <li>
                            <form method="post" action="{{ route('sell.canceled', $sell->pid) }}">
                                @csrf
                                <button class="dropdown-item" type="submit">Canceled</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </td>
        </tr>
    @endforeach
    @endif
    </tbody>
    </table>
</div>
@endsection
