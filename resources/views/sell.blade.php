@extends('admin')

@section('dashboard')
<div class="mt-5">
    <h3 class="mb-2">Daftar Penjualan</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col" style="font-size: 13px;">#</th>
                <th scope="col" style="font-size: 13px;">Invoice</th>
                <th scope="col" style="font-size: 13px;">Resi</th>
                <th scope="col" style="font-size: 13px;">Nama</th>
                <th scope="col" style="font-size: 13px;">Alamat</th>
                <th scope="col" style="font-size: 13px;">Barang</th>
                <th scope="col" style="font-size: 13px;">Metode<br>Pembayaran</th>
                <th scope="col" style="font-size: 13px;">Metode<br>Pengiriman</th>
                <th scope="col" style="font-size: 13px;">Harga</th>
                <th scope="col" style="font-size: 13px;">Total</th>
                <th scope="col" style="font-size: 13px;">Process</th>
                <th scope="col" style="font-size: 13px;"></th>
            </tr>
        </thead>
        <tbody>
        @if ($selling->isEmpty())
            <tr>
                <td style="text-align: center" colspan="12">
                    <i>
                        Belum ada penjualan
                    </i>
                </td>
            </tr>
        @else
        @foreach ($selling as $sell)
            <tr>
                <th scope="row">{{ $loop->index + 1 }}</th>
                <td>INV-{{ strtotime($sell->created_at) }}-{{ $loop->index }}{{ $sell->id }}</td>
                <td>{{ strtotime($sell->created_at) }}{{ $sell->id }}</td>
                <td>{{ $sell->user_name }}</td>
                <td>{{ $sell->alamat }}</td>
                <td>{{ $sell->nama }}</td>
                <td>{{ $sell->pay_method }}</td>
                <td>{{ $sell->expedisi }}</td>
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
                        <button class="badge rounded-pill bg-primary border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Action
                        </button>
                        <ul class="dropdown-menu">
                            @if ($sell->process == 1)
                                <li>
                                    <form method="post" action="{{ route('sell.kirim', $sell->pid) }}">
                                        @csrf
                                        <button class="dropdown-item kirim" type="submit">Kirim</button>
                                    </form>
                                </li>
                            @elseif ($sell->process == 2)
                                <li>
                                    <form method="post" action="{{ route('sell.selesai', $sell->pid) }}">
                                        @csrf
                                        <button class="dropdown-item selesai" type="submit">Selesai</button>
                                    </form>
                                </li>
                            @endif
                            <li>
                                <form method="post" action="{{ route('sell.canceled', $sell->pid) }}">
                                    @csrf
                                    <button class="dropdown-item batal" type="submit">Canceled</button>
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

<script>
    document.querySelectorAll(".kirim").forEach(item => {
        item.addEventListener("click", function() {
            axios.post('/api/notif', {
                pesan: "Pesanan Dikirimkan: Cek pesanan anda",
                user_id: this.closest("tr").querySelector(".hid").value,
                admin: 1,
                status: 0,
            }).then(response => {
                console.log(response.data);
                // Handle success, e.g., refresh chat or display success message
            }).catch(error => {
                console.error(error);
                // Handle error, e.g., display error message
            });
        });
    });

    document.querySelectorAll(".selesai").forEach(item => {
        item.addEventListener("click", function() {
            axios.post('/api/notif', {
                pesan: "Pesanan Diselesaikan: Cek pesanan anda",
                user_id: this.closest("tr").querySelector(".hid").value,
                admin: 1,
                status: 0,
            }).then(response => {
                console.log(response.data);
                // Handle success, e.g., refresh chat or display success message
                this.closest("form").submit();
            }).catch(error => {
                console.error(error);
                // Handle error, e.g., display error message
            });
        });
    });

    document.querySelectorAll(".batal").forEach(item => {
        item.addEventListener("click", function() {
            axios.post('/api/notif', {
                pesan: "Pesanan Dibatalkan: Cek pesanan anda",
                user_id: this.closest("tr").querySelector(".hid").value,
                admin: 1,
                status: 0,
            }).then(response => {
                console.log(response.data);
                // Handle success, e.g., refresh chat or display success message
                this.closest("form").submit();
            }).catch(error => {
                console.error(error);
                // Handle error, e.g., display error message
            });
        });
    });
</script>

@endsection
